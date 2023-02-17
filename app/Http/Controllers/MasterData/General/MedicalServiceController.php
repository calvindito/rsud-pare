<?php

namespace App\Http\Controllers\MasterData\General;

use App\Models\ClassType;
use Illuminate\Http\Request;
use App\Models\MedicalService;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MedicalServiceController extends Controller
{
    public function index()
    {
        $data = [
            'classType' => ClassType::all(),
            'content' => 'master-data.general.medical-service'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = MedicalService::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "%$search%")
                        ->orWhereHas('classType', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }
            })
            ->editColumn('fee', '{{ Simrs::formatRupiah($fee) }}')
            ->editColumn('emergency_care', '{{ Simrs::formatRupiah($emergency_care) }}')
            ->editColumn('status', function (MedicalService $query) {
                return $query->status();
            })
            ->addColumn('class_type_name', function (MedicalService $query) {
                $classTypeName = null;

                if (isset($query->classType)) {
                    $classTypeName = $query->classType->name;
                }

                return $classTypeName;
            })
            ->addColumn('action', function (MedicalService $query) {
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
            'class_type_id' => 'required',
            'code' => 'required',
            'name' => 'required',
            'fee' => 'required|numeric',
            'emergency_care' => 'required|numeric'
        ], [
            'class_type_id.required' => 'mohon memilih kelas',
            'code.required' => 'kode tidak boleh kosong',
            'name.required' => 'nama tidak boleh kosong',
            'fee.required' => 'biaya tidak boleh kosong',
            'fee.numeric' => 'biaya harus angka yang valid',
            'emergency_care.required' => 'ird tidak boleh kosong',
            'emergency_care.numeric' => 'ird harus angka yang valid'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = MedicalService::create([
                    'class_type_id' => $request->class_type_id,
                    'code' => $request->code,
                    'name' => $request->name,
                    'fee' => $request->fee,
                    'emergency_care' => $request->emergency_care
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
        $data = MedicalService::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'class_type_id' => 'required',
            'code' => 'required',
            'name' => 'required',
            'fee' => 'required|numeric',
            'emergency_care' => 'required|numeric'
        ], [
            'class_type_id.required' => 'mohon memilih kelas',
            'code.required' => 'kode tidak boleh kosong',
            'name.required' => 'nama tidak boleh kosong',
            'fee.required' => 'biaya tidak boleh kosong',
            'fee.numeric' => 'biaya harus angka yang valid',
            'emergency_care.required' => 'ird tidak boleh kosong',
            'emergency_care.numeric' => 'ird harus angka yang valid'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = MedicalService::findOrFail($id)->update([
                    'class_type_id' => $request->class_type_id,
                    'code' => $request->code,
                    'name' => $request->name,
                    'fee' => $request->fee,
                    'emergency_care' => $request->emergency_care,
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
            MedicalService::destroy($id);

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
