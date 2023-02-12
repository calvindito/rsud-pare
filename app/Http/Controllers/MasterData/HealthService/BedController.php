<?php

namespace App\Http\Controllers\MasterData\HealthService;

use App\Models\ClassType;
use Illuminate\Http\Request;
use App\Models\HealthServiceBed;
use App\Models\FunctionalService;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class BedController extends Controller
{
    public function index()
    {
        $data = [
            'classType' => ClassType::all(),
            'functionalService' => FunctionalService::where('status', true)->get(),
            'content' => 'master-data.health-service.bed'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = HealthServiceBed::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->whereHas('classType', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });

                    $query->orWhereHas('functionalService', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });
                }
            })
            ->addColumn('class_type_name', function (HealthServiceBed $query) {
                $classTypeName = null;

                if (isset($query->classType)) {
                    $classTypeName = $query->classType->name;
                }

                return $classTypeName;
            })
            ->addColumn('functional_service_name', function (HealthServiceBed $query) {
                $functionalServiceName = null;

                if (isset($query->functionalService)) {
                    $functionalServiceName = $query->functionalService->name;
                }

                return $functionalServiceName;
            })
            ->addColumn('total', function (HealthServiceBed $query) {
                $total = $query->qty_man + $query->qty_woman;

                return $total;
            })
            ->addColumn('action', function (HealthServiceBed $query) {
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
            'functional_service_id' => 'required'
        ], [
            'class_type_id.required' => 'mohon memilih kelas',
            'functional_service_id.required' => 'mohon memilih upf'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = HealthServiceBed::create([
                    'class_type_id' => $request->class_type_id,
                    'functional_service_id' => $request->functional_service_id,
                    'qty_man' => $request->qty_man,
                    'qty_woman' => $request->qty_woman
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
        $data = HealthServiceBed::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'class_type_id' => 'required',
            'functional_service_id' => 'required'
        ], [
            'class_type_id.required' => 'mohon memilih kelas',
            'functional_service_id.required' => 'mohon memilih upf'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = HealthServiceBed::findOrFail($id)->update([
                    'class_type_id' => $request->class_type_id,
                    'functional_service_id' => $request->functional_service_id,
                    'qty_man' => $request->qty_man,
                    'qty_woman' => $request->qty_woman
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
            HealthServiceBed::destroy($id);

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
