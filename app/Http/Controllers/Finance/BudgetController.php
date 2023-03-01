<?php

namespace App\Http\Controllers\Finance;

use App\Models\Budget;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class BudgetController extends Controller
{
    public function index()
    {
        $data = [
            'chartOfAccount' => ChartOfAccount::with('sub')->whereNull('parent_id')->where('status', true)->orderBy('code')->get(),
            'content' => 'finance.budget'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function settingChartOfAccount(Request $request)
    {
        try {
            ChartOfAccount::query()->update(['budgetable' => false]);

            if ($request->has('budgetable')) {
                foreach ($request->budgetable as $b) {
                    ChartOfAccount::find($b)->update(['budgetable' => true]);
                }
            }

            $response = [
                'code' => 200,
                'message' => 'Pengaturan bagan akun telah disimpan'
            ];
        } catch (\Exception $e) {
            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return response()->json($response);
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
            ->addColumn('employee_name', function (Budget $query) {
                $employeeName = null;

                if (isset($query->user->employee->name)) {
                    $employeeName = $query->user->employee->name;
                }

                return $employeeName;
            })
            ->addColumn('action', function (Budget $query) {
                if (in_array($query->status, [1, 3])) {
                    $action = '
                        <div class="btn-group">
                            <button type="button" class="btn btn-light text-primary btn-sm fw-semibold dropdown-toggle" data-bs-toggle="dropdown">Aksi</button>
                            <div class="dropdown-menu">
                                <a href="' . url('finance/budget/update/' . $query->id) . '" class="dropdown-item fs-13">
                                    <i class="ph-pen me-2"></i>
                                    Ubah Data
                                </a>
                                <a href="javascript:void(0);" class="dropdown-item fs-13" onclick="destroyData(' . $query->id . ')">
                                    <i class="ph-trash-simple me-2"></i>
                                    Hapus Data
                                </a>
                            </div>
                        </div>
                    ';
                } else {
                    $action = '
                        <a href="' . url('finance/budget/detail/' . $query->id) . '" class="btn btn-light text-info btn-sm fw-semibold">
                            <i class="ph-eye me-2"></i>
                            Lihat Detail
                        </a>
                    ';
                }

                return $action;
            })
            ->rawColumns(['action', 'status'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function detail($id)
    {
        $data = [
            'budget' => Budget::whereIn('status', [2, 4, 5])->findOrFail($id),
            'chartOfAccount' => ChartOfAccount::where('budgetable', true)->where('status', true)->orderBy('code')->get(),
            'content' => 'finance.budget-detail'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            $validation = Validator::make($request->all(), [
                'status' => 'required',
                'date' => 'required',
                'description' => 'required'
            ], [
                'status.required' => 'mohon memilih status',
                'date.required' => 'tanggal tidak boleh kosong',
                'description.required' => 'keterangan tidak boleh kosong'
            ]);

            if ($validation->fails()) {
                $response = [
                    'code' => 400,
                    'error' => $validation->errors()->all(),
                ];
            } else {
                try {
                    DB::transaction(function () use ($request) {
                        $createData = Budget::create([
                            'user_id' => auth()->id(),
                            'date' => $request->date,
                            'description' => $request->description,
                            'status' => $request->status
                        ]);

                        if ($request->has('bd_chart_of_account_id')) {
                            foreach ($request->bd_chart_of_account_id as $key => $coai) {
                                $nominal = isset($request->bd_nominal[$key]) ? $request->bd_nominal[$key] : null;
                                $limitBlud = isset($request->bd_limit_blud[$key]) ? $request->bd_limit_blud[$key] : null;

                                $createData->budgetDetail()->create([
                                    'chart_of_account_id' => $coai,
                                    'nominal' => $nominal,
                                    'limit_blud' => $limitBlud
                                ]);
                            }
                        }
                    });

                    $response = [
                        'code' => 200,
                        'message' => 'Data anggaran berhasil dibuat'
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
            'chartOfAccount' => ChartOfAccount::where('budgetable', true)->where('status', true)->orderBy('code')->get(),
            'content' => 'finance.budget-create'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $budget = Budget::whereIn('status', [1, 3])->findOrFail($id);

        if ($request->ajax()) {
            $validation = Validator::make($request->all(), [
                'status' => 'required',
                'date' => 'required',
                'description' => 'required'
            ], [
                'status.required' => 'mohon memilih status',
                'date.required' => 'tanggal tidak boleh kosong',
                'description.required' => 'keterangan tidak boleh kosong'
            ]);

            if ($validation->fails()) {
                $response = [
                    'code' => 400,
                    'error' => $validation->errors()->all(),
                ];
            } else {
                try {
                    DB::transaction(function () use ($budget, $request) {
                        $budget->update([
                            'date' => $request->date,
                            'description' => $request->description,
                            'status' => $request->status
                        ]);

                        $budget->budgetDetail()->delete();

                        if ($request->has('bd_chart_of_account_id')) {
                            foreach ($request->bd_chart_of_account_id as $key => $coai) {
                                $nominal = isset($request->bd_nominal[$key]) ? $request->bd_nominal[$key] : null;
                                $limitBlud = isset($request->bd_limit_blud[$key]) ? $request->bd_limit_blud[$key] : null;

                                $budget->budgetDetail()->create([
                                    'chart_of_account_id' => $coai,
                                    'nominal' => $nominal,
                                    'limit_blud' => $limitBlud
                                ]);
                            }
                        }
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
            'budget' => $budget,
            'chartOfAccount' => ChartOfAccount::where('budgetable', true)->where('status', true)->orderBy('code')->get(),
            'content' => 'finance.budget-update'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function destroyData(Request $request)
    {
        $id = $request->id;

        try {
            Budget::destroy($id);

            $response = [
                'code' => 200,
                'message' => 'Data telah dihapus'
            ];
        } catch (\Exception $e) {
            $response = [
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }

        return response()->json($response);
    }
}
