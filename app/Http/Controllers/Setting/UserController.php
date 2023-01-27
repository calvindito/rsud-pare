<?php

namespace App\Http\Controllers\Setting;

use App\Models\Role;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'employee' => Employee::where('status', true)->get(),
            'role' => Role::all(),
            'content' => 'setting.user'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = User::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('username', 'like', "%$search%")
                        ->orWhereHas('employee', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('role', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }
            })
            ->editColumn('status', function (User $query) {
                return $query->status();
            })
            ->addColumn('employee_name', function (User $query) {
                $employeeName = null;

                if (isset($query->employee)) {
                    $employeeName = $query->employee->name;
                }

                return $employeeName;
            })
            ->addColumn('role_name', function (User $query) {
                $roleName = null;

                if (isset($query->role)) {
                    $roleName = $query->role->name;
                }

                return $roleName;
            })
            ->addColumn('action', function (User $query) {
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
            'username' => 'required|unique:users,username',
            'employee_id' => 'required'
        ], [
            'username.required' => 'username tidak boleh kosong',
            'username.unique' => 'username telah digunakan',
            'employee_id.required' => 'mohon memilih pegawai'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $password = 'simrskk' . date('dmY');
                $createData = User::create([
                    'employee_id' => $request->employee_id,
                    'role_id' => $request->role_id,
                    'username' => $request->username,
                    'password' => bcrypt($password)
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
        $data = User::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'username' => 'required|unique:users,username,' . $id,
            'employee_id' => 'required'
        ], [
            'username.required' => 'username tidak boleh kosong',
            'username.unique' => 'username telah digunakan',
            'employee_id.required' => 'mohon memilih pegawai'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = User::findOrFail($id)->update([
                    'employee_id' => $request->employee_id,
                    'role_id' => $request->role_id,
                    'username' => $request->username,
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
            User::destroy($id);

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
