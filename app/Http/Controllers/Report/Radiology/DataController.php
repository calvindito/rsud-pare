<?php

namespace App\Http\Controllers\Report\Radiology;

use Carbon\Carbon;
use App\Helpers\Simrs;
use App\Models\Doctor;
use App\Models\Radiology;
use Illuminate\Http\Request;
use App\Models\RadiologyRequest;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class DataController extends Controller
{
    public function index()
    {
        $data = [
            'doctor' => Doctor::all(),
            'radiology' => Radiology::all(),
            'content' => 'report.radiology.data'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = RadiologyRequest::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search, $request) {
                if ($search) {
                    $query->whereHas('doctor', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });

                    $query->orWhereHas('patient', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });

                    $query->orWhereHas('radiologyRequestable', function ($query) use ($search) {
                        $query->whereRaw("LPAD(id, 7, 0) LIKE '%$search%'");
                    });
                }

                if ($request->doctor_id) {
                    $query->where('doctor_id', $request->doctor_id);
                }

                if ($request->patient_id) {
                    $query->where('patient_id', $request->patient_id);
                }

                if ($request->radiology_id) {
                    $query->where('radiology_id', $request->radiology_id);
                }

                if ($request->ref) {
                    $query->where('radiology_requestable_type', $request->ref);
                }

                if ($request->date) {
                    $explodeDate = explode(' - ', $request->date);
                    $startDate = Carbon::parse($explodeDate[0])->format('Y-m-d');
                    $endDate = Carbon::parse($explodeDate[1])->format('Y-m-d');

                    $query->whereDate($request->column_date, '>=', $startDate)->whereDate($request->column_date, '<=', $endDate);
                }

                if (!is_null($request->critical)) {
                    $query->where('critical', $request->critical);
                }

                if (!is_null($request->paid)) {
                    $query->where('paid', $request->paid);
                }

                if ($request->status) {
                    $query->where('status', $request->status);
                }
            })
            ->addColumn('doctor_name', function (RadiologyRequest $query) {
                $doctorName = $query->doctor->name ?? null;

                return $doctorName;
            })
            ->addColumn('patient_name', function (RadiologyRequest $query) {
                $patientName = $query->patient->name ?? null;

                return $patientName;
            })
            ->addColumn('radiology_name', function (RadiologyRequest $query) {
                $radiologyName = $query->radiology->type . ' - ' . $query->radiology->object . ' - ' . $query->radiology->projection;

                return $radiologyName;
            })
            ->addColumn('date', function (RadiologyRequest $query) use ($request) {
                $toArray = $query->toArray();
                $date = $query->created_at->format('Y-m-d');

                if ($request->date) {
                    $date = date('Y-m-d', strtotime($toArray[$request->column_date]));
                }

                return $date;
            })
            ->addColumn('nominal', function (RadiologyRequest $query) {
                return Simrs::formatRupiah($query->total());
            })
            ->addColumn('ref', function (RadiologyRequest $query) {
                return $query->ref() . ' | ' . $query->radiologyRequestable->code();
            })
            ->addColumn('paid', function (RadiologyRequest $query) {
                return $query->paid();
            })
            ->addColumn('status', function (RadiologyRequest $query) {
                return $query->status();
            })
            ->addColumn('action', function (RadiologyRequest $query) {
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
        $radiologyRequest = RadiologyRequest::find($id);

        return response()->json([
            'doctor' => $radiologyRequest->doctor->name ?? '-',
            'patient' => $radiologyRequest->patient->name ?? '-',
            'radiology' => $radiologyRequest->radiology->type . ' - ' . $radiologyRequest->radiology->object . ' - ' . $radiologyRequest->radiology->projection,
            'ref' => $radiologyRequest->ref(),
            'image' => '<a href="' . $radiologyRequest->image() . '" data-lightbox="Image-' . $id . '">Lihat Hasil Foto</a>',
            'date_of_request' => $radiologyRequest->date_of_request,
            'created_at' => $radiologyRequest->created_at->format('Y-m-d H:i:s'),
            'clinical' => $radiologyRequest->clinical,
            'critical' => $radiologyRequest->critical_format_result,
            'expertise' => $radiologyRequest->expertise,
            'consumables' => Simrs::formatRupiah($radiologyRequest->consumables),
            'hospital_service' => Simrs::formatRupiah($radiologyRequest->hospital_service),
            'service' => Simrs::formatRupiah($radiologyRequest->service),
            'fee' => Simrs::formatRupiah($radiologyRequest->fee),
            'paid' => $radiologyRequest->paid(),
            'status' => $radiologyRequest->status(),
        ]);
    }
}
