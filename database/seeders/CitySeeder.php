<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('refkabkota')->orderBy('KodeKabKota')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                City::insert([
                    'id' => $q->KodeKabKota,
                    'province_id' => $q->KodeProv,
                    'name' => $q->NamaKabKota,
                    'island' => $q->IbuKota,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}
