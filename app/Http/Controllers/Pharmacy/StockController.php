<?php

namespace App\Http\Controllers\Pharmacy;

use App\Models\Item;
use App\Models\ItemStock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    public function index()
    {
        $data = [
            'item' => Item::all(),
            'content' => 'pharmacy.stock'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = ItemStock::where('type', 1);

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->whereHas('item', function ($query) use ($search) {
                        $query->orWhere('name', 'like', "%$search%");
                    });
                }
            })
            ->editColumn('price_purchase', '{{ Simrs::formatRupiah($price_purchase) }}')
            ->editColumn('price_sell', '{{ Simrs::formatRupiah($price_sell) }}')
            ->editColumn('discount', '{{ $discount }} %')
            ->addColumn('available', function (ItemStock $query) {
                return $query->available();
            })
            ->addColumn('cut', function (ItemStock $query) {
                return $query->cut();
            })
            ->addColumn('item_name', function (ItemStock $query) {
                $itemName = $query->item->name ?? null;

                return $itemName;
            })
            ->addColumn('item_type_format_result', function (ItemStock $query) {
                $itemTypeFormatResultName = $query->item->type_format_result ?? null;

                return $itemTypeFormatResultName;
            })
            ->addColumn('action', function (ItemStock $query) {
                if ($query->qty == $query->cut()) {
                    $btnAction = '
                        <button type="button" class="btn btn-light text-danger btn-sm fw-semibold no-click">Habis</button>
                    ';
                } else if ($query->qty > 0 && $query->cut() == 0) {
                    $btnAction = '
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
                } else {
                    $btnAction = '
                        <button type="button" class="btn btn-light text-info btn-sm fw-semibold no-click">Sedang Berjalan</button>
                    ';
                }

                return $btnAction;
            })
            ->rawColumns(['action', 'stock'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function createData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'item_id' => 'required',
            'expired_date' => 'required',
            'qty' => 'required',
            'price_purchase' => 'required',
            'price_sell' => 'required',
            'discount' => 'required|numeric|max:100'
        ], [
            'item_id.required' => 'mohon memilih item',
            'expired_date.required' => 'tanggal kadaluwarsa tidak boleh kosong',
            'qty.required' => 'kuantitas tidak boleh kosong',
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
                $createData = ItemStock::create([
                    'item_id' => $request->item_id,
                    'expired_date' => $request->expired_date,
                    'qty' => $request->qty,
                    'price_purchase' => $request->price_purchase,
                    'price_sell' => $request->price_sell,
                    'discount' => $request->discount,
                    'type' => 1
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
        $data = ItemStock::with('item')->findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'item_id' => 'required',
            'expired_date' => 'required',
            'qty' => 'required',
            'price_purchase' => 'required',
            'price_sell' => 'required',
            'discount' => 'required|numeric|max:100'
        ], [
            'item_id.required' => 'mohon memilih item',
            'expired_date.required' => 'tanggal kadaluwarsa tidak boleh kosong',
            'qty.required' => 'kuantitas tidak boleh kosong',
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
                $updateData = ItemStock::findOrFail($id)->update([
                    'item_id' => $request->item_id,
                    'expired_date' => $request->expired_date,
                    'qty' => $request->qty,
                    'price_purchase' => $request->price_purchase,
                    'price_sell' => $request->price_sell,
                    'discount' => $request->discount,
                    'type' => 1
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
            ItemStock::destroy($id);

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
