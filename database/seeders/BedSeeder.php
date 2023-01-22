<?php

namespace Database\Seeders;

use App\Models\Bed;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BedSeeder extends Seeder
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
                if ($q->jk == 'L') {
                    $type = 1;
                } else if ($q->jk == 'P') {
                    $type = 2;
                } else if ($q->jk == 'M') {
                    $type = 3;
                } else if ($q->jk  == 'A') {
                    $type = 4;
                } else {
                    $type = null;
                }

                Bed::insert([
                    'id' => $q->id,
                    'room_space_id' => $q->ruang_id,
                    'type' => $type,
                    'name' => $q->nama,
                    'keywords' => $q->keyword,
                    'created_at' => $q->created_at,
                    'updated_at' => $q->updated_at
                ]);
            }
        });
    }
}
