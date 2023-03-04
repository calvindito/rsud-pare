<?php

namespace App\Http\Controllers\Finance;

use App\Models\Item;
use App\Models\Budget;
use App\Models\Installation;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PlanningController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'finance.planning'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Budget::has('budgetPlanning');

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
                $installationName = '-';

                if (isset($query->installation)) {
                    $installationName = $query->installation->name;
                }

                return $installationName;
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
                                <a href="' . url('finance/planning/update/' . $query->id) . '" class="dropdown-item fs-13">
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
                        <a href="' . url('finance/planning/detail/' . $query->id) . '" class="btn btn-light text-info btn-sm fw-semibold">
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

    public function loadItem(Request $request)
    {
        $installationId = $request->installation_id;
        $itemId = $request->has('item_id') ? $request->item_id : [];
        $search = $request->search;
        $response = [];

        if ($installationId) {
            $response = Item::wherehas('itemStock', function ($query) {
                $query->where('type', 1)->where('price_purchase', '>', 0);
            })->where('installation_id', $installationId)->whereNotIn('id', $itemId)->where('name', 'like', "%$search%")->limit(100)->get()->map(function ($item) {
                return [
                    'id' => $item->id . ';' . $item->name . ';' . $item->newStock->price_purchase . ';' . $item->type_format_result,
                    'text' => $item->name
                ];
            });
        }

        return response()->json($response);
    }

    public function detail($id)
    {
        $data = [
            'budget' => Budget::has('budgetPlanning')->whereIn('status', [2, 4, 5])->findOrFail($id),
            'chartOfAccount' => ChartOfAccount::where('budgetable', true)->where('status', true)->orderBy('code')->get(),
            'content' => 'finance.planning-detail'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function create(Request $request)
    {
        if ($request->ajax()) {
            $validation = Validator::make($request->all(), [
                'status' => 'required',
                'date' => 'required',
                'description' => 'required',
                'chart_of_account_id' => 'required',
                'installation_id' => 'required',
                'bp_item_id' => 'required'
            ], [
                'status.required' => 'mohon memilih status',
                'date.required' => 'tanggal tidak boleh kosong',
                'description.required' => 'keterangan tidak boleh kosong',
                'chart_of_account_id.required' => 'mohon memilih bagan akun',
                'installation_id.required' => 'mohon memilih instalasi',
                'bp_item_id.required' => 'mohon memilih salah satu item'
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
                            'installation_id' => $request->installation_id,
                            'user_id' => auth()->id(),
                            'date' => $request->date,
                            'description' => $request->description,
                            'status' => $request->status
                        ]);

                        if ($createData->status == 2) {
                            $createData->budgetHistory()->create([
                                'user_id' => auth()->id(),
                                'status' => $createData->status_format_result
                            ]);
                        }

                        $nominal = 0;

                        if ($request->has('bp_item_id')) {
                            foreach ($request->bp_item_id as $key => $ii) {
                                $item = Item::find($ii);
                                $qty = isset($request->bp_qty[$key]) ? $request->bp_qty[$key] : null;

                                if ($item && $qty) {
                                    $price = $item->newStock->price_purchase ?? 0;
                                    $nominal += $price * $qty;

                                    $createData->budgetPlanning()->create([
                                        'item_id' => $ii,
                                        'qty' => $qty,
                                        'price' => $price
                                    ]);
                                }
                            }
                        }

                        $createData->budgetDetail()->create([
                            'chart_of_account_id' => $request->chart_of_account_id,
                            'nominal' => $nominal
                        ]);
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
            'installation' => Installation::all(),
            'content' => 'finance.planning-create'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $budget = Budget::has('budgetPlanning')->whereIn('status', [1, 3])->findOrFail($id);

        if ($request->ajax()) {
            $validation = Validator::make($request->all(), [
                'status' => 'required',
                'date' => 'required',
                'description' => 'required',
                'installation_id' => 'required',
                'bp_item_id' => 'required'
            ], [
                'status.required' => 'mohon memilih status',
                'date.required' => 'tanggal tidak boleh kosong',
                'description.required' => 'keterangan tidak boleh kosong',
                'installation_id.required' => 'mohon memilih instalasi',
                'bp_item_id.required' => 'mohon memilih salah satu item'
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
                            'installation_id' => $request->installation_id,
                            'date' => $request->date,
                            'description' => $request->description,
                            'status' => $request->status
                        ]);

                        $budget->refresh();
                        $budget->budgetDetail()->delete();
                        $budget->budgetPlanning()->delete();

                        if ($budget->status == 2) {
                            $budget->budgetHistory()->create([
                                'user_id' => auth()->id(),
                                'status' => $budget->status_format_result
                            ]);
                        }

                        $nominal = 0;

                        if ($request->has('bp_item_id')) {
                            foreach ($request->bp_item_id as $key => $ii) {
                                $item = Item::find($ii);
                                $qty = isset($request->bp_qty[$key]) ? $request->bp_qty[$key] : null;

                                if ($item && $qty) {
                                    $price = $item->newStock->price_purchase ?? 0;
                                    $nominal += $price * $qty;

                                    $budget->budgetPlanning()->create([
                                        'item_id' => $ii,
                                        'qty' => $qty,
                                        'price' => $price
                                    ]);
                                }
                            }
                        }

                        $budget->budgetDetail()->create([
                            'chart_of_account_id' => $request->chart_of_account_id,
                            'nominal' => $nominal
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
            'budget' => $budget,
            'chartOfAccount' => ChartOfAccount::where('budgetable', true)->where('status', true)->orderBy('code')->get(),
            'installation' => Installation::all(),
            'content' => 'finance.planning-update'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function destroyData(Request $request)
    {
        $id = $request->id;

        try {
            Budget::has('budgetPlanning')->destroy($id);

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
