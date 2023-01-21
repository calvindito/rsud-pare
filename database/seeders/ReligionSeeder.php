<?php

namespace Database\Seeders;

use App\Models\Religion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('dm_agama')->orderBy('id_agama')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                Religion::insert([
                    'id' => $q->id_agama,
                    'name' => $q->nama_agama,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}
