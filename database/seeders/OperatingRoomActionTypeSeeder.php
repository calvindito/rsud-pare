<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\OperatingRoomActionType;

class OperatingRoomActionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('dm_ok_jenis_tindakan')->orderBy('id')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                OperatingRoomActionType::insert([
                    'id' => $q->id,
                    'name' => $q->nama,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}
