<?php

namespace App\Http\Controllers\MasterData\Lab;

use App\Models\LabFee;
use App\Models\LabItem;
use App\Models\ClassType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class FeeController extends Controller
{
    public function index()
    {
        $data = [
            'labItem' => LabItem::where('status', true)->get(),
            'classType' => ClassType::all(),
            'content' => 'master-data.lab.fee'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = LabFee::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->whereHas('labItem', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });

                    $query->orWhereHas('classType', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });
                }
            })
            ->editColumn('consumables', '{{ Simrs::formatRupiah($consumables) }}')
            ->editColumn('hospital_service', '{{ Simrs::formatRupiah($hospital_service) }}')
            ->editColumn('service', '{{ Simrs::formatRupiah($service) }}')
            ->editColumn('status', function (LabFee $query) {
                return $query->status();
            })
            ->addColumn('lab_item_name', function (LabFee $query) {
                $labItemName = $query->labItem->name ?? null;

                return $labItemName;
            })
            ->addColumn('class_type_name', function (LabFee $query) {
                $classTypeName = $query->classType->name ?? null;

                return $classTypeName;
            })
            ->addColumn('action', function (LabFee $query) {
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
            'lab_item_id' => 'required',
            'class_type_id' => 'required',
            'consumables' => 'required',
            'service' => 'required'
        ], [
            'lab_item_id.required' => 'mohon memilih item',
            'class_type_id.required' => 'mohon memilih kelas',
            'consumables.required' => 'bhp tidak boleh kosong',
            'service.required' => 'jaspel tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = LabFee::create([
                    'lab_item_id' => $request->lab_item_id,
                    'class_type_id' => $request->class_type_id,
                    'consumables' => $request->consumables,
                    'hospital_service' => $request->hospital_service,
                    'service' => $request->service
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
        $data = LabFee::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'lab_item_id' => 'required',
            'class_type_id' => 'required',
            'consumables' => 'required',
            'service' => 'required'
        ], [
            'lab_item_id.required' => 'mohon memilih item',
            'class_type_id.required' => 'mohon memilih kelas',
            'consumables.required' => 'bhp tidak boleh kosong',
            'service.required' => 'jaspel tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = LabFee::findOrFail($id)->update([
                    'lab_item_id' => $request->lab_item_id,
                    'class_type_id' => $request->class_type_id,
                    'consumables' => $request->consumables,
                    'hospital_service' => $request->hospital_service,
                    'service' => $request->service,
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
            LabFee::destroy($id);

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
