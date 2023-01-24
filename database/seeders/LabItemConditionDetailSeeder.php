<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\LabItemConditionDetail;

class LabItemConditionDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('dm_lab_kondisi_item')->orderBy('id')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                LabItemConditionDetail::insert([
                    'id' => $q->id,
                    'lab_item_condition_id' => $q->kondisi_id,
                    'slug' => Str::slug($q->nama, '-'),
                    'name' => $q->nama,
                    'status' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}
