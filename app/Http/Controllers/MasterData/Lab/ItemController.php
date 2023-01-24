<?php

namespace App\Http\Controllers\MasterData\Lab;

use App\Models\LabItem;
use App\Models\LabCategory;
use App\Models\LabItemGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function index()
    {
        $data = [
            'labCategory' => LabCategory::all(),
            'labItemGroup' => LabItemGroup::all(),
            'content' => 'master-data.lab.item'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = LabItem::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "%$search%")
                        ->orWhereHas('labCategory', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('labItemGroup', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }
            })
            ->editColumn('status', function (LabItem $query) {
                return $query->status();
            })
            ->addColumn('lab_category_name', function (LabItem $query) {
                $labCategoryName = null;

                if (isset($query->labCategory)) {
                    $labCategoryName = $query->labCategory->name;
                }

                return $labCategoryName;
            })
            ->addColumn('lab_item_group_name', function (LabItem $query) {
                $labItemGroupName = null;

                if (isset($query->labItemGroup)) {
                    $labItemGroupName = $query->labItemGroup->name;
                }

                return $labItemGroupName;
            })
            ->addColumn('action', function (LabItem $query) {
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
            'name' => 'required'
        ], [
            'name.required' => 'nama tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = LabItem::create([
                    'lab_category_id' => $request->lab_category_id,
                    'lab_item_group_id' => $request->lab_item_group_id,
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
        $data = LabItem::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'name' => 'required'
        ], [
            'name.required' => 'nama tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = LabItem::findOrFail($id)->update([
                    'lab_category_id' => $request->lab_category_id,
                    'lab_item_group_id' => $request->lab_item_group_id,
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
            LabItem::destroy($id);

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
