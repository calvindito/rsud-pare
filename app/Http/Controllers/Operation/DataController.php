<?php

namespace App\Http\Controllers\Operation;

use App\Models\Operation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class DataController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'operation.data'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Operation::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('patient_id', 'like', "%$search%")
                        ->orWhereHas('patient', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->whereHas('employee', function ($query) use ($search) {
                                $query->where('name', 'like', "%$search%");
                            });
                        })
                        ->orWhereHas('doctor', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }
            })
            ->addColumn('status', function (Operation $query) {
                return $query->status();
            })
            ->addColumn('employee_name', function (Operation $query) {
                $employeeName = 'Belum Ada';

                if (isset($query->user->employee)) {
                    $employeeName = $query->user->employee->name;
                }

                return $employeeName;
            })
            ->addColumn('patient_name', function (Operation $query) {
                $patientName = null;

                if (isset($query->patient)) {
                    $patientName = $query->patient->name;
                }

                return $patientName;
            })
            ->addColumn('doctor_name', function (Operation $query) {
                $doctorName = 'Tidak Ada';

                if (isset($query->doctor)) {
                    $doctorName = $query->doctor->name;
                }

                return $doctorName;
            })
            ->addColumn('unit_name', function (Operation $query) {
                $unitName = null;

                if (isset($query->unit)) {
                    $unitName = $query->unit->name;
                }

                return $unitName;
            })
            ->addColumn('functional_service_name', function (Operation $query) {
                $functionalServiceName = null;

                if (isset($query->functionalService)) {
                    $functionalServiceName = $query->functionalService->name;
                }

                return $functionalServiceName;
            })
            ->addColumn('ref', function (Operation $query) {
                return $query->ref();
            })
            ->addColumn('action', function (Operation $query) {
                return '';
            })
            ->rawColumns(['action', 'status'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }
}
