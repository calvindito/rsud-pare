<?php

namespace App\Http\Controllers\Register;

use App\Models\Unit;
use App\Helpers\Simrs;
use App\Models\Patient;
use App\Models\Religion;
use App\Models\Outpatient;
use Illuminate\Http\Request;
use App\Models\OutpatientPoly;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OutpatientController extends Controller
{
    public function index()
    {
        $data = [
            'unit' => Unit::where('type', 2)->orderBy('name')->get(),
            'religion' => Religion::all(),
            'content' => 'register.outpatient'
        ];

        return view('layouts.index', ['data' => $data]);
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

    public function registerPatient(Request $request)
    {
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
                DB::transaction(function () use ($request, $patientId) {
                    $userId = Auth::id();
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
                        $createPatient = Patient::create($fillPatient);
                        $patientId = $createPatient->id;
                    }

                    $createOutpatient = Outpatient::create([
                        'user_id' => $userId,
                        'patient_id' => $patientId,
                        'type' => $request->type,
                        'date_of_entry' => $dateOfEntry,
                        'presence' => $request->presence,
                        'description' => $request->description
                    ]);

                    foreach ($request->item as $key => $i) {
                        $unitId = $request->unit_id[$key];

                        OutpatientPoly::create([
                            'outpatient_id' => $createOutpatient->id,
                            'unit_id' => $unitId
                        ]);
                    }
                });

                $response = [
                    'code' => 200,
                    'message' => 'Data telah diubah'
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
}
