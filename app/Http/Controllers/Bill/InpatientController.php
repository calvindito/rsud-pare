<?php

namespace App\Http\Controllers\Bill;

use App\Helpers\Simrs;
use App\Models\Doctor;
use App\Models\Inpatient;
use App\Models\ActionOther;
use Illuminate\Http\Request;
use App\Models\MedicalService;
use App\Models\ActionOperative;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ActionSupporting;
use App\Models\ActionNonOperative;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class InpatientController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'bill.inpatient'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Inpatient::query();

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
            ->addColumn('paid', function (Inpatient $query) {
                return $query->paid();
            })
            ->addColumn('code', function (Inpatient $query) {
                return $query->code();
            })
            ->addColumn('total_action', function (Inpatient $query) {
                return Simrs::formatRupiah($query->totalAction());
            })
            ->addColumn('patient_name', function (Inpatient $query) {
                $patientName = null;

                if (isset($query->patient)) {
                    $patientName = $query->patient->name;
                }

                return $patientName;
            })
            ->addColumn('patient_id', function (Inpatient $query) {
                $patientId = null;

                if (isset($query->patient)) {
                    $patientId = $query->patient->no_medical_record;
                }

                return $patientId;
            })
            ->addColumn('action', function (Inpatient $query) {
                return '
                    <a href="' . url('bill/inpatient/detail/' . $query->id) . '" class="btn btn-light text-primary btn-sm fw-semibold">
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
        $inpatient = Inpatient::findOrFail($id);
        $roomType = $inpatient->roomType;
        $classType = $roomType->classType;

        if ($request->ajax()) {
            try {
                $inpatient->update(['paid' => true]);

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
            'inpatient' => $inpatient,
            'patient' => $inpatient->patient,
            'doctor' => Doctor::all(),
            'medicalService' => MedicalService::where('status', true)->where('class_type_id', $classType->id)->get(),
            'actionOperative' => ActionOperative::where('class_type_id', $classType->id)->get(),
            'actionNonOperative' => ActionNonOperative::where('class_type_id', $classType->id)->get(),
            'actionSupporting' => ActionSupporting::where('class_type_id', $classType->id)->get(),
            'tool' => Simrs::tool(),
            'actionOther' => ActionOther::where('class_type_id', $classType->id)->get(),
            'roomType' => $roomType,
            'classType' => $classType,
            'inpatientHealth' => $inpatient->inpatientHealth,
            'inpatientNonOperative' => $inpatient->inpatientNonOperative,
            'inpatientOperative' => $inpatient->inpatientOperative,
            'inpatientOther' => $inpatient->inpatientOther,
            'inpatientPackage' => $inpatient->inpatientPackage,
            'inpatientService' => $inpatient->inpatientService,
            'inpatientSupporting' => $inpatient->inpatientSupporting,
            'content' => 'bill.inpatient-detail'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function print($id)
    {
        $data = Inpatient::where('paid', true)->findOrFail($id);
        $pdf = Pdf::setOptions([
            'adminUsername' => auth()->user()->username
        ])->loadView('pdf.bill-inpatient', [
            'title' => 'Bukti Pembayaran Tagihan Rawat Inap',
            'data' => $data
        ]);

        return $pdf->stream('Bukti Pembayaran Tagihan Rawat Inap' . ' - ' . date('YmdHis') . '.pdf');
    }
}
