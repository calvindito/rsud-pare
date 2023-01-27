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
                    $provinceId = isset($dataPatientUpdate->KodeProv) ? $dataPatientUpdate->KodeProv : (isset($q->KodeProv) ? $q->KodeProv : null);
                    $cityId = isset($dataPatientUpdate->KodeKabKota) ? $dataPatientUpdate->KodeKabKota : (isset($q->KodeKabKota) ? $q->KodeKabKota : null);
                    $districtId = isset($dataPatientUpdate->KodeKec) ? $dataPatientUpdate->KodeKec : (isset($q->KodeKec) ? $q->KodeKec : null);
                    $religionId = isset($dataPatientUpdate->AGAMA) ? $dataPatientUpdate->AGAMA : (isset($q->AGAMA) ? $q->AGAMA : null);
                    $codeOld = isset($dataPatientUpdate->NoMedrecLama) ? $dataPatientUpdate->NoMedrecLama : (isset($q->NoMedrecLama) ? $q->NoMedrecLama : null);
                    $codeMember = isset($dataPatientUpdate->NoKpst) ? $dataPatientUpdate->NoKpst : (isset($q->NoKpst) ? $q->NoKpst : null);
                    $identityNumber = isset($dataPatientUpdate->NOIDENTITAS) ? $dataPatientUpdate->NOIDENTITAS : (isset($q->NOIDENTITAS) ? $q->NOIDENTITAS : null);
                    $name = isset($dataPatientUpdate->NAMA) ? $dataPatientUpdate->NAMA : (isset($q->NAMA) ? $q->NAMA : null);
                    $placeOfBirth = isset($dataPatientUpdate->TMPLAHIR) ? $dataPatientUpdate->TMPLAHIR : (isset($q->TMPLAHIR) ? $q->TMPLAHIR : null);
                    $dateOfBirth = isset($dataPatientUpdate->TGLLAHIR) ? $dataPatientUpdate->TGLLAHIR : (isset($q->TGLLAHIR) ? $q->TGLLAHIR : null);
                    $rt = isset($dataPatientAddress->rt) ? $dataPatientAddress->rt : null;
                    $rw = isset($dataPatientAddress->rw) ? $dataPatientAddress->rw : null;
                    $village = isset($dataPatientUpdate->Desa) ? $dataPatientUpdate->Desa : (isset($q->Desa) ? $q->Desa : null);
                    $address = isset($dataPatientUpdate->ALAMAT) ? $dataPatientUpdate->ALAMAT : (isset($q->ALAMAT) ? $q->ALAMAT : null);
                    $weight = isset($dataPatientUpdate->BeratLahir) ? $dataPatientUpdate->BeratLahir : (isset($q->BeratLahir) ? $q->BeratLahir : null);
                    $job = isset($dataPatientUpdate->PEKERJAAN) ? $dataPatientUpdate->PEKERJAAN : (isset($q->PEKERJAAN) ? $q->PEKERJAAN : null);
                    $phone = isset($dataPatientUpdate->TELP) ? $dataPatientUpdate->TELP : (isset($q->TELP) ? $q->TELP : null);
                    $parentName = isset($dataPatientUpdate->NamaOrtu) ? $dataPatientUpdate->NamaOrtu : (isset($q->NamaOrtu) ? $q->NamaOrtu : null);
                    $partnerName = isset($dataPatientUpdate->NamaSuamiIstri) ? $dataPatientUpdate->NamaSuamiIstri : (isset($q->NamaSuamiIstri) ? $q->NamaSuamiIstri : null);
                    $createdAt = isset($dataPatientUpdate->JamInput) ? $dataPatientUpdate->JamInput : (isset($q->JamInput) ? $q->JamInput : null);
                    $updatedAt = isset($dataPatientUpdate->Created) ? $dataPatientUpdate->Created : (isset($q->Created) ? $q->Created : null);

                    $dataGender = isset($dataPatientUpdate->JENSKEL) ? $dataPatientUpdate->JENSKEL : (isset($q->JENSKEL) ? $q->JENSKEL : null);
                    $dataGreeted = isset($dataPatientAddress->salutation) ? $dataPatientAddress->salutation : null;
                    $dataBloodGroup = strtolower(isset($dataPatientUpdate->GOLDARAH) ? $dataPatientUpdate->GOLDARAH : (isset($q->GOLDARAH) ? $q->GOLDARAH : null));
                    $dataPatientKodeGol = isset($dataPatientUpdate->KodeGol) ? $dataPatientUpdate->KodeGol : (isset($q->KodeGol) ? $q->KodeGol : null);
                    $dataPatientGroupId = PatientGroup::where('code', $dataPatientKodeGol)->first();
                    $dataMaritalStatus = strtolower(isset($dataPatientUpdate->STATUSPERKAWINAN) ? $dataPatientUpdate->STATUSPERKAWINAN : (isset($q->STATUSPERKAWINAN) ? $q->STATUSPERKAWINAN : null));

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
                        'type' => 1,
                        'verified_at' => now(),
                        'created_at' => $createdAt,
                        'updated_at' => $updatedAt,
                    ]);
                }
            });
    }
}
