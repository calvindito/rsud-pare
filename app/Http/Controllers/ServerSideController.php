<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServerSideController extends Controller
{
    public function location(Request $request)
    {
        $show = isset($request->show) ? $request->show : [];
        $search = $request->search;
        $response = [];
        $result = [];

        if (in_array('province', $show) || empty($show)) {
            $response[] = Province::where('name', 'like', "%$search%")->latest('id')->get();
        }

        if (in_array('city', $show) || empty($show)) {
            $response[] = City::where('name', 'like', "%$search%")->latest('id')->get();
        }

        if (in_array('district', $show) || empty($show)) {
            $response[] = District::where('name', 'like', "%$search%")->latest('id')->get();
        }

        if (count($response) > 0) {
            $collapse = collect($response)->collapse()->all();
            $result = collect($collapse)->map(function ($item) {
                $table = $item->getTable();

                if ($table == 'provinces') {
                    $name = $item->name;
                } else if ($table == 'cities') {
                    $provinceName = isset($item->province) ? $item->province->name : 'Invalid Provinsi';
                    $name = $provinceName . ' - ' . $item->name;
                } else if ($table == 'districts') {
                    $provinceName = isset($item->city->province) ? $item->city->province->name : 'Invalid Provinsi';
                    $cityName = isset($item->city) ? $item->city->name : 'Invalid Kota';
                    $name = $provinceName . ' - ' . $cityName . ' - ' . $item->name;
                }

                return [
                    'id' => $item->id,
                    'text' => $name
                ];
            })->all();
        }

        return response()->json($result);
    }
}
