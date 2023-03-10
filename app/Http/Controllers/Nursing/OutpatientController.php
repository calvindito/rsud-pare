<?php

namespace App\Http\Controllers\Nursing;

use App\Models\Outpatient;
use App\Models\UnitAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class OutpatientController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'nursing.outpatient'
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
                        ->orWwhere('description', 'like', "%$search%")
                        ->whereHas('patient', function ($query) use ($search) {
                            $query->whereRaw("LPAD(id, 7, 0) LIKE '%$search%'")
                                ->orWhere('name', 'like', "%$search%")
                                ->orWhere('address', 'like', "%$search%")
                                ->orWhere('parent_name', 'like', "%$search%")
                                ->orWhereHas('district', function ($query) use ($search) {
                                    $query->where('name', 'like', "%$search%");
                                });
                        });
                }
            })
            ->editColumn('status', function (Outpatient $query) {
                return $query->status();
            })
            ->addColumn('code', function (Outpatient $query) {
                return $query->code();
            })
            ->addColumn('patient_name', function (Outpatient $query) {
                $patientName = $query->patient->name ?? null;

                return $patientName;
            })
            ->addColumn('patient_id', function (Outpatient $query) {
                $patientId = $query->patient->no_medical_record ?? null;

                return $patientId;
            })
            ->addColumn('patient_gender', function (Outpatient $query) {
                $patientGender = $query->patient->gender_format_result ?? null;

                return $patientGender;
            })
            ->addColumn('unit_name', function (Outpatient $query) {
                $unitName = $query->unit->name ?? null;

                return $unitName;
            })
            ->addColumn('action', function (Outpatient $query) {
                return '
                    <a href="' . url('nursing/outpatient/action/' . $query->id) . '" class="btn btn-primary btn-sm">
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
        $outpatient = Outpatient::findOrFail($id);
        $limitAction = $outpatient->limit_action;

        if ($request->has('date')) {
            $date = $request->date;
        } else {
            if (!empty($outpatient->date_of_out)) {
                $date = date('Y-m-d', strtotime($outpatient->date_of_entry));
            } else {
                $date = date('Y-m-d');
            }
        }

        if ($request->ajax()) {
            try {
                DB::transaction(function () use ($request, $outpatient, $limitAction) {
                    $outpatient->outpatientNursing()->delete();

                    if ($request->has('item')) {
                        foreach ($request->item as $key => $i) {
                            $num = $key + 1;

                            if ($num <= $limitAction) {
                                $unitActionId = $request->unit_action_id[$key];
                                $userId = $request->user_id[$key];
                                $unitAction = UnitAction::find($unitActionId);

                                if ($unitAction) {
                                    $outpatient->outpatientNursing()->create([
                                        'unit_action_id' => $unitActionId,
                                        'user_id' => $userId,
                                        'consumables' => $unitAction->consumables,
                                        'hospital_service' => $unitAction->hospital_service,
                                        'service' => $unitAction->service,
                                        'fee' => $unitAction->action->fee
                                    ]);
                                }
                            }
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

        $data = [
            'outpatient' => $outpatient,
            'outpatientNursing' => $outpatient->outpatientNursing()->whereDate('created_at', $date)->get(),
            'patient' => $outpatient->patient,
            'unitAction' => UnitAction::all(),
            'date' => $date,
            'limitAction' => $limitAction,
            'content' => 'nursing.outpatient-action'
        ];

        return view('layouts.index', ['data' => $data]);
    }
}
