<?php

namespace Database\Seeders;

use App\Models\Medicine;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('m_obat_akhp')->orderBy('kd_barang')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                Medicine::insert([
                    'code' => $q->kd_barang,
                    'code_t' => $q->kd_t,
                    'code_type' => $q->kd_js,
                    'name' => $q->nama_barang,
                    'name_generic' => $q->nama_generik,
                    'power' => $q->kekuatan,
                    'power_unit' => $q->satuan_kekuatan,
                    'unit' => $q->satuan,
                    'inventory' => $q->jns_sediaan,
                    'bir' => $q->b_i_r,
                    'non_generic' => $q->gen_non,
                    'nar' => $q->nar_p_non,
                    'oakrl' => $q->oakrl,
                    'chronic' => $q->kronis,
                    'stock' => $q->stok,
                    'stock_min' => $q->stok_min,
                    'price' => $q->hj,
                    'price_purchase' => $q->hb,
                    'price_netto' => $q->hna,
                    'discount' => $q->diskon,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}
