<?php

namespace Database\Seeders;

use App\Models\Installation;
use Illuminate\Database\Seeder;

class InstallationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Installation::insert([
            [
                'name' => 'Farmasi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Gizi',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
