<?php

namespace Database\Seeders;

use App\Models\UnitAction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('a_unit_tindakan')->orderBy('id')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                UnitAction::insert([
                    'id' => $q->id,
                    'unit_id' => $q->unit_id,
                    'action_id' => $q->dm_tindakan_id,
                    'ahp' => $q->akhp,
                    'hospital_service' => $q->jrs,
                    'service' => $q->jaspel,
                    'score' => $q->nilai,
                    'created_at' => $q->created_at ? $q->created_at : now(),
                    'updated_at' => $q->updated_at ? $q->updated_at : now()
                ]);
            }
        });
    }
}
