<?php

namespace App\Http\Controllers\Pharmacy;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\ItemStock;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MutationController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'pharmacy.mutation'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function loadData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'item_id' => 'required',
            'date_start' => 'required|before_or_equal:date_end',
            'date_end' => 'required|after_or_equal:date_start'
        ], [
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
                $itemId = $request->item_id;
                $startDate = $request->date_start;
                $endDate = $request->date_end;
                $diff = Carbon::parse($startDate)->diffInDays($endDate);

                for ($i = 0; $i <= $diff; $i++) {
                    $date = date('Y-m-d', strtotime("+$i days", strtotime($startDate)));

                    $beforeIn = ItemStock::where('type', 1)
                        ->where('item_id', $itemId)
                        ->whereDate('created_at', '<', $date)
                        ->sum('qty');

                    $beforeOut = ItemStock::where('type', 2)
                        ->where('item_id', $itemId)
                        ->whereDate('created_at', '<', $date)
                        ->sum('qty');

                    $currentIn = ItemStock::where('type', 1)
                        ->where('item_id', $itemId)
                        ->whereDate('created_at', $date)
                        ->sum('qty');

                    $currentOut = ItemStock::where('type', 2)
                        ->where('item_id', $itemId)
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
        $item = Item::findOrFail($request->item_id);
        $validation = Validator::make($request->all(), [
            'item_id' => 'required',
            'date_start' => 'required|before_or_equal:date_end',
            'date_end' => 'required|after_or_equal:date_start'
        ], [
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
            $itemId = $request->item_id;
            $startDate = $request->date_start;
            $endDate = $request->date_end;
            $diff = Carbon::parse($startDate)->diffInDays($endDate);

            for ($i = 0; $i <= $diff; $i++) {
                $date = date('Y-m-d', strtotime("+$i days", strtotime($startDate)));

                $beforeIn = ItemStock::where('type', 1)
                    ->where('item_id', $itemId)
                    ->whereDate('created_at', '<', $date)
                    ->sum('qty');

                $beforeOut = ItemStock::where('type', 2)
                    ->where('item_id', $itemId)
                    ->whereDate('created_at', '<', $date)
                    ->sum('qty');

                $currentIn = ItemStock::where('type', 1)
                    ->where('item_id', $itemId)
                    ->whereDate('created_at', $date)
                    ->sum('qty');

                $currentOut = ItemStock::where('type', 2)
                    ->where('item_id', $itemId)
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
            ])->loadView('pdf.mutation-pharmacy', [
                'title' => 'Mutasi Stok Item Farmasi',
                'item' => $item,
                'data' => $data,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'diff' => $diff
            ]);

            return $pdf->stream('Mutasi Stok Item Farmasi' . ' - ' . date('YmdHis') . '.pdf');
        }
    }
}
