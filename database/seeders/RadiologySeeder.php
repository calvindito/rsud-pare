<?php

namespace Database\Seeders;

use App\Models\Radiology;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RadiologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('m_radiologi')->orderBy('kode')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                Radiology::create([
                    'action_supporting_id' => $q->master_tindakan_id,
                    'code' => $q->kode,
                    'type' => $q->jenis,
                    'object' => $q->objek,
                    'projection' => $q->proyeksi
                ]);
            }
        });
    }
}
