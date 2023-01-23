<?php

namespace App\Http\Controllers\MasterData\Action;

use App\Models\ClassType;
use App\Models\ActionOther;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class OtherController extends Controller
{
    public function index()
    {
        $data = [
            'classType' => ClassType::all(),
            'content' => 'master-data.action.other'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = ActionOther::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "%$search%")
                        ->orWhereHas('classType', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }
            })
            ->editColumn('fee', '{{ number_format($fee, 2) }}')
            ->editColumn('consumables', '{{ number_format($consumables, 2) }}')
            ->editColumn('hospital_service', '{{ number_format($hospital_service, 2) }}')
            ->editColumn('service', '{{ number_format($service, 2) }}')
            ->addColumn('class_type_name', function (ActionOther $query) {
                $classTypeName = null;

                if (isset($query->classType)) {
                    $classTypeName = $query->classType->name;
                }

                return $classTypeName;
            })
            ->addColumn('action', function (ActionOther $query) {
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
            'name' => 'required',
            'class_type_id' => 'required',
            'hospital_service' => 'required|numeric',
            'service' => 'required|numeric',
            'fee' => 'required|numeric'
        ], [
            'name.required' => 'nama tindakan tidak boleh kosong',
            'class_type_id.required' => 'mohon memilih kelas',
            'hospital_service.required' => 'jrs tidak boleh kosong',
            'hospital_service.numeric' => 'jrs harus angka yang valid',
            'service.required' => 'jaspel tidak boleh kosong',
            'service.numeric' => 'jaspel harus angka yang valid',
            'fee.required' => 'tarif tidak boleh kosong',
            'fee.numeric' => 'tarif harus angka yang valid'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = ActionOther::create([
                    'class_type_id' => $request->class_type_id,
                    'name' => $request->name,
                    'consumables' => str_replace(',', '', $request->consumables),
                    'hospital_service' => str_replace(',', '', $request->hospital_service),
                    'service' => str_replace(',', '', $request->service),
                    'fee' => str_replace(',', '', $request->fee),
                    'description' => $request->description
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
        $data = ActionOther::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'class_type_id' => 'required',
            'hospital_service' => 'required|numeric',
            'service' => 'required|numeric',
            'fee' => 'required|numeric'
        ], [
            'name.required' => 'nama tindakan tidak boleh kosong',
            'class_type_id.required' => 'mohon memilih kelas',
            'hospital_service.required' => 'jrs tidak boleh kosong',
            'hospital_service.numeric' => 'jrs harus angka yang valid',
            'service.required' => 'jaspel tidak boleh kosong',
            'service.numeric' => 'jaspel harus angka yang valid',
            'fee.required' => 'tarif tidak boleh kosong',
            'fee.numeric' => 'tarif harus angka yang valid'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = ActionOther::findOrFail($id)->update([
                    'class_type_id' => $request->class_type_id,
                    'name' => $request->name,
                    'consumables' => str_replace(',', '', $request->consumables),
                    'hospital_service' => str_replace(',', '', $request->hospital_service),
                    'service' => str_replace(',', '', $request->service),
                    'fee' => str_replace(',', '', $request->fee),
                    'description' => $request->description
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
            ActionOther::destroy($id);

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
