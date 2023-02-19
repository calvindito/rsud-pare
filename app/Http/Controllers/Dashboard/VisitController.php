<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Helpers\Simrs;
use App\Models\Inpatient;
use App\Models\Outpatient;
use Illuminate\Http\Request;
use App\Models\EmergencyDepartment;
use App\Http\Controllers\Controller;

class VisitController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'dashboard.visit'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function perYear(Request $request)
    {
        try {
            $data = [];
            $year = $request->has('year') ? $request->year : date('Y');
            $type = Simrs::nursingType();

            foreach ($type as $key => $t) {
                $outpatinet = Outpatient::where('type', $key + 1)->whereYear('date_of_entry', $year)->count();
                $inpatient = Inpatient::where('type', $key + 1)->whereYear('date_of_entry', $year)->count();
                $emergencyDepartment = EmergencyDepartment::where('type', $key + 1)->whereYear('date_of_entry', $year)->count();

                $data['outpatient'][] = $outpatinet;
                $data['inpatient'][] = $inpatient;
                $data['emergencyDepartment'][] = $emergencyDepartment;
            }

            $response = [
                'label' => $type,
                'data' => [
                    [
                        'name' => 'Rawat Jalan',
                        'type' => 'line',
                        'smooth' => true,
                        'stack' => 'Total',
                        'symbol' => 'circle',
                        'symbolSize' => 8,
                        'data' => $data['outpatient']
                    ],
                    [
                        'name' => 'Rawat Inap',
                        'type' => 'line',
                        'smooth' => true,
                        'stack' => 'Total',
                        'symbol' => 'circle',
                        'symbolSize' => 8,
                        'data' => $data['inpatient']
                    ],
                    [
                        'name' => 'IGD',
                        'type' => 'line',
                        'smooth' => true,
                        'stack' => 'Total',
                        'symbol' => 'circle',
                        'symbolSize' => 8,
                        'data' => $data['emergencyDepartment']
                    ]
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

    public function last3Year()
    {
        try {
            $response = [];
            $yearStart = date('Y', strtotime('-3 years'));
            $yearEnd = date('Y');
            $type = Simrs::nursingType();

            foreach ($type as $key => $t) {
                $outpatinet = Outpatient::where('type', $key + 1)
                    ->whereYear('date_of_entry', '>=', $yearStart)
                    ->whereYear('date_of_entry', '<=', $yearEnd)
                    ->count();

                $inpatient = Inpatient::where('type', $key + 1)
                    ->whereYear('date_of_entry', '>=', $yearStart)
                    ->whereYear('date_of_entry', '<=', $yearEnd)
                    ->count();

                $emergencyDepartment = EmergencyDepartment::where('type', $key + 1)
                    ->whereYear('date_of_entry', '>=', $yearStart)
                    ->whereYear('date_of_entry', '<=', $yearEnd)
                    ->count();

                $response[] = [
                    'name' => $t,
                    'value' => $outpatinet + $inpatient + $emergencyDepartment
                ];
            };
        } catch (\Exception $e) {
            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return response()->json($response);
    }

    public function last5Year()
    {
        try {
            $response = [];
            $yearStart = date('Y', strtotime('-5 years'));
            $yearEnd = date('Y');
            $type = Simrs::nursingType();

            foreach ($type as $key => $t) {
                $outpatinet = Outpatient::where('type', $key + 1)
                    ->whereYear('date_of_entry', '>=', $yearStart)
                    ->whereYear('date_of_entry', '<=', $yearEnd)
                    ->count();

                $inpatient = Inpatient::where('type', $key + 1)
                    ->whereYear('date_of_entry', '>=', $yearStart)
                    ->whereYear('date_of_entry', '<=', $yearEnd)
                    ->count();

                $emergencyDepartment = EmergencyDepartment::where('type', $key + 1)
                    ->whereYear('date_of_entry', '>=', $yearStart)
                    ->whereYear('date_of_entry', '<=', $yearEnd)
                    ->count();

                $response[] = [
                    'name' => $t,
                    'value' => $outpatinet + $inpatient + $emergencyDepartment
                ];
            };
        } catch (\Exception $e) {
            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return response()->json($response);
    }

    public function outpatient(Request $request)
    {
        try {
            $data = [];
            $year = $request->has('year') ? $request->year : date('Y');
            $month = [];

            for ($i = 1; $i <= 12; $i++) {
                $month[] = Carbon::parse($year . '-' . $i)->isoFormat('MMM');
                $data[] = Outpatient::whereMonth('date_of_entry', $i)->whereYear('date_of_entry', $year)->count();
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

    public function inpatient(Request $request)
    {
        try {
            $data = [];
            $year = $request->has('year') ? $request->year : date('Y');
            $month = [];

            for ($i = 1; $i <= 12; $i++) {
                $month[] = Carbon::parse($year . '-' . $i)->isoFormat('MMM');
                $data[] = Inpatient::whereMonth('date_of_entry', $i)->whereYear('date_of_entry', $year)->count();
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

    public function emergencyDepartment(Request $request)
    {
        try {
            $data = [];
            $year = $request->has('year') ? $request->year : date('Y');
            $month = [];

            for ($i = 1; $i <= 12; $i++) {
                $month[] = Carbon::parse($year . '-' . $i)->isoFormat('MMM');
                $data[] = EmergencyDepartment::whereMonth('date_of_entry', $i)->whereYear('date_of_entry', $year)->count();
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
