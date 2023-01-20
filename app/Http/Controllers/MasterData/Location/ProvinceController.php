<?php

namespace App\Http\Controllers\MasterData\Location;

use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ProvinceController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'master-data.location.province'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Province::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "%$search%")
                        ->orWhere('capital', 'like', "%$search%")
                        ->orWhere('specialization', 'like', "%$search%")
                        ->orWhere('island', 'like', "%$search%");
                }
            })
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }
}
