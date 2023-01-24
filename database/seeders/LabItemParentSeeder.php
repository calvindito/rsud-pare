<?php

namespace Database\Seeders;

use App\Models\LabItemParent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabItemParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('dm_lab_item_parent')->orderBy('id')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                LabItemParent::insert([
                    'id' => $q->id,
                    'parent_id' => $q->parent_id,
                    'lab_item_id' => $q->item_id,
                    'level' => $q->level,
                    'limit_lower' => $q->batas_bawah,
                    'limit_critical_lower' => $q->batas_bawah_kritis,
                    'limit_upper' => $q->batas_atas,
                    'limit_critical_upper' => $q->batas_atas_kritis,
                    'limit_lower_patient' => $q->batas_bawah_p,
                    'limit_critical_lower_patient' => $q->batas_bawah_kritis_p,
                    'limit_upper_patient' => $q->batas_atas_p,
                    'limit_critical_upper_patient' => $q->batas_atas_kritis_p,
                    'dropdown' => $q->dropdown_value ? $q->dropdown_value : false,
                    'method' => $q->metode,
                    'unit' => $q->satuan,
                    'status' => $q->is_removed == 1 ? 0 : 1,
                    'created_at' => $q->created_at ? $q->created_at : now(),
                    'updated_at' => $q->updated_at ? $q->updated_at : now()
                ]);
            }
        });
    }
}
