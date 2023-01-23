<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ActionNonOperative;
use Illuminate\Support\Facades\DB;

class ActionNonOperativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('tindakan_medis_non_operatif')->orderBy('id_tindakan')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                ActionNonOperative::insert([
                    'id' => $q->id_tindakan,
                    'class_type_id' => $q->kelas_id,
                    'code' => $q->kode_tindakan,
                    'name' => $q->nama_tindakan,
                    'hospital_service' => $q->jrs,
                    'doctor_operating' => $q->drOP,
                    'doctor_anesthetist' => $q->drANAS,
                    'nurse_operating_room' => $q->perawatOK,
                    'nurse_anesthetist' => $q->perawatANAS,
                    'total' => $q->total,
                    'fee' => $q->tarip,
                    'created_at' => $q->created ? $q->created : now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}
