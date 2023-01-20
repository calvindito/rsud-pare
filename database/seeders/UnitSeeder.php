<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        require public_path('assets/masterdata-general.php');

        foreach ($a_unit as $au) {
            Unit::create([
                'code' => $au['KodeUnit'],
                'name' => $au['NamaUnit'],
                'type' => $au['unit_tipe'] > 9 ? 0 : $au['unit_tipe'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
