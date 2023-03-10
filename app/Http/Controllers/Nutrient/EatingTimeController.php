<?php

namespace App\Http\Controllers\Nutrient;

use App\Models\EatingTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EatingTimeController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'nutrient.eating-time'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function set(Request $request)
    {
        try {
            if ($request->has('type')) {
                foreach ($request->type as $key => $t) {
                    EatingTime::updateOrCreate([
                        'type' => $t
                    ], [
                        'time_start' => $request->time_start[$key],
                        'time_end' => $request->time_end[$key]
                    ]);
                }
            }

            $response = [
                'code' => 200,
                'message' => 'Waktu makan telah disimpan'
            ];
        } catch (\Exception $e) {
            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return response()->json($response);
    }
}
