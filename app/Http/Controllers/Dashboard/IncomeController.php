<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\Operation;
use Illuminate\Http\Request;
use App\Models\OperationMaterial;
use Illuminate\Support\Facades\DB;
use App\Models\DispensaryItemStock;
use App\Http\Controllers\Controller;

class IncomeController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'dashboard.income'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function purchaseItem(Request $request)
    {
        try {
            $data = [];
            $year = $request->has('year') ? $request->year : date('Y');
            $month = [];

            for ($i = 1; $i <= 12; $i++) {
                $month[] = Carbon::parse($year . '-' . $i)->isoFormat('MMM');

                $data['nominal'][] = DispensaryItemStock::where('type', 1)
                    ->whereMonth('created_at', $i)
                    ->whereYear('created_at', $year)
                    ->sum(DB::raw('price_purchase * qty'));

                $data['qty'][] = DispensaryItemStock::where('type', 1)
                    ->whereMonth('created_at', $i)
                    ->whereYear('created_at', $year)
                    ->sum('qty');
            }

            $response = [
                'label' => $month,
                'data' => [
                    [
                        'name' => 'Nominal',
                        'type' => 'line',
                        'smooth' => true,
                        'stack' => 'Total',
                        'symbol' => 'circle',
                        'symbolSize' => 8,
                        'data' => $data['nominal']
                    ],
                    [
                        'name' => 'Kuantitas',
                        'type' => 'line',
                        'smooth' => true,
                        'stack' => 'Total',
                        'symbol' => 'circle',
                        'symbolSize' => 8,
                        'data' => $data['qty']
                    ],
                ]
            ];
        } catch (\Exception $e) {
            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return response()->json($response);
    }

    public function saleItem(Request $request)
    {
        try {
            $data = [];
            $year = $request->has('year') ? $request->year : date('Y');
            $month = [];

            for ($i = 1; $i <= 12; $i++) {
                $month[] = Carbon::parse($year . '-' . $i)->isoFormat('MMM');

                $data['nominal'][] = DispensaryItemStock::where('type', 2)
                    ->whereMonth('created_at', $i)
                    ->whereYear('created_at', $year)
                    ->sum(DB::raw('price_sell * qty'));

                $data['qty'][] = DispensaryItemStock::where('type', 2)
                    ->whereMonth('created_at', $i)
                    ->whereYear('created_at', $year)
                    ->sum('qty');
            }

            $response = [
                'label' => $month,
                'data' => [
                    [
                        'name' => 'Nominal',
                        'type' => 'line',
                        'smooth' => true,
                        'stack' => 'Total',
                        'symbol' => 'circle',
                        'symbolSize' => 8,
                        'data' => $data['nominal']
                    ],
                    [
                        'name' => 'Kuantitas',
                        'type' => 'line',
                        'smooth' => true,
                        'stack' => 'Total',
                        'symbol' => 'circle',
                        'symbolSize' => 8,
                        'data' => $data['qty']
                    ],
                ]
            ];
        } catch (\Exception $e) {
            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return response()->json($response);
    }

    public function comparePurchaseSaleItem(Request $request)
    {
        try {
            $data = [];
            $year = $request->has('year') ? $request->year : date('Y');
            $month = [];

            for ($i = 1; $i <= 12; $i++) {
                $month[] = Carbon::parse($year . '-' . $i)->isoFormat('MMM');

                $data['purchase'][] = DispensaryItemStock::where('type', 1)
                    ->whereMonth('created_at', $i)
                    ->whereYear('created_at', $year)
                    ->sum(DB::raw('price_purchase * qty'));

                $data['sell'][] = DispensaryItemStock::where('type', 2)
                    ->whereMonth('created_at', $i)
                    ->whereYear('created_at', $year)
                    ->sum(DB::raw('price_sell * qty'));
            }

            $response = [
                'label' => $month,
                'data' => [
                    [
                        'name' => 'Pembelian',
                        'type' => 'bar',
                        'smooth' => true,
                        'barWidth' => '60%',
                        'data' => $data['purchase']
                    ],
                    [
                        'name' => 'Penjualan',
                        'type' => 'bar',
                        'smooth' => true,
                        'barWidth' => '60%',
                        'data' => $data['sell']
                    ],
                ]
            ];
        } catch (\Exception $e) {
            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return response()->json($response);
    }

    public function profitItem(Request $request)
    {
        try {
            $data = [];
            $year = $request->has('year') ? $request->year : date('Y');
            $month = [];

            for ($i = 1; $i <= 12; $i++) {
                $month[] = Carbon::parse($year . '-' . $i)->isoFormat('MMM');
                $data[] = DispensaryItemStock::where('type', 2)
                    ->whereMonth('created_at', $i)
                    ->whereYear('created_at', $year)
                    ->sum(DB::raw('(price_sell - price_purchase) * qty'));
            }

            $response = [
                'label' => $month,
                'data' => $data
            ];
        } catch (\Exception $e) {
            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return response()->json($response);
    }

    public function operatingRoom(Request $request)
    {
        try {
            $data = [];
            $year = $request->has('year') ? $request->year : date('Y');
            $month = [];

            for ($i = 1; $i <= 12; $i++) {
                $month[] = Carbon::parse($year . '-' . $i)->isoFormat('MMM');

                $totalOperation = Operation::where('status', 3)
                    ->whereMonth('created_at', $i)
                    ->whereYear('created_at', $year)
                    ->sum(DB::raw('
                        hospital_service +
                        doctor_operating_room +
                        doctor_anesthetist +
                        nurse_operating_room +
                        nurse_anesthetist +
                        monitoring +
                        nursing_care
                    '));

                $totalOperationMaterial = OperationMaterial::whereHas('operation', function ($query) {
                    $query->where('status', 3);
                })->whereMonth('created_at', $i)->whereYear('created_at', $year)->sum(DB::raw('price_sell * qty'));

                $data[] = $totalOperation + $totalOperationMaterial;
            }

            $response = [
                'label' => $month,
                'data' => $data
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
