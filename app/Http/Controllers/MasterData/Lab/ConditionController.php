<?php

namespace App\Http\Controllers\MasterData\Lab;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\LabItemCondition;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\LabItemConditionDetail;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ConditionController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'master-data.lab.condition'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = LabItemCondition::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "%$search%");
                }
            })
            ->editColumn('created_at', '{{ date("Y-m-d H:i:s", strtotime($created_at)) }}')
            ->editColumn('updated_at', '{{ date("Y-m-d H:i:s", strtotime($updated_at)) }}')
            ->addColumn('action', function (LabItemCondition $query) {
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
                DB::transaction(function () use ($request) {
                    $createData = LabItemCondition::create([
                        'name' => $request->name
                    ]);

                    if ($request->has('item')) {
                        if (count($request->item) > 0) {
                            foreach ($request->item as $key => $i) {
                                $name = $request->lab_item_conditional_detail_name[$key];

                                LabItemConditionDetail::updateOrCreate([
                                    'lab_item_condition_id' => $createData->id,
                                    'slug' => Str::slug($name, '-')
                                ], [
                                    'name' => $name,
                                    'status' => true
                                ]);
                            }
                        }
                    }
                });

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
        $data = LabItemCondition::with([
            'labItemConditionDetail' => function ($query) {
                $query->where('status', true);
            }
        ])->findOrFail($id);

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
                DB::transaction(function () use ($request, $id) {
                    $updateData = LabItemCondition::findOrFail($id)->update([
                        'name' => $request->name
                    ]);

                    LabItemConditionDetail::where('lab_item_condition_id', $id)->update(['status' => false]);

                    if ($request->has('item')) {
                        if (count($request->item) > 0) {
                            foreach ($request->item as $key => $i) {
                                $name = $request->lab_item_conditional_detail_name[$key];

                                LabItemConditionDetail::updateOrCreate([
                                    'lab_item_condition_id' => $id,
                                    'slug' => Str::slug($name, '-')
                                ], [
                                    'name' => $name,
                                    'status' => true
                                ]);
                            }
                        }
                    }
                });

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
            LabItemCondition::destroy($id);

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
