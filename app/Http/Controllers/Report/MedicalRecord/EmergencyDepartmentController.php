<?php

namespace App\Http\Controllers\Report\MedicalRecord;

use Carbon\Carbon;
use App\Helpers\Simrs;
use App\Models\Doctor;
use App\Models\Dispensary;
use App\Models\ActionOther;
use Illuminate\Http\Request;
use App\Models\MedicalService;
use App\Models\ActionSupporting;
use App\Models\FunctionalService;
use App\Models\ActionNonOperative;
use App\Models\EmergencyDepartment;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class EmergencyDepartmentController extends Controller
{
    public function index()
    {
        $data = [
            'functionalService' => FunctionalService::where('status', true)->get(),
            'doctor' => Doctor::all(),
            'dispensary' => Dispensary::all(),
            'type' => Simrs::nursingType(),
            'content' => 'report.medical-record.emergency-department'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = EmergencyDepartment::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search, $request) {
                if ($search) {
                    $query->whereRaw("LPAD(id, 7, 0) LIKE '%$search%'")
                        ->orWhereHas('patient', function ($query) use ($search) {
                            $query->whereRaw("LPAD(id, 7, 0) LIKE '%$search%'");
                        })
                        ->orWhereHas('functionalService', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('dispensary', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('doctor', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }

                if ($request->patient_id) {
                    $query->where('patient_id', $request->patient_id);
                }

                if ($request->functional_service_id) {
                    $query->where('functional_service_id', $request->functional_service_id);
                }

                if ($request->doctor_id) {
                    $query->where('doctor_id', $request->doctor_id);
                }

                if ($request->dispensary_id) {
                    $query->where('dispensary_id', $request->dispensary_id);
                }

                if ($request->type) {
                    $query->where('type', $request->type);
                }

                if ($request->date) {
                    $explodeDate = explode(' - ', $request->date);
                    $startDate = Carbon::parse($explodeDate[0])->format('Y-m-d');
                    $endDate = Carbon::parse($explodeDate[1])->format('Y-m-d');

                    $query->whereDate($request->column_date, '>=', $startDate)->whereDate($request->column_date, '<=', $endDate);
                }

                if ($request->status) {
                    $query->where('status', $request->status);
                }

                if ($request->ending) {
                    $query->where('ending', $request->ending);
                }
            })
            ->addColumn('code', function (EmergencyDepartment $query) {
                return $query->code();
            })
            ->addColumn('patient_name', function (EmergencyDepartment $query) {
                $patientName = $query->patient->name ?? null;

                return $patientName;
            })
            ->addColumn('functional_service_name', function (EmergencyDepartment $query) {
                $functionalServiceName = $query->functionalService->name ?? null;

                return $functionalServiceName;
            })
            ->addColumn('doctor_name', function (EmergencyDepartment $query) {
                $doctorName = $query->doctor->name ?? null;

                return $doctorName;
            })
            ->addColumn('dispensary_name', function (EmergencyDepartment $query) {
                $dispensaryName = $query->dispensary->name ?? null;

                return $dispensaryName;
            })
            ->addColumn('date', function (EmergencyDepartment $query) use ($request) {
                $toArray = $query->toArray();
                $date = $query->created_at->format('Y-m-d');

                if ($request->date) {
                    $date = date('Y-m-d', strtotime($toArray[$request->column_date]));
                }

                return $date;
            })
            ->addColumn('paid', function (EmergencyDepartment $query) {
                return $query->paid();
            })
            ->addColumn('status', function (EmergencyDepartment $query) {
                return $query->status();
            })
            ->addColumn('action', function (EmergencyDepartment $query) {
                return '
                    <a href="' . url('report/medical-record/emergency-department/detail/' . $query->id) . '" class="btn btn-primary btn-sm">
                        <i class="ph-info me-1"></i>
                        Detail
                    </a>
                ';
            })
            ->rawColumns(['action', 'paid', 'status'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function detail($id)
    {
        $emergencyDepartment = EmergencyDepartment::findOrFail($id);

        $data = [
            'emergencyDepartment' => $emergencyDepartment,
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
            'soap' => $emergencyDepartment->emergencyDepartmentSoap,
            'diagnosis' => $emergencyDepartment->emergencyDepartmentDiagnosis,
            'laboratorium' => $emergencyDepartment->labRequest,
            'radiology' => $emergencyDepartment->radiologyRequest,
            'operation' => $emergencyDepartment->operation,
            'recipe' => $emergencyDepartment->dispensaryRequest()->groupBy('dispensary_requestable_type', 'dispensary_requestable_id', 'dispensary_id')->get(),
            'content' => 'report.medical-record.emergency-department-detail'
        ];

        return view('layouts.index', ['data' => $data]);
    }
}
