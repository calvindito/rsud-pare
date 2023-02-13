<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Patient;
use App\Models\District;
use App\Models\Medicine;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServerSideController extends Controller
{
    public function location(Request $request)
    {
        $show = isset($request->show) ? $request->show : null;
        $search = $request->search;
        $response = [];
        $result = [];

        if ($show == 'province' || is_null($show)) {
            $response[] = Province::where('name', 'like', "%$search%")->orderBy('name')->get();
        }

        if ($show == 'city' || is_null($show)) {
            $response[] = City::where('name', 'like', "%$search%")->orderBy('name')->get();
        }

        if ($show == 'district' || is_null($show)) {
            $response[] = District::where('name', 'like', "%$search%")->orderBy('name')->get();
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

    public function patient(Request $request)
    {
        $search = $request->search;
        $data = Patient::selectRaw('id, name as text')
            ->whereNotNull('verified_at')
            ->when(!empty($search), function ($query) use ($search) {
                $query->where('id', 'like', "%$search%")
                    ->orWhere('identity_number', 'like', "%$search%")
                    ->orWhere('name', 'like', "%$search%");
            })
            ->limit(100)
            ->get()
            ->toArray();

        return response()->json($data);
    }

    public function medicine(Request $request)
    {
        $search = $request->search;
        $data = Medicine::selectRaw('id, name as text')
            ->when(!empty($search), function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })
            ->get()
            ->toArray();

        return response()->json($data);
    }
}
