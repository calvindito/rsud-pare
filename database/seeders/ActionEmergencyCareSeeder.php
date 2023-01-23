<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ActionEmergencyCare;

class ActionEmergencyCareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('tindakan_rawat_darurat')->orderBy('id_tindakan')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                ActionEmergencyCare::insert([
                    'id' => $q->id_tindakan,
                    'name' => $q->nama_tindakan,
                    'hospital_service' => $q->jrs,
                    'service_doctor' => $q->japel_dokter,
                    'service_nursing_care' => $q->japel_askep,
                    'fee' => $q->tarip,
                    'description' => $q->catatan,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}
