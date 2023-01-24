<?php

namespace App\Http\Controllers\MasterData\Lab;

use App\Models\LabItem;
use Illuminate\Http\Request;
use App\Models\LabItemParent;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ItemParentController extends Controller
{
    public function index()
    {
        $data = [
            'labItem' => LabItem::where('status', true)->get(),
            'content' => 'master-data.lab.item-parent'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = LabItemParent::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('method', 'like', "%$search%")
                        ->orWhere('unit', 'like', "%$search%")
                        ->orWhereHas('parent', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('labItem', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }
            })
            ->editColumn('status', function (LabItemParent $query) {
                return $query->status();
            })
            ->addColumn('parent_name', function (LabItemParent $query) {
                $parentName = null;

                if (isset($query->parent)) {
                    $parentName = $query->parent->name;
                }

                return $parentName;
            })
            ->addColumn('lab_item_name', function (LabItemParent $query) {
                $labItemName = null;

                if (isset($query->labItem)) {
                    $labItemName = $query->labItem->name;
                }

                return $labItemName;
            })
            ->addColumn('action', function (LabItemParent $query) {
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
            'parent_id' => 'required',
            'lab_item_id' => 'required',
            'level' => 'required'
        ], [
            'parent_id.required' => 'mohon memilih parent',
            'lab_item_id.required' => 'mohon memilih item',
            'level.required' => 'mohon memilih level'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = LabItemParent::create([
                    'parent_id' => $request->parent_id,
                    'lab_item_id' => $request->lab_item_id,
                    'level' => $request->level,
                    'limit_lower' => $request->limit_lower,
                    'limit_critical_lower' => $request->limit_critical_lower,
                    'limit_upper' => $request->limit_upper,
                    'limit_critical_upper' => $request->limit_critical_upper,
                    'limit_lower_patient' => $request->limit_lower_patient,
                    'limit_critical_lower_patient' => $request->limit_critical_lower_patient,
                    'limit_upper_patient' => $request->limit_upper_patient,
                    'limit_critical_upper_patient' => $request->limit_critical_upper_patient,
                    'dropdown' => $request->dropdown,
                    'method' => $request->method,
                    'unit' => $request->unit
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
        $data = LabItemParent::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'parent_id' => 'required',
            'lab_item_id' => 'required',
            'level' => 'required'
        ], [
            'parent_id.required' => 'mohon memilih parent',
            'lab_item_id.required' => 'mohon memilih item',
            'level.required' => 'mohon memilih level'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = LabItemParent::findOrFail($id)->update([
                    'parent_id' => $request->parent_id,
                    'lab_item_id' => $request->lab_item_id,
                    'level' => $request->level,
                    'limit_lower' => $request->limit_lower,
                    'limit_critical_lower' => $request->limit_critical_lower,
                    'limit_upper' => $request->limit_upper,
                    'limit_critical_upper' => $request->limit_critical_upper,
                    'limit_lower_patient' => $request->limit_lower_patient,
                    'limit_critical_lower_patient' => $request->limit_critical_lower_patient,
                    'limit_upper_patient' => $request->limit_upper_patient,
                    'limit_critical_upper_patient' => $request->limit_critical_upper_patient,
                    'dropdown' => $request->dropdown,
                    'method' => $request->method,
                    'unit' => $request->unit,
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
            LabItemParent::destroy($id);

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
