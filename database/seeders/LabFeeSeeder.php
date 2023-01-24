<?php

namespace Database\Seeders;

use App\Models\LabFee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('dm_lab_item_tarif')->orderBy('id')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                LabFee::insert([
                    'id' => $q->id,
                    'lab_item_id' => $q->item_id,
                    'class_type_id' => $q->kelas_id,
                    'consumables' => $q->bhp,
                    'hospital_service' => $q->jrs,
                    'service' => $q->japel,
                    'status' => $q->is_removed == 1 ? 0 : 1,
                    'created_at' => $q->created_at ? $q->created_at : now(),
                    'updated_at' => $q->updated_at ? $q->updated_at : now()
                ]);
            }
        });
    }
}
