<?php

namespace Database\Seeders;

use App\Models\MedicalService;
use Illuminate\Database\Seeder;

class MedicalServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        require public_path('assets/masterdata-general.php');

        foreach ($jenis_visite as $jv) {
            if ($jv['kode_visite'] == 'VISITE') {
                $code = 1;
            } else if ($jv['kode_visite'] == 'VISITE IRD') {
                $code = 2;
            } else if ($jv['kode_visite'] == 'KONSUL') {
                $code = 3;
            } else if ($jv['kode_visite'] == 'KONSUL IRD') {
                $code = 4;
            } else if ($jv['kode_visite'] == 'PDP') {
                $code = 5;
            } else {
                $code = 'Invalid';
            }

            MedicalService::create([
                'class_type_id' => $jv['kelas_tingkat'],
                'code' => $code,
                'name' => $jv['nama_visite'],
                'fee' => $jv['biaya'],
                'status' => $jv['is_deleted'] == true ? 0 : 1,
                'created_at' => $jv['created_at'],
                'updated_at' => $jv['updated_at']
            ]);
        }
    }
}
