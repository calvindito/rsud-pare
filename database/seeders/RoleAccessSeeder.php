<?php

namespace Database\Seeders;

use App\Models\RoleAccess;
use Illuminate\Database\Seeder;

class RoleAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoleAccess::truncate();

        $data = [];

        foreach (config('menu') as $m1) {
            if ($m1['sub']) {
                foreach ($m1['sub'] as $m2) {
                    if ($m2['sub']) {
                        foreach ($m2['sub'] as $m3) {
                            $data[] = [
                                'role_id' => 1,
                                'menu' => $m1['name'] . '.' . $m2['name'] . '.' . $m3['name'],
                                'created_at' => now(),
                                'updated_at' => now()
                            ];
                        }
                    } else {
                        $data[] = [
                            'role_id' => 1,
                            'menu' => $m1['name'] . '.' . $m2['name'],
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }
                }
            } else {
                $data[] = [
                    'role_id' => 1,
                    'menu' => $m1['name'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        RoleAccess::insert($data);
    }
}
