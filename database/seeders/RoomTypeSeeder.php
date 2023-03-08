<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\RoomType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('clone')->table('dm_kamar')->orderBy('id_kamar')->chunk(1000, function ($query) {
            foreach ($query as $q) {
                $dataUser = User::where('username', $q->user_kamar)->first();

                RoomType::insert([
                    'id' => $q->id_kamar,
                    'room_id' => $q->kamar_master_id,
                    'class_type_id' => $q->kelas_id,
                    'user_id' => $dataUser ? $dataUser->id : null,
                    'name' => $q->nama_kamar,
                    'fee_room' => $q->biaya_kamar,
                    'fee_meal' => $q->biaya_makan,
                    'fee_nursing_care' => $q->biaya_askep,
                    'fee_nutritional_care' => $q->biaya_asnut,
                    'tier' => $q->tingkat_kamar,
                    'status' => $q->is_hapus == 1 ? 0 : 1,
                    'created_at' => $q->created ? $q->created : now(),
                    'updated_at' => now()
                ]);
            }
        });
    }
}
