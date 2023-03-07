<?php

namespace App\Http\Controllers\Report\MedicalRecord;

use App\Helpers\Simrs;
use App\Models\Patient;
use App\Models\Religion;
use Illuminate\Http\Request;
use App\Models\InpatientDiagnosis;
use App\Models\OutpatientDiagnosis;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\EmergencyDepartmentDiagnosis;

class PatientController extends Controller
{
    public function index()
    {
        $data = [
            'religion' => Religion::all(),
            'content' => 'report.medical-record.patient'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Patient::whereNotNull('verified_at');

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search, $request) {
                if ($search) {
                    $query->whereRaw("LPAD(id, 7, 0) LIKE '%$search%'")
                        ->orWhere('code_old', 'like', "%$search%")
                        ->orWhere('code_member', 'like', "%$search%")
                        ->orWhere('identity_number', 'like', "%$search%")
                        ->orWhere('name', 'like', "%$search%")
                        ->orWhere('village', 'like', "%$search%")
                        ->orWhere('phone', 'like', "%$search%");
                }

                if ($request->location_id) {
                    $location = Simrs::locationById($request->location_id);

                    $query->where('province_id', $location->id)
                        ->orWhere('city_id', $location->id)
                        ->orWhere('district_id', $location->id);
                }

                if ($request->religion_id) {
                    $query->where('religion_id', $request->religion_id);
                }

                if ($request->gender) {
                    $query->where('gender', $request->gender);
                }

                if ($request->blood_group) {
                    $query->where('blood_group', $request->blood_group);
                }

                if ($request->marital_status) {
                    $query->where('marital_status', $request->marital_status);
                }

                if ($request->date_of_register) {
                    $query->whereDate('created_at', $request->date_of_register);
                }
            })
            ->addColumn('religion_name', function (Patient $query) {
                $religionName = $query->religion->name ?? null;

                return $religionName;
            })
            ->addColumn('action', function (Patient $query) {
                return '
                    <a href="' . url('report/medical-record/patient/detail/' . $query->id) . '" class="btn btn-primary btn-sm">
                        <i class="ph-info me-1"></i>
                        Detail
                    </a>
                ';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function detail($id)
    {
        $patient = Patient::findOrFail($id);

        $diagnosis = OutpatientDiagnosis::selectRaw("'Rawat Jalan' as ref, type, value, created_at")
            ->whereHas('outpatient', function ($query) use ($patient) {
                $query->where('patient_id', $patient->id);
            })->unionAll(
                InpatientDiagnosis::selectRaw("'Rawat Inap' as ref, type, value, created_at")
                    ->whereHas('inpatient', function ($query) use ($patient) {
                        $query->where('patient_id', $patient->id);
                    })->unionAll(
                        EmergencyDepartmentDiagnosis::selectRaw("'IGD' as ref, type, value, created_at")
                            ->whereHas('emergencyDepartment', function ($query) use ($patient) {
                                $query->where('patient_id', $patient->id);
                            })
                    )
            )->orderBy('created_at')->get();

        $data = [
            'patient' => $patient,
            'outpatient' => $patient->outpatient,
            'inpatient' => $patient->inpatient,
            'emergencyDepartment' => $patient->emergencyDepartment,
            'diagnosis' => collect($diagnosis)->groupBy('type')->all(),
            'diagnosisTotal' => $diagnosis->count(),
            'laboratorium' => $patient->labRequest,
            'radiology' => $patient->radiologyRequest,
            'operation' => $patient->operation,
            'recipe' => $patient->dispensaryRequest()->groupBy('dispensary_requestable_type', 'dispensary_requestable_id', 'dispensary_id')->get(),
            'content' => 'report.medical-record.patient-detail'
        ];

        return view('layouts.index', ['data' => $data]);
    }
}
