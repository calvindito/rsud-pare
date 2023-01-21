<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('a_unit')->orderBy('KodeUnit')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                Unit::insert([
                    'code' => $q->KodeUnit,
                    'name' => $q->NamaUnit,
                    'type' => $q->unit_tipe > 9 ? 0 : $q->unit_tipe,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}
