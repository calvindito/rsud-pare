<?php

namespace Database\Seeders;

use App\Models\ClassType;
use Illuminate\Database\Seeder;

class ClassTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        require public_path('assets/masterdata-general.php');

        foreach ($dm_kelas as $dk) {
            ClassType::insert([
                'code' => $dk['kode_kelas'],
                'code_bpjs' => $dk['kode_kelas_bpjs'],
                'name' => $dk['nama_kelas'],
                'fee_monitoring' => $dk['biaya_rr_monitor'],
                'fee_nursing_care' => $dk['biaya_rr_askep'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
