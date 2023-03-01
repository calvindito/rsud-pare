<?php

namespace App\Http\Controllers\Bill;

use App\Helpers\Simrs;
use App\Models\Setting;
use App\Models\LabRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\LabItemCondition;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class LabController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'bill.lab'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = LabRequest::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->whereHas('patient', function ($query) use ($search) {
                        $query->whereRaw("LPAD(id, 7, 0) LIKE '%$search%'")
                            ->orWhere('name', 'like', "%$search%");
                    });
                }
            })
            ->editColumn('created_at', '{{ date("Y-m-d", strtotime($created_at)) }}')
            ->editColumn('paid', function (LabRequest $query) {
                return $query->paid();
            })
            ->addColumn('total', function (LabRequest $query) {
                return Simrs::formatRupiah($query->total());
            })
            ->addColumn('patient_name', function (LabRequest $query) {
                $patientName = null;

                if (isset($query->patient)) {
                    $patientName = $query->patient->name;
                }

                return $patientName;
            })
            ->addColumn('patient_id', function (LabRequest $query) {
                $patientId = null;

                if (isset($query->patient)) {
                    $patientId = $query->patient->no_medical_record;
                }

                return $patientId;
            })
            ->addColumn('action', function (LabRequest $query) {
                return '
                    <a href="' . url('bill/lab/detail/' . $query->id) . '" class="btn btn-light text-primary btn-sm fw-semibold">
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
        $labRequest = LabRequest::findOrFail($id);

        if ($request->ajax()) {
            try {
                $labRequest->update(['paid' => true]);

                Transaction::create([
                    'chart_of_account_id' => Setting::firstWhere('slug', 'coa-bill')->settingable_id ?? null,
                    'transactionable_type' => LabRequest::class,
                    'transactionable_id' => $labRequest->id,
                    'nominal' => $labRequest->total()
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
            'labRequest' => $labRequest,
            'labRequestDetail' => $labRequest->labRequestDetail,
            'patient' => $labRequest->patient,
            'labItemCondition' => LabItemCondition::all(),
            'content' => 'bill.lab-detail'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function print($id)
    {
        $data = LabRequest::where('paid', true)->findOrFail($id);
        $pdf = Pdf::setOptions([
            'adminUsername' => auth()->user()->username
        ])->loadView('pdf.bill-lab', [
            'title' => 'Bukti Pembayaran Tagihan Laboratorium',
            'data' => $data
        ]);

        return $pdf->stream('Bukti Pembayaran Tagihan Laboratorium' . ' - ' . date('YmdHis') . '.pdf');
    }
}
