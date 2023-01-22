<?php

namespace App\Http\Controllers\MasterData\Location;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'master-data.location.city'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = City::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "%$search%")
                        ->orWhere('island', 'like', "%$search%")
                        ->orWhereHas('province', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }
            })
            ->addColumn('province_name', function (City $query) {
                $provinceName = null;

                if (isset($query->province)) {
                    $provinceName = $query->province->name;
                }

                return $provinceName;
            })
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }
}
