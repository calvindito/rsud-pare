<?php

namespace App\Http\Controllers\Collection;

use App\Helpers\Simrs;
use App\Models\Doctor;
use App\Models\LabItem;
use App\Models\Medicine;
use App\Models\Radiology;
use App\Models\LabRequest;
use App\Models\ActionOther;
use App\Models\LabItemGroup;
use Illuminate\Http\Request;
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
            ->editColumn('date_of_entry', '{{ date("Y-m-d H:i:s", strtotime($date_of_entry)) }}')
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
                        <a href="javascript:void(0);" class="btn btn-light text-danger btn-sm fw-semibold" onclick="destroyData(' . $query->id . ')">
                            Hapus Data
                        </a>
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
                        'doctor_id' => $request->doctor_id,
                        'date_of_out' => date('Y-m-d H:i:s', strtotime($request->date_of_out)),
                        'observation' => $observation,
                        'supervision_doctor' => $supervisionDoctor,
                        'ending' => $request->ending
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
                    $emergencyDepartment->recipe()->delete();

                    foreach ($request->recipe as $r) {
                        $emergencyDepartment->recipe()->create([
                            'medicine_id' => $r
                        ]);
                    }

                    return redirect('collection/emergency-department/recipe/' . $id)->with([
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
            'emergencyDepartment' => $emergencyDepartment,
            'functionalService' => $emergencyDepartment->functionalService,
            'patient' => $emergencyDepartment->patient,
            'recipe' => $emergencyDepartment->recipe,
            'medicine' => Medicine::where('stock', '>', 0)->get(),
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

    public function destroyData(Request $request)
    {
        $id = $request->id;

        try {
            EmergencyDepartment::destroy($id);

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
