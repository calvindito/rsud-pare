<?php

namespace App\Http\Controllers\Bill;

use App\Helpers\Simrs;
use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DispensaryRequest;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class MedicineAndToolController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'bill.medicine-and-tool'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = DispensaryRequest::where('status', 4)
            ->groupBy('dispensary_requestable_type', 'dispensary_requestable_id', 'dispensary_id');

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('patient_id', 'like', "%$search%")
                        ->orWhereHas('patient', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->whereHas('employee', function ($query) use ($search) {
                                $query->where('name', 'like', "%$search%");
                            });
                        })
                        ->orWhereHas('dispensary', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }
            })
            ->editColumn('created_at', '{{ date("Y-m-d", strtotime($created_at)) }}')
            ->editColumn('paid', function (DispensaryRequest $query) {
                return $query->paid();
            })
            ->addColumn('total', function (DispensaryRequest $query) {
                return Simrs::formatRupiah($query->total());
            })
            ->addColumn('patient_name', function (DispensaryRequest $query) {
                $patientName = null;

                if (isset($query->patient)) {
                    $patientName = $query->patient->name;
                }

                return $patientName;
            })
            ->addColumn('patient_id', function (DispensaryRequest $query) {
                $patientId = null;

                if (isset($query->patient)) {
                    $patientId = $query->patient->no_medical_record;
                }

                return $patientId;
            })
            ->addColumn('dispensary_name', function (DispensaryRequest $query) {
                $dispensaryName = 'Belum Ada';

                if (isset($query->dispensary)) {
                    $dispensaryName = $query->dispensary->name;
                }

                return $dispensaryName;
            })
            ->addColumn('ref', function (DispensaryRequest $query) {
                return $query->ref();
            })
            ->addColumn('action', function (DispensaryRequest $query) {
                return '
                    <a href="' . url('bill/medicine-and-tool/detail/' . $query->id) . '" class="btn btn-light text-primary btn-sm fw-semibold">
                        <i class="ph-info me-1"></i>
                        Detail
                    </a>
                ';
            })
            ->rawColumns(['action', 'paid'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function detail(Request $request, $id)
    {
        $dispensaryRequest = DispensaryRequest::findOrFail($id);
        $dispensaryRequestItem = DispensaryRequest::with('dispensaryItemStock')
            ->where('dispensary_requestable_type', $dispensaryRequest->dispensary_requestable_type)
            ->where('dispensary_requestable_id', $dispensaryRequest->dispensary_requestable_id)
            ->where('dispensary_id', $dispensaryRequest->dispensary_id)
            ->get();

        if ($request->ajax()) {
            try {
                DispensaryRequest::with('dispensaryItemStock')
                    ->where('dispensary_requestable_type', $dispensaryRequest->dispensary_requestable_type)
                    ->where('dispensary_requestable_id', $dispensaryRequest->dispensary_requestable_id)
                    ->where('dispensary_id', $dispensaryRequest->dispensary_id)
                    ->update(['paid' => true]);

                foreach ($dispensaryRequestItem as $dri) {
                    $price = $dri->price_sell;
                    $discount = $dri->discount;
                    $qty = $dri->qty;
                    $nett = $price * $qty;

                    if ($discount > 0) {
                        $nett = ($price - (($discount / 100) * $price)) * $qty;
                    }

                    Transaction::create([
                        'chart_of_acccount_id' => Setting::firstWhere('slug', 'coa-bill')->settingable_id ?? null,
                        'transactionable_type' => DispensaryRequest::class,
                        'transactionable_id' => $dri->id,
                        'nominal' => $nett
                    ]);
                }

                $response = [
                    'code' => 200,
                    'message' => 'Pembayaran berhasil disimpan'
                ];
            } catch (\Exception $e) {
                $response = [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ];
            }

            return response()->json($response);
        }

        $data = [
            'dispensaryRequest' => $dispensaryRequest,
            'patient' => $dispensaryRequest->patient,
            'dispensaryRequestItem' => $dispensaryRequestItem,
            'patient' => $dispensaryRequest->patient,
            'content' => 'bill.medicine-and-tool-detail'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function print($id)
    {
        $data = DispensaryRequest::where('paid', true)->findOrFail($id);
        $pdf = Pdf::setOptions([
            'adminUsername' => auth()->user()->username
        ])->loadView('pdf.bill-medicine-and-tool', [
            'title' => 'Bukti Pembayaran Tagihan Obat & Alkes',
            'data' => $data
        ]);

        return $pdf->stream('Bukti Pembayaran Tagihan Obat & Alkes' . ' - ' . date('YmdHis') . '.pdf');
    }
}
