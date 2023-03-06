<?php

namespace App\Http\Controllers\Report\MedicalRecord;

use Carbon\Carbon;
use App\Models\Unit;
use App\Helpers\Simrs;
use App\Models\Dispensary;
use App\Models\Outpatient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class OutpatientController extends Controller
{
    public function index()
    {
        $data = [
            'unit' => Unit::where('type', 2)->orderBy('name')->get(),
            'dispensary' => Dispensary::all(),
            'doctor' => Dispensary::all(),
            'type' => Simrs::nursingType(),
            'content' => 'report.medical-record.outpatient'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Outpatient::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search, $request) {
                if ($search) {
                    $query->whereRaw("LPAD(id, 7, 0) LIKE '%$search%'")
                        ->orWhereHas('patient', function ($query) use ($search) {
                            $query->whereRaw("LPAD(id, 7, 0) LIKE '%$search%'");
                        })
                        ->orWhereHas('unit', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('dispensary', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('doctor', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }

                if ($request->patient_id) {
                    $query->where('patient_id', $request->patient_id);
                }

                if ($request->unit_id) {
                    $query->where('unit_id', $request->unit_id);
                }

                if ($request->dispensary_id) {
                    $query->where('dispensary_id', $request->dispensary_id);
                }

                if ($request->doctor_id) {
                    $query->where('doctor_id', $request->doctor_id);
                }

                if ($request->type) {
                    $query->where('type', $request->type);
                }

                if ($request->date) {
                    $explodeDate = explode(' - ', $request->date);
                    $startDate = Carbon::parse($explodeDate[0])->format('Y-m-d');
                    $endDate = Carbon::parse($explodeDate[1])->format('Y-m-d');

                    $query->whereDate($request->column_date, '>=', $startDate)->whereDate($request->column_date, '<=', $endDate);
                }

                if ($request->presence) {
                    $query->where('presence', $request->presence);
                }

                if ($request->status) {
                    $query->where('status', $request->status);
                }
            })
            ->addColumn('code', function (Outpatient $query) {
                return $query->code();
            })
            ->addColumn('patient_name', function (Outpatient $query) {
                $patientName = $query->patient->name ?? null;

                return $patientName;
            })
            ->addColumn('unit_name', function (Outpatient $query) {
                $unitName = $query->unit->name ?? null;

                return $unitName;
            })
            ->addColumn('dispensary_name', function (Outpatient $query) {
                $dispensaryName = $query->dispensary->name ?? null;

                return $dispensaryName;
            })
            ->addColumn('doctor_name', function (Outpatient $query) {
                $doctorName = $query->doctor->name ?? null;

                return $doctorName;
            })
            ->addColumn('date', function (Outpatient $query) use ($request) {
                $toArray = $query->toArray();
                $date = $query->created_at->format('Y-m-d');

                if ($request->date) {
                    $date = date('Y-m-d', strtotime($toArray[$request->column_date]));
                }

                return $date;
            })
            ->addColumn('paid', function (Outpatient $query) {
                return $query->paid();
            })
            ->addColumn('status', function (Outpatient $query) {
                return $query->status();
            })
            ->addColumn('action', function (Outpatient $query) {
                return '
                    <a href="' . url('report/medical-record/outpatient/detail/' . $query->id) . '" class="btn btn-primary btn-sm">
                        <i class="ph-info me-1"></i>
                        Detail
                    </a>
                ';
            })
            ->rawColumns(['action', 'paid', 'status'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function detail($id)
    {
        $outpatient = Outpatient::findOrFail($id);

        $data = [
            'outpatient' => $outpatient,
            'soap' => $outpatient->outpatientSoap(),
            'diagnosis' => $outpatient->outpatientDiagnosis,
            'laboratorium' => $outpatient->labRequest,
            'radiology' => $outpatient->radiologyRequest,
            'operation' => $outpatient->operation,
            'recipe' => $outpatient->dispensaryRequest()->groupBy('dispensary_requestable_type', 'dispensary_requestable_id', 'dispensary_id')->get(),
            'content' => 'report.medical-record.outpatient-detail'
        ];

        return view('layouts.index', ['data' => $data]);
    }
}
