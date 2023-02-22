<?php

namespace App\Http\Controllers\Pharmacy;

use App\Models\ItemStock;
use Illuminate\Http\Request;
use App\Models\DispensaryRequest;
use App\Models\DispensaryItemStock;
use App\Http\Controllers\Controller;

class RequestController extends Controller
{
    public function index()
    {
        $data = [
            'dispensaryItemStock' => DispensaryItemStock::where('qty', '>', 0)->where('status', 1)->get(),
            'content' => 'pharmacy.request'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function submitted(Request $request)
    {
        try {
            foreach ($request->id as $key => $i) {
                $status = $request->has('status_' . $i) ? 2 : 3;
                $dispensaryItemStock = DispensaryItemStock::find($i);
                $dispensaryItem = $dispensaryItemStock->dispensaryItem;
                $qty = $dispensaryItemStock->qty;

                if ($status == 2) {
                    $itemStock = ItemStock::selectRaw("*, SUM(CASE WHEN type = '1' THEN qty END) as stock, SUM(CASE WHEN type = '2' THEN qty END) as cut")
                        ->where('item_id', $dispensaryItem->item_id)
                        ->groupBy('item_id')
                        ->havingRaw('stock > IF(cut > 0, cut, 0)')
                        ->oldest('expired_date')
                        ->first();

                    if ($qty > $itemStock->qty) {
                        $qty = $itemStock->qty;
                    }

                    ItemStock::find($itemStock->id)->replicate()->fill([
                        'type' => 2,
                        'qty' => $qty
                    ])->save();
                }

                $dispensaryItemStock->update([
                    'qty' => $qty,
                    'status' => $status
                ]);
            }

            $response = [
                'code' => 200,
                'message' => 'Data permintaan berhasil disubmit'
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
