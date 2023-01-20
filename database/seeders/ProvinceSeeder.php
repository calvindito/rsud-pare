<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        require public_path('assets/masterdata-location.php');

        foreach ($refprov as $rp) {
            Province::create([
                'id' => $rp['KodeProv'],
                'name' => $rp['NamaProv'],
                'iso' => $rp['KodeIso'],
                'capital' => $rp['IbuKota'],
                'wide' => (float)str_replace(',', '', $rp['Luas']),
                'specialization' => $rp['StatusKhusus'],
                'island' => $rp['Pulau'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
