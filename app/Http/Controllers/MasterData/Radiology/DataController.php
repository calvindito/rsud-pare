<?php

namespace App\Http\Controllers\MasterData\Radiology;

use App\Models\Radiology;
use Illuminate\Http\Request;
use App\Models\ActionSupporting;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{
    public function index()
    {
        $data = [
            'actionSupporting' => ActionSupporting::all(),
            'content' => 'master-data.radiology.data'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Radiology::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('code', 'like', "%$search%")
                        ->orWhere('type', 'like', "%$search%")
                        ->orWhere('object', 'like', "%$search%")
                        ->orWhere('projection', 'like', "%$search%")
                        ->orWhereHas('actionSupporting', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }
            })
            ->addColumn('action_supporting_name', function (Radiology $query) {
                $actionSupportingName = null;

                if (isset($query->actionSupporting)) {
                    $actionSupportingName = $query->actionSupporting->name;
                }

                return $actionSupportingName;
            })
            ->addColumn('action', function (Radiology $query) {
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
            'action_supporting_id' => 'required',
            'type' => 'required',
            'object' => 'required',
            'projection' => 'required'
        ], [
            'action_supporting_id.required' => 'mohon memilih tindakan penunjang',
            'type.required' => 'jenis tidak boleh kosong',
            'object.required' => 'objek tidak boleh kosong',
            'projection.required' => 'proyeksi tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = Radiology::create([
                    'action_supporting_id' => $request->action_supporting_id,
                    'type' => $request->type,
                    'object' => $request->object,
                    'projection' => $request->projection
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
        $data = Radiology::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'action_supporting_id' => 'required',
            'type' => 'required',
            'object' => 'required',
            'projection' => 'required'
        ], [
            'action_supporting_id.required' => 'mohon memilih tindakan penunjang',
            'type.required' => 'jenis tidak boleh kosong',
            'object.required' => 'objek tidak boleh kosong',
            'projection.required' => 'proyeksi tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = Radiology::findOrFail($id)->update([
                    'action_supporting_id' => $request->action_supporting_id,
                    'type' => $request->type,
                    'object' => $request->object,
                    'projection' => $request->projection
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
            Radiology::destroy($id);

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
