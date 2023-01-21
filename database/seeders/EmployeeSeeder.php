<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('tpegawai')->orderBy('KDPEGAWAI')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                Employee::insert([
                    'code' => $q->KDPEGAWAI,
                    'name' => $q->NAMA,
                    'city' => $q->KOTA,
                    'address' => $q->ALAMAT,
                    'postal_code' => $q->KODEPOS,
                    'phone' => $q->TELEPON,
                    'cellphone' => $q->PONSEL,
                    'email' => $q->EMAIL,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}
