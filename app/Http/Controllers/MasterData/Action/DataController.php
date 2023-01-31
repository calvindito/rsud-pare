<?php

namespace App\Http\Controllers\MasterData\Action;

use App\Models\Action;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'master-data.action.data'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Action::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('code', 'like', "%$search%")
                        ->orWhere('name', 'like', "%$search%");
                }
            })
            ->editColumn('fee', '{{ Simrs::formatRupiah($fee) }}')
            ->editColumn('created_at', '{{ date("Y-m-d H:i:s", strtotime($created_at)) }}')
            ->editColumn('updated_at', '{{ date("Y-m-d H:i:s", strtotime($updated_at)) }}')
            ->addColumn('action', function (Action $query) {
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
            'code' => 'required|unique:actions,code',
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
                $createData = Action::create([
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
        $data = Action::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'code' => 'required|unique:actions,code,' . $id,
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
                $updateData = Action::findOrFail($id)->update([
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
            Action::destroy($id);

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
