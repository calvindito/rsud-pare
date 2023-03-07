<?php

namespace App\Http\Controllers\Finance;

use App\Models\Budget;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class SubmissionController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'finance.submission'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Budget::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->whereRaw("LPAD(id, 6, 0) LIKE '%$search%'")
                        ->orWhere('description', 'like', "%$search%")
                        ->orWhereHas('installation', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->whereHas('employee', function ($query) use ($search) {
                                $query->where('name', 'like', "%$search%");
                            });
                        });
                }
            })
            ->editColumn('code', function (Budget $query) {
                return $query->code();
            })
            ->editColumn('status', function (Budget $query) {
                return $query->status();
            })
            ->addColumn('installation_name', function (Budget $query) {
                $installationName = $query->installation->name ?? '-';

                return $installationName;
            })
            ->addColumn('employee_name', function (Budget $query) {
                $employeeName = $query->user->employee->name ?? null;

                return $employeeName;
            })
            ->addColumn('action', function (Budget $query) {
                return '
                    <a href="' . url('finance/submission/detail/' . $query->id) . '" class="btn btn-light text-info btn-sm fw-semibold">
                        <i class="ph-eye me-2"></i>
                        Lihat Detail
                    </a>
                ';
            })
            ->rawColumns(['action', 'status'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function detail(Request $request, $id)
    {
        $budget = Budget::findOrFail($id);

        if ($request->ajax() && $budget->status == 2) {
            $validation = Validator::make($request->all(), [
                'status' => 'required'
            ], [
                'status.required' => 'mohon memilih status'
            ]);

            if ($validation->fails()) {
                $response = [
                    'code' => 400,
                    'error' => $validation->errors()->all(),
                ];
            } else {
                try {
                    DB::transaction(function () use ($budget, $request) {
                        $budget->update(['status' => $request->status]);
                        $budget->refresh();

                        $budget->budgetHistory()->create([
                            'user_id' => auth()->id(),
                            'status' => $budget->status_format_result,
                            'reason' => $request->reason
                        ]);
                    });

                    $response = [
                        'code' => 200,
                        'message' => 'Data anggaran berhasil diubah'
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

        $data = [
            'budget' => Budget::findOrFail($id),
            'content' => 'finance.submission-detail'
        ];

        return view('layouts.index', ['data' => $data]);
    }
}
