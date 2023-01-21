<?php

namespace Database\Seeders;

use App\Models\DTD;
use App\Models\ICD;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ICDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('m_icd')->orderBy('kode')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                $dataDtd = DTD::where('code', $q->dtd_kode)->first();

                if ($dataDtd) {
                    $dtdId = $dataDtd->id;
                } else {
                    $dtdId = null;
                }

                ICD::insert([
                    'dtd_id' => $dtdId,
                    'code' => $q->kode,
                    'name' => $q->deskripsi,
                    'created_at' => $q->created_at,
                    'updated_at' => $q->updated_at
                ]);
            }
        });
    }
}
