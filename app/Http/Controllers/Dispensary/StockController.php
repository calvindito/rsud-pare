<?php

namespace App\Http\Controllers\Dispensary;

use App\Models\ItemStock;
use App\Models\Dispensary;
use Illuminate\Http\Request;
use App\Models\DispensaryItem;
use App\Models\DispensaryItemStock;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    public function index()
    {
        $data = [
            'dispensary' => Dispensary::all(),
            'content' => 'dispensary.stock'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = DispensaryItemStock::where('type', 1);

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->whereHas('dispensaryItem', function ($query) use ($search) {
                        $query->whereHas('item', function ($query) use ($search) {
                            $query->orWhere('name', 'like', "%$search%");
                        });
                    });
                }
            })
            ->editColumn('price_purchase', '{{ Simrs::formatRupiah($price_purchase) }}')
            ->editColumn('price_sell', '{{ Simrs::formatRupiah($price_sell) }}')
            ->editColumn('discount', '{{ $discount }} %')
            ->addColumn('status', function (DispensaryItemStock $query) {
                return $query->status();
            })
            ->addColumn('qty', function (DispensaryItemStock $query) {
                return $query->status == 2 ? $query->qty : '-';
            })
            ->addColumn('available', function (DispensaryItemStock $query) {
                return $query->status == 2 ? $query->available() : '-';
            })
            ->addColumn('sold', function (DispensaryItemStock $query) {
                return $query->status == 2 ? $query->sold() : '-';
            })
            ->addColumn('dispensary_name', function (DispensaryItemStock $query) {
                $dispensaryName = null;

                if (isset($query->dispensaryItem)) {
                    if (isset($query->dispensaryItem->dispensary)) {
                        $dispensaryName = $query->dispensaryItem->dispensary->name;
                    }
                }

                return $dispensaryName;
            })
            ->addColumn('item_name', function (DispensaryItemStock $query) {
                $itemName = null;

                if (isset($query->dispensaryItem)) {
                    if (isset($query->dispensaryItem->item)) {
                        $itemName = $query->dispensaryItem->item->name;
                    }
                }

                return $itemName;
            })
            ->addColumn('item_type', function (DispensaryItemStock $query) {
                $itemType = null;

                if (isset($query->dispensaryItem)) {
                    if (isset($query->dispensaryItem->item)) {
                        $itemType = $query->dispensaryItem->item->type_format_result;
                    }
                }

                return $itemType;
            })
            ->addColumn('action', function (DispensaryItemStock $query) {
                if ($query->status == 2) {
                    if ($query->qty == $query->sold()) {
                        $btnAction = '
                            <button type="button" class="btn btn-light text-danger btn-sm fw-semibold no-click">Habis</button>
                        ';
                    } else if ($query->qty > 0 && $query->sold() == 0) {
                        $btnAction = '
                            <button type="button" class="btn btn-light text-primary btn-sm fw-semibold no-click">Belum Digunakan</button>
                        ';
                    } else {
                        $btnAction = '
                            <button type="button" class="btn btn-light text-info btn-sm fw-semibold no-click">Sedang Berjalan</button>
                        ';
                    }
                } else {
                    if ($query->status == 1) {
                        $btnAction = '
                            <button type="button" class="btn btn-danger btn-sm fw-semibold fs-13" onclick="destroyData(' . $query->id . ')">
                                <i class="ph-trash-simple me-2"></i>
                                Hapus Data
                            </button>
                        ';
                    } else {
                        $btnAction = '
                            <button type="button" class="btn btn-light text-dark btn-sm fw-semibold no-click">Tidak Bisa Digunakan</button>
                        ';
                    }
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
            'dispensary_id' => 'required',
            'qty' => 'required',
            'item_id' => 'required'
        ], [
            'dispensary_id.required' => 'mohon memilih apotek',
            'item_id.required' => 'mohon memilih item',
            'expired_date.required' => 'tanggal kadaluwarsa tidak boleh kosong',
            'qty.required' => 'jumlah tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $itemStock = ItemStock::selectRaw("*, SUM(CASE WHEN type = '1' THEN qty END) as stock, SUM(CASE WHEN type = '2' THEN qty END) as sold")
                    ->where('item_id', $request->item_id)
                    ->groupBy('item_id')
                    ->havingRaw('stock > IF(sold > 0, sold, 0)')
                    ->oldest('expired_date')
                    ->first();

                $dispensaryItem = DispensaryItem::where('item_id', $request->item_id)
                    ->where('dispensary_id', $request->dispensary_id)
                    ->first();

                if (!$dispensaryItem) {
                    $dispensaryItem = DispensaryItem::create([
                        'item_id' => $request->item_id,
                        'dispensary_id' => $request->dispensary_id
                    ]);
                }

                $dispensaryItem->dispensaryItemStock()->create([
                    'expired_date' => $itemStock->expired_date,
                    'qty' => $request->qty,
                    'price_purchase' => $itemStock->price_purchase,
                    'price_sell' => $itemStock->price_sell,
                    'discount' => $itemStock->discount,
                    'status' => 1,
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

    public function destroyData(Request $request)
    {
        $id = $request->id;

        try {
            DispensaryItemStock::destroy($id);

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
