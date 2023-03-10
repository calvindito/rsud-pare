<?php

namespace App\Http\Controllers\MasterData\Lab;

use App\Models\LabItem;
use Illuminate\Http\Request;
use App\Models\LabItemOption;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ItemOptionController extends Controller
{
    public function index()
    {
        $data = [
            'labItem' => LabItem::where('status', true)->get(),
            'content' => 'master-data.lab.item-option'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = LabItemOption::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('label', 'like', "%$search%")
                        ->orWhereHas('labItem', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }
            })
            ->addColumn('lab_item_name', function (LabItemOption $query) {
                $labItemName = $query->labItem->name ?? null;

                return $labItemName;
            })
            ->addColumn('action', function (LabItemOption $query) {
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
            'lab_item_id' => 'required',
            'score' => 'required',
            'label' => 'required'
        ], [
            'lab_item_id.required' => 'mohon memilih item',
            'score.required' => 'nilai tidak boleh kosong',
            'label.required' => 'label tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = LabItemOption::create([
                    'lab_item_id' => $request->lab_item_id,
                    'score' => $request->score,
                    'label' => $request->label
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
        $data = LabItemOption::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'lab_item_id' => 'required',
            'score' => 'required',
            'label' => 'required'
        ], [
            'lab_item_id.required' => 'mohon memilih item',
            'score.required' => 'nilai tidak boleh kosong',
            'label.required' => 'label tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = LabItemOption::findOrFail($id)->update([
                    'lab_item_id' => $request->lab_item_id,
                    'score' => $request->score,
                    'label' => $request->label
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
            LabItemOption::destroy($id);

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
