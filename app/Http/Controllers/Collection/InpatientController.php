<?php

namespace App\Http\Controllers\Collection;

use App\Helpers\Simrs;
use App\Models\Doctor;
use App\Models\Inpatient;
use App\Models\ActionOther;
use Illuminate\Http\Request;
use App\Models\MedicalService;
use App\Models\ActionOperative;
use App\Models\ActionSupporting;
use App\Models\ActionNonOperative;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class InpatientController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'collection.inpatient'
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
                    $query->whereHas('patient', function ($query) use ($search) {
                        $query->where('id', 'like', "%$search%")
                            ->orWhere('name', 'like', "%$search%");
                    });

                    $query->whereHas('roomType', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });
                }
            })
            ->editColumn('date_of_entry', '{{ date("Y-m-d H:i:s", strtotime($date_of_entry)) }}')
            ->editColumn('status', function (Inpatient $query) {
                return $query->status();
            })
            ->addColumn('patient_name', function (Inpatient $query) {
                $patientName = null;

                if (isset($query->patient)) {
                    $patientName = $query->patient->name;
                }

                return $patientName;
            })
            ->addColumn('room_type_name', function (Inpatient $query) {
                $roomTypeName = null;

                if (isset($query->roomType)) {
                    $roomTypeName = $query->roomType->name . ' | ' . $query->roomType->classType->name;
                }

                return $roomTypeName;
            })
            ->addColumn('action', function (Inpatient $query) {
                return '
                    <div class="btn-group">
                        <button type="button" class="btn btn-light text-primary btn-sm fw-semibold dropdown-toggle" data-bs-toggle="dropdown">Aksi</button>
                        <div class="dropdown-menu">
                            <a href="' . url('collection/inpatient/action/' . $query->id) . '" class="dropdown-item fs-13">
                                <i class="ph-person-simple-run me-2"></i>
                                Tindakan
                            </a>
                            <a href="' . url('collection/inpatient/recipe/' . $query->id) . '" class="dropdown-item fs-13">
                                <i class="ph-drop-half-bottom me-2"></i>
                                E-Resep
                            </a>
                            <a href="' . url('collection/inpatient/diagnosis/' . $query->id) . '" class="dropdown-item fs-13">
                                <i class="ph-bezier-curve me-2"></i>
                                Diagnosa
                            </a>
                            <a href="' . url('collection/inpatient/lab/' . $query->id) . '" class="dropdown-item fs-13">
                                <i class="ph-flask me-2"></i>
                                Laboratorium
                            </a>
                            <a href="' . url('collection/inpatient/radiology/' . $query->id) . '" class="dropdown-item fs-13">
                                <i class="ph-wheelchair me-2"></i>
                                Radiologi
                            </a>
                            <a href="' . url('collection/inpatient/print/' . $query->id) . '?slug=receipt" target="_blank" class="dropdown-item fs-13">
                                <i class="ph-newspaper-clipping me-2"></i>
                                Cetak Kwitansi
                            </a>
                            <a href="' . url('collection/inpatient/print/' . $query->id) . '?slug=detail" target="_blank" class="dropdown-item fs-13">
                                <i class="ph-clipboard-text me-2"></i>
                                Cetak Rincian
                            </a>
                            <a href="' . url('collection/inpatient/print/' . $query->id) . '?slug=bpjs" target="_blank" class="dropdown-item fs-13">
                                <i class="ph-shield-plus me-2"></i>
                                Cetak BPJS
                            </a>
                            <a href="' . url('collection/inpatient/checkout/' . $query->id) . '" class="dropdown-item fs-13">
                                <i class="ph-sign-out me-2"></i>
                                Check-Out
                            </a>
                        </div>
                    </div>
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
        $roomType = $inpatient->roomType;
        $classType = $roomType->classType;

        if ($request->ajax()) {
            DB::transaction(function () use ($request, $inpatient, $roomType, $classType) {
                $observation = [
                    'action_emergency_care_id' => (int) $request->observation_action_emergency_care_id,
                    'nominal' => Simrs::numberable($request->observation_nominal)
                ];

                $supervisionDoctor = [
                    'action_emergency_care_id' => (int) $request->supervision_doctor_action_emergency_care_id,
                    'doctor_id' => (int) $request->supervision_doctor_doctor_id,
                    'nominal' => Simrs::numberable($request->supervision_doctor_nominal)
                ];

                $inpatient->update([
                    'doctor_id' => $request->doctor_id,
                    'date_of_out' => date('Y-m-d H:i:s', strtotime($request->date_of_out)),
                    'observation' => $observation,
                    'supervision_doctor' => $supervisionDoctor,
                    'fee_room' => $request->fee_room,
                    'fee_nursing_care' => $request->fee_nursing_care,
                    'fee_nutritional_care' => $request->fee_nutritional_care,
                    'fee_nutritional_care_qty' => $request->fee_nutritional_care_qty,
                    'ending' => $request->ending
                ]);

                $inpatient->inpatientHealth()->delete();
                $inpatient->inpatientNonOperative()->delete();
                $inpatient->inpatientOperative()->delete();
                $inpatient->inpatientOther()->delete();
                $inpatient->inpatientPackage()->delete();
                $inpatient->inpatientService()->delete();
                $inpatient->inpatientSupporting()->delete();

                if ($request->has('inpatient_health')) {
                    foreach ($request->inpatient_health as $key => $ih) {
                        $inpatient->inpatientHealth()->create([
                            'tool_id' => $request->ih_tool_id[$key],
                            'emergency_care' => $request->ih_emergency_care[$key],
                            'hospitalization' => $request->ih_hospitalization[$key]
                        ]);
                    }
                }

                if ($request->has('inpatient_non_operative')) {
                    foreach ($request->inpatient_non_operative as $key => $ino) {
                        $inpatient->inpatientNonOperative()->create([
                            'action_non_operative_id' => $request->ino_action_non_operative_id[$key],
                            'emergency_care' => $request->ino_emergency_care[$key],
                            'hospitalization' => $request->ino_hospitalization[$key]
                        ]);
                    }
                }

                if ($request->has('inpatient_operative')) {
                    foreach ($request->inpatient_operative as $key => $io) {
                        $inpatient->inpatientOperative()->create([
                            'action_operative_id' => $request->io_action_operative_id[$key],
                            'nominal' => $request->io_nominal[$key]
                        ]);
                    }
                }

                if ($request->has('inpatient_other')) {
                    foreach ($request->inpatient_other as $key => $io) {
                        $inpatient->inpatientOther()->create([
                            'action_other_id' => $request->io_action_other_id[$key],
                            'emergency_care' => $request->io_emergency_care[$key],
                            'hospitalization' => $request->io_hospitalization[$key],
                            'hospitalization_qty' => $request->io_hospitalization_qty[$key]
                        ]);
                    }
                }

                if ($request->has('inpatient_package')) {
                    foreach ($request->inpatient_package as $ip) {
                        $inpatient->inpatientPackage()->create([
                            'nominal' => $ip
                        ]);
                    }
                }

                if ($request->has('inpatient_service')) {
                    foreach ($request->inpatient_service as $key => $is) {
                        $emergencyCare = [
                            'doctor_id' => (int) $request->is_emergency_care_doctor_id[$key],
                            'nominal' => Simrs::numberable($request->is_emergency_care_nominal[$key]),
                            'qty' => Simrs::numberable($request->is_emergency_care_qty[$key])
                        ];

                        $hospitalization = [
                            'doctor_id' => (int) $request->is_hospitalization_doctor_id[$key],
                            'nominal' => Simrs::numberable($request->is_hospitalization_nominal[$key]),
                            'qty' => Simrs::numberable($request->is_hospitalization_qty[$key])
                        ];

                        $inpatient->inpatientService()->create([
                            'medical_service_id' => $request->is_medical_service_id[$key],
                            'emergency_care' => $emergencyCare,
                            'hospitalization' => $hospitalization
                        ]);
                    }
                }

                if ($request->has('inpatient_supporting')) {
                    foreach ($request->inpatient_supporting as $key => $is) {
                        $inpatient->inpatientSupporting()->create([
                            'action_supporting_id' => $request->is_action_supporting_id[$key],
                            'doctor_id' => $request->is_doctor_id[$key],
                            'emergency_care' => $request->is_emergency_care[$key],
                            'hospitalization' => $request->is_hospitalization[$key]
                        ]);
                    }
                }
            });

            return response()->json([
                'code' => 200,
                'message' => 'Tindakan berhasil disimpan'
            ]);
        }

        $data = [
            'inpatient' => $inpatient,
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
            'content' => 'collection.inpatient-action'
        ];

        return view('layouts.index', ['data' => $data]);
    }
}
