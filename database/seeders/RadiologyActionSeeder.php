<?php

namespace Database\Seeders;

use App\Models\Radiology;
use App\Models\RadiologyAction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RadiologyActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('m_radiologi_tindakan')->orderBy('id')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                $dataRadiology = Radiology::where('code', $q->radiologi_id)->first();

                RadiologyAction::insert([
                    'id' => $q->id,
                    'radiology_id' => $dataRadiology ? $dataRadiology->id : null,
                    'class_type_id' => $q->kelas_id,
                    'consumables' => $q->bhp,
                    'hospital_service' => $q->jrs,
                    'service' => $q->jaspel,
                    'fee' => $q->tarif,
                    'created_at' => $q->created_at ? $q->created_at : now(),
                    'updated_at' => $q->updated_at ? $q->updated_at : now()
                ]);
            }
        });
    }
}
