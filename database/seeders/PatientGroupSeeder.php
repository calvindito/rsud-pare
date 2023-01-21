<?php

namespace Database\Seeders;

use App\Models\PatientGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('a_golpasien')->orderBy('KodeGol')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                PatientGroup::insert([
                    'code' => $q->KodeGol,
                    'name' => $q->NamaGol,
                    'kpid' => $q->a_kpid,
                    'initial' => $q->Inisial,
                    'privilege_class_code' => $q->KodeKlsHak,
                    'privilege_class_type' => $q->JenisKlsHak,
                    'rule_code' => $q->KodeAturan,
                    'first_number' => $q->NoAwal,
                    'contribution_assistance' => $q->IsPBI,
                    'car_free_ambulance' => $q->MblAmbGratis,
                    'car_free_corpse' => $q->MblJnhGratis,
                    'code_member' => $q->KDJNSKPST,
                    'code_membership' => $q->KDJNSPESERTA,
                    'employeeable' => $q->IsKaryawan,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}
