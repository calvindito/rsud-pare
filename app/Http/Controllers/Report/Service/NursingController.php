<?php

namespace App\Http\Controllers\Report\Service;

use Carbon\Carbon;
use App\Models\Employee;
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
        $employeeId = $request->employee_id;
        $date = $request->date;
        $employee = Employee::where('status', 1)->get();
        $operation = 0;
        $lab = 0;
        $radiology = 0;
        $action = 0;

        if ($request->_token == csrf_token()) {
            if (empty($employeeId)) {
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

            $dataOperation = Operation::whereHas('user', function ($query) use ($employeeId) {
                $query->whereHas('employee', function ($query) use ($employeeId) {
                    $query->where('id', $employeeId);
                });
            })->orWhereHas('operationDoctorAssistant', function ($query) use ($employeeId) {
                $query->whereHas('employee', function ($query) use ($employeeId) {
                    $query->where('id', $employeeId);
                });
            })->where(function ($query) use ($startDate, $endDate) {
                $query->where('created_at', '>=', $startDate)
                    ->where('created_at', '<=', $endDate);
            })->where('paid', 1)->where('status', 3)->get();

            foreach ($dataOperation as $do) {
                $operation += $do->totalServiceNursing();
            }

            $dataLab = LabRequest::whereHas('user', function ($query) use ($employeeId) {
                $query->whereHas('employee', function ($query) use ($employeeId) {
                    $query->where('id', $employeeId);
                });
            })->where(function ($query) use ($startDate, $endDate) {
                $query->where('created_at', '>=', $startDate)
                    ->where('created_at', '<=', $endDate);
            })->where('paid', 1)->where('status', 3)->get();

            foreach ($dataLab as $dl) {
                $lab += $dl->labRequestDetail->sum('service');
            }

            $dataRadiology = RadiologyRequest::whereHas('user', function ($query) use ($employeeId) {
                $query->whereHas('employee', function ($query) use ($employeeId) {
                    $query->where('id', $employeeId);
                });
            })->where(function ($query) use ($startDate, $endDate) {
                $query->where('created_at', '>=', $startDate)
                    ->where('created_at', '<=', $endDate);
            })->where('paid', 1)->where('status', 3)->get();

            foreach ($dataRadiology as $dr) {
                $radiology += $dr->service;
            }

            $outpatientAction = OutpatientNursing::whereHas('user', function ($query) use ($employeeId) {
                $query->whereHas('employee', function ($query) use ($employeeId) {
                    $query->where('id', $employeeId);
                });
            })->get();

            foreach ($outpatientAction as $oa) {
                $totalNursing = OutpatientNursing::selectRaw('COUNT(DISTINCT(user_id)) as total')
                    ->where('outpatient_id', $oa->outpatient_id)
                    ->first();

                $fee = $oa->service / ($totalNursing->total == 0 ? 1 : $totalNursing->total);
                $action += ceil($fee);
            }

            $inpatientAction = InpatientNursing::whereHas('user', function ($query) use ($employeeId) {
                $query->whereHas('employee', function ($query) use ($employeeId) {
                    $query->where('id', $employeeId);
                });
            })->where(function ($query) use ($startDate, $endDate) {
                $query->where('created_at', '>=', $startDate)
                    ->where('created_at', '<=', $endDate);
            })->get();

            foreach ($inpatientAction as $in) {
                $totalNursing = InpatientNursing::selectRaw('COUNT(DISTINCT(user_id)) as total')
                    ->where('inpatient_id', $in->inpatient_id)
                    ->first();

                $fee = $in->service / ($totalNursing->total == 0 ? 1 : $totalNursing->total);
                $action += ceil($fee);
            }

            $emergencyDepartmentAction = EmergencyDepartmentNursing::whereHas('user', function ($query) use ($employeeId) {
                $query->whereHas('employee', function ($query) use ($employeeId) {
                    $query->where('id', $employeeId);
                });
            })->where(function ($query) use ($startDate, $endDate) {
                $query->where('created_at', '>=', $startDate)
                    ->where('created_at', '<=', $endDate);
            })->get();

            foreach ($emergencyDepartmentAction as $edn) {
                $totalNursing = EmergencyDepartmentNursing::selectRaw('COUNT(DISTINCT(user_id)) as total')
                    ->where('emergency_department_id', $edn->emergency_department_id)
                    ->first();

                $fee = $edn->service / ($totalNursing->total == 0 ? 1 : $totalNursing->total);
                $action += ceil($fee);
            }

            $contentable = true;
        }

        $data = [
            'token' => $request->_token,
            'contentable' => $contentable,
            'employee' => $employee,
            'operation' => $operation,
            'lab' => $lab,
            'radiology' => $radiology,
            'action' => $action,
            'employeeId' => $employeeId,
            'date' => $date,
            'content' => 'report.service.nursing'
        ];

        return view('layouts.index', ['data' => $data]);
    }
}
