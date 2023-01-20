<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        require public_path('assets/masterdata-general.php');

        foreach ($dm_dokter as $dd) {
            if ($dd['jenis_dokter'] == 'AHLI') {
                $type = 1;
            } else if ($dd['jenis_dokter'] == 'GIGI') {
                $type = 2;
            } else if ($dd['jenis_dokter'] == 'UMUM') {
                $type = 3;
            } else {
                $type = null;
            }

            Doctor::create([
                'id' => $dd['id_dokter'],
                'name' => $dd['nama_dokter'],
                'calling' => $dd['nama_panggilan'],
                'type' => $type,
                'percentage' => $dd['prosentasi_jasa'],
                'address' => $dd['alamat_praktik'],
                'phone' => $dd['telp'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
