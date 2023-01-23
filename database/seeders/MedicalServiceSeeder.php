<?php

namespace Database\Seeders;

use App\Models\MedicalService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicalServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('jenis_visite')->orderBy('id_jenis_visite')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                if ($q->kode_visite == 'VISITE') {
                    $code = 1;
                } else if ($q->kode_visite == 'VISITE IRD') {
                    $code = 2;
                } else if ($q->kode_visite == 'KONSUL') {
                    $code = 3;
                } else if ($q->kode_visite == 'KONSUL IRD') {
                    $code = 4;
                } else if ($q->kode_visite == 'PDP') {
                    $code = 5;
                } else {
                    $code = 'Invalid';
                }

                MedicalService::insert([
                    'id' => $q->id_jenis_visite,
                    'class_type_id' => $q->kelas_tingkat,
                    'code' => $code,
                    'name' => $q->nama_visite,
                    'fee' => $q->biaya,
                    'status' => $q->is_deleted == true ? 0 : 1,
                    'created_at' => $q->created_at ? $q->created_at : now(),
                    'updated_at' => $q->updated_at ? $q->updated_at : now()
                ]);
            }
        });
    }
}
