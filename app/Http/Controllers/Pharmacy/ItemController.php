<?php

namespace App\Http\Controllers\Pharmacy;

use App\Models\Item;
use App\Models\ItemUnit;
use App\Models\Distributor;
use App\Models\Installation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function index()
    {
        $data = [
            'distributor' => Distributor::all(),
            'itemUnit' => ItemUnit::all(),
            'installation' => Installation::all(),
            'content' => 'pharmacy.item'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Item::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('code', 'like', "%$search%")
                        ->orWhere('code_t', 'like', "%$search%")
                        ->orWhere('code_type', 'like', "%$search%")
                        ->orWhere('name', 'like', "%$search%")
                        ->orWhere('name_generic', 'like', "%$search%");
                }
            })
            ->addColumn('stock', function (Item $query) {
                $html = '<div><small><b>Total : </b>' . $query->stock() . '</small></div>';
                $html .= '<div><small><b>Terpotong : </b>' . $query->stock('cut') . '</small></div>';
                $html .= '<div><small><b>Tersedia : </b>' . $query->stock('available') . '</small></div>';

                return '<button type="button" class="btn btn-light btn-sm" onclick="onPopover(this, ' . "'$html'" . ')">Klik Disini</button>';
            })
            ->addColumn('installation_name', function (Item $query) {
                $installationName = null;

                if (isset($query->installation)) {
                    $installationName = $query->installation->name;
                }

                return $installationName;
            })
            ->addColumn('item_unit_name', function (Item $query) {
                $itemUnitName = null;

                if (isset($query->itemUnit)) {
                    $itemUnitName = $query->itemUnit->name;
                }

                return $itemUnitName;
            })
            ->addColumn('distributor_name', function (Item $query) {
                $distributorName = null;

                if (isset($query->distributor)) {
                    $distributorName = $query->distributor->name;
                }

                return $distributorName;
            })
            ->editColumn('factory_name', function (Item $query) {
                $factoryName = '';

                if ($query->distributor) {
                    if ($query->distributor->distributorFactory->count() > 0) {
                        foreach ($query->distributor->distributorFactory as $df) {
                            $factoryName .= '<div><small>- ' . $df->factory->name . '</small></div>';
                        }
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
            ->addColumn('action', function (Item $query) {
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
            ->rawColumns(['action', 'factory_name', 'stock'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function createData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'installation_id' => 'required',
            'distributor_id' => 'required',
            'item_unit_id' => 'required',
            'type' => 'required',
            'code' => 'required|unique:items,code',
            'code_type' => 'required|unique:items,code_type',
            'name' => 'required',
            'name_generic' => 'required'
        ], [
            'installation_id.required' => 'mohon memilih instalasi',
            'distributor_id.required' => 'mohon memilih distributor',
            'item_unit_id.required' => 'mohon memilih satuan',
            'type.required' => 'mohon memilih jenis',
            'code.required' => 'kode t tidak boleh kosong',
            'code.unique' => 'kode t telah digunakan',
            'code_type.required' => 'kode jenis tidak boleh kosong',
            'code_type.unique' => 'kode jenis telah digunakan',
            'name.required' => 'nama tidak boleh kosong',
            'name_generic.required' => 'nama generik tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = Item::create([
                    'installation_id' => $request->installation_id,
                    'distributor_id' => $request->distributor_id,
                    'item_unit_id' => $request->item_unit_id,
                    'code' => $request->code,
                    'code_t' => $request->code_t,
                    'code_type' => $request->code_type,
                    'name' => $request->name,
                    'name_generic' => $request->name_generic,
                    'power' => $request->power,
                    'power_unit' => $request->power_unit,
                    'unit' => $request->unit,
                    'inventory' => $request->inventory,
                    'bir' => $request->bir,
                    'non_generic' => $request->non_generic,
                    'nar' => $request->nar,
                    'oakrl' => $request->oakrl,
                    'chronic' => $request->chronic,
                    'type' => $request->type
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
        $data = Item::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'installation_id' => 'required',
            'distributor_id' => 'required',
            'item_unit_id' => 'required',
            'type' => 'required',
            'code' => 'required|unique:items,code,' . $id,
            'code_type' => 'required|unique:items,code_type,' . $id,
            'name' => 'required',
            'name_generic' => 'required'
        ], [
            'installation_id.required' => 'mohon memilih instalasi',
            'distributor_id.required' => 'mohon memilih distributor',
            'item_unit_id.required' => 'mohon memilih satuan',
            'type.required' => 'mohon memilih jenis',
            'code.required' => 'kode t tidak boleh kosong',
            'code.unique' => 'kode t telah digunakan',
            'code_type.required' => 'kode jenis tidak boleh kosong',
            'code_type.unique' => 'kode jenis telah digunakan',
            'name.required' => 'nama tidak boleh kosong',
            'name_generic.required' => 'nama generik tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = Item::findOrFail($id)->update([
                    'installation_id' => $request->installation_id,
                    'distributor_id' => $request->distributor_id,
                    'item_unit_id' => $request->item_unit_id,
                    'code' => $request->code,
                    'code_t' => $request->code_t,
                    'code_type' => $request->code_type,
                    'name' => $request->name,
                    'name_generic' => $request->name_generic,
                    'power' => $request->power,
                    'power_unit' => $request->power_unit,
                    'unit' => $request->unit,
                    'inventory' => $request->inventory,
                    'bir' => $request->bir,
                    'non_generic' => $request->non_generic,
                    'nar' => $request->nar,
                    'oakrl' => $request->oakrl,
                    'chronic' => $request->chronic,
                    'type' => $request->type
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
            Item::destroy($id);

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
