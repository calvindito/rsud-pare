<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        require public_path('assets/masterdata-location.php');

        foreach ($refkabkota as $rkk) {
            City::create([
                'id' => $rkk['KodeKabKota'],
                'province_id' => $rkk['KodeProv'],
                'name' => $rkk['NamaKabKota'],
                'island' => $rkk['IbuKota'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
