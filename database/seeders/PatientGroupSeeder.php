<?php

namespace Database\Seeders;

use App\Models\PatientGroup;
use Illuminate\Database\Seeder;

class PatientGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        require public_path('assets/masterdata-general.php');

        foreach ($a_golpasien as $agp) {
            PatientGroup::create([
                'code' => $agp['KodeGol'],
                'name' => $agp['NamaGol'],
                'kpid' => $agp['a_kpid'],
                'initial' => $agp['Inisial'],
                'privilege_class_code' => $agp['KodeKlsHak'],
                'privilege_class_type' => $agp['JenisKlsHak'],
                'rule_code' => $agp['KodeAturan'],
                'first_number' => $agp['NoAwal'],
                'contribution_assistance' => $agp['IsPBI'],
                'car_free_ambulance' => $agp['MblAmbGratis'],
                'car_free_corpse' => $agp['MblJnhGratis'],
                'code_member' => $agp['KDJNSKPST'],
                'code_membership' => $agp['KDJNSPESERTA'],
                'employeeable' => $agp['IsKaryawan'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
