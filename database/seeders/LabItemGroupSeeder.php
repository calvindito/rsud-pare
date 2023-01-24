<?php

namespace Database\Seeders;

use App\Models\LabItemGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabItemGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('dm_lab_grup')->orderBy('id')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                LabItemGroup::insert([
                    'id' => $q->id,
                    'code' => $q->kode,
                    'name' => $q->nama,
                    'created_at' => $q->created_at ? $q->created_at : now(),
                    'updated_at' => $q->updated_at ? $q->updated_at : now()
                ]);
            }
        });
    }
}
