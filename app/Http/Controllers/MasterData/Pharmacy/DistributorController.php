<?php

namespace App\Http\Controllers\MasterData\Pharmacy;

use App\Models\Factory;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DistributorController extends Controller
{
    public function index()
    {
        $data = [
            'factory' => Factory::all(),
            'content' => 'master-data.pharmacy.distributor'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Distributor::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "%$search%")
                        ->whereHas('factoryDistributor', function ($query) use ($search) {
                            $query->whereHas('distributor', function ($query) use ($search) {
                                $query->where('name', 'like', "%$search%");
                            });
                        });
                }
            })
            ->editColumn('factory_name', function (Distributor $query) {
                $factoryName = '';

                if ($query->distributorFactory->count() > 0) {
                    foreach ($query->distributorFactory as $df) {
                        $factoryName .= '<div><small>- ' . $df->factory->name . '</small></div>';
                    }
                }

                if ($factoryName) {
                    $implodeName = $factoryName;
                } else {
                    $implodeName = 'Tidak ada data';
                }

                return '
                    <button type="button" class="btn btn-light btn-sm" onclick="onPopover(this, ' . "'$implodeName'" . ')">Klik Disini</button>
                ';
            })
            ->addColumn('action', function (Distributor $query) {
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
            ->rawColumns(['action', 'factory_name'])
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
                    $createData = Distributor::create([
                        'name' => $request->name
                    ]);

                    if ($request->has('distributor_factory_factory_id')) {
                        foreach ($request->distributor_factory_factory_id as $dffi) {
                            $createData->distributorFactory()->create([
                                'factory_id' => $dffi
                            ]);
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
        $data = Distributor::with('factoryDistributor')->findOrFail($id);

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
                    $updateData = Factory::findOrFail($id);

                    $updateData->update([
                        'name' => $request->name
                    ]);

                    $updateData->distributorFactory()->delete();

                    if ($request->has('distributor_factory_factory_id')) {
                        foreach ($request->distributor_factory_factory_id as $dffi) {
                            $updateData->distributorFactory()->create([
                                'factory_id' => $dffi
                            ]);
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
            Distributor::destroy($id);

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
