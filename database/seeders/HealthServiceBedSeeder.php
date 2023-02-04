<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HealthServiceBed;
use Illuminate\Support\Facades\DB;

class HealthServiceBedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('yankes_bed')->orderBy('id')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                HealthServiceBed::insert([
                    'id' => $q->id,
                    'class_type_id' => $q->kelas_id,
                    'functional_service_id' => $q->upf_id,
                    'qty_man' => $q->jumlah_l,
                    'qty_woman' => $q->jumlah_p,
                    'created_at' => $q->created_at ? $q->created_at : now(),
                    'updated_at' => $q->updated_at ? $q->updated_at : now()
                ]);
            }
        });
    }
}
