<?php

namespace Database\Seeders;

use App\Models\DTD;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DTDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('m_dtd')->orderBy('kode')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                DTD::insert([
                    'code' => $q->kode,
                    'name' => $q->deskripsi,
                    'created_at' => $q->created_at ? $q->created_at : now(),
                    'updated_at' => $q->updated_at ? $q->updated_at : now()
                ]);
            }
        });
    }
}
