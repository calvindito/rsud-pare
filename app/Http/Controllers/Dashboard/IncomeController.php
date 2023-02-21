<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\Recipe;
use App\Models\ItemStock;
use App\Models\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                $data['nominal'][] = ItemStock::whereMonth('created_at', $i)->whereYear('created_at', $year)->sum(DB::raw('price_purchase * (stock + sold)'));
                $data['qty'][] = ItemStock::whereMonth('created_at', $i)->whereYear('created_at', $year)->sum(DB::raw('stock + sold'));
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
                        'name' => 'Jumlah',
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
                $data['nominal'][] = Recipe::where('status', 4)->whereMonth('created_at', $i)->whereYear('created_at', $year)->sum(DB::raw('price_sell * qty'));
                $data['qty'][] = Recipe::where('status', 4)->whereMonth('created_at', $i)->whereYear('created_at', $year)->sum('qty');
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
                        'name' => 'Jumlah',
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
                $data['purchase'][] = ItemStock::whereMonth('created_at', $i)->whereYear('created_at', $year)->sum(DB::raw('price_purchase * (stock + sold)'));
                $data['sell'][] = Recipe::where('status', 4)->whereMonth('created_at', $i)->whereYear('created_at', $year)->sum(DB::raw('price_sell * qty'));
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
                $data[] = Recipe::where('status', 4)->whereMonth('created_at', $i)->whereYear('created_at', $year)->sum(DB::raw('(price_sell - price_purchase) * qty'));
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
                $data[] = Operation::whereIn('status', [2, 3])
                    ->whereMonth('created_at', $i)
                    ->whereYear('created_at', $year)
                    ->sum(DB::raw('
                        hospital_service +
                        doctor_operating_room +
                        doctor_anesthetist +
                        nurse_operating_room +
                        nurse_anesthetist +
                        material +
                        monitoring +
                        nursing_care
                    '));
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
