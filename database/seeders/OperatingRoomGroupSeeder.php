<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OperatingRoomGroup;
use Illuminate\Support\Facades\DB;

class OperatingRoomGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('dm_ok_gol_operasi')->orderBy('id')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                if ($q->grup == 'KHUSUS') {
                    $group = 1;
                } else if ($q->grup == 'BESAR') {
                    $group = 2;
                } else if ($q->grup == 'SEDANG') {
                    $group = 3;
                } else if ($q->grup == 'KECIL') {
                    $group = 4;
                } else {
                    $group = null;
                }

                OperatingRoomGroup::insert([
                    'id' => $q->id,
                    'name' => $q->nama,
                    'group' => $group,
                    'fee_cssd' => $q->biaya_cssd,
                    'created_at' => $q->created_at ? $q->created_at : now(),
                    'updated_at' => $q->updated_at ? $q->updated_at : now()
                ]);
            }
        });
    }
}
