<?php

namespace App\Http\Controllers\Collection;

use App\Models\Unit;
use App\Helpers\Simrs;
use App\Models\Doctor;
use App\Models\LabItem;
use App\Models\Patient;
use App\Models\Employee;
use App\Models\Religion;
use App\Models\Operation;
use App\Models\Radiology;
use App\Models\Dispensary;
use App\Models\LabRequest;
use App\Models\Outpatient;
use App\Models\UnitAction;
use App\Models\LabItemGroup;
use Illuminate\Http\Request;
use App\Models\DispensaryItem;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\OutpatientAction;
use App\Models\RadiologyRequest;
use App\Models\FunctionalService;
use Illuminate\Support\Facades\DB;
use App\Models\DispensaryItemStock;
use App\Models\OperatingRoomAction;
use App\Http\Controllers\Controller;
use App\Models\OperatingRoomAnesthetist;
use App\Models\OperationDoctorAssistant;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class OutpatientController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'collection.outpatient'
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
            ->addColumn('parentable', function (Outpatient $query) {
                $parentable = 'Tidak Ada';

                if ($query->parent) {
                    $parentable = $query->parent->code();
                }

                return $parentable;
            })
            ->addColumn('patient_name', function (Outpatient $query) {
                $patientName = null;

                if (isset($query->patient)) {
                    $patientName = $query->patient->name;
                }

                return $patientName;
            })
            ->addColumn('patient_id', function (Outpatient $query) {
                $patientId = null;

                if (isset($query->patient)) {
                    $patientId = $query->patient->no_medical_record;
                }

                return $patientId;
            })
            ->addColumn('patient_gender', function (Outpatient $query) {
                $patientGender = null;

                if (isset($query->patient)) {
                    $patientGender = $query->patient->gender_format_result;
                }

                return $patientGender;
            })
            ->addColumn('unit_name', function (Outpatient $query) {
                $unitName = null;

                if (isset($query->unit->name)) {
                    $unitName = $query->unit->name;
                }

                return $unitName;
            })
            ->addColumn('action', function (Outpatient $query) {
                $fullAction = '';
                if (in_array($query->status, [1, 3])) {
                    $fullAction = '
                        <a href="' . url('collection/outpatient/checkout/' . $query->id) . '" class="btn btn-light text-secondary btn-sm fw-semibold">
                            Check-Out
                        </a>
                        <div class="btn-group">
                            <button type="button" class="btn btn-light text-warning btn-sm btn-block fw-semibold dropdown-toggle" data-bs-toggle="dropdown">Lainnya</button>
                            <div class="dropdown-menu">
                                <a href="' . url('collection/outpatient/update-data/' . $query->id) . '" class="dropdown-item fs-13">
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
                        <button type="button" class="btn btn-light text-primary btn-sm fw-semibold dropdown-toggle" data-bs-toggle="dropdown">Aksi</button>
                        <div class="dropdown-menu">
                            <a href="' . url('collection/outpatient/action/' . $query->id) . '" class="dropdown-item fs-13">
                                <i class="ph-person-simple-run me-2"></i>
                                Tindakan
                            </a>
                            <a href="' . url('collection/outpatient/recipe/' . $query->id) . '" class="dropdown-item fs-13">
                                <i class="ph-drop-half-bottom me-2"></i>
                                E-Resep
                            </a>
                            <a href="' . url('collection/outpatient/soap/' . $query->id) . '" class="dropdown-item fs-13">
                                <i class="ph-chat-centered-text me-2"></i>
                                SOAP
                            </a>
                            <a href="' . url('collection/outpatient/diagnosis/' . $query->id) . '" class="dropdown-item fs-13">
                                <i class="ph-bezier-curve me-2"></i>
                                Diagnosa
                            </a>
                            <a href="' . url('collection/outpatient/lab/' . $query->id) . '" class="dropdown-item fs-13">
                                <i class="ph-flask me-2"></i>
                                Laboratorium
                            </a>
                            <a href="' . url('collection/outpatient/radiology/' . $query->id) . '" class="dropdown-item fs-13">
                                <i class="ph-wheelchair me-2"></i>
                                Radiologi
                            </a>
                            <a href="' . url('collection/outpatient/operating-room/' . $query->id) . '" class="dropdown-item fs-13">
                                <i class="ph-bed me-2"></i>
                                Kamar Operasi
                            </a>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-light text-success btn-sm fw-semibold dropdown-toggle" data-bs-toggle="dropdown">Cetak</button>
                        <div class="dropdown-menu">
                            <a href="' . url('collection/outpatient/print/' . $query->id) . '?slug=ticket" target="_blank" class="dropdown-item fs-13">
                                <i class="ph-ticket me-2"></i>
                                E-Tiket
                            </a>
                            <a href="' . url('collection/outpatient/print/' . $query->id) . '?slug=bracelet" target="_blank" class="dropdown-item fs-13">
                                <i class="ph-circle-wavy me-2"></i>
                                Gelang
                            </a>
                        </div>
                    </div>
                    ' . $fullAction . '
                ';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function loadPatient(Request $request)
    {
        $id = $request->id;
        $data = Patient::with([
            'province',
            'city',
            'district',
            'outpatient.unit',
            'inpatient' => fn ($q) => $q->with(['roomType.classType', 'functionalService'])
        ])->whereNotNull('verified_at')->findOrFail($id);

        return response()->json($data);
    }

    public function registerPatient(Request $request)
    {
        if ($request->ajax()) {
            $patientId = $request->patient_id;
            $validation = Validator::make($request->all(), [
                'identity_number' => 'nullable|digits:16|numeric|unique:patients,identity_number,' . $patientId,
                'name' => 'required',
                'village' => 'required',
                'location_id' => 'required',
                'address' => 'required',
                'religion_id' => 'required',
                'phone' => 'nullable|digits_between:8,13|numeric',
                'type' => 'required',
                'date_of_entry' => 'required',
                'presence' => 'required',
                'unit_id' => 'required',
                'dispensary_id' => 'required',
                'doctor_id' => 'required'
            ], [
                'identity_number.required' => 'no identitas tidak boleh kosong',
                'identity_number.digits' => 'no identitas harus 16 karakter',
                'identity_number.unique' => 'no identitas telah digunakan',
                'name.required' => 'nama tidak boleh kosong',
                'village.required' => 'desa tidak boleh kosong',
                'location_id.required' => 'mohon memilih wilayah',
                'address.required' => 'alamat tidak boleh kosong',
                'religion_id.required' => 'mohon memilih agama',
                'phone.required' => 'no telp tidak boleh kosong',
                'phone.digits_between' => 'no telp min 8 dan maks 13 karakter',
                'phone.numeric' => 'no telp harus angka',
                'type.required' => 'mohon memilih golongan pasien',
                'date_of_entry.required' => 'tanggal masuk tidak boleh kosong',
                'presence.required' => 'mohon memilih kehadiran',
                'unit_id.required' => 'mohon memilih poli',
                'dispensary_id.required' => 'mohon memilih apotek',
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
                        $locationId = $request->location_id;
                        $location = Simrs::locationById($locationId);
                        $hasDataPatient = Patient::find($patientId);
                        $dateOfEntry = date('Y-m-d H:i:s', strtotime($request->date_of_entry));

                        $fillPatient = [
                            'province_id' => $locationId ? $location->city->province->id : null,
                            'city_id' => $locationId ? $location->city->id : null,
                            'district_id' => $locationId ? $location->id : null,
                            'religion_id' => $request->religion_id,
                            'identity_number' => $request->identity_number,
                            'name' => $request->name,
                            'greeted' => $request->greeted,
                            'gender' => $request->gender,
                            'place_of_birth' => $request->place_of_birth,
                            'date_of_birth' => $request->date_of_birth,
                            'rt' => $request->rt,
                            'rw' => $request->rw,
                            'village' => $request->village,
                            'address' => $request->address,
                            'tribe' => $request->tribe,
                            'weight' => $request->weight,
                            'blood_group' => $request->blood_group,
                            'marital_status' => $request->marital_status,
                            'job' => $request->job,
                            'phone' => $request->phone,
                            'parent_name' => $request->parent_name,
                            'partner_name' => $request->partner_name
                        ];

                        if ($hasDataPatient) {
                            $hasDataPatient->update($fillPatient);
                            $patientId = $hasDataPatient->id;
                        } else {
                            $fillPatient = array_merge($fillPatient, ['verified_at' => now()]);
                            $createPatient = Patient::create($fillPatient);
                            $patientId = $createPatient->id;
                        }

                        Outpatient::create([
                            'user_id' => $userId,
                            'patient_id' => $patientId,
                            'unit_id' => $request->unit_id,
                            'dispensary_id' => $request->dispensary_id,
                            'doctor_id' => $request->doctor_id,
                            'type' => $request->type,
                            'date_of_entry' => $dateOfEntry,
                            'presence' => $request->presence,
                            'description' => $request->description
                        ]);
                    });

                    $response = [
                        'code' => 200,
                        'message' => 'Pasien berhasil didaftarkan di rawat jalan'
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
            'unit' => Unit::where('type', 2)->orderBy('name')->get(),
            'religion' => Religion::all(),
            'dispensary' => Dispensary::all(),
            'doctor' => Doctor::all(),
            'content' => 'collection.outpatient-register-patient'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function action(Request $request, $id)
    {
        $outpatient = Outpatient::findOrFail($id);
        $unit = $outpatient->unit;

        if ($request->ajax()) {
            $outpatient->outpatientAction()->delete();

            try {
                DB::transaction(function () use ($request, $outpatient) {
                    if ($request->has('item')) {
                        foreach ($request->item as $key => $i) {
                            $doctorId = isset($request->doctor_id[$key]) ? $request->doctor_id[$key] : null;
                            $unitActionId = isset($request->unit_action_id[$key]) ? $request->unit_action_id[$key] : null;
                            $status = isset($request->status[$key]) ? $request->status[$key] : null;

                            $consumables = 0;
                            $hostpitalSevice = 0;
                            $service = 0;

                            if ($unitActionId) {
                                $unitAction = UnitAction::find($unitActionId);
                                $consumables = $unitAction->consumables ?? null;
                                $hostpitalSevice = $unitAction->hospital_service ?? null;
                                $service = $unitAction->service ?? null;
                            }

                            $outpatient->outpatientAction()->create([
                                'doctor_id' => $doctorId,
                                'unit_action_id' => $unitActionId,
                                'consumables' => $consumables,
                                'hospital_service' => $hostpitalSevice,
                                'service' => $service,
                                'status' => $status
                            ]);
                        }
                    }
                });

                $response = [
                    'code' => 200,
                    'message' => 'Data tindakan berhasil disimpan'
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
            'patient' => $outpatient->patient,
            'unit' => $unit,
            'outpatientAction' => $outpatient->outpatientAction,
            'doctor' => Doctor::all(),
            'unitAction' => UnitAction::where('unit_id', $outpatient->unit_id)->orderBy('action_id')->get(),
            'content' => 'collection.outpatient-action'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function actionPrint(Request $request, $id)
    {
        if ($request->has('slug')) {
            if ($request->slug == 'payment-letter') {
                $data = OutpatientAction::where('status', false)->findOrFail($id);
                $view = 'pdf.action-payment-letter';
                $title = 'Surat Pembayaran Tindakan';
            } else if ($request->slug == 'proof-of-payment') {
                $data = OutpatientAction::where('status', true)->findOrFail($id);
                $view = 'pdf.action-proof-of-payment';
                $title = 'Bukti Pembayaran Tindakan';
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

    public function recipe(Request $request, $id)
    {
        $outpatient = Outpatient::findOrFail($id);
        $dispensaryId = $outpatient->dispensary_id;

        if ($request->ajax()) {
            $validation = Validator::make($request->all(), [
                'item' => 'required',
            ], [
                'item.required' => 'mohon mengisi minimal 1 item yang diresepkan',
            ]);

            if ($validation->fails()) {
                $response = [
                    'code' => 400,
                    'error' => $validation->errors()->all(),
                ];
            } else {
                try {
                    $outpatient->dispensaryRequest()->whereNull('status')->delete();

                    if ($request->has('item')) {
                        foreach ($request->item as $key => $i) {
                            $dispensaryItemStockId = isset($request->dr_dispensary_item_stock_id[$key]) ? $request->dr_dispensary_item_stock_id[$key] : null;
                            $status = isset($request->dr_status[$key]) ? $request->dr_status[$key] : null;
                            $consumed = isset($request->dr_consumed[$key]) ? $request->dr_consumed[$key] : null;

                            if ($dispensaryItemStockId && empty($status)) {
                                $dispensaryItemStock = DispensaryItemStock::find($dispensaryItemStockId);

                                $qty = isset($request->dr_qty[$key]) ? (int) $request->dr_qty[$key] : 0;
                                $stock = $dispensaryItemStock->qty ?? 0;

                                if ($stock > 0) {
                                    if ($qty > $stock) {
                                        $qty = $stock;
                                    }

                                    $outpatient->dispensaryRequest()->create([
                                        'user_id' => auth()->id(),
                                        'patient_id' => $outpatient->patient_id,
                                        'dispensary_item_stock_id' => $dispensaryItemStockId,
                                        'dispensary_id' => $dispensaryId,
                                        'qty' => $qty,
                                        'price_purchase' => $dispensaryItemStock->price_purchase ?? null,
                                        'price_sell' => $dispensaryItemStock->price_sell ?? null,
                                        'discount' => $dispensaryItemStock->discount ?? null,
                                        'consumed' => $consumed
                                    ]);
                                }
                            }
                        }
                    }

                    $response = [
                        'code' => 200,
                        'message' => 'Resep berhasil disimpan'
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
            'outpatient' => $outpatient,
            'patient' => $outpatient->patient,
            'dispensaryRequest' => $outpatient->dispensaryRequest,
            'dispensaryItem' => DispensaryItem::available()->where('dispensary_id', $dispensaryId)->get(),
            'content' => 'collection.outpatient-recipe'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function soap(Request $request, $id)
    {
        $outpatient = Outpatient::findOrFail($id);

        if ($request->ajax()) {
            $outpatient->outpatientSoap()->delete();

            try {
                $fill = [
                    [
                        'value' => $request->nursing_care_value,
                        'subjective' => $request->nursing_care_subjective,
                        'objective' => $request->nursing_care_objective,
                        'assessment' => $request->nursing_care_assessment,
                        'planning' => $request->nursing_care_planning,
                        'type' => 1
                    ],
                    [
                        'subjective' => $request->checkup_subjective,
                        'objective' => $request->checkup_objective,
                        'assessment' => $request->checkup_assessment,
                        'planning' => $request->checkup_planning,
                        'type' => 2
                    ]
                ];

                foreach ($fill as $f) {
                    $outpatient->outpatientSoap()->create($f);
                }

                $response = [
                    'code' => 200,
                    'message' => 'Data SOAP berhasil disimpan'
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
            'patient' => $outpatient->patient,
            'outpatientSoap' => $outpatient->outpatientSoap,
            'content' => 'collection.outpatient-soap'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function diagnosis(Request $request, $id)
    {
        $outpatient = Outpatient::findOrFail($id);

        if ($request->ajax()) {
            try {
                $outpatient->outpatientDiagnosis()->delete();

                if ($request->has('diagnosis')) {
                    foreach ($request->diagnosis as $d) {
                        if (!empty($d)) {
                            $outpatient->outpatientDiagnosis()->create([
                                'type' => 1,
                                'value' => $d
                            ]);
                        }
                    }
                }

                if ($request->has('action')) {
                    foreach ($request->action as $a) {
                        if (!empty($a)) {
                            $outpatient->outpatientDiagnosis()->create([
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
            'outpatient' => $outpatient,
            'patient' => $outpatient->patient,
            'outpatientDiagnosis' => $outpatient->outpatientDiagnosis,
            'content' => 'collection.outpatient-diagnosis'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function lab(Request $request, $id)
    {
        $outpatient = Outpatient::findOrFail($id);

        if ($request->ajax()) {
            $validation = Validator::make($request->all(), [
                'date_of_request' => 'required',
                'doctor_id' => 'required',
                'lrd_item_id' => 'required'
            ], [
                'date_of_request.required' => 'tanggal permintaan tidak boleh kosong',
                'doctor_id.required' => 'mohon memilih dokter',
                'lrd_item_id.required' => 'mohon memilih salah satu item'
            ]);

            if ($validation->fails()) {
                $response = [
                    'code' => 400,
                    'error' => $validation->errors()->all(),
                ];
            } else {
                try {
                    DB::transaction(function () use ($request, $outpatient) {
                        $createLabRequest = LabRequest::create([
                            'patient_id' => $outpatient->patient_id,
                            'doctor_id' => $request->doctor_id,
                            'lab_requestable_type' => Outpatient::class,
                            'lab_requestable_id' => $outpatient->id,
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
            'outpatient' => $outpatient,
            'patient' => $outpatient->patient,
            'labRequest' => $outpatient->labRequest,
            'doctor' => Doctor::all(),
            'labItemGroup' => LabItemGroup::orderBy('name')->get(),
            'content' => 'collection.outpatient-lab'
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
        $outpatient = Outpatient::findOrFail($id);

        if ($request->ajax()) {
            $validation = Validator::make($request->all(), [
                'date_of_request' => 'required',
                'radiology_id' => 'required',
                'doctor_id' => 'required',
            ], [
                'date_of_request.required' => 'tanggal permintaan tidak boleh kosong',
                'radiology_id.required' => 'mohon memilih tindakan',
                'doctor_id.required' => 'mohon memilih dokter'
            ]);

            if ($validation->fails()) {
                $response = [
                    'code' => 400,
                    'error' => $validation->errors()->all(),
                ];
            } else {
                try {
                    DB::transaction(function () use ($request, $outpatient) {
                        $radiology = Radiology::find($request->radiology_id);

                        RadiologyRequest::create([
                            'doctor_id' => $request->doctor_id,
                            'patient_id' => $outpatient->patient_id,
                            'radiology_id' => $request->radiology_id,
                            'radiology_requestable_type' => Outpatient::class,
                            'radiology_requestable_id' => $outpatient->id,
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

        $data = [
            'outpatient' => $outpatient,
            'patient' => $outpatient->patient,
            'radiologyRequest' => $outpatient->radiologyRequest,
            'radiology' => Radiology::orderBy('type')->get(),
            'doctor' => Doctor::all(),
            'content' => 'collection.outpatient-radiology'
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

    public function checkout(Request $request, $id)
    {
        $outpatient = Outpatient::whereIn('status', [1, 3])->findOrFail($id);

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

            if ($status == 5) {
                $ruleMessage = [
                    'rule' => [
                        'unit_id' => 'required',
                        'dispensary_id' => 'required',
                        'doctor_id' => 'required'
                    ],
                    'message' => [
                        'unit_id.required' => 'mohon memilih poli',
                        'dispensary_id.required' => 'mohon memilih apotek',
                        'doctor_id.required' => 'mohon memilih dokter'
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
                    if ($status == 5) {
                        Outpatient::create([
                            'user_id' => auth()->id(),
                            'patient_id' => $outpatient->patient_id,
                            'unit_id' => $request->unit_id,
                            'dispensary_id' => $request->dispensary_id,
                            'doctor_id' => $request->doctor_id,
                            'parent_id' => $outpatient->id,
                            'type' => $outpatient->type,
                            'date_of_entry' => now(),
                            'presence' => $outpatient->presence,
                            'description' => $request->description
                        ]);

                        $outpatient->update([
                            'date_of_out' => now()
                        ]);
                    }

                    $outpatient->update([
                        'status' => $status
                    ]);

                    $next = Outpatient::where('status', 1)->where('unit_id', $outpatient->unit_id)->oldest('date_of_entry')->first();

                    if ($next) {
                        Outpatient::find($next->id)->update(['status' => 3]);
                    }

                    $response = [
                        'code' => 200,
                        'message' => 'Rawat jalan berhasil di checkout'
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
            'outpatient' => $outpatient,
            'patient' => $outpatient->patient,
            'unit' => Unit::where('type', 2)->orderBy('name')->get(),
            'dispensary' => Dispensary::all(),
            'doctor' => Doctor::all(),
            'content' => 'collection.outpatient-checkout'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function updateData(Request $request, $id)
    {
        $outpatient = Outpatient::findOrFail($id);
        $patientId = $outpatient->patient->id;

        if ($request->ajax()) {
            $validation = Validator::make($request->all(), [
                'identity_number' => 'nullable|digits:16|numeric|unique:patients,identity_number,' . $patientId,
                'name' => 'required',
                'village' => 'required',
                'location_id' => 'required',
                'address' => 'required',
                'religion_id' => 'required',
                'phone' => 'nullable|digits_between:8,13|numeric',
                'type' => 'required',
                'date_of_entry' => 'required',
                'presence' => 'required',
                'dispensary_id' => 'required',
                'doctor_id' => 'required'
            ], [
                'identity_number.digits' => 'no identitas harus 16 karakter',
                'identity_number.numeric' => 'no identitas harus angka',
                'identity_number.unique' => 'no identitas telah digunakan',
                'name.required' => 'nama tidak boleh kosong',
                'village.required' => 'desa tidak boleh kosong',
                'location_id.required' => 'mohon memilih wilayah',
                'address.required' => 'alamat tidak boleh kosong',
                'religion_id.required' => 'mohon memilih agama',
                'phone.required' => 'no telp tidak boleh kosong',
                'phone.digits_between' => 'no telp min 8 dan maks 13 karakter',
                'phone.numeric' => 'no telp harus angka',
                'type.required' => 'mohon memilih golongan pasien',
                'date_of_entry.required' => 'tanggal masuk tidak boleh kosong',
                'presence.required' => 'mohon memilih kehadiran',
                'dispensary_id.required' => 'mohon memilih apotek',
                'doctor_id.required' => 'mohon memilih dokter'
            ]);

            if ($validation->fails()) {
                $response = [
                    'code' => 400,
                    'error' => $validation->errors()->all(),
                ];
            } else {
                try {
                    DB::transaction(function () use ($request, $patientId, $outpatient) {
                        $userId = auth()->id();
                        $locationId = $request->location_id;
                        $location = Simrs::locationById($locationId);
                        $dateOfEntry = date('Y-m-d H:i:s', strtotime($request->date_of_entry));

                        $fillPatient = [
                            'province_id' => $locationId ? $location->city->province->id : null,
                            'city_id' => $locationId ? $location->city->id : null,
                            'district_id' => $locationId ? $location->id : null,
                            'religion_id' => $request->religion_id,
                            'identity_number' => $request->identity_number,
                            'name' => $request->name,
                            'greeted' => $request->greeted,
                            'gender' => $request->gender,
                            'place_of_birth' => $request->place_of_birth,
                            'date_of_birth' => $request->date_of_birth,
                            'rt' => $request->rt,
                            'rw' => $request->rw,
                            'village' => $request->village,
                            'address' => $request->address,
                            'tribe' => $request->tribe,
                            'weight' => $request->weight,
                            'blood_group' => $request->blood_group,
                            'marital_status' => $request->marital_status,
                            'job' => $request->job,
                            'phone' => $request->phone,
                            'parent_name' => $request->parent_name,
                            'partner_name' => $request->partner_name
                        ];

                        $fillOutpatient = [
                            'user_id' => $userId,
                            'patient_id' => $patientId,
                            'dispensary_id' => $request->dispensary_id,
                            'doctor_id' => $request->doctor_id,
                            'type' => $request->type,
                            'date_of_entry' => $dateOfEntry,
                            'presence' => $request->presence,
                            'description' => $request->description
                        ];

                        $outpatient->patient()->update($fillPatient);
                        $outpatient->fill($fillOutpatient)->save();
                    });

                    $response = [
                        'code' => 200,
                        'message' => 'Data berhasil diubah'
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
            $data = [
                'outpatient' => $outpatient,
                'religion' => Religion::all(),
                'unit' => Unit::where('type', 2)->orderBy('name')->get(),
                'dispensary' => Dispensary::all(),
                'doctor' => Doctor::all(),
                'content' => 'collection.outpatient-update'
            ];
        }

        return view('layouts.index', ['data' => $data]);
    }

    public function operatingRoom(Request $request, $id)
    {
        $outpatient = Outpatient::findOrFail($id);
        $patientId = $outpatient->patient->id;
        $operation = $outpatient->operation;

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
                'unit_id.required' => 'mohon memilih poli',
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
                    DB::transaction(function () use ($request, $patientId, $outpatient, $operation) {
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
                            'operationable_type' => Outpatient::class,
                            'operationable_id' => $outpatient->id,
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

                        $outpatient->patient()->update($fillPatient);
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
            $operatingRoomAction = OperatingRoomAction::where('status', true)
                ->orderBy('operating_room_group_id')
                ->orderBy('operating_room_action_type_id')
                ->get();

            $data = [
                'outpatient' => $outpatient,
                'operation' => $operation,
                'employee' => Employee::where('status', true)->get(),
                'unit' => Unit::where('type', 2)->orderBy('name')->get(),
                'operatingRoomAction' => $operatingRoomAction,
                'functionalService' => FunctionalService::where('status', true)->get(),
                'operatingRoomAnesthetist' => OperatingRoomAnesthetist::all(),
                'doctor' => Doctor::all(),
                'content' => 'collection.outpatient-operating-room'
            ];
        }

        return view('layouts.index', ['data' => $data]);
    }

    public function print(Request $request, $id)
    {
        $data = Outpatient::findOrFail($id);

        if ($request->has('slug')) {
            if ($request->slug == 'ticket') {
                $view = 'pdf.patient-ticket';
                $pageSize = [0, 0, 221.102, 255.118];
                $title = 'E-Tiket Pasien';
                $dpi = 102;
            } else if ($request->slug == 'bracelet') {
                $view = 'pdf.patient-bracelet';
                $pageSize = [0, 0, 90.7087, 907.087];
                $title = 'Gelang Pasien';
                $dpi = 80;
            } else {
                abort(404);
            }

            $pdf = Pdf::setOptions([
                'dpi' => $dpi,
                'adminUsername' => auth()->user()->username
            ])->loadView($view, [
                'title' => $title,
                'data' => $data->patient
            ])->setPaper($pageSize, 'portrait');

            return $pdf->download($title . ' - ' . date('YmdHis') . '.pdf');
        }

        abort(404);
    }

    public function destroyData(Request $request)
    {
        $id = $request->id;

        try {
            Outpatient::destroy($id);

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
