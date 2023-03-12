<?php

namespace App\Http\Controllers\Nutrient;

use App\Models\Food;
use App\Models\Eating;
use App\Models\Patient;
use App\Models\RoomType;
use App\Models\EatingTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SchedulingController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->has('date') ? $request->date : date('Y-m-d');

        $patient = Patient::whereNotNull('verified_at')
            ->where(function ($query) use ($date) {
                $query->whereHas('eating', function ($query) use ($date) {
                    $query->whereDate('date', $date);
                });

                if ($date == date('Y-m-d')) {
                    $query->orWhereHas('inpatient', function ($query) {
                        $query->where('status', 1);
                    });
                }
            })
            ->get();

        $data = [
            'eatingTime' => EatingTime::all(),
            'patient' => $patient,
            'food' => Food::all(),
            'date' => $date,
            'content' => 'nutrient.scheduling'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function set(Request $request)
    {
        try {
            $count = EatingTime::count();
            $date = $request->date;

            if ($request->has('patient_id')) {
                foreach ($request->patient_id as $pi) {
                    for ($i = 0; $i < $count; $i++) {
                        $eatingTimeId = $request->input("eating_time_$pi.$i");
                        $foodId = $request->input("food_$pi.$i");
                        $code = $request->input("code_$pi.$i");
                        $food = Food::find($foodId);

                        Eating::updateOrCreate([
                            'patient_id' => $pi,
                            'eating_time_id' => $eatingTimeId,
                            'date' => $date
                        ], [
                            'food_id' => $foodId,
                            'fee' => $food->fee ?? 0,
                            'code' => $code
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
