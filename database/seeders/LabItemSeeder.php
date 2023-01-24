<?php

namespace Database\Seeders;

use App\Models\LabItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('dm_lab_item')->orderBy('id')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                LabItem::insert([
                    'id' => $q->id,
                    'lab_category_id' => $q->kategori_id,
                    'lab_group_id' => $q->grup_id,
                    'name' => $q->nama,
                    'status' => $q->is_removed == 1 ? 0 : 1,
                    'created_at' => $q->created_at ? $q->created_at : now(),
                    'updated_at' => $q->updated_at ? $q->updated_at : now()
                ]);
            }
        });
    }
}
