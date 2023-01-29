<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('user')->orderBy('created_at')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                $dataEmployee = Employee::where('code', $q->PEGAWAI_ID)->first();

                if ($dataEmployee) {
                    User::insert([
                        'employee_id' => $dataEmployee->id,
                        'role_id' => $q->LEVEL,
                        'username' => $q->USERNAME,
                        'password' => bcrypt('123456'),
                        'status' => $q->STATUS != 1 ? 0 : 1,
                        'created_at' => $q->created_at ? $q->created_at : now(),
                        'updated_at' => $q->updated_at ? $q->updated_at : now()
                    ]);
                }
            }
        });
    }
}
