<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\PatientGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')
            ->table('a_pasien')
            ->selectRaw('a_pasien.*, refkabkota.KodeKabKota, refkabkota.KodeProv')
            ->leftJoin('refkec', 'a_pasien.KodeKec', '=', 'refkec.KodeKec')
            ->leftJoin('refkabkota', 'refkec.KodeKabKota', '=', 'refkabkota.KodeKabKota')
            ->orderBy('a_pasien.NoMedrec')
            ->take(5000)
            ->chunk(1000, function ($query) {
                foreach ($query as $q) {
                    $getPatientUpdate = DB::connection('clone')
                        ->table('a_pasien_update')
                        ->selectRaw('a_pasien_update.*, refkabkota.KodeKabKota, refkabkota.KodeProv')
                        ->where('a_pasien_update.NoMedrec', $q->NoMedrec)
                        ->leftJoin('refkec', 'a_pasien_update.KodeKec', '=', 'refkec.KodeKec')
                        ->leftJoin('refkabkota', 'refkec.KodeKabKota', '=', 'refkabkota.KodeKabKota')
                        ->orderByDesc('a_pasien_update.Created')
                        ->take(1)
                        ->get();

                    $getPatientAddress = DB::connection('clone')
                        ->table('a_pasien_alamat')
                        ->where('pasien_id', $q->NoMedrec)
                        ->orderByDesc('created_at')
                        ->take(1)
                        ->get();

                    $dataPatientUpdate = $getPatientUpdate->count() > 0 ? $getPatientUpdate[0] : null;
                    $dataPatientAddress = $getPatientAddress->count() > 0 ? $getPatientAddress[0] : null;

                    $id = $q->NoMedrec;
                    $provinceId = $dataPatientUpdate ? $dataPatientUpdate->KodeProv : $q->KodeProv;
                    $cityId = $dataPatientUpdate ? $dataPatientUpdate->KodeKabKota : $q->KodeKabKota;
                    $districtId = $dataPatientUpdate ? $dataPatientUpdate->KodeKec : $q->KodeKec;
                    $religionId = $dataPatientUpdate ? $dataPatientUpdate->AGAMA : $q->AGAMA;
                    $codeOld = $dataPatientUpdate ? $dataPatientUpdate->NoMedrecLama : $q->NoMedrecLama;
                    $codeMember = $dataPatientUpdate ? $dataPatientUpdate->NoKpst : $q->NoKpst;
                    $identityNumber = $dataPatientUpdate ? $dataPatientUpdate->NOIDENTITAS : $q->NOIDENTITAS;
                    $name = $dataPatientUpdate ? $dataPatientUpdate->NAMA : $q->NAMA;
                    $placeOfBirth = $dataPatientUpdate ? $dataPatientUpdate->TMPLAHIR : $q->TMPLAHIR;
                    $dateOfBirth = $dataPatientUpdate ? $dataPatientUpdate->TGLLAHIR : $q->TGLLAHIR;
                    $rt = $dataPatientAddress ? $dataPatientAddress->rt : null;
                    $rw = $dataPatientAddress ? $dataPatientAddress->rw : null;
                    $village = $dataPatientUpdate ? $dataPatientUpdate->Desa : $q->Desa;
                    $address = $dataPatientUpdate ? $dataPatientUpdate->ALAMAT : $q->ALAMAT;
                    $weight = $dataPatientUpdate ? $dataPatientUpdate->BeratLahir : $q->BeratLahir;
                    $job = $dataPatientUpdate ? $dataPatientUpdate->PEKERJAAN : $q->PEKERJAAN;
                    $phone = $dataPatientUpdate ? $dataPatientUpdate->TELP : $q->TELP;
                    $parentName = $dataPatientUpdate ? $dataPatientUpdate->NamaOrtu : $q->NamaOrtu;
                    $partnerName = $dataPatientUpdate ? $dataPatientUpdate->NamaSuamiIstri : $q->NamaSuamiIstri;
                    $createdAt = $dataPatientUpdate ? $dataPatientUpdate->JamInput : $q->JamInput;
                    $updatedAt = $dataPatientUpdate ? $dataPatientUpdate->Created : $q->Created;

                    $dataGender = $dataPatientUpdate ? $dataPatientUpdate->JENSKEL : $q->JENSKEL;
                    $dataGreeted = $dataPatientAddress ? $dataPatientAddress->salutation : null;
                    $dataBloodGroup = strtolower($dataPatientUpdate ? $dataPatientUpdate->GOLDARAH : $q->GOLDARAH);
                    $dataMaritalStatus = strtolower($dataPatientUpdate ? $dataPatientUpdate->STATUSPERKAWINAN : $q->STATUSPERKAWINAN);
                    $dataPatientGroupId = PatientGroup::where('code', $dataPatientUpdate ? $dataPatientUpdate->KodeGol : $q->KodeGol)->first();

                    if ($dataGender == 'L') {
                        $gender = 1;
                    } else if ($dataGender == 'P') {
                        $gender = 2;
                    } else {
                        $gender = null;
                    }

                    if ($dataGreeted == 'TN') {
                        $greeted = 1;
                    } else if ($dataGreeted == 'NY') {
                        $greeted = 2;
                    } else if ($dataGreeted == 'SDR') {
                        $greeted = 3;
                    } else if ($dataGreeted == 'ANAK') {
                        $greeted = 4;
                    } else if ($dataGreeted == 'NN') {
                        $greeted = 5;
                    } else {
                        $greeted = null;
                    }

                    if ($dataBloodGroup == 'a') {
                        $bloodGroup = 1;
                    } else if ($dataBloodGroup == 'b') {
                        $bloodGroup = 2;
                    } else if ($dataBloodGroup == 'o') {
                        $bloodGroup = 3;
                    } else if ($dataBloodGroup == 'ab') {
                        $bloodGroup = 4;
                    } else {
                        $bloodGroup = null;
                    }

                    if ($dataMaritalStatus == 'BELUM KAWIN') {
                        $maritalStatus = 1;
                    } else if ($dataMaritalStatus == 'SUDAH KAWIN' || $dataMaritalStatus == 'KAWIN') {
                        $maritalStatus = 2;
                    } else if ($dataMaritalStatus == 'JANDA' || $dataMaritalStatus == 'DUDA' || $dataMaritalStatus == 'CERAI HIDUP') {
                        $maritalStatus = 3;
                    } else {
                        $maritalStatus = null;
                    }

                    Patient::insert([
                        'id' => $id,
                        'province_id' => $provinceId,
                        'city_id' => $cityId,
                        'district_id' => $districtId,
                        'religion_id' => $religionId,
                        'patient_group_id' => $dataPatientGroupId ? $dataPatientGroupId->id : null,
                        'code_old' => $codeOld,
                        'code_member' => $codeMember,
                        'identity_number' => $identityNumber,
                        'name' => $name,
                        'greeted' => $greeted,
                        'gender' => $gender,
                        'place_of_birth' => $placeOfBirth,
                        'date_of_birth' => $dateOfBirth,
                        'rt' => $rt,
                        'rw' => $rw,
                        'village' => $village,
                        'address' => $address,
                        'weight' => $weight,
                        'blood_group' => $bloodGroup,
                        'marital_status' => $maritalStatus,
                        'job' => $job,
                        'phone' => $phone,
                        'parent_name' => $parentName,
                        'partner_name' => $partnerName,
                        'created_at' => $createdAt,
                        'updated_at' => $updatedAt,
                    ]);
                }
            });
    }
}
