<?php

namespace App\Http\Controllers\Report\Lab;

use Carbon\Carbon;
use App\Helpers\Simrs;
use App\Models\Doctor;
use App\Models\LabRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class DataController extends Controller
{
    public function index()
    {
        $data = [
            'doctor' => Doctor::all(),
            'content' => 'report.lab.data'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = LabRequest::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search, $request) {
                if ($search) {
                    $query->whereHas('patient', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });

                    $query->orWhereHas('doctor', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });

                    $query->orWhereHas('labRequestable', function ($query) use ($search) {
                        $query->whereRaw("LPAD(id, 7, 0) LIKE '%$search%'");
                    });
                }

                if ($request->patient_id) {
                    $query->where('patient_id', $request->patient_id);
                }

                if ($request->doctor_id) {
                    $query->where('doctor_id', $request->doctor_id);
                }

                if ($request->ref) {
                    $query->where('lab_requestable_type', $request->ref);
                }

                if ($request->date) {
                    $explodeDate = explode(' - ', $request->date);
                    $startDate = Carbon::parse($explodeDate[0])->format('Y-m-d');
                    $endDate = Carbon::parse($explodeDate[1])->format('Y-m-d');

                    $query->whereDate($request->column_date, '>=', $startDate)->whereDate($request->column_date, '<=', $endDate);
                }

                if (!is_null($request->paid)) {
                    $query->where('paid', $request->paid);
                }

                if ($request->status) {
                    $query->where('status', $request->status);
                }
            })
            ->addColumn('patient_name', function (LabRequest $query) {
                $patientName = $query->patient->name ?? null;

                return $patientName;
            })
            ->addColumn('doctor_name', function (LabRequest $query) {
                $doctorName = $query->doctor->name ?? null;

                return $doctorName;
            })
            ->addColumn('date', function (LabRequest $query) use ($request) {
                $toArray = $query->toArray();
                $date = $query->created_at->format('Y-m-d');

                if ($request->date) {
                    $date = date('Y-m-d', strtotime($toArray[$request->column_date]));
                }

                return $date;
            })
            ->addColumn('nominal', function (LabRequest $query) {
                return Simrs::formatRupiah($query->total());
            })
            ->addColumn('ref', function (LabRequest $query) {
                return $query->ref() . ' | ' . $query->labRequestable->code();
            })
            ->addColumn('paid', function (LabRequest $query) {
                return $query->paid();
            })
            ->addColumn('status', function (LabRequest $query) {
                return $query->status();
            })
            ->addColumn('action', function (LabRequest $query) {
                return '
                    <button type="button" class="btn btn-primary btn-sm" onclick="detail(' . $query->id . ')">
                        <i class="ph-info me-1"></i>
                        Detail
                    </button>
                ';
            })
            ->rawColumns(['action', 'paid', 'status'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function detail(Request $request)
    {
        $id = $request->id;
        $labRequest = LabRequest::find($id);
        $response = [];

        foreach ($labRequest->labRequestDetail as $lrd) {
            $normal = '-';
            $status = 'Tidak ada pembatas';

            if (isset($lrd->labItemParent)) {
                if ($lrd->labItemParent->limit_lower && $lrd->labItemParent->limit_upper) {
                    $normal = $lrd->labItemParent->limit_lower . ' - ' . $lrd->labItemParent->limit_upper;
                } elseif ($lrd->labItemParent->limit_upper) {
                    $normal = $lrd->labItemParent->limit_upper;
                } elseif ($lrd->labItemParent->limit_lower) {
                    $normal = $lrd->labItemParent->limit_lower;
                }
            }

            if ($lrd->labItemParent) {
                if (!empty($lrd->result)) {
                    if (!empty($lrd->labItemParent->limit_lower) && !empty($lrd->result <= $lrd->labItemParent->limit_upper)) {
                        if ($lrd->result >= $lrd->labItemParent->limit_lower && $lrd->result <= $lrd->labItemParent->limit_upper) {
                            $status = 'Normal';
                        } else {
                            $status = 'Danger';
                        }
                    } elseif ((!empty($lrd->labItemParent->limit_lower) && empty($lrd->labItemParent->limit_upper))) {
                        if ($lrd->result >= $lrd->labItemParent->limit_lower && $lrd->result <= $lrd->labItemParent->limit_lower) {
                            $status = 'Normal';
                        } else {
                            $status = 'Danger';
                        }
                    } elseif ((!empty($lrd->labItemParent->limit_upper) && empty($lrd->labItemParent->limit_lower))) {
                        if ($lrd->result >= $lrd->labItemParent->limit_upper && $lrd->result <= $lrd->labItemParent->limit_upper) {
                            $status = 'Normal';
                        } else {
                            $status = 'Danger';
                        }
                    }
                }
            }

            $response[] = [
                'group' => $lrd->labItem->labItemGroup->name ?? '-',
                'item' => $lrd->labItem->name ?? '-',
                'result' => $lrd->result,
                'normal' => $normal,
                'unit' => $lrd->labItemParent->unit ?? '-',
                'condition' => $lrd->labItemCondition->name ?? '-',
                'method' => $lrd->labItemParent->method ?? '-',
                'status' => $status
            ];
        }

        $total = [
            'consumables' => Simrs::formatRupiah($labRequest->labRequestDetail->sum('consumables')),
            'hospital_service' => Simrs::formatRupiah($labRequest->labRequestDetail->sum('hospital_service')),
            'service' => Simrs::formatRupiah($labRequest->labRequestDetail->sum('service')),
            'total' => Simrs::formatRupiah($labRequest->total())
        ];

        return response()->json([
            'data' => $response,
            'total' => $total
        ]);
    }
}
