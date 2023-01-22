<?php

namespace Database\Seeders;

use App\Models\RoomBed;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomBedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('m_bed')->orderBy('id')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                RoomBed::insert([
                    'id' => $q->id,
                    'room_space_id' => $q->ruang_id,
                    'type' => $q->jk,
                    'name' => $q->nama,
                    'keywords' => $q->keyword,
                    'created_at' => $q->created_at,
                    'updated_at' => $q->updated_at
                ]);
            }
        });
    }
}
