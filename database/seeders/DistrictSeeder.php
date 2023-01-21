<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('refkec')->orderBy('KodeKec')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                District::insert([
                    'id' => $q->KodeKec,
                    'city_id' => $q->KodeKabKota,
                    'name' => $q->NamaKec,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}
