<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Unit;
use App\Models\Outpatient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PolyQueueController extends Controller
{
    public function general()
    {
        $data = [
            'unit' => Unit::where('type', 2)->orderBy('name')->get(),
            'content' => 'dashboard.poly-queue'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function loadLongLine(Request $request)
    {
        $unitId = $request->unit_id;
        $unit = Unit::find($unitId);
        $totalLongLine = Outpatient::where('unit_id', $unitId)->whereDate('date_of_entry', now())->count();
        $totalLongLineDone = Outpatient::where('unit_id', $unitId)->whereDate('date_of_entry', now())->whereNotIn('status', [1, 3])->count();
        $totalLongLineRemaining = Outpatient::where('unit_id', $unitId)->whereDate('date_of_entry', now())->whereIn('status', [1, 3])->count();

        $active = '---';
        $code = '-------';

        if ($totalLongLine > 0) {
            if ($totalLongLineRemaining > 0) {
                $active = $totalLongLineDone == 0 ? 1 : $totalLongLineDone + 1;
                $code = Outpatient::where('unit_id', $unitId)->whereDate('date_of_entry', now())->where('status', 3)->first()->code();
            }
        }

        return response()->json([
            'poly' => $unit->name,
            'active' => $active,
            'code' => $code,
            'total' => $totalLongLine,
            'done' => $totalLongLineDone,
            'remaining' => $totalLongLineRemaining,
        ]);
    }
}
