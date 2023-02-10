<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\RadiologyRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class RadiologyController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'radiology'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = RadiologyRequest::query();

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
                        })
                        ->orWhereHas('radiology', function ($query) use ($search) {
                            $query->where('type', 'like', "%$search%")
                                ->orWhere('object', 'like', "%$search%")
                                ->orWhere('projection', 'like', "%$search%");
                        });
                }
            })
            ->addColumn('status', function (RadiologyRequest $query) {
                return $query->status();
            })
            ->addColumn('employee_name', function (RadiologyRequest $query) {
                $employeeName = 'Belum Ada';

                if (isset($query->user->employee)) {
                    $employeeName = $query->user->employee->name;
                }

                return $employeeName;
            })
            ->addColumn('patient_name', function (RadiologyRequest $query) {
                $patientName = null;

                if (isset($query->patient)) {
                    $patientName = $query->patient->name;
                }

                return $patientName;
            })
            ->addColumn('doctor_name', function (RadiologyRequest $query) {
                $doctorName = 'Tidak Ada';

                if (isset($query->doctor)) {
                    $doctorName = $query->doctor->name;
                }

                return $doctorName;
            })
            ->addColumn('ref', function (RadiologyRequest $query) {
                return $query->ref();
            })
            ->addColumn('radiology_action', function (RadiologyRequest $query) {
                return $query->radiology->type . ' - ' . $query->radiology->object . ' - ' . $query->radiology->projection;
            })
            ->addColumn('action', function (RadiologyRequest $query) {
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
                    <a href="' . url('radiology/process/' . $query->id) . '" class="btn ' . $colorBtn . ' btn-sm">
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
        $radiologyRequest = RadiologyRequest::findOrFail($id);

        if ($request->ajax()) {
            $requiredImage = $radiologyRequest->image ? 'nullable' : 'required';
            $validation = Validator::make($request->all(), [
                'image' => $requiredImage . '|mimes:png,jpg,jpeg|image',
                'clinical' => 'required',
                'critical' => 'required',
                'expertise' => 'required'
            ], [
                'image.required' => 'foto tidak boleh kosong',
                'image.mimes' => 'ekstensi foto yang diperbolehkan hanya png, jpg, jpeg',
                'image.image' => 'foto tidak valid',
                'clinical.required' => 'klinis tidak boleh kosong',
                'critical.required' => 'mohon memilih kritis',
                'expertise.required' => 'expertise tidak boleh kosong'
            ]);

            if ($validation->fails()) {
                $response = [
                    'code' => 400,
                    'error' => $validation->errors()->all(),
                ];
            } else {
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

                    DB::transaction(function () use ($request, $radiologyRequest, $status) {
                        $image = $radiologyRequest->image;

                        if ($request->hasFile('image')) {
                            if (Storage::exists($image)) {
                                Storage::delete($image);
                            }

                            $image = $request->file('image')->store('public/radiology');
                        }

                        $radiologyRequest->update([
                            'user_id' => auth()->id(),
                            'image' => $image,
                            'clinical' => $request->clinical,
                            'critical' => $request->critical,
                            'expertise' => $request->expertise,
                            'status' => $status,
                        ]);
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
            }

            return response()->json($response);
        }

        if (in_array($radiologyRequest->status, [1, 2])) {
            $radiologyRequest->update(['user_id' => auth()->id(), 'status' => 2]);
        }

        $data = [
            'radiologyRequest' => $radiologyRequest,
            'patient' => $radiologyRequest->patient,
            'content' => 'radiology-process'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function print(Request $request, $id)
    {
        $data = RadiologyRequest::where('status', 3)->where('id', $id)->firstOrFail();

        if ($request->has('slug')) {
            if ($request->slug == 'result') {
                $view = 'pdf.radiology-result';
                $title = 'Hasil Pemeriksaan Radiologi';
            } else if ($request->slug == 'introduction') {
                $view = 'pdf.radiology-introduction';
                $title = 'Surat Pembayaran Radiologi';
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
