<?php

namespace Database\Seeders;

use App\Models\RoomSpace;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSpaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('m_ruang_kamar')->orderBy('id')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                RoomSpace::insert([
                    'id' => $q->id,
                    'room_type_id' => $q->kamar_id,
                    'name' => $q->nama,
                    'facility' => $q->fasilitas,
                    'created_at' => $q->created_at,
                    'updated_at' => $q->updated_at
                ]);
            }
        });
    }
}
