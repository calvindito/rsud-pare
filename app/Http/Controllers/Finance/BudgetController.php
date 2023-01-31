<?php

namespace App\Http\Controllers\Finance;

use App\Models\Budget;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class BudgetController extends Controller
{
    public function index()
    {
        $data = [
            'chartOfAccount' => ChartOfAccount::where('status', true)->orderBy('code')->get(),
            'content' => 'finance.budget'
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
                    $query->where('description', 'like', "%$search%")
                        ->whereHas('chartOfAccount', function ($query) use ($search) {
                            $query->where('code', 'like', "%$search%")
                                ->orWhere('name', 'like', "%$search%");
                        });
                }
            })
            ->editColumn('status', function (Budget $query) {
                return $query->status();
            })
            ->addColumn('chart_of_account_name', function (Budget $query) {
                $chartOfAccountName = null;

                if (isset($query->chartOfAccount->name)) {
                    $code = $query->chartOfAccount->code;
                    $name = $query->chartOfAccount->name;

                    $chartOfAccountName = "$code&nbsp;&nbsp;$name";
                }

                return $chartOfAccountName;
            })
            ->addColumn('action', function (Budget $query) {
                if ($query->status == 1 || $query->status == 3) {
                    $action = '
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
                } else {
                    $action = '<button type="button" class="btn btn-light text-primary btn-sm fw-semibold" disabled>Tidak Ada Aksi</button>';
                }

                return $action;
            })
            ->rawColumns(['action', 'status', 'chart_of_account_name'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function createData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'chart_of_account_id' => 'required',
            'nominal' => 'required|numeric',
            'limit_blud' => 'required|numeric',
            'date' => 'required'
        ], [
            'chart_of_account_id.required' => 'mohon memilih bagan akun',
            'nominal.required' => 'nominal tidak boleh kosong',
            'nominal.numeric' => 'nominal harus angka yang valid',
            'limit_blud.required' => 'batas blud tidak boleh kosong',
            'limit_blud.required' => 'batas blud harus angka yang valid',
            'date.required' => 'tanggal tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = Budget::create([
                    'chart_of_account_id' => $request->chart_of_account_id,
                    'nominal' => $request->nominal,
                    'limit_blud' => $request->limit_blud,
                    'date' => $request->date,
                    'description' => $request->description,
                    'status' => $request->status
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
        $data = Budget::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'chart_of_account_id' => 'required',
            'nominal' => 'required|numeric',
            'limit_blud' => 'required|numeric',
            'date' => 'required'
        ], [
            'chart_of_account_id.required' => 'mohon memilih bagan akun',
            'nominal.required' => 'nominal tidak boleh kosong',
            'nominal.numeric' => 'nominal harus angka yang valid',
            'limit_blud.required' => 'batas blud tidak boleh kosong',
            'limit_blud.required' => 'batas blud harus angka yang valid',
            'date.required' => 'tanggal tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = Budget::findOrFail($id)->update([
                    'chart_of_account_id' => $request->chart_of_account_id,
                    'nominal' => $request->nominal,
                    'limit_blud' => $request->limit_blud,
                    'date' => $request->date,
                    'description' => $request->description,
                    'status' => $request->status
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
