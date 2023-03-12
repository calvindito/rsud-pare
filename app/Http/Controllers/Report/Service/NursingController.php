<?php

namespace App\Http\Controllers\Report\Service;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Operation;
use App\Models\LabRequest;
use Illuminate\Http\Request;
use App\Models\InpatientNursing;
use App\Models\RadiologyRequest;
use App\Models\OutpatientNursing;
use App\Http\Controllers\Controller;
use App\Models\EmergencyDepartmentNursing;

class NursingController extends Controller
{
    public function index(Request $request)
    {
        $contentable = false;
        $userId = $request->user_id;
        $date = $request->date;
        $user = User::where('status', 1)->get();
        $operation = 0;
        $lab = 0;
        $radiology = 0;
        $action = 0;

        if ($request->_token == csrf_token()) {
            if (empty($userId)) {
                return redirect()->back()->withInput()->with(['validation' => 'mohon memilih perawat']);
            }

            if (empty($date)) {
                return redirect()->back()->withInput()->with(['validation' => 'mohon tentukan tanggal']);
            }

            $explodeDate = explode(' - ', $date);
            $startDate = Carbon::parse($explodeDate[0]);
            $endDate = Carbon::parse($explodeDate[1]);
            $rangeDate = $startDate->diffInDays($endDate) + 1;

            if ($rangeDate > 31) {
                return redirect()->back()->withInput()->with(['validation' => 'jarak tanggal maksimal 31 hari']);
            }

            $dataOperation = Operation::where('user_id', $userId)
                ->orWhereHas('operationDoctorAssistant', function ($query) use ($userId) {
                    $query->whereHas('employee', function ($query) use ($userId) {
                        $query->whereHas('user', function ($query) use ($userId) {
                            $query->where('id', $userId);
                        });
                    });
                })
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->where('created_at', '>=', $startDate)
                        ->where('created_at', '<=', $endDate);
                })
                ->where('paid', 1)
                ->where('status', 3)
                ->get();

            foreach ($dataOperation as $do) {
                $operation += $do->totalServiceNursing();
            }

            $dataLab = LabRequest::where('user_id', $userId)
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->where('created_at', '>=', $startDate)
                        ->where('created_at', '<=', $endDate);
                })
                ->where('paid', 1)
                ->where('status', 3)
                ->get();

            foreach ($dataLab as $dl) {
                $lab += $dl->labRequestDetail->sum('service');
            }

            $dataRadiology = RadiologyRequest::where('user_id', $userId)
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->where('created_at', '>=', $startDate)
                        ->where('created_at', '<=', $endDate);
                })
                ->where('paid', 1)
                ->where('status', 3)
                ->get();

            foreach ($dataRadiology as $dr) {
                $radiology += $dr->service;
            }

            $outpatientAction = OutpatientNursing::where('user_id', $userId)
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->where('created_at', '>=', $startDate)
                        ->where('created_at', '<=', $endDate);
                })
                ->get();

            foreach ($outpatientAction as $oa) {
                $totalNursing = OutpatientNursing::where('outpatient_id', $oa->id)->groupBy('user_id')->count();
                $fee = $oa->service / $totalNursing;
                $action += ceil($fee);
            }

            $inpatientAction = InpatientNursing::where('user_id', $userId)
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->where('created_at', '>=', $startDate)
                        ->where('created_at', '<=', $endDate);
                })
                ->get();

            foreach ($inpatientAction as $ia) {
                $totalNursing = InpatientNursing::where('inpatient_id', $ia->id)->groupBy('user_id')->count();
                $fee = $ia->fee / $totalNursing;
                $action += ceil($fee);
            }

            $emergencyDepartmentAction = EmergencyDepartmentNursing::where('user_id', $userId)
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->where('created_at', '>=', $startDate)
                        ->where('created_at', '<=', $endDate);
                })
                ->get();

            foreach ($emergencyDepartmentAction as $eda) {
                $totalNursing = EmergencyDepartmentNursing::where('emergency_department_id', $ia->id)->groupBy('user_id')->count();
                $fee = $ia->fee / $totalNursing;
                $action += ceil($fee);
            }

            $contentable = true;
        }

        $data = [
            'token' => $request->_token,
            'user' => User::has('employee')->where('status', 1)->get(),
            'contentable' => $contentable,
            'user' => $user,
            'operation' => $operation,
            'lab' => $lab,
            'radiology' => $radiology,
            'action' => $action,
            'content' => 'report.service.nursing'
        ];

        return view('layouts.index', ['data' => $data]);
    }
}
