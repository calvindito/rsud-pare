<?php

namespace App\Http\Controllers\Pharmacy;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Models\MedicineStock;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    public function index()
    {
        $data = [
            'medicine' => Medicine::all(),
            'content' => 'pharmacy.stock'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = MedicineStock::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->whereHas('medicine', function ($query) use ($search) {
                        $query->orWhere('name', 'like', "%$search%");
                    });
                }
            })
            ->editColumn('price_purchase', '{{ Simrs::formatRupiah($price_purchase) }}')
            ->editColumn('price_sell', '{{ Simrs::formatRupiah($price_sell) }}')
            ->editColumn('discount', '{{ $discount }} %')
            ->addColumn('total', function (MedicineStock $query) {
                return $query->stock + $query->sold;
            })
            ->addColumn('medicine_name', function (MedicineStock $query) {
                $medicineName = null;

                if (isset($query->medicine)) {
                    $medicineName = $query->medicine->name;
                }

                return $medicineName;
            })
            ->addColumn('action', function (MedicineStock $query) {
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
            'medicine_id' => 'required',
            'expired_date' => 'required',
            'stock' => 'required',
            'price_purchase' => 'required',
            'price_sell' => 'required',
            'discount' => 'required|numeric|max:100'
        ], [
            'medicine_id.required' => 'mohon memilih obat',
            'expired_date.required' => 'tanggal kadaluwarsa tidak boleh kosong',
            'stock.required' => 'stok tidak boleh kosong',
            'price_purchase.required' => 'harga beli tidak boleh kosong',
            'price_sell.required' => 'harga jual tidak boleh kosong',
            'discount.required' => 'diskon tidak boleh kosong',
            'discount.numeric' => 'diskon harus angka',
            'discount.max' => 'diskon maksimal 100%'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = MedicineStock::create([
                    'medicine_id' => $request->medicine_id,
                    'expired_date' => $request->expired_date,
                    'stock' => $request->stock,
                    'price_purchase' => $request->price_purchase,
                    'price_sell' => $request->price_sell,
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
        $data = MedicineStock::with('medicine')->findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'medicine_id' => 'required',
            'expired_date' => 'required',
            'stock' => 'required',
            'price_purchase' => 'required',
            'price_sell' => 'required',
            'discount' => 'required|numeric|max:100'
        ], [
            'medicine_id.required' => 'mohon memilih obat',
            'expired_date.required' => 'tanggal kadaluwarsa tidak boleh kosong',
            'stock.required' => 'stok tidak boleh kosong',
            'price_purchase.required' => 'harga beli tidak boleh kosong',
            'price_sell.required' => 'harga jual tidak boleh kosong',
            'discount.required' => 'diskon tidak boleh kosong',
            'discount.numeric' => 'diskon harus angka',
            'discount.max' => 'diskon maksimal 100%'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = MedicineStock::findOrFail($id)->update([
                    'medicine_id' => $request->medicine_id,
                    'expired_date' => $request->expired_date,
                    'stock' => $request->stock,
                    'price_purchase' => $request->price_purchase,
                    'price_sell' => $request->price_sell,
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
            MedicineStock::destroy($id);

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
