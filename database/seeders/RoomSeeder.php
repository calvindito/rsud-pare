<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('dm_kamar_master')->orderBy('id')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                Room::insert([
                    'id' => $q->id,
                    'unit_id' => $q->unit_id,
                    'code' => $q->kode_kamar,
                    'name' => $q->nama_kamar,
                    'created_at' => $q->created_at,
                    'updated_at' => $q->updated_at
                ]);
            }
        });
    }
}
