<?php

namespace Database\Seeders;

use App\Models\Action;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('dm_tindakan')->orderBy('id')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                Action::insert([
                    'id' => $q->id,
                    'code' => $q->kode,
                    'name' => $q->nama,
                    'fee' => $q->biaya,
                    'created_at' => $q->created_at ? $q->created_at : now(),
                    'updated_at' => $q->updated_at ? $q->updated_at : now()
                ]);
            }
        });
    }
}
