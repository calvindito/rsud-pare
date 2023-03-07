<?php

namespace App\Http\Controllers\Finance;

use App\Helpers\Simrs;
use App\Models\CashBank;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class CashBankController extends Controller
{
    public function index()
    {
        $data = [
            'chartOfAccount' => ChartOfAccount::where('status', true)->orderBy('code')->get(),
            'content' => 'finance.cash-bank'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = CashBank::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('description', 'like', "%$search%")
                        ->whereHas('chartOfAccount', function ($query) use ($search) {
                            $query->where('code', 'like', "%$search%")
                                ->orWhere('name', 'like', "%$search%");
                        })
                        ->whereHas('user', function ($query) use ($search) {
                            $query->whereHas('employee', function ($query) use ($search) {
                                $query->where('name', 'like', "%$search%");
                            });
                        });
                }
            })
            ->editColumn('nominal', '{{ Simrs::formatRupiah($nominal) }}')
            ->addColumn('chart_of_account_code', function (CashBank $query) {
                $chartOfAccountCode = $query->chartOfAccount->code ?? null;

                return $chartOfAccountCode;
            })
            ->addColumn('chart_of_account_name', function (CashBank $query) {
                $chartOfAccountName = $query->chartOfAccount->name ?? null;

                return $chartOfAccountName;
            })
            ->addColumn('employee_name', function (CashBank $query) {
                $employeeName = $query->user->employee->name ?? null;

                return $employeeName;
            })
            ->addColumn('action', function (CashBank $query) {
                return '
                    <div class="btn-group">
                        <button type="button" class="btn btn-light text-primary btn-sm fw-semibold dropdown-toggle" data-bs-toggle="dropdown">Aksi</button>
                        <div class="dropdown-menu">
                            <a href="javascript:void(0);" class="dropdown-item fs-13" onclick="showDataUpdate(' . $query->id . ')">
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
            })
            ->rawColumns(['action', 'status'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function createData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'chart_of_account_id' => 'required',
            'nominal' => 'required|numeric',
            'date' => 'required'
        ], [
            'chart_of_account_id.required' => 'mohon memilih bagan akun',
            'nominal.required' => 'nominal tidak boleh kosong',
            'nominal.numeric' => 'nominal harus angka yang valid',
            'date.required' => 'tanggal tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = CashBank::create([
                    'chart_of_account_id' => $request->chart_of_account_id,
                    'user_id' => auth()->id(),
                    'nominal' => $request->nominal,
                    'date' => $request->date,
                    'type' => $request->type,
                    'description' => $request->description
                ]);

                $response = [
                    'code' => 200,
                    'message' => 'Data telah ditambahkan'
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

    public function showData(Request $request)
    {
        $id = $request->id;
        $data = CashBank::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'chart_of_account_id' => 'required',
            'nominal' => 'required|numeric',
            'date' => 'required'
        ], [
            'chart_of_account_id.required' => 'mohon memilih bagan akun',
            'nominal.required' => 'nominal tidak boleh kosong',
            'nominal.numeric' => 'nominal harus angka yang valid',
            'date.required' => 'tanggal tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = CashBank::findOrFail($id)->update([
                    'chart_of_account_id' => $request->chart_of_account_id,
                    'user_id' => auth()->id(),
                    'nominal' => $request->nominal,
                    'date' => $request->date,
                    'type' => $request->type,
                    'description' => $request->description
                ]);

                $response = [
                    'code' => 200,
                    'message' => 'Data telah diubah'
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

    public function destroyData(Request $request)
    {
        $id = $request->id;

        try {
            CashBank::destroy($id);

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
