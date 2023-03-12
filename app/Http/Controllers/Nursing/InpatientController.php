<?php

namespace App\Http\Controllers\Nursing;

use App\Models\Action;
use App\Models\Inpatient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class InpatientController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'nursing.inpatient'
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
                        })
                        ->orWhereHas('bed', function ($query) use ($search) {
                            $query->where('name', 'like', "%%$search%")
                                ->orWhereHas('roomSpace', function ($query) use ($search) {
                                    $query->whereHas('roomType', function ($query) use ($search) {
                                        $query->where('name', 'like', "%$search%");
                                    });
                                });
                        });
                }
            })
            ->editColumn('status', function (Inpatient $query) {
                return $query->status();
            })
            ->addColumn('code', function (Inpatient $query) {
                return $query->code();
            })
            ->addColumn('patient_name', function (Inpatient $query) {
                $patientName = $query->patient->name ?? null;

                return $patientName;
            })
            ->addColumn('patient_id', function (Inpatient $query) {
                $patientId = $query->patient->no_medical_record ?? null;

                return $patientId;
            })
            ->addColumn('room_type_name', function (Inpatient $query) {
                $roomTypeName = null;

                if (isset($query->bed)) {
                    if (isset($query->bed->roomSpace)) {
                        if (isset($query->bed->roomSpace->roomType)) {
                            $roomTypeName = $query->bed->roomSpace->roomType->name . ' | ' . $query->bed->roomSpace->roomType->classType->name;
                        }
                    }
                }

                return $roomTypeName;
            })
            ->addColumn('bed_name', function (Inpatient $query) {
                $bedName = $query->bed->name ?? null;

                return $bedName;
            })
            ->addColumn('action', function (Inpatient $query) {
                return '
                    <a href="' . url('nursing/inpatient/action/' . $query->id) . '" class="btn btn-primary btn-sm">
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
        $inpatient = Inpatient::findOrFail($id);

        if ($request->has('date')) {
            $date = $request->date;
        } else {
            if (!empty($inpatient->date_of_out)) {
                $date = date('Y-m-d', strtotime($inpatient->date_of_entry));
            } else {
                $date = date('Y-m-d');
            }
        }

        if ($request->ajax()) {
            try {
                DB::transaction(function () use ($request, $inpatient, $date) {
                    $inpatient->inpatientNursing()->whereDate('created_at', $date)->where('user_id', auth()->id())->delete();

                    if ($request->has('action_id')) {
                        foreach ($request->action_id as $ai) {
                            $explodeId = explode('_', $ai);
                            $actionId = end($explodeId);
                            $action = Action::find($actionId);

                            $inpatient->inpatientNursing()->create([
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

        $action = Action::whereHas('inpatientActionLimit', function ($query) use ($inpatient) {
            $query->where('inpatient_id', $inpatient->id);
        })->get();

        $data = [
            'inpatient' => $inpatient,
            'inpatientNursing' => $inpatient->inpatientNursing()->whereDate('created_at', $date)->get(),
            'patient' => $inpatient->patient,
            'action' => $action,
            'date' => $date,
            'content' => 'nursing.inpatient-action'
        ];

        return view('layouts.index', ['data' => $data]);
    }
}
