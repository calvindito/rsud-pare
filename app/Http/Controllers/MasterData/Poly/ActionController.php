<?php

namespace App\Http\Controllers\MasterData\Poly;

use App\Models\Unit;
use App\Helpers\Simrs;
use App\Models\Action;
use App\Models\UnitAction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ActionController extends Controller
{
    public function index()
    {
        $data = [
            'unit' => Unit::where('type', 2)->get(),
            'action' => Action::all(),
            'content' => 'master-data.poly.action'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = UnitAction::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->whereHas('unit', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });

                    $query->orWhereHas('action', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });
                }
            })
            ->editColumn('consumables', '{{ Simrs::formatRupiah($consumables) }}')
            ->editColumn('hospital_service', '{{ Simrs::formatRupiah($hospital_service) }}')
            ->editColumn('service', '{{ Simrs::formatRupiah($service) }}')
            ->editColumn('created_at', '{{ date("Y-m-d H:i:s", strtotime($created_at)) }}')
            ->editColumn('updated_at', '{{ date("Y-m-d H:i:s", strtotime($updated_at)) }}')
            ->addColumn('unit_name', function (UnitAction $query) {
                $unitName = $query->unit->name ?? null;

                return $unitName;
            })
            ->addColumn('action_name', function (UnitAction $query) {
                $actionName = $query->action->name ?? null;

                return $actionName;
            })
            ->addColumn('action_fee', function (UnitAction $query) {
                $actionFee = $query->action->fee ?? 0;

                return Simrs::formatRupiah($actionFee);
            })
            ->addColumn('action', function (UnitAction $query) {
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
            'unit_id' => 'required',
            'action_id' => 'required'
        ], [
            'name.required' => 'mohon memilih poli',
            'action_id.required' => 'mohon memilih tindakan'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = UnitAction::create([
                    'unit_id' => $request->unit_id,
                    'action_id' => $request->action_id,
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
        $data = UnitAction::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'unit_id' => 'required',
            'action_id' => 'required'
        ], [
            'name.required' => 'mohon memilih poli',
            'action_id.required' => 'mohon memilih tindakan'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = UnitAction::findOrFail($id)->update([
                    'unit_id' => $request->unit_id,
                    'action_id' => $request->action_id,
                    'consumables' => $request->consumables,
                    'hospital_service' => $request->hospital_service,
                    'service' => $request->service
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
            UnitAction::destroy($id);

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
