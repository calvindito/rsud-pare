<?php

namespace App\Http\Controllers\Collection;

use App\Models\Outpatient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class VisitWindowController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'collection.visit-window'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Outpatient::has('outpatientPoly');

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('description', 'like', "%$search%")
                        ->whereHas('patient', function ($query) use ($search) {
                            $query->where('id', 'like', "%$search%")
                                ->orWhere('name', 'like', "%$search%")
                                ->orWhere('address', 'like', "%$search%")
                                ->orWhere('parent_name', 'like', "%$search%")
                                ->orWhereHas('district', function ($query) use ($search) {
                                    $query->where('name', 'like', "%$search%");
                                });
                        });
                }
            })
            ->addColumn('patient_name', function (Outpatient $query) {
                $patientName = null;

                if (isset($query->patient)) {
                    $patientName = $query->patient->name;
                }

                return $patientName;
            })
            ->addColumn('patient_gender', function (Outpatient $query) {
                $patientGender = null;

                if (isset($query->patient)) {
                    $patientGender = $query->patient->gender_format_result;
                }

                return $patientGender;
            })
            ->addColumn('poly', function (Outpatient $query) {
                $outpatientPoly = '';

                foreach ($query->outpatientPoly as $op) {
                    $outpatientPoly .= '<div>- <small>' . $op->unit->name . ' (' . $op->status() . ')</small></div>';
                }

                return '<button type="button" class="btn btn-light btn-sm" onclick="onPopover(this, ' . "'$outpatientPoly'" . ')">Lihat</button>';
            })
            ->rawColumns(['poly'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }
}
