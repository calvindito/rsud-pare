<?php

namespace App\Http\Controllers\MasterData\OperatingRoom;

use Illuminate\Http\Request;
use App\Models\OperatingRoomGroup;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class OperatingGroupController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'master-data.operating-room.operating-group'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = OperatingRoomGroup::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "%$search%");
                }
            })
            ->addColumn('action', function (OperatingRoomGroup $query) {
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
            'group' => 'required',
            'name' => 'required',
            'fee_cssd' => 'required|numeric'
        ], [
            'group.required' => 'mohon memilih grup',
            'name.required' => 'nama tidak boleh kosong',
            'fee_cssd.required' => 'biaya cssd tidak boleh kosong',
            'fee_cssd.numeric' => 'biaya cssd harus angka yang valid'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = OperatingRoomGroup::create([
                    'name' => $request->name,
                    'group' => $request->group,
                    'fee_cssd' => $request->fee_cssd
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
        $data = OperatingRoomGroup::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'group' => 'required',
            'name' => 'required',
            'fee_cssd' => 'required|numeric'
        ], [
            'group.required' => 'mohon memilih grup',
            'name.required' => 'nama tidak boleh kosong',
            'fee_cssd.required' => 'biaya cssd tidak boleh kosong',
            'fee_cssd.numeric' => 'biaya cssd harus angka yang valid'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = OperatingRoomGroup::findOrFail($id)->update([
                    'name' => $request->name,
                    'group' => $request->group,
                    'fee_cssd' => $request->fee_cssd
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
            OperatingRoomGroup::destroy($id);

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
