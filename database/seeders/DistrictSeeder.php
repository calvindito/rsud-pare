<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        require public_path('assets/masterdata-location.php');

        foreach ($refkec as $rk) {
            District::create([
                'id' => $rk['KodeKec'],
                'city_id' => $rk['KodeKabKota'],
                'name' => $rk['NamaKec'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
