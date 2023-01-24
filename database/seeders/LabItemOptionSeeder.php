<?php

namespace Database\Seeders;

use App\Models\LabItemOption;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabItemOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('dm_lab_item_option')->orderBy('id')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                LabItemOption::insert([
                    'id' => $q->id,
                    'lab_item_id' => $q->item_id,
                    'score' => $q->nilai,
                    'label' => $q->label,
                    'created_at' => $q->created_at ? $q->created_at : now(),
                    'updated_at' => $q->updated_at ? $q->updated_at : now()
                ]);
            }
        });
    }
}
