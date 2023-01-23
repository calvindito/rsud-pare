<?php

namespace Database\Seeders;

use App\Models\ActionOther;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActionOtherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('tindakan_medis_lain')->orderBy('id_tindakan')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                ActionOther::insert([
                    'id' => $q->id_tindakan,
                    'class_type_id' => $q->kelas_id,
                    'name' => $q->nama_tindakan,
                    'consumables' => $q->bhp,
                    'hospital_service' => $q->jrs,
                    'service' => $q->japel,
                    'fee' => $q->tarip,
                    'description' => $q->catatan,
                    'created_at' => $q->created ? $q->created : now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}
