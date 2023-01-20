<?php

namespace App\Http\Controllers\MasterData\Location;

use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class DistrictController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'master-data.location.district'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = District::with('city');

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "%$search%")
                        ->orWhereHas('city', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }
            })
            ->addColumn('city_name', function (District $query) {
                $cityName = null;

                if (isset($query->city)) {
                    $cityName = $query->city->name;
                }

                return $cityName;
            })
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }
}
