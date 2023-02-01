<?php

namespace App\Http\Controllers\MasterData\Pharmacy;

use App\Models\Factory;
use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class MedicineController extends Controller
{
    public function index()
    {
        $data = [
            'factory' => Factory::all(),
            'content' => 'master-data.pharmacy.medicine'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Medicine::query();

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
            ->editColumn('price_purchase', '{{ Simrs::formatRupiah($price_purchase) }}')
            ->editColumn('price', '{{ Simrs::formatRupiah($price) }}')
            ->addColumn('factory_name', function (Medicine $query) {
                $factoryName = null;

                if (isset($query->factory)) {
                    $factoryName = $query->factory->name;
                }

                return $factoryName;
            })
            ->editColumn('distributor_name', function (Medicine $query) {
                $distributorName = '';

                if ($query->factory) {
                    if ($query->factory->factoryDistributor->count() > 0) {
                        foreach ($query->factory->factoryDistributor as $fd) {
                            $distributorName .= '<div><small>- ' . $fd->distributor->name . '</small></div>';
                        }
                    }
                }

                if ($distributorName) {
                    $implodeName = $distributorName;
                } else {
                    $implodeName = 'Tidak ada data';
                }

                return '
                    <button type="button" class="btn btn-light btn-sm" onclick="onPopover(this, ' . "'$implodeName'" . ')">Klik Disini</button>
                ';
            })
            ->addColumn('action', function (Medicine $query) {
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
            ->rawColumns(['action', 'distributor_name'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function createData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'factory_id' => 'required',
            'code' => 'required|unique:medicines,code',
            'code_type' => 'required|unique:medicines,code_type',
            'name' => 'required',
            'name_generic' => 'required',
            'price' => 'required'
        ], [
            'factory_id.required' => 'mohon memilih pabrik',
            'code.required' => 'kode t tidak boleh kosong',
            'code.unique' => 'kode t telah digunakan',
            'code_type.required' => 'kode jenis tidak boleh kosong',
            'code_type.unique' => 'kode jenis telah digunakan',
            'name.required' => 'nama tidak boleh kosong',
            'name_generic.required' => 'nama generik tidak boleh kosong',
            'price.required' => 'harga jual tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = Medicine::create([
                    'factory_id' => $request->factory_id,
                    'code' => $request->code,
                    'code_item' => $request->code_item,
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
                    'stock' => $request->stock,
                    'stock_min' => $request->stock_min,
                    'price' => $request->price,
                    'price_purchase' => $request->price_purchase,
                    'price_netto' => $request->price_netto,
                    'discount' => $request->discount
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
        $data = Medicine::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'factory_id' => 'required',
            'code' => 'required|unique:medicines,code,' . $id,
            'code_type' => 'required|unique:medicines,code_type,' . $id,
            'name' => 'required',
            'name_generic' => 'required',
            'price' => 'required'
        ], [
            'factory_id.required' => 'mohon memilih pabrik',
            'code.required' => 'kode t tidak boleh kosong',
            'code.unique' => 'kode t telah digunakan',
            'code_type.required' => 'kode jenis tidak boleh kosong',
            'code_type.unique' => 'kode jenis telah digunakan',
            'name.required' => 'nama tidak boleh kosong',
            'name_generic.required' => 'nama generik tidak boleh kosong',
            'price.required' => 'harga jual tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = Medicine::findOrFail($id)->update([
                    'factory_id' => $request->factory_id,
                    'code' => $request->code,
                    'code_item' => $request->code_item,
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
                    'stock' => $request->stock,
                    'stock_min' => $request->stock_min,
                    'price' => $request->price,
                    'price_purchase' => $request->price_purchase,
                    'price_netto' => $request->price_netto,
                    'discount' => $request->discount
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
            Medicine::destroy($id);

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
