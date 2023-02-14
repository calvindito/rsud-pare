<?php

namespace App\Http\Controllers\Collection;

use App\Helpers\Simrs;
use App\Models\Doctor;
use App\Models\LabItem;
use App\Models\Patient;
use App\Models\Medicine;
use App\Models\Religion;
use App\Models\Radiology;
use App\Models\LabRequest;
use App\Models\ActionOther;
use App\Models\LabItemGroup;
use Illuminate\Http\Request;
use App\Models\MedicineStock;
use App\Models\MedicalService;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ActionSupporting;
use App\Models\RadiologyRequest;
use App\Models\FunctionalService;
use App\Models\ActionNonOperative;
use Illuminate\Support\Facades\DB;
use App\Models\EmergencyDepartment;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class EmergencyDepartmentController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'collection.emergency-department'
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
                    $query->whereRaw("LPAD(id, 6, 0) LIKE '%$search%'")
                        ->orWhereHas('patient', function ($query) use ($search) {
                            $query->where('id', 'like', "$search%")
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
                $patientName = null;

                if (isset($query->patient)) {
                    $patientName = $query->patient->name;
                }

                return $patientName;
            })
            ->addColumn('functional_service_name', function (EmergencyDepartment $query) {
                $functionalServiceName = null;

                if (isset($query->functionalService)) {
                    $functionalServiceName = $query->functionalService->name;
                }

                return $functionalServiceName;
            })
            ->addColumn('action', function (EmergencyDepartment $query) {
                $fullAction = '';
                if ($query->status == 1) {
                    $fullAction = '
                        <a href="' . url('collection/emergency-department/checkout/' . $query->id) . '" class="btn btn-light text-secondary btn-sm fw-semibold">
                            Check-Out
                        </a>
                        <div class="btn-group">
                            <button type="button" class="btn btn-light text-warning btn-sm btn-block fw-semibold dropdown-toggle" data-bs-toggle="dropdown">Lainnya</button>
                            <div class="dropdown-menu">
                                <a href="' . url('collection/emergency-department/update-data/' . $query->id) . '" class="dropdown-item fs-13">
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
                            <a href="' . url('collection/emergency-department/action/' . $query->id) . '" class="dropdown-item fs-13">
                                <i class="ph-person-simple-run me-2"></i>
                                Tindakan
                            </a>
                            <a href="' . url('collection/emergency-department/recipe/' . $query->id) . '" class="dropdown-item fs-13">
                                <i class="ph-drop-half-bottom me-2"></i>
                                E-Resep
                            </a>
                            <a href="' . url('collection/emergency-department/diagnosis/' . $query->id) . '" class="dropdown-item fs-13">
                                <i class="ph-bezier-curve me-2"></i>
                                Diagnosa
                            </a>
                            <a href="' . url('collection/emergency-department/lab/' . $query->id) . '" class="dropdown-item fs-13">
                                <i class="ph-flask me-2"></i>
                                Laboratorium
                            </a>
                            <a href="' . url('collection/emergency-department/radiology/' . $query->id) . '" class="dropdown-item fs-13">
                                <i class="ph-wheelchair me-2"></i>
                                Radiologi
                            </a>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-light text-success btn-sm btn-block fw-semibold dropdown-toggle" data-bs-toggle="dropdown">Cetak</button>
                        <div class="dropdown-menu">
                            <a href="' . url('collection/emergency-department/print/' . $query->id) . '?slug=receipt" target="_blank" class="dropdown-item fs-13">
                                <i class="ph-newspaper-clipping me-2"></i>
                                Kwitansi
                            </a>
                            <a href="' . url('collection/emergency-department/print/' . $query->id) . '?slug=detail" target="_blank" class="dropdown-item fs-13">
                                <i class="ph-clipboard-text me-2"></i>
                                Rincian
                            </a>
                            <a href="' . url('collection/emergency-department/print/' . $query->id) . '?slug=bpjs" target="_blank" class="dropdown-item fs-13">
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
            'province',
            'city',
            'district',
            'emergencyDepartment' => fn ($q) => $q->with(['doctor', 'functionalService'])
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
                'type' => 'required',
                'date_of_entry' => 'required',
                'functional_service_id' => 'required',
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
                'type.required' => 'mohon memilih golongan pasien',
                'date_of_entry.required' => 'tanggal masuk tidak boleh kosong',
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
                            'address' => $request->address
                        ];

                        if ($hasDataPatient) {
                            $hasDataPatient->update($fillPatient);
                            $patientId = $hasDataPatient->id;
                        } else {
                            $fillPatient = array_merge($fillPatient, ['verified_at' => now()]);
                            $createPatient = Patient::create($fillPatient);
                            $patientId = $createPatient->id;
                        }

                        EmergencyDepartment::create([
                            'user_id' => $userId,
                            'patient_id' => $patientId,
                            'functional_service_id' => $request->functional_service_id,
                            'doctor_id' => $request->doctor_id,
                            'type' => $request->type,
                            'date_of_entry' => $dateOfEntry
                        ]);
                    });

                    $response = [
                        'code' => 200,
                        'message' => 'Pasien berhasil didaftarkan di IGD'
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
            'doctor' => Doctor::all(),
            'functionalService' => FunctionalService::where('status', true)->orderBy('name')->get(),
            'religion' => Religion::all(),
            'content' => 'collection.emergency-department-register-patient'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function action(Request $request, $id)
    {
        $emergencyDepartment = EmergencyDepartment::findOrFail($id);

        if ($request->ajax()) {
            try {
                DB::transaction(function () use ($request, $emergencyDepartment) {
                    $observation = [
                        'action_emergency_care_id' => (int) $request->observation_action_emergency_care_id ?? null,
                        'nominal' => Simrs::numberable($request->observation_nominal ?? null)
                    ];

                    $supervisionDoctor = [
                        'action_emergency_care_id' => (int) $request->supervision_doctor_action_emergency_care_id ?? null,
                        'doctor_id' => (int) $request->supervision_doctor_doctor_id ?? null,
                        'nominal' => Simrs::numberable($request->supervision_doctor_nominal ?? null)
                    ];

                    $emergencyDepartment->update([
                        'observation' => $observation,
                        'supervision_doctor' => $supervisionDoctor
                    ]);

                    $emergencyDepartment->emergencyDepartmentHealth()->delete();
                    $emergencyDepartment->emergencyDepartmentNonOperative()->delete();
                    $emergencyDepartment->emergencyDepartmentOther()->delete();
                    $emergencyDepartment->emergencyDepartmentPackage()->delete();
                    $emergencyDepartment->emergencyDepartmentService()->delete();
                    $emergencyDepartment->emergencyDepartmentSupporting()->delete();

                    if ($request->has('emergency_department_health')) {
                        foreach ($request->emergency_department_health as $key => $edh) {
                            $emergencyDepartment->emergencyDepartmentHealth()->create([
                                'tool_id' => $request->edh_tool_id[$key] ?? null,
                                'nominal' => $request->edh_nominal[$key] ?? null
                            ]);
                        }
                    }

                    if ($request->has('emergency_department_non_operative')) {
                        foreach ($request->emergency_department_non_operative as $key => $edno) {
                            $emergencyDepartment->emergencyDepartmentNonOperative()->create([
                                'action_non_operative_id' => $request->edno_action_non_operative_id[$key] ?? null,
                                'nominal' => $request->edno_nominal[$key] ?? null
                            ]);
                        }
                    }

                    if ($request->has('emergency_department_other')) {
                        foreach ($request->emergency_department_other as $key => $edo) {
                            $emergencyDepartment->emergencyDepartmentOther()->create([
                                'action_other_id' => $request->edo_action_other_id[$key] ?? null,
                                'nominal' => $request->edo_nominal[$key] ?? null
                            ]);
                        }
                    }

                    if ($request->has('emergency_department_package')) {
                        foreach ($request->emergency_department_package as $edp) {
                            $emergencyDepartment->emergencyDepartmentPackage()->create([
                                'nominal' => $edp ?? null
                            ]);
                        }
                    }

                    if ($request->has('emergency_department_service')) {
                        foreach ($request->emergency_department_service as $key => $eds) {
                            $emergencyDepartment->emergencyDepartmentService()->create([
                                'medical_service_id' => $request->eds_medical_service_id[$key] ?? null,
                                'doctor_id' => $request->eds_doctor_id[$key] ?? null,
                                'nominal' => $request->eds_nominal[$key] ?? null,
                                'qty' => $request->eds_qty[$key] ?? null,
                            ]);
                        }
                    }

                    if ($request->has('emergency_department_supporting')) {
                        foreach ($request->emergency_department_supporting as $key => $edss) {
                            $emergencyDepartment->emergencyDepartmentSupporting()->create([
                                'action_supporting_id' => $request->edss_action_supporting_id[$key] ?? null,
                                'doctor_id' => $request->edss_doctor_id[$key] ?? null,
                                'nominal' => $request->edss_nominal[$key] ?? null
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
            'emergencyDepartment' => $emergencyDepartment,
            'functionalService' => $emergencyDepartment->functionalService,
            'patient' => $emergencyDepartment->patient,
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
            'content' => 'collection.emergency-department-action'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function recipe(Request $request, $id)
    {
        $emergencyDepartment = EmergencyDepartment::findOrFail($id);

        if ($request->ajax()) {
            $validation = Validator::make($request->all(), [
                'item' => 'required',
            ], [
                'item.required' => 'mohon mengisi minimal 1 obat yang diresepkan',
            ]);

            if ($validation->fails()) {
                $response = [
                    'code' => 400,
                    'error' => $validation->errors()->all(),
                ];
            } else {
                try {
                    foreach ($emergencyDepartment->recipe as $r) {
                        $qty = $r->qty;

                        if ($r->medicineStock->sold > 0) {
                            $r->medicineStock()->decrement('sold', $qty);
                        }

                        $r->medicineStock()->increment('stock', $qty);
                        $r->delete();
                    }

                    if ($request->has('item')) {
                        foreach ($request->item as $key => $i) {
                            $medicineStockId = isset($request->r_medicine_stock_id[$key]) ? $request->r_medicine_stock_id[$key] : 0;

                            if ($medicineStockId) {
                                $qty = isset($request->r_qty[$key]) ? $request->r_qty[$key] : 0;
                                $medicineStock = MedicineStock::find($medicineStockId);

                                if ($medicineStock) {
                                    if ($qty > $medicineStock->stock) {
                                        $qty = $medicineStock->stock;
                                    }
                                }

                                $medicineStock->decrement('stock', $qty);
                                $medicineStock->increment('sold', $qty);

                                $emergencyDepartment->recipe()->create([
                                    'medicine_stock_id' => $medicineStockId,
                                    'qty' => $qty,
                                    'price_purchase' => $medicineStock->price_purchase ?? null,
                                    'price_sell' => $medicineStock->price_sell ?? null,
                                    'discount' => $medicineStock->discount ?? null
                                ]);
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
            'emergencyDepartment' => $emergencyDepartment,
            'functionalService' => $emergencyDepartment->functionalService,
            'patient' => $emergencyDepartment->patient,
            'recipe' => $emergencyDepartment->recipe,
            'medicine' => Medicine::available($emergencyDepartment->recipe->count() > 0 ? true : false)->get(),
            'content' => 'collection.emergency-department-recipe'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function diagnosis(Request $request, $id)
    {
        $emergencyDepartment = EmergencyDepartment::findOrFail($id);

        if ($request->ajax()) {
            try {
                $emergencyDepartment->emergencyDepartmentDiagnosis()->delete();

                if ($request->has('diagnosis')) {
                    foreach ($request->diagnosis as $d) {
                        if (!empty($d)) {
                            $emergencyDepartment->emergencyDepartmentDiagnosis()->create([
                                'type' => 1,
                                'value' => $d
                            ]);
                        }
                    }
                }

                if ($request->has('action')) {
                    foreach ($request->action as $a) {
                        if (!empty($a)) {
                            $emergencyDepartment->emergencyDepartmentDiagnosis()->create([
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
            'emergencyDepartment' => $emergencyDepartment,
            'functionalService' => $emergencyDepartment->functionalService,
            'patient' => $emergencyDepartment->patient,
            'emergencyDepartmentDiagnosis' => $emergencyDepartment->emergencyDepartmentDiagnosis,
            'content' => 'collection.emergency-department-diagnosis'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function lab(Request $request, $id)
    {
        $emergencyDepartment = EmergencyDepartment::findOrFail($id);

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
                    DB::transaction(function () use ($request, $emergencyDepartment) {
                        $createLabRequest = LabRequest::create([
                            'patient_id' => $emergencyDepartment->patient_id,
                            'doctor_id' => $emergencyDepartment->doctor_id,
                            'lab_requestable_type' => EmergencyDepartment::class,
                            'lab_requestable_id' => $emergencyDepartment->id,
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
            'emergencyDepartment' => $emergencyDepartment,
            'functionalService' => $emergencyDepartment->functionalService,
            'patient' => $emergencyDepartment->patient,
            'labRequest' => $emergencyDepartment->labRequest,
            'labItemGroup' => LabItemGroup::orderBy('name')->get(),
            'content' => 'collection.emergency-department-lab'
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
        $emergencyDepartment = EmergencyDepartment::findOrFail($id);

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
                    DB::transaction(function () use ($request, $emergencyDepartment) {
                        $radiology = Radiology::find($request->radiology_id);

                        RadiologyRequest::create([
                            'doctor_id' => $emergencyDepartment->doctor_id,
                            'patient_id' => $emergencyDepartment->patient_id,
                            'radiology_id' => $request->radiology_id,
                            'radiology_requestable_type' => EmergencyDepartment::class,
                            'radiology_requestable_id' => $emergencyDepartment->id,
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

        $radiology = Radiology::whereHas('radiologyAction', function ($query) use ($emergencyDepartment) {
            $query->where('class_type_id', 7);
        })->orderBy('type')->get();

        $data = [
            'emergencyDepartment' => $emergencyDepartment,
            'functionalService' => $emergencyDepartment->functionalService,
            'patient' => $emergencyDepartment->patient,
            'radiologyRequest' => $emergencyDepartment->radiologyRequest,
            'radiology' => $radiology,
            'content' => 'collection.emergency-department-radiology'
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
        $emergencyDepartment = EmergencyDepartment::where('status', 1)->findOrFail($id);

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

            if ($status == 2 || $status == 3) {
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
                    if ($status == 2 || $status == 3) {
                        $emergencyDepartment->update([
                            'date_of_out' => $request->date_of_out,
                            'ending' => $request->ending
                        ]);
                    }

                    $emergencyDepartment->update([
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
            'emergencyDepartment' => $emergencyDepartment,
            'patient' => $emergencyDepartment->patient,
            'content' => 'collection.emergency-department-checkout'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function updateData(Request $request, $id)
    {
        $emergencyDepartment = EmergencyDepartment::where('status', 1)->findOrFail($id);
        $patient = $emergencyDepartment->patient;

        if ($request->ajax()) {
            $validation = Validator::make($request->all(), [
                'identity_number' => 'nullable|digits:16|numeric|unique:patients,identity_number,' . $patient->id,
                'name' => 'required',
                'village' => 'required',
                'location_id' => 'required',
                'address' => 'required',
                'religion_id' => 'required',
                'type' => 'required',
                'date_of_entry' => 'required',
                'functional_service_id' => 'required',
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
                'type.required' => 'mohon memilih golongan pasien',
                'date_of_entry.required' => 'tanggal masuk tidak boleh kosong',
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
                    DB::transaction(function () use ($request, $emergencyDepartment, $patient) {
                        $locationId = $request->location_id;
                        $location = Simrs::locationById($locationId);

                        $patient->update([
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
                            'address' => $request->address
                        ]);

                        $emergencyDepartment->update([
                            'user_id' => auth()->id(),
                            'functional_service_id' => $request->functional_service_id,
                            'doctor_id' => $request->doctor_id,
                            'type' => $request->type,
                            'date_of_entry' => $request->date_of_entry
                        ]);
                    });

                    $response = [
                        'code' => 200,
                        'message' => 'Data igd berhasil diubah'
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
            'emergencyDepartment' => $emergencyDepartment,
            'patient' => $emergencyDepartment->patient,
            'doctor' => Doctor::all(),
            'functionalService' => FunctionalService::where('status', true)->orderBy('name')->get(),
            'religion' => Religion::all(),
            'content' => 'collection.emergency-department-update'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function destroyData(Request $request)
    {
        $id = $request->id;

        try {
            EmergencyDepartment::where('status', 1)->destroy($id);

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
