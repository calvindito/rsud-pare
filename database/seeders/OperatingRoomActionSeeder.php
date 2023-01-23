<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\OperatingRoomAction;

class OperatingRoomActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('dm_ok_tindakan')->orderBy('id')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                OperatingRoomAction::insert([
                    'id' => $q->id,
                    'class_type_id' => $q->dm_kelas_id,
                    'operating_room_action_type_id' => $q->dm_ok_jenis_tindakan_id,
                    'operating_room_group_id' => $q->dm_gol_operasi_id,
                    'fee_hospital_service' => $q->biaya_jrs,
                    'fee_doctor_operating_room' => $q->biaya_drop,
                    'fee_doctor_anesthetist' => $q->biaya_dran,
                    'fee_nurse_operating_room' => $q->biaya_prwt_op,
                    'fee_nurse_anesthetist' => $q->biaya_prwt_an,
                    'status' => $q->is_hapus == true ? 0 : 1,
                    'created_at' => $q->created_at ? $q->created_at : now(),
                    'updated_at' => $q->updated_at ? $q->updated_at : now()
                ]);
            }
        });
    }
}
