<?php

namespace App\Http\Controllers\Nursing;

use App\Models\Action;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\EmergencyDepartment;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class EmergencyDepartmentController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'nursing.emergency-department'
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
            ->editColumn('status', function (EmergencyDepartment $query) {
                return $query->status();
            })
            ->addColumn('code', function (EmergencyDepartment $query) {
                return $query->code();
            })
            ->addColumn('patient_name', function (EmergencyDepartment $query) {
                $patientName = $query->patient->name ?? null;

                return $patientName;
            })
            ->addColumn('patient_id', function (EmergencyDepartment $query) {
                $patientId = $query->patient->no_medical_record ?? null;

                return $patientId;
            })
            ->addColumn('functional_service_name', function (EmergencyDepartment $query) {
                $functionalServiceName = $query->functionalService->name ?? null;

                return $functionalServiceName;
            })
            ->addColumn('action', function (EmergencyDepartment $query) {
                return '
                    <a href="' . url('nursing/emergency-department/action/' . $query->id) . '" class="btn btn-primary btn-sm">
                        <i class="ph-person-simple-run me-2"></i>
                        Tindakan
                    </a>
                ';
            })
            ->rawColumns(['action', 'status'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function action(Request $request, $id)
    {
        $emergencyDepartment = EmergencyDepartment::findOrFail($id);

        if ($request->has('date')) {
            $date = $request->date;
        } else {
            if (!empty($emergencyDepartment->date_of_out)) {
                $date = date('Y-m-d', strtotime($emergencyDepartment->date_of_entry));
            } else {
                $date = date('Y-m-d');
            }
        }

        if ($request->ajax()) {
            try {
                DB::transaction(function () use ($request, $emergencyDepartment, $date) {
                    $emergencyDepartment->emergencyDepartmentNursing()->whereDate('created_at', $date)->where('user_id', auth()->id())->delete();

                    if ($request->has('action_id')) {
                        foreach ($request->action_id as $ai) {
                            $explodeId = explode('_', $ai);
                            $actionId = end($explodeId);
                            $action = Action::find($actionId);

                            $emergencyDepartment->emergencyDepartmentNursing()->create([
                                'action_id' => $actionId,
                                'user_id' => auth()->id(),
                                'fee' => $action->fee ?? 0
                            ]);
                        }
                    }
                });

                $response = [
                    'code' => 200,
                    'message' => 'Tindakan berhasil disimpan'
                ];
            } catch (\Exception $e) {
                $response = [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ];
            }

            return response()->json($response);
        }

        $action = Action::whereHas('emergencyDepartmentActionLimit', function ($query) use ($emergencyDepartment) {
            $query->where('emergency_department_id', $emergencyDepartment->id);
        })->get();

        $data = [
            'emergencyDepartment' => $emergencyDepartment,
            'emergencyDepartmentNursing' => $emergencyDepartment->emergencyDepartmentNursing()->whereDate('created_at', $date)->get(),
            'patient' => $emergencyDepartment->patient,
            'action' => $action,
            'date' => $date,
            'content' => 'nursing.emergency-department-action'
        ];

        return view('layouts.index', ['data' => $data]);
    }
}
