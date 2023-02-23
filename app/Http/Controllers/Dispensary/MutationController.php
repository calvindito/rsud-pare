<?php

namespace App\Http\Controllers\Dispensary;

use Carbon\Carbon;
use App\Models\Dispensary;
use Illuminate\Http\Request;
use App\Models\DispensaryItem;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DispensaryItemStock;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MutationController extends Controller
{
    public function index()
    {
        $data = [
            'dispensary' => Dispensary::all(),
            'content' => 'dispensary.mutation'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function loadData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'dispensary_id' => 'required',
            'item_id' => 'required',
            'date_start' => 'required|before_or_equal:date_end',
            'date_end' => 'required|after_or_equal:date_start'
        ], [
            'dispensary_id.required' => 'mohon memilih apotek',
            'item_id.required' => 'mohon memilih item',
            'date_start.required' => 'tanggal awal tidak boleh kosong',
            'date_start.before_or_equal' => 'tanggal awal tidak boleh lebih dari tanggal akhir',
            'date_end.required' => 'tanggal akhir tidak boleh kosong',
            'date_end.after_or_equal' => 'tanggal akhir tidak boleh kurang dari tanggal awal'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $data = [];
                $dispensaryId = $request->dispensary_id;
                $itemId = $request->item_id;
                $dispensaryItem = DispensaryItem::where('dispensary_id', $dispensaryId)->where('item_id', $itemId)->first();
                $startDate = $request->date_start;
                $endDate = $request->date_end;
                $diff = Carbon::parse($startDate)->diffInDays($endDate);

                for ($i = 0; $i <= $diff; $i++) {
                    $date = date('Y-m-d', strtotime("+$i days", strtotime($startDate)));

                    $beforeIn = DispensaryItemStock::where('type', 1)
                        ->where('status', 2)
                        ->where('dispensary_item_id', $dispensaryItem->id ?? null)
                        ->whereDate('created_at', '<', $date)
                        ->sum('qty');

                    $beforeOut = DispensaryItemStock::where('type', 2)
                        ->where('status', 2)
                        ->where('dispensary_item_id', $dispensaryItem->id ?? null)
                        ->whereDate('created_at', '<', $date)
                        ->sum('qty');

                    $currentIn = DispensaryItemStock::where('type', 1)
                        ->where('status', 2)
                        ->where('dispensary_item_id', $dispensaryItem->id ?? null)
                        ->whereDate('created_at', $date)
                        ->sum('qty');

                    $currentOut = DispensaryItemStock::where('type', 2)
                        ->where('status', 2)
                        ->where('dispensary_item_id', $dispensaryItem->id ?? null)
                        ->whereDate('created_at', $date)
                        ->sum('qty');

                    $data[] = [
                        'date' => $date,
                        'stock_in' => $currentIn,
                        'stock_out' => $currentOut,
                        'remaining' => ($beforeIn - $beforeOut) + ($currentIn - $currentOut)
                    ];
                }

                $response = [
                    'code' => 200,
                    'data' => $data
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

    public function print(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'dispensary_id' => 'required',
            'item_id' => 'required',
            'date_start' => 'required|before_or_equal:date_end',
            'date_end' => 'required|after_or_equal:date_start'
        ], [
            'dispensary_id.required' => 'mohon memilih apotek',
            'item_id.required' => 'mohon memilih item',
            'date_start.required' => 'tanggal awal tidak boleh kosong',
            'date_start.before_or_equal' => 'tanggal awal tidak boleh lebih dari tanggal akhir',
            'date_end.required' => 'tanggal akhir tidak boleh kosong',
            'date_end.after_or_equal' => 'tanggal akhir tidak boleh kurang dari tanggal awal'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors()->all());
        } else {
            $data = [];
            $dispensaryId = $request->dispensary_id;
            $itemId = $request->item_id;
            $dispensaryItem = DispensaryItem::where('dispensary_id', $dispensaryId)->where('item_id', $itemId)->first();
            $startDate = $request->date_start;
            $endDate = $request->date_end;
            $diff = Carbon::parse($startDate)->diffInDays($endDate);

            for ($i = 0; $i <= $diff; $i++) {
                $date = date('Y-m-d', strtotime("+$i days", strtotime($startDate)));

                $beforeIn = DispensaryItemStock::where('type', 1)
                    ->where('status', 2)
                    ->where('dispensary_item_id', $dispensaryItem->id ?? null)
                    ->whereDate('created_at', '<', $date)
                    ->sum('qty');

                $beforeOut = DispensaryItemStock::where('type', 2)
                    ->where('status', 2)
                    ->where('dispensary_item_id', $dispensaryItem->id ?? null)
                    ->whereDate('created_at', '<', $date)
                    ->sum('qty');

                $currentIn = DispensaryItemStock::where('type', 1)
                    ->where('status', 2)
                    ->where('dispensary_item_id', $dispensaryItem->id ?? null)
                    ->whereDate('created_at', $date)
                    ->sum('qty');

                $currentOut = DispensaryItemStock::where('type', 2)
                    ->where('status', 2)
                    ->where('dispensary_item_id', $dispensaryItem->id ?? null)
                    ->whereDate('created_at', $date)
                    ->sum('qty');

                $data[] = [
                    'date' => $date,
                    'stock_in' => $currentIn,
                    'stock_out' => $currentOut,
                    'remaining' => ($beforeIn - $beforeOut) + ($currentIn - $currentOut)
                ];
            }

            $pdf = Pdf::setOptions([
                'adminUsername' => auth()->user()->username
            ])->loadView('pdf.mutation-dispensary', [
                'title' => 'Mutasi Stok Item Apotek',
                'dispensaryItem' => $dispensaryItem,
                'data' => $data,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'diff' => $diff
            ]);

            return $pdf->stream('Mutasi Stok Item Apotek' . ' - ' . date('YmdHis') . '.pdf');
        }
    }
}
