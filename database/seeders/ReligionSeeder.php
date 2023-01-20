<?php

namespace Database\Seeders;

use App\Models\Religion;
use Illuminate\Database\Seeder;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        require public_path('assets/masterdata-general.php');

        foreach ($dm_agama as $dma) {
            Religion::create([
                'id' => $dma['id_agama'],
                'name' => $dma['nama_agama'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
