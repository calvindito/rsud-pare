<?php

namespace Database\Seeders;

use App\Models\ClassType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('dm_kelas')->orderBy('id_kelas')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                ClassType::insert([
                    'id' => $q->id_kelas,
                    'code' => $q->kode_kelas,
                    'code_bpjs' => $q->kode_kelas_bpjs,
                    'name' => $q->nama_kelas,
                    'fee_monitoring' => $q->biaya_rr_monitor,
                    'fee_nursing_care' => $q->biaya_rr_askep,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}
