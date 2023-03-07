<?php

namespace App\Http\Controllers\MasterData\Radiology;

use App\Models\ClassType;
use App\Models\Radiology;
use Illuminate\Http\Request;
use App\Models\RadiologyAction;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ActionController extends Controller
{
    public function index()
    {
        $data = [
            'radiology' => Radiology::orderBy('type')->get(),
            'classType' => ClassType::all(),
            'content' => 'master-data.radiology.action'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = RadiologyAction::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->whereHas('radiology', function ($query) use ($search) {
                        $query->where('code', 'like', "%$search%")
                            ->orWhere('object', 'like', "%$search%")
                            ->orWhere('projection', 'like', "%$search%");
                    });

                    $query->orWhereHas('classType', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });
                }
            })
            ->editColumn('consumables', '{{ Simrs::formatRupiah($consumables) }}')
            ->editColumn('hospital_service', '{{ Simrs::formatRupiah($hospital_service) }}')
            ->editColumn('service', '{{ Simrs::formatRupiah($service) }}')
            ->editColumn('fee', '{{ Simrs::formatRupiah($fee) }}')
            ->addColumn('radiology_type', function (RadiologyAction $query) {
                $radiologyType = $query->radiology->type ?? null;

                return $radiologyType;
            })
            ->addColumn('radiology_object', function (RadiologyAction $query) {
                $radiologyObject = $query->radiology->object ?? null;

                return $radiologyObject;
            })
            ->addColumn('radiology_projection', function (RadiologyAction $query) {
                $radiologyProjection = $query->radiology->projection ?? null;

                return $radiologyProjection;
            })
            ->addColumn('class_type_name', function (RadiologyAction $query) {
                $classTypeName = $query->classType->name ?? null;

                return $classTypeName;
            })
            ->addColumn('action', function (RadiologyAction $query) {
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
            'radiology_id' => 'required',
            'class_type_id' => 'required',
            'consumables' => 'required',
            'hospital_service' => 'required',
            'service' => 'required',
            'fee' => 'required'
        ], [
            'radiology_id.required' => 'mohon memilih radiologi',
            'class_type_id.required' => 'mohon memilih kelas',
            'consumables.required' => 'bhp tidak boleh kosong',
            'hospital_service.required' => 'jrs tidak boleh kosong',
            'service.required' => 'jaspel tidak boleh kosong',
            'fee.required' => 'tarif tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = RadiologyAction::create([
                    'radiology_id' => $request->radiology_id,
                    'class_type_id' => $request->class_type_id,
                    'consumables' => $request->consumables,
                    'hospital_service' => $request->hospital_service,
                    'service' => $request->service,
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
        $data = RadiologyAction::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'radiology_id' => 'required',
            'class_type_id' => 'required',
            'consumables' => 'required',
            'hospital_service' => 'required',
            'service' => 'required',
            'fee' => 'required'
        ], [
            'radiology_id.required' => 'mohon memilih radiologi',
            'class_type_id.required' => 'mohon memilih kelas',
            'consumables.required' => 'bhp tidak boleh kosong',
            'hospital_service.required' => 'jrs tidak boleh kosong',
            'service.required' => 'jaspel tidak boleh kosong',
            'fee.required' => 'tarif tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = RadiologyAction::findOrFail($id)->update([
                    'radiology_id' => $request->radiology_id,
                    'class_type_id' => $request->class_type_id,
                    'consumables' => $request->consumables,
                    'hospital_service' => $request->hospital_service,
                    'service' => $request->service,
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
            RadiologyAction::destroy($id);

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
