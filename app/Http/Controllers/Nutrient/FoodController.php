<?php

namespace App\Http\Controllers\Nutrient;

use App\Models\Food;
use App\Helpers\Simrs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class FoodController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'nutrient.food'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Food::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('code', 'like', "%$search%")
                        ->orWhere('name', 'like', "%$search%");
                }
            })
            ->editColumn('fee', '{{ Simrs::formatRupiah($fee) }}')
            ->addColumn('action', function (Food $query) {
                return '
                    <div class="btn-group">
                        <button type="button" class="btn btn-light text-primary btn-sm fw-semibold dropdown-toggle" data-bs-toggle="dropdown">Aksi</button>
                        <div class="dropdown-menu">
                            <a href="javascript:void(0);" class="dropdown-item fs-13" onclick="showDataUpdate(' . $query->id . ')">
                                <i class="ph-pen me-2"></i>
                                Ubah Data
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item fs-13" onclick="destroyData(' . $query->id . ')">
                                <i class="ph-trash-simple me-2"></i>
                                Hapus Data
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

    public function createData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'code' => 'required|unique:food,code',
            'name' => 'required',
            'fee' => 'required|numeric'
        ], [
            'code.required' => 'kode tidak boleh kosong',
            'code.unique' => 'kode telah digunakan',
            'name.required' => 'nama tidak boleh kosong',
            'fee.required' => 'biaya tidak boleh kosong',
            'fee.numeric' => 'biaya harus angka yang valid'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = Food::create([
                    'code' => $request->code,
                    'name' => $request->name,
                    'fee' => $request->fee
                ]);

                $response = [
                    'code' => 200,
                    'message' => 'Data telah ditambahkan'
                ];
            } catch (\Exception $e) {
                $response = [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ];
            }
        }

        return response()->json($response);
    }

    public function showData(Request $request)
    {
        $id = $request->id;
        $data = Food::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'code' => 'required|unique:food,code,' . $id,
            'name' => 'required',
            'fee' => 'required|numeric'
        ], [
            'code.required' => 'kode tidak boleh kosong',
            'code.unique' => 'kode telah digunakan',
            'name.required' => 'nama tidak boleh kosong',
            'fee.required' => 'biaya tidak boleh kosong',
            'fee.numeric' => 'biaya harus angka yang valid'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = Food::findOrFail($id)->update([
                    'code' => $request->code,
                    'name' => $request->name,
                    'fee' => $request->fee
                ]);

                $response = [
                    'code' => 200,
                    'message' => 'Data telah diubah'
                ];
            } catch (\Exception $e) {
                $response = [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ];
            }
        }

        return response()->json($response);
    }

    public function destroyData(Request $request)
    {
        $id = $request->id;

        try {
            Food::destroy($id);

            $response = [
                'code' => 200,
                'message' => 'Data telah dihapus'
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
