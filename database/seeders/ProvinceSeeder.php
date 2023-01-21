<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('refprov')->orderBy('KodeProv')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                Province::insert([
                    'id' => $q->KodeProv,
                    'name' => $q->NamaProv,
                    'iso' => $q->KodeIso,
                    'capital' => $q->IbuKota,
                    'wide' => (float)str_replace(',', '', $q->Luas),
                    'specialization' => $q->StatusKhusus,
                    'island' => $q->Pulau,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}
