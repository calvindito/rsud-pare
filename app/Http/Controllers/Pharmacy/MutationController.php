<?php

namespace App\Http\Controllers\Pharmacy;

use Carbon\Carbon;
use App\Models\Recipe;
use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Models\MedicineStock;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MutationController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'content' => 'pharmacy.mutation'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function loadData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'medicine_id' => 'required',
            'date_start' => 'required|before_or_equal:date_end',
            'date_end' => 'required|after_or_equal:date_start'
        ], [
            'medicine_id.required' => 'mohon memilih obat',
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
                $medicineId = $request->medicine_id;
                $startDate = $request->date_start;
                $endDate = $request->date_end;
                $diff = Carbon::parse($startDate)->diffInDays($endDate);

                for ($i = 0; $i <= $diff; $i++) {
                    $date = date('Y-m-d', strtotime("+$i days", strtotime($startDate)));
                    $remaining = MedicineStock::whereDate('created_at', '<', $date)->where('medicine_id', $medicineId)->sum('stock');
                    $stockIn = MedicineStock::whereDate('created_at', $date)->where('medicine_id', $medicineId)->sum(DB::raw('stock + sold'));
                    $stockOut = Recipe::whereDate('created_at', $date)
                        ->whereHas('medicineStock', function ($query) use ($date, $medicineId) {
                            $query->where('medicine_id', $medicineId)
                                ->whereDate('created_at', $date);
                        })
                        ->where('status', 4)
                        ->sum('qty');

                    $data[] = [
                        'date' => $date,
                        'stock_in' => $stockIn,
                        'stock_out' => $stockOut,
                        'remaining' => ($remaining - $stockOut) + $stockIn
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
        $medicine = Medicine::findOrFail($request->medicine_id);
        $validation = Validator::make($request->all(), [
            'medicine_id' => 'required',
            'date_start' => 'required|before_or_equal:date_end',
            'date_end' => 'required|after_or_equal:date_start'
        ], [
            'medicine_id.required' => 'mohon memilih obat',
            'date_start.required' => 'tanggal awal tidak boleh kosong',
            'date_start.before_or_equal' => 'tanggal awal tidak boleh lebih dari tanggal akhir',
            'date_end.required' => 'tanggal akhir tidak boleh kosong',
            'date_end.after_or_equal' => 'tanggal akhir tidak boleh kurang dari tanggal awal'
        ]);

        if ($validation->fails()) {
            return response()->json($validation->errors()->all());
        } else {
            $data = [];
            $medicineId = $request->medicine_id;
            $startDate = $request->date_start;
            $endDate = $request->date_end;
            $diff = Carbon::parse($startDate)->diffInDays($endDate);

            for ($i = 0; $i <= $diff; $i++) {
                $date = date('Y-m-d', strtotime("+$i days", strtotime($startDate)));
                $remaining = MedicineStock::whereDate('created_at', '<', $date)->where('medicine_id', $medicineId)->sum('stock');
                $stockIn = MedicineStock::whereDate('created_at', $date)->where('medicine_id', $medicineId)->sum(DB::raw('stock + sold'));
                $stockOut = Recipe::whereDate('created_at', $date)
                    ->whereHas('medicineStock', function ($query) use ($date, $medicineId) {
                        $query->where('medicine_id', $medicineId)
                            ->whereDate('created_at', $date);
                    })
                    ->where('status', 4)
                    ->sum('qty');

                $data[] = [
                    'date' => $date,
                    'stock_in' => $stockIn,
                    'stock_out' => $stockOut,
                    'remaining' => ($remaining - $stockOut) + $stockIn
                ];
            }

            $pdf = Pdf::setOptions([
                'adminUsername' => auth()->user()->username
            ])->loadView('pdf.mutation', [
                'title' => 'Mutasi Stok Obat',
                'medicine' => $medicine,
                'data' => $data,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'diff' => $diff
            ]);

            return $pdf->stream('Mutasi Stok Obat' . ' - ' . date('YmdHis') . '.pdf');
        }
    }
}
