<?php

namespace App\Http\Controllers\Bill;

use App\Helpers\Simrs;
use App\Models\Setting;
use App\Models\Outpatient;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class OutpatientController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'bill.outpatient'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Outpatient::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->whereRaw("LPAD(id, 7, 0) LIKE '%$search%'")
                        ->orWhereHas('patient', function ($query) use ($search) {
                            $query->whereRaw("LPAD(id, 7, 0) LIKE '%$search%'")
                                ->orWhere('name', 'like', "%$search%");
                        });
                }
            })
            ->editColumn('created_at', '{{ date("Y-m-d", strtotime($created_at)) }}')
            ->addColumn('paid', function (Outpatient $query) {
                return $query->paid();
            })
            ->addColumn('code', function (Outpatient $query) {
                return $query->code();
            })
            ->addColumn('total_action', function (Outpatient $query) {
                return Simrs::formatRupiah($query->totalAction());
            })
            ->addColumn('patient_name', function (Outpatient $query) {
                $patientName = null;

                if (isset($query->patient)) {
                    $patientName = $query->patient->name;
                }

                return $patientName;
            })
            ->addColumn('patient_id', function (Outpatient $query) {
                $patientId = null;

                if (isset($query->patient)) {
                    $patientId = $query->patient->no_medical_record;
                }

                return $patientId;
            })
            ->addColumn('action', function (Outpatient $query) {
                return '
                    <a href="' . url('bill/outpatient/detail/' . $query->id) . '" class="btn btn-light text-primary btn-sm fw-semibold">
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
        $outpatient = Outpatient::findOrFail($id);
        $unit = $outpatient->unit;

        if ($request->ajax()) {
            try {
                if ($outpatient->outpatientAction->count() > 0) {
                    foreach ($outpatient->outpatientAction as $oa) {
                        $oa->update(['status' => true]);
                    }
                }

                $outpatient->update(['paid' => true]);

                Transaction::create([
                    'chart_of_account_id' => Setting::firstWhere('slug', 'coa-bill')->settingable_id ?? null,
                    'transactionable_type' => Outpatient::class,
                    'transactionable_id' => $outpatient->id,
                    'nominal' => $outpatient->totalAction()
                ]);

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
            'outpatient' => $outpatient,
            'patient' => $outpatient->patient,
            'outpatientAction' => $outpatient->outpatientAction,
            'unit' => $unit,
            'content' => 'bill.outpatient-detail'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function print($id)
    {
        $data = Outpatient::where('paid', true)->findOrFail($id);
        $pdf = Pdf::setOptions([
            'adminUsername' => auth()->user()->username
        ])->loadView('pdf.bill-outpatient', [
            'title' => 'Bukti Pembayaran Tagihan Rawat Jalan',
            'data' => $data
        ]);

        return $pdf->stream('Bukti Pembayaran Tagihan Rawat Jalan' . ' - ' . date('YmdHis') . '.pdf');
    }
}
