<?php

namespace App\Http\Controllers\Nutrient;

use App\Models\Food;
use App\Models\Eating;
use App\Models\RoomType;
use App\Models\EatingTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SchedulingController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->has('date') ? $request->date : date('Y-m-d');
        $eatingSingleData = Eating::whereDate('date', $date)
            ->groupByRaw('eating_time_id, date')
            ->first();

        $data = [
            'eatingSingleData' => $eatingSingleData,
            'eatingTime' => EatingTime::all(),
            'roomType' => RoomType::where('status', 1)->orderByRaw('room_id, class_type_id ASC')->get(),
            'food' => Food::all(),
            'date' => $date,
            'eatingTimeId',
            'content' => 'nutrient.scheduling'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function set(Request $request)
    {
        try {
            $count = EatingTime::count();
            $date = $request->date;

            if ($request->has('room_type_id')) {
                foreach ($request->room_type_id as $rti) {
                    for ($i = 0; $i < $count; $i++) {
                        $eatingTimeId = $request->input("eating_time_$rti.$i");
                        $foodId = $request->input("food_$rti.$i");
                        $portion = $request->input("portion_$rti.$i");
                        $food = Food::find($foodId);

                        Eating::updateOrCreate([
                            'room_type_id' => $rti,
                            'eating_time_id' => $eatingTimeId,
                            'date' => $date
                        ], [
                            'food_id' => $foodId,
                            'fee' => $food->fee ?? 0,
                            'portion' => $portion
                        ]);
                    }
                }
            }

            if ($date == date('Y-m-d')) {
                $param = null;
            } else {
                $param = '?date=' . $date;
            }

            return redirect('nutrient/scheduling' . $param)->with(['success' => 'Penjadwalan ditanggal ' . $date . ' telah tersimpan']);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with(['failed' => $e->getMessage()]);
        }
    }
}
