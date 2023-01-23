<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\OperatingRoomAnesthetist;

class OperatingRoomAnesthetistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('dm_ok_anastesi')->orderBy('id')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                OperatingRoomAnesthetist::insert([
                    'id' => $q->id,
                    'code' => $q->kode,
                    'name' => $q->nama,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}
