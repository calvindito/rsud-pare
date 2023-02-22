<?php

namespace App\Http\Controllers\Pharmacy;

use Illuminate\Http\Request;
use App\Models\DispensaryRequest;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class RequestController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'pharmacy.request'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = DispensaryRequest::groupBy('dispensary_requestable_type', 'dispensary_requestable_id');

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->whereRaw("LPAD(id, 6, 0) LIKE '%$search%'")
                        ->orWhere('patient_id', 'like', "%$search%")
                        ->orWhereHas('patient', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->whereHas('employee', function ($query) use ($search) {
                                $query->where('name', 'like', "%$search%");
                            });
                        });
                }
            })
            ->addColumn('statusable', function (DispensaryRequest $query) {
                return $query->statusable(true);
            })
            ->addColumn('employee_name', function (DispensaryRequest $query) {
                $employeeName = 'Belum Ada';

                if (isset($query->user->employee)) {
                    $employeeName = $query->user->employee->name;
                }

                return $employeeName;
            })
            ->addColumn('patient_name', function (DispensaryRequest $query) {
                $patientName = null;

                if (isset($query->patient)) {
                    $patientName = $query->patient->name;
                }

                return $patientName;
            })
            ->addColumn('ref', function (DispensaryRequest $query) {
                return $query->ref();
            })
            ->addColumn('action', function (DispensaryRequest $query) {
                return '
                    <a href="' . url('pharmacy/request/detail/' . $query->id) . '" class="btn btn-primary btn-sm">
                        <i class="ph-eye me-2"></i>
                        Lihat Detail
                    </a>
                ';
            })
            ->rawColumns(['action', 'statusable'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function detail(Request $request, $id)
    {
        $dispensaryRequest = DispensaryRequest::findOrFail($id);
        $dispensaryRequestItem = DispensaryRequest::where('dispensary_requestable_type', $dispensaryRequest->dispensary_requestable_type)
            ->where('dispensary_requestable_id', $dispensaryRequest->dispensary_requestable_id)
            ->get();

        if ($request->ajax()) {
            try {
                foreach ($request->id as $key => $i) {
                    $status = isset($request->status[$key]) ? $request->status[$key] : null;

                    if (!empty($status)) {
                        $update = DispensaryRequest::find($i)->update(['status' => $status]);

                        if (in_array($status, [1, 3])) {
                            $update->itemStock()->increment('stock', $update);
                            $update->itemStock()->decrement('sold', $update);
                        } else if ($status == 2) {
                            $update->itemStock()->update(['stock' => 0]);
                        } else {
                            $update->itemStock()->decrement('stock', $update);
                            $update->itemStock()->increment('sold', $update);
                        }
                    }
                }

                $response = [
                    'code' => 200,
                    'message' => 'Data resep berhasil disubmit'
                ];
            } catch (\Exception $e) {
                $response = [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ];
            }

            return response()->json($response);
        }

        $data = [
            'dispensaryRequest' => $dispensaryRequest,
            'patient' => $dispensaryRequest->patient,
            'dispensaryRequestItem' => $dispensaryRequestItem,
            'patient' => $dispensaryRequest->patient,
            'content' => 'pharmacy.request-detail'
        ];

        return view('layouts.index', ['data' => $data]);
    }
}
