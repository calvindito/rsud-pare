<?php

namespace Database\Seeders;

use App\Models\LabCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('dm_lab_kategori')->orderBy('id')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                LabCategory::insert([
                    'id' => $q->id,
                    'name' => $q->nama,
                    'created_at' => $q->created_at ? $q->created_at : now(),
                    'updated_at' => $q->updated_at ? $q->updated_at : now()
                ]);
            }
        });
    }
}
