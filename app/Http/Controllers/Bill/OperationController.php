<?php

namespace App\Http\Controllers\Bill;

use App\Helpers\Simrs;
use App\Models\Doctor;
use App\Models\Setting;
use App\Models\Operation;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class OperationController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'bill.operation'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Operation::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->whereRaw("LPAD(id, 7, 0) LIKE '%$search%'")
                        ->whereHas('patient', function ($query) use ($search) {
                            $query->whereRaw("LPAD(id, 7, 0) LIKE '%$search%'")
                                ->orWhere('name', 'like', "%$search%");
                        });
                }
            })
            ->editColumn('date_of_entry', '{{ date("Y-m-d", strtotime($date_of_entry)) }}')
            ->editColumn('paid', function (Operation $query) {
                return $query->paid();
            })
            ->addColumn('code', function (Operation $query) {
                return $query->code();
            })
            ->addColumn('total', function (Operation $query) {
                return Simrs::formatRupiah($query->total(false));
            })
            ->addColumn('patient_name', function (Operation $query) {
                $patientName = null;

                if (isset($query->patient)) {
                    $patientName = $query->patient->name;
                }

                return $patientName;
            })
            ->addColumn('patient_id', function (Operation $query) {
                $patientId = null;

                if (isset($query->patient)) {
                    $patientId = $query->patient->no_medical_record;
                }

                return $patientId;
            })
            ->addColumn('action', function (Operation $query) {
                return '
                    <a href="' . url('bill/operation/detail/' . $query->id) . '" class="btn btn-light text-primary btn-sm fw-semibold">
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
        $operation = Operation::findOrFail($id);

        if ($request->ajax()) {
            try {
                $operation->update(['paid' => true]);

                Transaction::create([
                    'chart_of_account_id' => Setting::firstWhere('slug', 'coa-bill')->settingable_id ?? null,
                    'transactionable_type' => Operation::class,
                    'transactionable_id' => $operation->id,
                    'nominal' => $operation->total(false)
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
            'operation' => $operation,
            'operationMaterial' => $operation->operationMaterial,
            'patient' => $operation->patient,
            'doctor' => Doctor::all(),
            'content' => 'bill.operation-detail'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function print($id)
    {
        $data = Operation::where('paid', true)->findOrFail($id);
        $pdf = Pdf::setOptions([
            'adminUsername' => auth()->user()->username
        ])->loadView('pdf.bill-operation', [
            'title' => 'Bukti Pembayaran Tagihan Operasi',
            'data' => $data
        ]);

        return $pdf->stream('Bukti Pembayaran Tagihan Operasi' . ' - ' . date('YmdHis') . '.pdf');
    }
}
