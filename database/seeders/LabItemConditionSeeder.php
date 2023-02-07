<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LabItemCondition;
use Illuminate\Support\Facades\DB;

class LabItemConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('dm_lab_kondisi_item')->whereNotNull('kondisi_id')->orderBy('id')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                LabItemCondition::insert([
                    'id' => $q->id,
                    'name' => $q->nama,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}
