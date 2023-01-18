<?php

namespace App\Http\Controllers\MasterData\General;

use App\Models\ClassType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ClassTypeController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'master-data.general.class-type'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $data = ClassType::query();
        $search = $request->search['value'];

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "%$search%");
                }
            })
            ->addColumn('action', function (ClassType $query) {
                return '
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            Aksi
                        </button>
                        <div class="dropdown-menu">
                            <a href="javascript:void(0);" class="dropdown-item fs-13" onclick="editable(' . $query->id . ')">
                                <i class="ph-pen me-1"></i>
                                Ubah
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item fs-13" onclick="destroy(' . $query->id . ')">
                                <i class="ph-trash-simple me-1"></i>
                                Hapus
                            </a>
                        </div>
                    </div>
                ';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }
}
