<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FunctionalService;
use Illuminate\Support\Facades\DB;

class FunctionalServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('td_upf')->orderBy('id')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                FunctionalService::insert([
                    'id' => $q->id,
                    'name' => $q->nama,
                    'status' => $q->is_removed == 1 ? 0 : 1,
                    'created_at' => $q->created_at ? $q->created_at : now(),
                    'updated_at' => $q->updated_at ? $q->updated_at : now()
                ]);
            }
        });
    }
}
