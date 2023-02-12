<?php

namespace App\Http\Controllers;

use App\Models\LabRequest;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\LabItemCondition;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class LabController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'lab'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = LabRequest::query();

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
            ->addColumn('status', function (LabRequest $query) {
                return $query->status();
            })
            ->addColumn('employee_name', function (LabRequest $query) {
                $employeeName = 'Belum Ada';

                if (isset($query->user->employee)) {
                    $employeeName = $query->user->employee->name;
                }

                return $employeeName;
            })
            ->addColumn('patient_name', function (LabRequest $query) {
                $patientName = null;

                if (isset($query->patient)) {
                    $patientName = $query->patient->name;
                }

                return $patientName;
            })
            ->addColumn('doctor_name', function (LabRequest $query) {
                $doctorName = 'Tidak Ada';

                if (isset($query->doctor)) {
                    $doctorName = $query->doctor->name;
                }

                return $doctorName;
            })
            ->addColumn('ref', function (LabRequest $query) {
                return $query->ref();
            })
            ->addColumn('action', function (LabRequest $query) {
                if (in_array($query->status, [1, 2])) {
                    $icon = 'ph-scales';
                    $text = 'Proses Sekarang';
                    $colorBtn = 'btn-primary';
                } else {
                    $icon = 'ph-check-circle';
                    $text = 'Selesai Diproses';
                    $colorBtn = 'btn-success';
                }

                return '
                    <a href="' . url('lab/process/' . $query->id) . '" class="btn ' . $colorBtn . ' btn-sm">
                        <i class="' . $icon . ' me-2"></i>
                        ' . $text . '
                    </a>
                ';
            })
            ->rawColumns(['action', 'status'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function process(Request $request, $id)
    {
        $labRequest = LabRequest::findOrFail($id);

        if ($request->ajax()) {
            try {
                if ($request->submit == 'reject') {
                    $status = 4;
                    $notif = 'Permintaan berhasil ditolak';
                } else if ($request->submit == 'keep') {
                    $status = 2;
                    $notif = 'Permintaan berhasil disimpan';
                } else if ($request->submit == 'done') {
                    $status = 3;
                    $notif = 'Permintaan berhasil diselesaikan';
                } else {
                    $status = 1;
                    $notif = null;
                }

                DB::transaction(function () use ($request, $labRequest, $status) {
                    foreach ($request->lab_request_detail_id as $key => $lrdi) {
                        $labRequest->labRequestDetail()->find($lrdi)->update([
                            'lab_item_condition_id' => $request->lrd_lab_item_condition_id[$key],
                            'result' => $request->lrd_result[$key]
                        ]);
                    }

                    $labRequest->update(['user_id' => auth()->id(), 'status' => $status]);
                });

                $response = [
                    'code' => 200,
                    'message' => $notif
                ];
            } catch (\Exception $e) {
                $response = [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ];
            }

            return response()->json($response);
        }

        if (in_array($labRequest->status, [1, 2])) {
            $labRequest->update(['user_id' => auth()->id(), 'status' => 2]);
        }

        $data = [
            'labRequest' => $labRequest,
            'labRequestDetail' => $labRequest->labRequestDetail,
            'patient' => $labRequest->patient,
            'labItemCondition' => LabItemCondition::all(),
            'content' => 'lab-process'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function print(Request $request, $id)
    {
        $data = LabRequest::where('status', 3)->findOrFail($id);

        if ($request->has('slug')) {
            if ($request->slug == 'result') {
                $view = 'pdf.lab-result';
                $title = 'Hasil Laboratorium';
            } else if ($request->slug == 'detail') {
                $view = 'pdf.lab-detail';
                $title = 'Rincian Biaya Hasil Cek Laboratorium';
            } else {
                abort(404);
            }

            $pdf = Pdf::setOptions([
                'adminUsername' => auth()->user()->username
            ])->loadView($view, [
                'title' => $title,
                'data' => $data
            ]);

            return $pdf->stream($title . ' - ' . date('YmdHis') . '.pdf');
        }

        abort(404);
    }
}
