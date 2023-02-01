<?php

namespace App\Http\Controllers\Register;

use App\Models\Patient;
use App\Models\Religion;
use App\Models\RoomType;
use App\Models\Inpatient;
use Illuminate\Http\Request;
use App\Models\PharmacyProduction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class InpatientController extends Controller
{
    public function index()
    {
        $data = [
            'roomType' => RoomType::where('status', true)->orderBy('name')->get(),
            'pharmacyProduction' => PharmacyProduction::where('status', true)->orderBy('name')->get(),
            'religion' => Religion::all(),
            'content' => 'register.inpatient'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function loadPatient(Request $request)
    {
        $id = $request->id;
        $data = Patient::with([
            'inpatient' => fn ($q) => $q->with(['roomType.classType', 'pharmacyProduction'])
        ])->whereNotNull('verified_at')->findOrFail($id);

        return response()->json($data);
    }

    public function registerPatient(Request $request)
    {
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
            'pharmacy_production_id' => 'required'
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
            'pharmacy_production_id.required' => 'mohon memilih upf'
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
                        'religion_id' => $request->religion_id,
                        'verified_at' => now()
                    ];

                    if ($hasDataPatient) {
                        $hasDataPatient->update($fillPatient);
                        $patientId = $hasDataPatient->id;
                    } else {
                        $createPatient = Patient::create($fillPatient);
                        $patientId = $createPatient->id;
                    }

                    Inpatient::create([
                        'user_id' => $userId,
                        'patient_id' => $patientId,
                        'room_type_id' => $request->room_type_id,
                        'pharmacy_production_id' => $request->pharmacy_production_id,
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
}
