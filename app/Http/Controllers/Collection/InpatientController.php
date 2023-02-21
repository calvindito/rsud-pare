<?php

namespace App\Http\Controllers\Collection;

use App\Models\Item;
use App\Models\Unit;
use App\Helpers\Simrs;
use App\Models\Doctor;
use App\Models\LabItem;
use App\Models\Patient;
use App\Models\Employee;
use App\Models\Religion;
use App\Models\RoomType;
use App\Models\Inpatient;
use App\Models\ItemStock;
use App\Models\Operation;
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
use App\Models\OperatingRoomAction;
use App\Http\Controllers\Controller;
use App\Models\OperatingRoomAnesthetist;
use App\Models\OperationDoctorAssistant;
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
                        <div class="btn-group">
                            <button type="button" class="btn btn-light text-warning btn-sm btn-block fw-semibold dropdown-toggle" data-bs-toggle="dropdown">Lainnya</button>
                            <div class="dropdown-menu">
                                <a href="' . url('collection/inpatient/update-data/' . $query->id) . '" class="dropdown-item fs-13">
                                    <i class="ph-pen me-2"></i>
                                    Edit Data
                                </a>
                                <a href="javascript:void(0);" class="dropdown-item fs-13" onclick="destroyData(' . $query->id . ')">
                                    <i class="ph-trash-simple me-2"></i>
                                    Hapus Data
                                </a>
                            </div>
                        </div>
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
                            <a href="' . url('collection/inpatient/operating-room/' . $query->id) . '" class="dropdown-item fs-13">
                                <i class="ph-bed me-2"></i>
                                Kamar Operasi
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

    public function loadPatient(Request $request)
    {
        $id = $request->id;
        $data = Patient::with([
            'inpatient' => fn ($q) => $q->with(['roomType.classType', 'functionalService'])
        ])->whereNotNull('verified_at')->findOrFail($id);

        return response()->json($data);
    }

    public function registerPatient(Request $request)
    {
        if ($request->ajax()) {
            $patientId = $request->patient_id;
            $validation = Validator::make($request->all(), [
                'patient_id' => 'required',
                'identity_number' => 'nullable|digits:16|numeric|unique:patients,identity_number,' . $patientId,
                'name' => 'required',
                'gender' => 'required',
                'religion_id' => 'required',
                'type' => 'required',
                'date_of_entry' => 'required',
                'room_type_id' => 'required',
                'functional_service_id' => 'required',
                'doctor_id' => 'required'
            ], [
                'patient_id' => 'mohon memilih pasien',
                'identity_number.digits' => 'no identitas harus 16 karakter',
                'identity_number.numeric' => 'no identitas harus angka',
                'identity_number.unique' => 'no identitas telah digunakan',
                'name.required' => 'nama tidak boleh kosong',
                'gender.required' => 'mohon memilih jenis kelamin',
                'religion_id.required' => 'mohon memilih agama',
                'type.required' => 'mohon memilih golongan pasien',
                'date_of_entry.required' => 'tanggal masuk tidak boleh kosong',
                'room_type_id.required' => 'mohon memilih kamar',
                'functional_service_id.required' => 'mohon memilih upf',
                'doctor_id.required' => 'mohon memilih dokter'
            ]);

            if ($validation->fails()) {
                $response = [
                    'code' => 400,
                    'error' => $validation->errors()->all(),
                ];
            } else {
                try {
                    DB::transaction(function () use ($request, $patientId) {
                        $userId = auth()->id();
                        $hasDataPatient = Patient::find($patientId);
                        $dateOfEntry = date('Y-m-d H:i:s', strtotime($request->date_of_entry));

                        $fillPatient = [
                            'religion_id' => $request->religion_id,
                            'identity_number' => $request->identity_number,
                            'name' => $request->name,
                            'greeted' => $request->greeted,
                            'gender' => $request->gender,
                            'date_of_birth' => $request->date_of_birth,
                            'religion_id' => $request->religion_id
                        ];

                        if ($hasDataPatient) {
                            $hasDataPatient->update($fillPatient);
                            $patientId = $hasDataPatient->id;
                        } else {
                            $fillPatient = array_merge($fillPatient, ['verified_at' => now()]);
                            $createPatient = Patient::create($fillPatient);
                            $patientId = $createPatient->id;
                        }

                        Inpatient::create([
                            'user_id' => $userId,
                            'patient_id' => $patientId,
                            'room_type_id' => $request->room_type_id,
                            'functional_service_id' => $request->functional_service_id,
                            'type' => $request->type,
                            'date_of_entry' => $dateOfEntry
                        ]);
                    });

                    $response = [
                        'code' => 200,
                        'message' => 'Pasien berhasil didaftarkan'
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
            'roomType' => RoomType::where('status', true)->orderBy('name')->get(),
            'functionalService' => FunctionalService::where('status', true)->orderBy('name')->get(),
            'religion' => Religion::all(),
            'doctor' => Doctor::all(),
            'content' => 'collection.inpatient-register-patient'
        ];

        return view('layouts.index', ['data' => $data]);
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
                        'action_emergency_care_id' => (int) $request->observation_action_emergency_care_id ?? null,
                        'nominal' => Simrs::numberable($request->observation_nominal ?? null)
                    ];

                    $supervisionDoctor = [
                        'action_emergency_care_id' => (int) $request->supervision_doctor_action_emergency_care_id ?? null,
                        'doctor_id' => (int) $request->supervision_doctor_doctor_id ?? null,
                        'nominal' => Simrs::numberable($request->supervision_doctor_nominal ?? null)
                    ];

                    $inpatient->update([
                        'observation' => $observation,
                        'supervision_doctor' => $supervisionDoctor,
                        'fee_room' => $request->fee_room,
                        'fee_nursing_care' => $request->fee_nursing_care,
                        'fee_nutritional_care' => $request->fee_nutritional_care,
                        'fee_nutritional_care_qty' => $request->fee_nutritional_care_qty
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
                                'tool_id' => $request->ih_tool_id[$key] ?? null,
                                'emergency_care' => $request->ih_emergency_care[$key] ?? null,
                                'hospitalization' => $request->ih_hospitalization[$key] ?? null
                            ]);
                        }
                    }

                    if ($request->has('inpatient_non_operative')) {
                        foreach ($request->inpatient_non_operative as $key => $ino) {
                            $inpatient->inpatientNonOperative()->create([
                                'action_non_operative_id' => $request->ino_action_non_operative_id[$key] ?? null,
                                'emergency_care' => $request->ino_emergency_care[$key] ?? null,
                                'hospitalization' => $request->ino_hospitalization[$key] ?? null
                            ]);
                        }
                    }

                    if ($request->has('inpatient_operative')) {
                        foreach ($request->inpatient_operative as $key => $io) {
                            $inpatient->inpatientOperative()->create([
                                'action_operative_id' => $request->io_action_operative_id[$key] ?? null,
                                'nominal' => $request->io_nominal[$key] ?? null
                            ]);
                        }
                    }

                    if ($request->has('inpatient_other')) {
                        foreach ($request->inpatient_other as $key => $io) {
                            $inpatient->inpatientOther()->create([
                                'action_other_id' => $request->io_action_other_id[$key] ?? null,
                                'emergency_care' => $request->io_emergency_care[$key] ?? null,
                                'hospitalization' => $request->io_hospitalization[$key] ?? null,
                                'hospitalization_qty' => $request->io_hospitalization_qty[$key] ?? null
                            ]);
                        }
                    }

                    if ($request->has('inpatient_package')) {
                        foreach ($request->inpatient_package as $ip) {
                            $inpatient->inpatientPackage()->create([
                                'nominal' => $ip ?? null
                            ]);
                        }
                    }

                    if ($request->has('inpatient_service')) {
                        foreach ($request->inpatient_service as $key => $is) {
                            $emergencyCare = [
                                'doctor_id' => (int) $request->is_emergency_care_doctor_id[$key] ?? null,
                                'nominal' => Simrs::numberable($request->is_emergency_care_nominal[$key]) ?? null,
                                'qty' => Simrs::numberable($request->is_emergency_care_qty[$key]) ?? null
                            ];

                            $hospitalization = [
                                'doctor_id' => (int) $request->is_hospitalization_doctor_id[$key] ?? null,
                                'nominal' => Simrs::numberable($request->is_hospitalization_nominal[$key]) ?? null,
                                'qty' => Simrs::numberable($request->is_hospitalization_qty[$key]) ?? null
                            ];

                            $inpatient->inpatientService()->create([
                                'medical_service_id' => $request->is_medical_service_id[$key] ?? null,
                                'emergency_care' => $emergencyCare,
                                'hospitalization' => $hospitalization
                            ]);
                        }
                    }

                    if ($request->has('inpatient_supporting')) {
                        foreach ($request->inpatient_supporting as $key => $is) {
                            $inpatient->inpatientSupporting()->create([
                                'action_supporting_id' => $request->is_action_supporting_id[$key] ?? null,
                                'doctor_id' => $request->is_doctor_id[$key] ?? null,
                                'emergency_care' => $request->is_emergency_care[$key] ?? null,
                                'hospitalization' => $request->is_hospitalization[$key] ?? null
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

        if ($request->ajax()) {
            $validation = Validator::make($request->all(), [
                'item' => 'required',
            ], [
                'item.required' => 'mohon mengisi minimal 1 barang yang diresepkan',
            ]);

            if ($validation->fails()) {
                $response = [
                    'code' => 400,
                    'error' => $validation->errors()->all(),
                ];
            } else {
                try {
                    $inpatient->recipe()->whereNull('status')->delete();

                    if ($request->has('item')) {
                        foreach ($request->item as $key => $i) {
                            $itemStockId = isset($request->r_item_stock_id[$key]) ? $request->r_item_stock_id[$key] : 0;
                            $status = isset($request->r_status[$key]) ? $request->r_status[$key] : null;

                            if ($itemStockId && empty($status)) {
                                $itemStock = ItemStock::where('stock', '>', 0)->find($itemStockId);
                                $qty = isset($request->r_qty[$key]) ? (int) $request->r_qty[$key] : 0;
                                $stock = $itemStock->stock ?? 0;

                                if ($stock > 0) {
                                    if ($qty > $stock) {
                                        $qty = $stock;
                                    }

                                    $inpatient->recipe()->create([
                                        'user_id' => auth()->id(),
                                        'patient_id' => $inpatient->patient_id,
                                        'item_stock_id' => $itemStockId,
                                        'qty' => $qty,
                                        'price_purchase' => $itemStock->price_purchase ?? null,
                                        'price_sell' => $itemStock->price_sell ?? null,
                                        'discount' => $itemStock->discount ?? null
                                    ]);
                                }
                            }
                        }
                    }

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
            }

            return response()->json($response);
        }

        $data = [
            'inpatient' => $inpatient,
            'patient' => $inpatient->patient,
            'recipe' => $inpatient->recipe,
            'item' => Item::available(['type' => Inpatient::class, 'id' => $inpatient->id])->get(),
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
        $data = LabRequest::where('status', 3)->findOrFail($id);

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
                            'consumables' => $radiology->radiologyAction->consumables ?? null,
                            'hospital_service' => $radiology->radiologyAction->hospital_service ?? null,
                            'service' => $radiology->radiologyAction->service ?? null,
                            'fee' => $radiology->radiologyAction->fee ?? null,
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
        $data = RadiologyRequest::where('status', 3)->findOrFail($id);
        $pdf = Pdf::setOptions([
            'adminUsername' => auth()->user()->username
        ])->loadView('pdf.radiology-result', [
            'title' => 'Hasil Pemeriksaan Radiologi',
            'data' => $data
        ]);

        return $pdf->stream('Hasil Pemeriksaan Radiologi - ' . date('YmdHis') . '.pdf');
    }

    public function operatingRoom(Request $request, $id)
    {
        $inpatient = Inpatient::findOrFail($id);
        $patientId = $inpatient->patient->id;
        $operation = $inpatient->operation;

        if ($request->ajax()) {
            $validation = Validator::make($request->all(), [
                'identity_number' => 'nullable|digits:16|numeric|unique:patients,identity_number,' . $patientId,
                'name' => 'required',
                'gender' => 'required',
                'date_of_birth' => 'required',
                'village' => 'required',
                'address' => 'required',
                'unit_id' => 'required',
                'date_of_entry' => 'required',
                'operating_room_action_id' => 'required',
                'functional_service_id' => 'required',
                'operating_room_anesthetist_id' => 'required',
                'doctor_id' => 'required'
            ], [
                'identity_number.digits' => 'no identitas harus 16 karakter',
                'identity_number.numeric' => 'no identitas harus angka',
                'identity_number.unique' => 'no identitas telah digunakan',
                'name.required' => 'nama tidak boleh kosong',
                'gender.required' => 'mohon memilih jenis kelamin',
                'date_of_birth.required' => 'tanggal lahir tidak boleh kosong',
                'village.required' => 'nama tidak boleh kosong',
                'address.required' => 'alamat tidak boleh kosong',
                'unit_id.required' => 'mohon memilih unit',
                'date_of_entry.required' => 'tanggal masuk tidak boleh kosong',
                'operating_room_action_id.required' => 'mohon memilih operasi',
                'functional_service_id.required' => 'mohon memilih upf',
                'operating_room_anesthetist_id.required' => 'mohon memilih jenis anestesi',
                'doctor_id.required' => 'mohon memilih dokter anestesi'
            ]);

            if ($validation->fails()) {
                $response = [
                    'code' => 400,
                    'error' => $validation->errors()->all(),
                ];
            } else {
                try {
                    DB::transaction(function () use ($request, $patientId, $inpatient, $operation) {
                        $userId = auth()->id();
                        $dateOfEntry = date('Y-m-d H:i:s', strtotime($request->date_of_entry));
                        $operatingRoomActionId = $request->operating_room_action_id;
                        $operatingRoomAction = OperatingRoomAction::find($operatingRoomActionId);

                        $fillPatient = [
                            'identity_number' => $request->identity_number,
                            'name' => $request->name,
                            'greeted' => $request->greeted,
                            'gender' => $request->gender,
                            'date_of_birth' => $request->date_of_birth,
                            'village' => $request->village,
                            'address' => $request->address
                        ];

                        $fillOperation = [
                            'user_id' => $userId,
                            'patient_id' => $patientId,
                            'operating_room_action_id' => $operatingRoomActionId,
                            'functional_service_id' => $request->functional_service_id,
                            'operating_room_anesthetist_id' => $request->operating_room_anesthetist_id,
                            'doctor_id' => $request->doctor_id,
                            'unit_id' => $request->unit_id,
                            'operationable_type' => Inpatient::class,
                            'operationable_id' => $inpatient->id,
                            'date_of_entry' => $dateOfEntry,
                            'diagnosis' => $request->diagnosis,
                            'specimen' => $request->specimen,
                            'hospital_service' => $operatingRoomAction->fee_hospital_service ?? null,
                            'doctor_operating_room' => $operatingRoomAction->fee_doctor_operating_room ?? null,
                            'doctor_anesthetist' => $operatingRoomAction->fee_doctor_anesthetist ?? null,
                            'nurse_operating_room' => $operatingRoomAction->fee_nurse_operating_room ?? null,
                            'nurse_anesthetist' => $operatingRoomAction->fee_nurse_anesthetist ?? null

                        ];

                        if ($operation) {
                            $operation->operationDoctorAssistant()->delete();
                            $operation->fill($fillOperation)->save();
                            $operationId = $operation->id;
                        } else {
                            $operation = Operation::create($fillOperation);
                            $operationId = $operation->id;
                        }

                        if ($request->has('item')) {
                            foreach ($request->item as $key => $i) {
                                $employeeId = isset($request->o_employee_id[$key]) ? $request->o_employee_id[$key] : null;

                                if ($employeeId) {
                                    OperationDoctorAssistant::create([
                                        'operation_id' => $operationId,
                                        'employee_id' => $employeeId
                                    ]);
                                }
                            }
                        }

                        $inpatient->patient()->update($fillPatient);
                    });

                    $response = [
                        'code' => 200,
                        'message' => 'Data kamar operasi berhasil disimpan'
                    ];
                } catch (\Exception $e) {
                    $response = [
                        'code' => $e->getCode(),
                        'message' => $e->getMessage()
                    ];
                }
            }

            return response()->json($response);
        } else {
            $operatingRoomAction = OperatingRoomAction::where('class_type_id', $inpatient->roomType->class_type_id)
                ->where('status', true)
                ->orderBy('operating_room_group_id')
                ->orderBy('operating_room_action_type_id')
                ->get();

            $data = [
                'inpatient' => $inpatient,
                'operation' => $operation,
                'employee' => Employee::where('status', true)->get(),
                'unit' => Unit::where('type', 1)->orderBy('name')->get(),
                'operatingRoomAction' => $operatingRoomAction,
                'functionalService' => FunctionalService::where('status', true)->get(),
                'operatingRoomAnesthetist' => OperatingRoomAnesthetist::all(),
                'doctor' => Doctor::all(),
                'content' => 'collection.inpatient-operating-room'
            ];
        }

        return view('layouts.index', ['data' => $data]);
    }

    public function print(Request $request, $id)
    {
        $data = Inpatient::findOrFail($id);

        if ($request->has('slug')) {
            if ($request->slug == 'receipt') {
                $view = 'pdf.inpatient-receipt';
                $title = 'Kwitansi Rawat Inap';
            } else if ($request->slug == 'detail') {
                $view = 'pdf.inpatient-detail';
                $title = 'Rincian Biaya Rawat Inap';
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

    public function updateData(Request $request, $id)
    {
        $inpatient = Inpatient::where('status', 1)->findOrFail($id);
        $patient = $inpatient->patient;

        if ($request->ajax()) {
            $validation = Validator::make($request->all(), [
                'identity_number' => 'nullable|digits:16|numeric|unique:patients,identity_number,' . $patient->id,
                'name' => 'required',
                'gender' => 'required',
                'religion_id' => 'required',
                'type' => 'required',
                'date_of_entry' => 'required',
                'room_type_id' => 'required',
                'functional_service_id' => 'required',
                'doctor_id' => 'required'
            ], [
                'identity_number.digits' => 'no identitas harus 16 karakter',
                'identity_number.numeric' => 'no identitas harus angka',
                'identity_number.unique' => 'no identitas telah digunakan',
                'name.required' => 'nama tidak boleh kosong',
                'gender.required' => 'mohon memilih jenis kelamin',
                'religion_id.required' => 'mohon memilih agama',
                'type.required' => 'mohon memilih golongan pasien',
                'date_of_entry.required' => 'tanggal masuk tidak boleh kosong',
                'room_type_id.required' => 'mohon memilih kamar',
                'functional_service_id.required' => 'mohon memilih upf',
                'doctor_id.required' => 'mohon memilih dokter'
            ]);

            if ($validation->fails()) {
                $response = [
                    'code' => 400,
                    'error' => $validation->errors()->all(),
                ];
            } else {
                try {
                    DB::transaction(function () use ($request, $inpatient, $patient) {
                        $patient->update([
                            'religion_id' => $request->religion_id,
                            'identity_number' => $request->identity_number,
                            'name' => $request->name,
                            'greeted' => $request->greeted,
                            'gender' => $request->gender,
                            'date_of_birth' => $request->date_of_birth
                        ]);

                        $inpatient->update([
                            'user_id' => auth()->id(),
                            'room_type_id' => $request->room_type_id,
                            'functional_service_id' => $request->functional_service_id,
                            'doctor_id' => $request->doctor_id,
                            'type' => $request->type,
                            'date_of_entry' => $request->date_of_entry
                        ]);
                    });

                    $response = [
                        'code' => 200,
                        'message' => 'Data rawat inap berhasil diubah'
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
            'patient' => $patient,
            'roomType' => RoomType::where('status', true)->orderBy('name')->get(),
            'functionalService' => FunctionalService::where('status', true)->orderBy('name')->get(),
            'religion' => Religion::all(),
            'doctor' => Doctor::all(),
            'content' => 'collection.inpatient-update'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function destroyData(Request $request)
    {
        $id = $request->id;

        try {
            Inpatient::where('status', 1)->destroy($id);

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
