<?php

namespace App\Http\Controllers\Dispensary;

use Illuminate\Http\Request;
use App\Models\DispensaryRequest;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class RequestController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'dispensary.request'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = DispensaryRequest::groupBy('dispensary_requestable_type', 'dispensary_requestable_id', 'dispensary_id');

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
                        ->orWhereHas('dispensary', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }
            })
            ->addColumn('statusable', function (DispensaryRequest $query) {
                return $query->statusable(true);
            })
            ->addColumn('employee_name', function (DispensaryRequest $query) {
                $employeeName = $query->user->employee->name ?? 'Belum Ada';

                return $employeeName;
            })
            ->addColumn('dispensary_name', function (DispensaryRequest $query) {
                $dispensaryName = $query->dispensary->name ?? 'Belum Ada';

                return $dispensaryName;
            })
            ->addColumn('patient_name', function (DispensaryRequest $query) {
                $patientName = $query->patient->name ?? null;

                return $patientName;
            })
            ->addColumn('ref', function (DispensaryRequest $query) {
                return $query->ref();
            })
            ->addColumn('action', function (DispensaryRequest $query) {
                return '
                    <a href="' . url('dispensary/request/detail/' . $query->id) . '" class="btn btn-primary btn-sm">
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
        $dispensaryRequestItem = DispensaryRequest::with('dispensaryItemStock')
            ->where('dispensary_requestable_type', $dispensaryRequest->dispensary_requestable_type)
            ->where('dispensary_requestable_id', $dispensaryRequest->dispensary_requestable_id)
            ->where('dispensary_id', $dispensaryRequest->dispensary_id)
            ->get();

        if ($request->ajax()) {
            try {
                foreach ($request->id as $key => $i) {
                    $status = isset($request->status[$key]) ? $request->status[$key] : null;
                    $dispensaryRequest = DispensaryRequest::find($i);

                    if (!empty($status)) {
                        $dispensaryRequest->update(['status' => $status]);

                        if ($status == 4) {
                            $dispensaryRequest->dispensaryItemStock->replicate()->fill([
                                'type' => 2,
                                'qty' => $dispensaryRequest->qty
                            ])->save();
                        }
                    }
                }

                $response = [
                    'code' => 200,
                    'message' => 'Data permintaan berhasil disubmit'
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
            'content' => 'dispensary.request-detail'
        ];

        return view('layouts.index', ['data' => $data]);
    }
}
