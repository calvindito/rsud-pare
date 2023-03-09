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
            'date' => 'required'
        ], [
            'item_id.required' => 'mohon memilih item',
            'date.required' => 'tanggal tidak boleh kosong'
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
                $explodeDate = explode(' - ', $request->date);
                $startDate = date('Y-m-d', strtotime($explodeDate[0]));
                $endDate = date('Y-m-d', strtotime($explodeDate[1]));
                $columnFilterDate = $request->column_date;
                $diff = Carbon::parse($startDate)->diffInDays($endDate);

                for ($i = 0; $i <= $diff; $i++) {
                    $date = date('Y-m-d', strtotime("+$i days", strtotime($startDate)));

                    $beforeIn = ItemStock::where('type', 1)
                        ->where('item_id', $itemId)
                        ->whereDate($columnFilterDate, '<', $date)
                        ->sum('qty');

                    $beforeOut = ItemStock::where('type', 2)
                        ->where('item_id', $itemId)
                        ->whereDate($columnFilterDate, '<', $date)
                        ->sum('qty');

                    $currentIn = ItemStock::where('type', 1)
                        ->where('item_id', $itemId)
                        ->whereDate($columnFilterDate, $date)
                        ->sum('qty');

                    $currentOut = ItemStock::where('type', 2)
                        ->where('item_id', $itemId)
                        ->whereDate($columnFilterDate, $date)
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
            'date' => 'required'
        ], [
            'item_id.required' => 'mohon memilih item',
            'date.required' => 'tanggal tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors()->all());
        } else {
            $data = [];
            $itemId = $request->item_id;
            $explodeDate = explode(' - ', $request->date);
            $startDate = date('Y-m-d', strtotime($explodeDate[0]));
            $endDate = date('Y-m-d', strtotime($explodeDate[1]));
            $columnFilterDate = $request->column_date;
            $diff = Carbon::parse($startDate)->diffInDays($endDate);

            for ($i = 0; $i <= $diff; $i++) {
                $date = date('Y-m-d', strtotime("+$i days", strtotime($startDate)));

                $beforeIn = ItemStock::where('type', 1)
                    ->where('item_id', $itemId)
                    ->whereDate($columnFilterDate, '<', $date)
                    ->sum('qty');

                $beforeOut = ItemStock::where('type', 2)
                    ->where('item_id', $itemId)
                    ->whereDate($columnFilterDate, '<', $date)
                    ->sum('qty');

                $currentIn = ItemStock::where('type', 1)
                    ->where('item_id', $itemId)
                    ->whereDate($columnFilterDate, $date)
                    ->sum('qty');

                $currentOut = ItemStock::where('type', 2)
                    ->where('item_id', $itemId)
                    ->whereDate($columnFilterDate, $date)
                    ->sum('qty');

                $data[] = [
                    'date' => $date,
                    'stock_in' => $currentIn,
                    'stock_out' => $currentOut,
                    'remaining' => ($beforeIn - $beforeOut) + ($currentIn - $currentOut)
                ];
            }

            if ($columnFilterDate == 'created_at') {
                $columnDate = 'Tanggal Masuk';
            } else if ($columnFilterDate == 'expired_date') {
                $columnDate = 'Tanggal Kadaluwarsa';
            } else {
                $columnDate = 'Invalid';
            }

            $pdf = Pdf::setOptions([
                'adminUsername' => auth()->user()->username
            ])->loadView('pdf.mutation-pharmacy', [
                'title' => 'Mutasi Stok Item Farmasi',
                'item' => $item,
                'data' => $data,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'columnDate' => $columnDate,
                'diff' => $diff
            ]);

            return $pdf->stream('Mutasi Stok Item Farmasi' . ' - ' . date('YmdHis') . '.pdf');
        }
    }
}
