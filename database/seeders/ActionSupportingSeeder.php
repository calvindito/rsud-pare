<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ActionSupporting;
use Illuminate\Support\Facades\DB;

class ActionSupportingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('tindakan_medis_penunjang')->orderBy('id_tindakan_penunjang')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                ActionSupporting::insert([
                    'id' => $q->id_tindakan_penunjang,
                    'class_type_id' => $q->kelas_id,
                    'name' => $q->nama_tindakan,
                    'created_at' => $q->created ? $q->created : now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}
