<?php

namespace App\Http\Controllers\Accounting;

use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ChartOfAccountController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'accounting.chart-of-account'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function loadParent()
    {
        $data = ChartOfAccount::where('status', true)->orderBy('code')->get();

        return response()->json($data);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = ChartOfAccount::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('code', 'like', "%$search%")
                        ->orWhere('name', 'like', "%$search%");
                }
            })
            ->editColumn('status', function (ChartOfAccount $query) {
                return $query->status();
            })
            ->addColumn('action', function (ChartOfAccount $query) {
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
            ->rawColumns(['action', 'status'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function createData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'code' => 'required|unique:chart_of_accounts,code',
            'name' => 'required'
        ], [
            'code.required' => 'kode tidak boleh kosong',
            'code.unique' => 'kode telah digunakan',
            'name.required' => 'nama tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = ChartOfAccount::create([
                    'parent_id' => $request->parent_id != 0 ?? $request->parent_id,
                    'code' => $request->code,
                    'name' => $request->name
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
        $data = ChartOfAccount::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'code' => 'required|unique:chart_of_accounts,code,' . $id,
            'name' => 'required'
        ], [
            'code.required' => 'kode tidak boleh kosong',
            'code.unique' => 'kode telah digunakan',
            'name.required' => 'nama tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = ChartOfAccount::findOrFail($id)->update([
                    'parent_id' => $request->parent_id != 0 ?? $request->parent_id,
                    'code' => $request->code,
                    'name' => $request->name,
                    'status' => $request->status
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
            ChartOfAccount::destroy($id);

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
