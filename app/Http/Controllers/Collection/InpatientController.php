<?php

namespace App\Http\Controllers\Collection;

use App\Helpers\Simrs;
use App\Models\Doctor;
use App\Models\LabItem;
use App\Models\Medicine;
use App\Models\RoomType;
use App\Models\Inpatient;
use App\Models\Radiology;
use App\Models\LabRequest;
use App\Models\ActionOther;
use App\Models\LabItemGroup;
use Illuminate\Http\Request;
use App\Models\MedicalService;
use App\Models\ActionOperative;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ActionSupporting;
use App\Models\RadiologyRequest;
use App\Models\FunctionalService;
use App\Models\ActionNonOperative;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

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
                    $query->whereRaw("LPAD(id, 6, 0) LIKE '%$search%'")
                        ->orWhereHas('patient', function ($query) use ($search) {
                            $query->where('id', 'like', "$search%")
                                ->orWhere('name', 'like', "%$search%");
                        })
                        ->orWhereHas('roomType', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }
            })
            ->editColumn('date_of_entry', '{{ date("Y-m-d H:i:s", strtotime($date_of_entry)) }}')
            ->editColumn('status', function (Inpatient $query) {
                return $query->status();
            })
            ->addColumn('code', function (Inpatient $query) {
                return $query->code();
            })
            ->addColumn('parentable', function (Inpatient $query) {
                $parentable = 'Tidak Ada';

                if ($query->parent) {
                    $parentable = $query->parent->code();
                }

                return $parentable;
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
                $fullAction = '';
                if ($query->status == 1) {
                    $fullAction = '
                        <a href="' . url('collection/inpatient/checkout/' . $query->id) . '" class="btn btn-light text-secondary btn-sm fw-semibold">
                            Check-Out
                        </a>
                        <a href="javascript:void(0);" class="btn btn-light text-danger btn-sm fw-semibold" onclick="destroyData(' . $query->id . ')">
                            Hapus Data
                        </a>
                    ';
                }

                return '
                    <div class="btn-group">
                        <button type="button" class="btn btn-light text-primary btn-sm btn-block fw-semibold dropdown-toggle" data-bs-toggle="dropdown">Aksi</button>
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
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-light text-success btn-sm btn-block fw-semibold dropdown-toggle" data-bs-toggle="dropdown">Cetak</button>
                        <div class="dropdown-menu">
                            <a href="' . url('collection/inpatient/print/' . $query->id) . '?slug=receipt" target="_blank" class="dropdown-item fs-13">
                                <i class="ph-newspaper-clipping me-2"></i>
                                Kwitansi
                            </a>
                            <a href="' . url('collection/inpatient/print/' . $query->id) . '?slug=detail" target="_blank" class="dropdown-item fs-13">
                                <i class="ph-clipboard-text me-2"></i>
                                Rincian
                            </a>
                            <a href="' . url('collection/inpatient/print/' . $query->id) . '?slug=bpjs" target="_blank" class="dropdown-item fs-13">
                                <i class="ph-shield-plus me-2"></i>
                                BPJS
                            </a>
                        </div>
                    </div>
                    ' . $fullAction . '
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
            try {
                DB::transaction(function () use ($request, $inpatient) {
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
            'content' => 'collection.inpatient-action'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function recipe(Request $request, $id)
    {
        $inpatient = Inpatient::findOrFail($id);

        if ($request->_token == csrf_token()) {
            $validation = Validator::make($request->all(), [
                'recipe' => 'required',
            ], [
                'recipe.required' => 'Mohon memilih salah satu obat',
            ]);

            if ($validation->fails()) {
                return redirect()->back()->withErrors($validation);
            } else {
                try {
                    $inpatient->recipe()->delete();

                    foreach ($request->recipe as $r) {
                        $inpatient->recipe()->create([
                            'medicine_id' => $r
                        ]);
                    }

                    return redirect('collection/inpatient/recipe/' . $id)->with([
                        'success' => 'Data berhasil di submit'
                    ]);
                } catch (\Exception $e) {
                    return redirect()->back()->with([
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        $data = [
            'inpatient' => $inpatient,
            'patient' => $inpatient->patient,
            'recipe' => $inpatient->recipe,
            'medicine' => Medicine::where('stock', '>', 0)->get(),
            'content' => 'collection.inpatient-recipe'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function diagnosis(Request $request, $id)
    {
        $inpatient = Inpatient::findOrFail($id);

        if ($request->ajax()) {
            try {
                $inpatient->inpatientDiagnosis()->delete();

                if ($request->has('diagnosis')) {
                    foreach ($request->diagnosis as $d) {
                        if (!empty($d)) {
                            $inpatient->inpatientDiagnosis()->create([
                                'type' => 1,
                                'value' => $d
                            ]);
                        }
                    }
                }

                if ($request->has('action')) {
                    foreach ($request->action as $a) {
                        if (!empty($a)) {
                            $inpatient->inpatientDiagnosis()->create([
                                'type' => 2,
                                'value' => $a
                            ]);
                        }
                    }
                }

                $response = [
                    'code' => 200,
                    'message' => 'Diagnosa berhasil disimpan'
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
            'inpatientDiagnosis' => $inpatient->inpatientDiagnosis,
            'content' => 'collection.inpatient-diagnosis'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function lab(Request $request, $id)
    {
        $inpatient = Inpatient::findOrFail($id);

        if ($request->ajax()) {
            $validation = Validator::make($request->all(), [
                'date_of_request' => 'required',
                'lrd_item_id' => 'required'
            ], [
                'date_of_request.required' => 'tanggal permintaan tidak boleh kosong',
                'lrd_item_id.required' => 'mohon memilih salah satu item'
            ]);

            if ($validation->fails()) {
                $response = [
                    'code' => 400,
                    'error' => $validation->errors()->all(),
                ];
            } else {
                try {
                    DB::transaction(function () use ($request, $inpatient) {
                        $createLabRequest = LabRequest::create([
                            'patient_id' => $inpatient->patient_id,
                            'doctor_id' => $inpatient->doctor_id,
                            'lab_requestable_type' => Inpatient::class,
                            'lab_requestable_id' => $inpatient->id,
                            'date_of_request' => $request->date_of_request,
                            'status' => 1
                        ]);

                        foreach ($request->lrd_item_id as $lii) {
                            $labItem = LabItem::find($lii);
                            $labParent = $labItem ? $labItem->labItemParent : null;
                            $labFee = $labItem ? $labItem->labFee : null;

                            if ($labItem) {
                                $createLabRequest->labRequestDetail()->create([
                                    'lab_item_id' => $labItem->id,
                                    'lab_item_parent_id' => $labParent ? $labParent->id : null,
                                    'consumables' => $labFee ? $labFee->consumables : null,
                                    'hospital_service' => $labFee ? $labFee->hospital_service : null,
                                    'service' => $labFee ? $labFee->service : null
                                ]);
                            }
                        }
                    });

                    $response = [
                        'code' => 200,
                        'message' => 'Data berhasil dikirim di laboratorium'
                    ];
                } catch (\Exception $e) {
                    $response = [
                        'code' => $e->getCode(),
                        'message' => $e->getMessage()
                    ];
                }
            }

            return response()->json($response);
        }

        $data = [
            'inpatient' => $inpatient,
            'patient' => $inpatient->patient,
            'labRequest' => $inpatient->labRequest,
            'labItemGroup' => LabItemGroup::orderBy('name')->get(),
            'content' => 'collection.inpatient-lab'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function labPrint(Request $request, $id)
    {
        $data = LabRequest::where('status', 3)->where('id', $id)->firstOrFail();

        if ($request->has('slug')) {
            if ($request->slug == 'result') {
                $view = 'pdf.lab-result';
                $title = 'Hasil Laboratorium';
            } else if ($request->slug == 'detail') {
                $view = 'pdf.lab-detail';
                $title = 'Rincian Biaya Hasil Cek Laboratorium';
            } else {
                abort(404);
            }

            $pdf = Pdf::setOptions([
                'adminUsername' => auth()->user()->username
            ])->loadView($view, [
                'title' => $title,
                'data' => $data
            ]);

            return $pdf->stream($title . ' - ' . date('YmdHis') . '.pdf');
        }

        abort(404);
    }

    public function radiology(Request $request, $id)
    {
        $inpatient = Inpatient::findOrFail($id);

        if ($request->ajax()) {
            $validation = Validator::make($request->all(), [
                'date_of_request' => 'required',
                'radiology_id' => 'required'
            ], [
                'date_of_request.required' => 'tanggal permintaan tidak boleh kosong',
                'radiology_id.required' => 'mohon memilih tindakan'
            ]);

            if ($validation->fails()) {
                $response = [
                    'code' => 400,
                    'error' => $validation->errors()->all(),
                ];
            } else {
                try {
                    DB::transaction(function () use ($request, $inpatient) {
                        $radiology = Radiology::find($request->radiology_id);

                        RadiologyRequest::create([
                            'doctor_id' => $inpatient->doctor_id,
                            'patient_id' => $inpatient->patient_id,
                            'radiology_id' => $request->radiology_id,
                            'radiology_requestable_type' => Inpatient::class,
                            'radiology_requestable_id' => $inpatient->id,
                            'date_of_request' => $request->date_of_request,
                            'consumables' => $radiology->radiologyAction->consumables ?? 0,
                            'hospital_service' => $radiology->radiologyAction->hospital_service ?? 0,
                            'service' => $radiology->radiologyAction->service ?? 0,
                            'fee' => $radiology->radiologyAction->fee ?? 0,
                            'status' => 1
                        ]);
                    });

                    $response = [
                        'code' => 200,
                        'message' => 'Data berhasil dikirim di radiologi'
                    ];
                } catch (\Exception $e) {
                    $response = [
                        'code' => $e->getCode(),
                        'message' => $e->getMessage()
                    ];
                }
            }

            return response()->json($response);
        }

        $radiology = Radiology::whereHas('radiologyAction', function ($query) use ($inpatient) {
            $query->where('class_type_id', $inpatient->roomType->class_type_id);
        })->orderBy('type')->get();

        $data = [
            'inpatient' => $inpatient,
            'patient' => $inpatient->patient,
            'radiologyRequest' => $inpatient->radiologyRequest,
            'radiology' => $radiology,
            'content' => 'collection.inpatient-radiology'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function radiologyPrint($id)
    {
        $data = RadiologyRequest::where('status', 3)->where('id', $id)->firstOrFail();
        $pdf = Pdf::setOptions([
            'adminUsername' => auth()->user()->username
        ])->loadView('pdf.radiology-result', [
            'title' => 'Hasil Pemeriksaan Radiologi',
            'data' => $data
        ]);

        return $pdf->stream('Hasil Pemeriksaan Radiologi - ' . date('YmdHis') . '.pdf');
    }

    public function checkout(Request $request, $id)
    {
        $inpatient = Inpatient::where('status', 1)->findOrFail($id);

        if ($request->ajax()) {
            $status = $request->status;
            $ruleMessage = [
                'rule' => [
                    'status' => 'required'
                ],
                'message' => [
                    'status.required' => 'mohon memilih status'
                ]
            ];

            if ($status == 2) {
                $ruleMessage = [
                    'rule' => [
                        'room_type_id' => 'required',
                        'type' => 'required',
                        'functional_service_id' => 'required',
                    ],
                    'message' => [
                        'room_type_id.required' => 'mohon memilih kelas kamar baru',
                        'type.required' => 'mohon memilih golongan baru',
                        'functional_service_id.required' => 'mohon memilih upf baru'
                    ]
                ];
            } else if ($status == 3 || $status == 4) {
                $ruleMessage = [
                    'rule' => [
                        'ending' => 'required',
                        'date_of_out' => 'required'
                    ],
                    'message' => [
                        'ending.required' => 'mohon memilih hasil',
                        'date_of_out.required' => 'tanggal keluar tidak boleh kosong'
                    ]
                ];
            }

            $validation = Validator::make($request->all(), $ruleMessage['rule'], $ruleMessage['message']);

            if ($validation->fails()) {
                $response = [
                    'code' => 400,
                    'error' => $validation->errors()->all(),
                ];
            } else {
                try {
                    if ($status == 2) {
                        Inpatient::create([
                            'user_id' => auth()->id(),
                            'patient_id' => $inpatient->patient_id,
                            'room_type_id' => $request->room_type_id,
                            'functional_service_id' => $request->functional_service_id,
                            'parent_id' => $inpatient->id,
                            'type' => $request->type,
                            'date_of_entry' => now()
                        ]);

                        $inpatient->update([
                            'date_of_out' => now()
                        ]);
                    } else if ($status == 3 || $status == 4) {
                        $inpatient->update([
                            'date_of_out' => $request->date_of_out,
                            'ending' => $request->ending
                        ]);
                    }

                    $inpatient->update([
                        'status' => $status
                    ]);

                    $response = [
                        'code' => 200,
                        'message' => 'Rawat inap berhasil di checkout'
                    ];
                } catch (\Exception $e) {
                    $response = [
                        'code' => $e->getCode(),
                        'message' => $e->getMessage()
                    ];
                }
            }

            return response()->json($response);
        }

        $data = [
            'inpatient' => $inpatient,
            'patient' => $inpatient->patient,
            'roomType' => RoomType::where('status', true)->orderBy('class_type_id')->get(),
            'functionalService' => FunctionalService::where('status', true)->orderBy('name')->get(),
            'content' => 'collection.inpatient-checkout'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function destroyData(Request $request)
    {
        $id = $request->id;

        try {
            Inpatient::destroy($id);

            $response = [
                'code' => 200,
                'message' => 'Data telah dihapus'
            ];
        } catch (\Exception $e) {
            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return response()->json($response);
    }
}
