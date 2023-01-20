<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        require public_path('assets/masterdata-general.php');

        foreach ($tpegawai as $tp) {
            Employee::create([
                'code' => $tp['KDPEGAWAI'],
                'name' => $tp['NAMA'],
                'city' => $tp['KOTA'],
                'address' => $tp['ALAMAT'],
                'postal_code' => $tp['KODEPOS'],
                'phone' => $tp['TELEPON'],
                'cellphone' => $tp['PONSEL'],
                'email' => $tp['EMAIL'],
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
