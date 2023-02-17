<?php

namespace App\Http\Controllers\Pharmacy;

use App\Models\Recipe;
use Illuminate\Http\Request;
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
        $data = Recipe::groupBy('recipeable_type', 'recipeable_id');

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
            ->addColumn('statusable', function (Recipe $query) {
                return $query->statusable(true);
            })
            ->addColumn('employee_name', function (Recipe $query) {
                $employeeName = 'Belum Ada';

                if (isset($query->user->employee)) {
                    $employeeName = $query->user->employee->name;
                }

                return $employeeName;
            })
            ->addColumn('patient_name', function (Recipe $query) {
                $patientName = null;

                if (isset($query->patient)) {
                    $patientName = $query->patient->name;
                }

                return $patientName;
            })
            ->addColumn('ref', function (Recipe $query) {
                return $query->ref();
            })
            ->addColumn('action', function (Recipe $query) {
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
        $recipe = Recipe::findOrFail($id);
        $recipeMedicine = Recipe::where('recipeable_type', $recipe->recipeable_type)->where('recipeable_id', $recipe->recipeable_id)->get();

        if ($request->ajax()) {
            try {
                foreach ($request->id as $key => $i) {
                    $status = isset($request->status[$key]) ? $request->status[$key] : null;
                    Recipe::find($i)->update(['status' => $status]);
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
            'recipe' => $recipe,
            'patient' => $recipe->patient,
            'recipeMedicine' => $recipeMedicine,
            'patient' => $recipe->patient,
            'content' => 'pharmacy.request-detail'
        ];

        return view('layouts.index', ['data' => $data]);
    }
}
