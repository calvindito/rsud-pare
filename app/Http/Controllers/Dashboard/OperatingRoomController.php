<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\Operation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FunctionalService;
use App\Http\Controllers\Controller;
use App\Models\OperatingRoomActionType;
use App\Models\OperatingRoomAnesthetist;

class OperatingRoomController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'dashboard.operating-room'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function perYear(Request $request)
    {
        try {
            $data = [];
            $year = $request->has('year') ? $request->year : date('Y');
            $month = [];
            $actionType = OperatingRoomActionType::all();
            $series = [];

            for ($i = 1; $i <= 12; $i++) {
                $month[] = Carbon::parse($year . '-' . $i)->isoFormat('MMM');

                foreach ($actionType as $at) {
                    $operationRoomActionTypeId = $at->id;
                    $data[Str::slug($at->name, '-')][] = Operation::whereHas('operatingRoomAction', function ($query) use ($operationRoomActionTypeId) {
                        $query->where('operating_room_action_type_id', $operationRoomActionTypeId);
                    })->whereMonth('date_of_entry', $i)->whereYear('date_of_entry', $year)->count();
                }
            }

            foreach ($actionType as $at) {
                $series[] = [
                    'name' => $at->name,
                    'type' => 'line',
                    'smooth' => true,
                    'stack' => 'Total',
                    'symbol' => 'circle',
                    'symbolSize' => 8,
                    'data' => $data[Str::slug($at->name, '-')]
                ];
            }

            $response = [
                'label' => $month,
                'data' => $series
            ];
        } catch (\Exception $e) {
            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return response()->json($response);
    }

    public function anesthetist(Request $request)
    {
        try {
            $response = [];
            $year = $request->has('year_month') ? date('Y', strtotime($request->year_month)) : date('Y');
            $month = $request->has('year_month') ? date('m', strtotime($request->year_month)) : date('m');

            $anesthetist = OperatingRoomAnesthetist::withCount(['operation' => function ($query) use ($year, $month) {
                $query->whereMonth('date_of_entry', $month)->whereYear('date_of_entry', $year);
            }])->get();

            foreach ($anesthetist as $a) {
                $response[] = [
                    'name' => $a->code,
                    'value' => $a->operation_count
                ];
            }
        } catch (\Exception $e) {
            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return response()->json($response);
    }

    public function status()
    {
        try {
            $response = [];
            $status = ['Belum Operasi', 'Sedang Operasi', 'Selesai Operasi'];

            foreach ($status as $key => $s) {
                $response[] = [
                    'name' => $s,
                    'value' => Operation::where('status', $key + 1)->whereMonth('date_of_entry', date('m'))->whereYear('date_of_entry', date('Y'))->count()
                ];
            }
        } catch (\Exception $e) {
            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return response()->json($response);
    }
}
