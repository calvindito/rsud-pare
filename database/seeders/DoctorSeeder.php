<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('dm_dokter')->orderBy('id_dokter')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                if ($q->jenis_dokter == 'AHLI') {
                    $type = 1;
                } else if ($q->jenis_dokter == 'GIGI') {
                    $type = 2;
                } else if ($q->jenis_dokter == 'UMUM') {
                    $type = 3;
                } else {
                    $type = null;
                }

                Doctor::insert([
                    'id' => $q->id_dokter,
                    'name' => $q->nama_dokter,
                    'calling' => $q->nama_panggilan,
                    'type' => $type,
                    'percentage' => $q->prosentasi_jasa,
                    'address' => $q->alamat_praktik,
                    'phone' => $q->telp,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}
