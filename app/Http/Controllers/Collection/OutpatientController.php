<?php

namespace App\Http\Controllers\Collection;

use PDF;
use App\Models\Unit;
use App\Helpers\Simrs;
use App\Models\Patient;
use App\Models\Religion;
use App\Models\Outpatient;
use Illuminate\Http\Request;
use App\Models\OutpatientPoly;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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
        $data = OutpatientPoly::has('outpatient');

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->whereHas('outpatient', function ($query) use ($search) {
                        $query->where('description', 'like', "%$search%")
                            ->whereHas('patient', function ($query) use ($search) {
                                $query->where('id', 'like', "%$search%")
                                    ->orWhere('name', 'like', "%$search%")
                                    ->orWhere('address', 'like', "%$search%")
                                    ->orWhere('parent_name', 'like', "%$search%")
                                    ->orWhereHas('district', function ($query) use ($search) {
                                        $query->where('name', 'like', "%$search%");
                                    });
                            });
                    });
                }
            })
            ->addColumn('patient_id', function (OutpatientPoly $query) {
                $patientId = null;

                if (isset($query->outpatient->patient)) {
                    $patientId = $query->outpatient->patient->id;
                }

                return $patientId;
            })
            ->addColumn('patient_name', function (OutpatientPoly $query) {
                $patientName = null;

                if (isset($query->outpatient->patient)) {
                    $patientName = $query->outpatient->patient->name;
                }

                return $patientName;
            })
            ->addColumn('patient_gender', function (OutpatientPoly $query) {
                $patientGender = null;

                if (isset($query->outpatient->patient)) {
                    $patientGender = $query->outpatient->patient->gender_format_result;
                }

                return $patientGender;
            })
            ->addColumn('outpatient_type', function (OutpatientPoly $query) {
                $outpatientType = null;

                if (isset($query->outpatient->type_format_result)) {
                    $outpatientType = $query->outpatient->type_format_result;
                }

                return $outpatientType;
            })
            ->addColumn('outpatient_date_of_entry', function (OutpatientPoly $query) {
                $outpatientDateOfEntry = null;

                if (isset($query->outpatient->date_of_entry)) {
                    $outpatientDateOfEntry = $query->outpatient->date_of_entry;
                }

                return $outpatientDateOfEntry;
            })
            ->addColumn('unit_name', function (OutpatientPoly $query) {
                $unitName = null;

                if (isset($query->unit->name)) {
                    $unitName = $query->unit->name;
                }

                return $unitName;
            })
            ->addColumn('outpatient_presence', function (OutpatientPoly $query) {
                $outpatientPresence = null;

                if (isset($query->outpatient->presence_format_result)) {
                    $outpatientPresence = $query->outpatient->presence_format_result;
                }

                return $outpatientPresence;
            })
            ->addColumn('outpatient_description', function (OutpatientPoly $query) {
                $outpatientDescription = null;

                if (isset($query->outpatient->description)) {
                    $outpatientDescription = $query->outpatient->description;
                }

                return $outpatientDescription;
            })
            ->addColumn('action', function (OutpatientPoly $query) {
                return '
                    <div class="btn-group">
                        <button type="button" class="btn btn-light text-primary btn-sm fw-semibold dropdown-toggle" data-bs-toggle="dropdown">Aksi</button>
                        <div class="dropdown-menu">
                            <a href="' . url('collection/outpatient/update-data/' . $query->outpatient->id) . '" class="dropdown-item fs-13">
                                <i class="ph-pen me-2"></i>
                                Edit Data
                            </a>
                            <a href="' . url('collection/outpatient/entry-operating-room/' . $query->outpatient->id) . '" class="dropdown-item fs-13">
                                <i class="ph-bed me-2"></i>
                                Entry Kamar Operasi
                            </a>
                            <a href="' . url('collection/outpatient/print/' . $query->id) . '?slug=ticket" target="_blank" class="dropdown-item fs-13">
                                <i class="ph-ticket me-2"></i>
                                Cetak E-Tiket
                            </a>
                            <a href="' . url('collection/outpatient/print/' . $query->id) . '?slug=bracelet" target="_blank" class="dropdown-item fs-13">
                                <i class="ph-circle-wavy me-2"></i>
                                Cetak Gelang
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item fs-13" onclick="destroyData(' . $query->id . ')">
                                <i class="ph-trash-simple me-2"></i>
                                Hapus Data
                            </a>
                        </div>
                    </div>
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
            'outpatient.outpatientPoly.unit',
            'inpatient' => fn ($q) => $q->with(['roomType.classType', 'pharmacyProduction'])
        ])->whereNotNull('verified_at')->findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request, $outpatient_id)
    {
        $outpatient = Outpatient::findOrFail($outpatient_id);
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
                'item' => 'required',
                'unit_id.*' => 'required',
            ], [
                'identity_number.required' => 'no identitas tidak boleh kosong',
                'identity_number.digits' => 'no identitas harus 16 karakter',
                'identity_number.unique' => 'no identitas telah digunakan',
                'name.required' => 'nama tidak boleh kosong',
                'village.required' => 'nama tidak boleh kosong',
                'location_id.required' => 'mohon memilih wilayah',
                'address.required' => 'alamat tidak boleh kosong',
                'religion_id.required' => 'mohon memilih agama',
                'phone.required' => 'no telp tidak boleh kosong',
                'phone.digits_between' => 'no telp min 8 dan maks 13 karakter',
                'phone.numeric' => 'no telp harus angka',
                'type.required' => 'mohon memilih golongan pasien',
                'date_of_entry.required' => 'tanggal masuk tidak boleh kosong',
                'presence.required' => 'mohon memilih kehadiran',
                'item.required' => 'poli tujuan harus ada minimal 1 data',
                'unit_id.*.required' => 'poli tidak boleh ada yang kosong'
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
                            'type' => $request->type,
                            'date_of_entry' => $dateOfEntry,
                            'presence' => $request->presence,
                            'description' => $request->description
                        ];

                        $outpatient->patient()->update($fillPatient);
                        $outpatient->fill($fillOutpatient)->save();
                        $outpatient->outpatientPoly()->delete();
                        $outpatient->fresh();

                        foreach ($request->item as $key => $i) {
                            $unitId = $request->unit_id[$key];

                            $outpatient->outpatientPoly()->create([
                                'unit_id' => $unitId,
                                'status' => 1
                            ]);
                        }
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
                'content' => 'collection.outpatient-update'
            ];
        }

        return view('layouts.index', ['data' => $data]);
    }

    public function print(Request $request, $id)
    {
        $data = OutpatientPoly::findOrFail($id);

        if ($request->has('slug')) {
            if ($request->slug == 'ticket') {
                $view = 'pdf.patient-ticket';
                $pageSize = [68, 43];
                $title = 'E-Tiket Pasien';
            } else if ($request->slug == 'bracelet') {
                $view = 'pdf.patient-bracelet';
                $pageSize = [39, 373];
                $title = 'Gelang Pasien';
            } else {
                abort(404);
            }

            $pdf = PDF::loadView($view, [
                'title' => $title . ' - ' . $data->outpatient->patient->name . ' (' . $data->outpatient->patient->id . ')',
                'data' => $data->outpatient->patient,
                'barcode' => $data->id
            ], [], [
                'mode' => 'utf-8',
                'format' => $pageSize,
                'display_mode' => 'fullwidth',
                'margin_top' => 3,
                'margin_right' => 3,
                'margin_bottom' => 3,
                'margin_left' => 3,
                'author' => auth()->user()->employee->name,
                'subject' => $title,
            ]);

            return $pdf->download($title . ' - ' . $data->id . '.pdf');
        }

        abort(404);
    }

    public function destroyData(Request $request)
    {
        $id = $request->id;

        try {
            OutpatientPoly::destroy($id);

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
