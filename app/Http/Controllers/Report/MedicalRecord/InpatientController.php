<?php

namespace App\Http\Controllers\Report\MedicalRecord;

use Carbon\Carbon;
use App\Helpers\Simrs;
use App\Models\Doctor;
use App\Models\RoomType;
use App\Models\ClassType;
use App\Models\Inpatient;
use App\Models\Dispensary;
use App\Models\ActionOther;
use Illuminate\Http\Request;
use App\Models\MedicalService;
use App\Models\ActionOperative;
use App\Models\ActionSupporting;
use App\Models\FunctionalService;
use App\Models\ActionNonOperative;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class InpatientController extends Controller
{
    public function index()
    {
        $data = [
            'functionalService' => FunctionalService::where('status', true)->get(),
            'doctor' => Doctor::all(),
            'dispensary' => Dispensary::all(),
            'type' => Simrs::nursingType(),
            'classType' => ClassType::all(),
            'roomType' => RoomType::where('status', true)->get(),
            'content' => 'report.medical-record.inpatient'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Inpatient::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search, $request) {
                if ($search) {
                    $query->whereRaw("LPAD(id, 7, 0) LIKE '%$search%'")
                        ->orWhereHas('patient', function ($query) use ($search) {
                            $query->whereRaw("LPAD(id, 7, 0) LIKE '%$search%'");
                        })
                        ->orWhereHas('bed', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%")
                                ->orWhereHas('roomSpace', function ($query) use ($search) {
                                    $query->whereHas('roomType', function ($query) use ($search) {
                                        $query->where('name', 'like', "%$search%")
                                            ->orWhereHas('classType', function ($query) use ($search) {
                                                $query->where('name', 'like', "%$search%");
                                            });
                                    });
                                });
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

                if ($request->bed_id) {
                    $query->where('bed_id', $request->bed_id);
                }

                if ($request->room_type_id || $request->class_type_id) {
                    $query->whereHas('bed', function ($query) use ($request) {
                        $query->whereHas('roomSpace', function ($query) use ($request) {
                            $query->whereHas('roomType', function ($query) use ($request) {
                                if ($request->room_type_id) {
                                    $query->where('id', $request->room_type_id);
                                }

                                if ($request->class_type_id) {
                                    $query->whereHas('classType', function ($query) use ($request) {
                                        $query->where('id', $request->class_type_id);
                                    });
                                }
                            });
                        });
                    });
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
            ->addColumn('code', function (Inpatient $query) {
                return $query->code();
            })
            ->addColumn('patient_name', function (Inpatient $query) {
                $patientName = $query->patient->name ?? null;

                return $patientName;
            })
            ->addColumn('room_type_name', function (Inpatient $query) {
                $roomTypeName = $query->bed->roomSpace->roomType->name ?? null;

                return $roomTypeName;
            })
            ->addColumn('class_type_name', function (Inpatient $query) {
                $classTypeName = $query->bed->roomSpace->roomType->classType->name ?? null;

                return $classTypeName;
            })
            ->addColumn('bed_name', function (Inpatient $query) {
                $bedName = $query->bed->name ?? null;

                return $bedName;
            })
            ->addColumn('functional_service_name', function (Inpatient $query) {
                $functionalServiceName = $query->functionalService->name ?? null;

                return $functionalServiceName;
            })
            ->addColumn('doctor_name', function (Inpatient $query) {
                $doctorName = $query->doctor->name ?? null;

                return $doctorName;
            })
            ->addColumn('dispensary_name', function (Inpatient $query) {
                $dispensaryName = $query->dispensary->name ?? null;

                return $dispensaryName;
            })
            ->addColumn('date', function (Inpatient $query) use ($request) {
                $toArray = $query->toArray();
                $date = $query->created_at->format('Y-m-d');

                if ($request->date) {
                    $date = date('Y-m-d', strtotime($toArray[$request->column_date]));
                }

                return $date;
            })
            ->addColumn('paid', function (Inpatient $query) {
                return $query->paid();
            })
            ->addColumn('status', function (Inpatient $query) {
                return $query->status();
            })
            ->addColumn('action', function (Inpatient $query) {
                return '
                    <a href="' . url('report/medical-record/inpatient/detail/' . $query->id) . '" class="btn btn-primary btn-sm">
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
        $inpatient = Inpatient::findOrFail($id);
        $roomType = $inpatient->bed->roomSpace->roomType;
        $classType = $roomType->classType;

        $data = [
            'inpatient' => $inpatient,
            'doctor' => Doctor::all(),
            'medicalService' => MedicalService::where('status', true)->where('class_type_id', $classType->id)->get(),
            'actionOperative' => ActionOperative::where('class_type_id', $classType->id)->get(),
            'actionNonOperative' => ActionNonOperative::where('class_type_id', $classType->id)->get(),
            'actionSupporting' => ActionSupporting::where('class_type_id', $classType->id)->get(),
            'tool' => Simrs::tool(),
            'actionOther' => ActionOther::where('class_type_id', $classType->id)->get(),
            'inpatientHealth' => $inpatient->inpatientHealth,
            'inpatientNonOperative' => $inpatient->inpatientNonOperative,
            'inpatientOperative' => $inpatient->inpatientOperative,
            'inpatientOther' => $inpatient->inpatientOther,
            'inpatientPackage' => $inpatient->inpatientPackage,
            'inpatientService' => $inpatient->inpatientService,
            'inpatientSupporting' => $inpatient->inpatientSupporting,
            'soap' => $inpatient->inpatientSoap,
            'diagnosis' => $inpatient->inpatientDiagnosis,
            'laboratorium' => $inpatient->labRequest,
            'radiology' => $inpatient->radiologyRequest,
            'operation' => $inpatient->operation,
            'recipe' => $inpatient->dispensaryRequest()->groupBy('dispensary_requestable_type', 'dispensary_requestable_id', 'dispensary_id')->get(),
            'content' => 'report.medical-record.inpatient-detail'
        ];

        return view('layouts.index', ['data' => $data]);
    }
}
