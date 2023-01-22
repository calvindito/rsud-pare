<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('user_level')->orderBy('KODE_LEVEL')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                Role::insert([
                    'id' => $q->KODE_LEVEL,
                    'name' => $q->NAMA_LEVEL,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}
