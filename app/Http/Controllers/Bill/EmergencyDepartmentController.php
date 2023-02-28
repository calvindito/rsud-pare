<?php

namespace App\Http\Controllers\Bill;

use App\Helpers\Simrs;
use App\Models\Doctor;
use App\Models\ActionOther;
use Illuminate\Http\Request;
use App\Models\MedicalService;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ActionSupporting;
use App\Models\ActionNonOperative;
use App\Models\EmergencyDepartment;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class EmergencyDepartmentController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'bill.emergency-department'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = EmergencyDepartment::query();

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
            ->addColumn('paid', function (EmergencyDepartment $query) {
                return $query->paid();
            })
            ->addColumn('code', function (EmergencyDepartment $query) {
                return $query->code();
            })
            ->addColumn('total_action', function (EmergencyDepartment $query) {
                return Simrs::formatRupiah($query->totalAction());
            })
            ->addColumn('patient_name', function (EmergencyDepartment $query) {
                $patientName = null;

                if (isset($query->patient)) {
                    $patientName = $query->patient->name;
                }

                return $patientName;
            })
            ->addColumn('patient_id', function (EmergencyDepartment $query) {
                $patientId = null;

                if (isset($query->patient)) {
                    $patientId = $query->patient->no_medical_record;
                }

                return $patientId;
            })
            ->addColumn('action', function (EmergencyDepartment $query) {
                return '
                    <a href="' . url('bill/emergency-department/detail/' . $query->id) . '" class="btn btn-light text-primary btn-sm fw-semibold">
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
        $emergencyDepartment = EmergencyDepartment::findOrFail($id);

        if ($request->ajax()) {
            try {
                $emergencyDepartment->update(['paid' => true]);

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
            'emergencyDepartment' => $emergencyDepartment,
            'functionalService' => $emergencyDepartment->functionalService,
            'patient' => $emergencyDepartment->patient,
            'doctor' => Doctor::all(),
            'medicalService' => MedicalService::where('status', true)->where('class_type_id', 7)->get(),
            'actionNonOperative' => ActionNonOperative::where('class_type_id', 7)->get(),
            'actionSupporting' => ActionSupporting::where('class_type_id', 7)->get(),
            'tool' => Simrs::tool(),
            'actionOther' => ActionOther::where('class_type_id', 7)->get(),
            'emergencyDepartmentHealth' => $emergencyDepartment->emergencyDepartmentHealth,
            'emergencyDepartmentNonOperative' => $emergencyDepartment->emergencyDepartmentNonOperative,
            'emergencyDepartmentOther' => $emergencyDepartment->emergencyDepartmentOther,
            'emergencyDepartmentPackage' => $emergencyDepartment->emergencyDepartmentPackage,
            'emergencyDepartmentService' => $emergencyDepartment->emergencyDepartmentService,
            'emergencyDepartmentSupporting' => $emergencyDepartment->emergencyDepartmentSupporting,
            'content' => 'bill.emergency-department-detail'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function print($id)
    {
        $data = EmergencyDepartment::where('paid', true)->findOrFail($id);
        $pdf = Pdf::setOptions([
            'adminUsername' => auth()->user()->username
        ])->loadView('pdf.bill-emergency-department', [
            'title' => 'Bukti Pembayaran Tagihan IGD',
            'data' => $data
        ]);

        return $pdf->stream('Bukti Pembayaran Tagihan IGD' . ' - ' . date('YmdHis') . '.pdf');
    }
}
