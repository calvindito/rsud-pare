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
            'date' => 'required'
        ], [
            'dispensary_id.required' => 'mohon memilih apotek',
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
                $dispensaryId = $request->dispensary_id;
                $itemId = $request->item_id;
                $dispensaryItem = DispensaryItem::where('dispensary_id', $dispensaryId)->where('item_id', $itemId)->first();
                $explodeDate = explode(' - ', $request->date);
                $startDate = date('Y-m-d', strtotime($explodeDate[0]));
                $endDate = date('Y-m-d', strtotime($explodeDate[1]));
                $columnFilterDate = $request->column_date;
                $diff = Carbon::parse($startDate)->diffInDays($endDate);

                for ($i = 0; $i <= $diff; $i++) {
                    $date = date('Y-m-d', strtotime("+$i days", strtotime($startDate)));

                    $beforeIn = DispensaryItemStock::where('type', 1)
                        ->where('status', 2)
                        ->where('dispensary_item_id', $dispensaryItem->id ?? null)
                        ->whereDate($columnFilterDate, '<', $date)
                        ->sum('qty');

                    $beforeOut = DispensaryItemStock::where('type', 2)
                        ->where('status', 2)
                        ->where('dispensary_item_id', $dispensaryItem->id ?? null)
                        ->whereDate($columnFilterDate, '<', $date)
                        ->sum('qty');

                    $currentIn = DispensaryItemStock::where('type', 1)
                        ->where('status', 2)
                        ->where('dispensary_item_id', $dispensaryItem->id ?? null)
                        ->whereDate($columnFilterDate, $date)
                        ->sum('qty');

                    $currentOut = DispensaryItemStock::where('type', 2)
                        ->where('status', 2)
                        ->where('dispensary_item_id', $dispensaryItem->id ?? null)
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
        $validation = Validator::make($request->all(), [
            'dispensary_id' => 'required',
            'item_id' => 'required',
            'date' => 'required'
        ], [
            'dispensary_id.required' => 'mohon memilih apotek',
            'item_id.required' => 'mohon memilih item',
            'date.required' => 'tanggal tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors()->all());
        } else {
            $data = [];
            $dispensaryId = $request->dispensary_id;
            $itemId = $request->item_id;
            $dispensaryItem = DispensaryItem::where('dispensary_id', $dispensaryId)->where('item_id', $itemId)->first();
            $explodeDate = explode(' - ', $request->date);
            $startDate = date('Y-m-d', strtotime($explodeDate[0]));
            $endDate = date('Y-m-d', strtotime($explodeDate[1]));
            $columnFilterDate = $request->column_date;
            $diff = Carbon::parse($startDate)->diffInDays($endDate);

            for ($i = 0; $i <= $diff; $i++) {
                $date = date('Y-m-d', strtotime("+$i days", strtotime($startDate)));

                $beforeIn = DispensaryItemStock::where('type', 1)
                    ->where('status', 2)
                    ->where('dispensary_item_id', $dispensaryItem->id ?? null)
                    ->whereDate($columnFilterDate, '<', $date)
                    ->sum('qty');

                $beforeOut = DispensaryItemStock::where('type', 2)
                    ->where('status', 2)
                    ->where('dispensary_item_id', $dispensaryItem->id ?? null)
                    ->whereDate($columnFilterDate, '<', $date)
                    ->sum('qty');

                $currentIn = DispensaryItemStock::where('type', 1)
                    ->where('status', 2)
                    ->where('dispensary_item_id', $dispensaryItem->id ?? null)
                    ->whereDate($columnFilterDate, $date)
                    ->sum('qty');

                $currentOut = DispensaryItemStock::where('type', 2)
                    ->where('status', 2)
                    ->where('dispensary_item_id', $dispensaryItem->id ?? null)
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
            ])->loadView('pdf.mutation-dispensary', [
                'title' => 'Mutasi Stok Item Apotek',
                'dispensaryItem' => $dispensaryItem,
                'data' => $data,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'columnDate' => $columnDate,
                'diff' => $diff
            ]);

            return $pdf->stream('Mutasi Stok Item Apotek' . ' - ' . date('YmdHis') . '.pdf');
        }
    }
}
