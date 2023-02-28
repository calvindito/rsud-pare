<?php

namespace App\Http\Controllers\Bill;

use App\Helpers\Simrs;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\RadiologyRequest;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class RadiologyController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'bill.radiology'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = RadiologyRequest::query();

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
            ->editColumn('paid', function (RadiologyRequest $query) {
                return $query->paid();
            })
            ->addColumn('total', function (RadiologyRequest $query) {
                return Simrs::formatRupiah($query->total());
            })
            ->addColumn('patient_name', function (RadiologyRequest $query) {
                $patientName = null;

                if (isset($query->patient)) {
                    $patientName = $query->patient->name;
                }

                return $patientName;
            })
            ->addColumn('patient_id', function (RadiologyRequest $query) {
                $patientId = null;

                if (isset($query->patient)) {
                    $patientId = $query->patient->no_medical_record;
                }

                return $patientId;
            })
            ->addColumn('action', function (RadiologyRequest $query) {
                return '
                    <a href="' . url('bill/radiology/detail/' . $query->id) . '" class="btn btn-light text-primary btn-sm fw-semibold">
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
        $radiologyRequest = RadiologyRequest::findOrFail($id);

        if ($request->ajax()) {
            try {
                $radiologyRequest->update(['paid' => true]);

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
            'radiologyRequest' => $radiologyRequest,
            'patient' => $radiologyRequest->patient,
            'content' => 'bill.radiology-detail'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function print($id)
    {
        $data = RadiologyRequest::where('paid', true)->findOrFail($id);
        $pdf = Pdf::setOptions([
            'adminUsername' => auth()->user()->username
        ])->loadView('pdf.bill-radiology', [
            'title' => 'Bukti Pembayaran Tagihan Radiologi',
            'data' => $data
        ]);

        return $pdf->stream('Bukti Pembayaran Tagihan Radiologi' . ' - ' . date('YmdHis') . '.pdf');
    }
}
