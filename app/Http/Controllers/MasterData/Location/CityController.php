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
        $data = City::with('province');

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
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }
}
