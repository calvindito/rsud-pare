<?php

namespace App\Http\Controllers\MasterData\General;

use App\Models\City;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        $data = [
            'city' => City::all(),
            'content' => 'master-data.general.employee'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Employee::latest('id');

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('code', 'like', "%$search%")
                        ->orWhere('name', 'like', "%$search%")
                        ->orWhere('address', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                }
            })
            ->editColumn('status', function (Employee $query) {
                return $query->status();
            })
            ->addColumn('action', function (Employee $query) {
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
            'name' => 'required',
            'postal_code' => 'nullable|digits:5|numeric',
            'phone' => 'nullable|digits_between:8,13|numeric',
            'cellphone' => 'nullable|digits_between:8,13|numeric',
            'email' => 'nullable|email'
        ], [
            'name.required' => 'nama tidak boleh kosong',
            'postal_code.digits' => 'kode pos harus 5 karakter',
            'postal_code.numeric' => 'kode pos harus angka',
            'phone.digits_between' => 'no telp min 8 dan maks 13 karakter',
            'phone.numeric' => 'no telp harus angka',
            'cellphone.digits_between' => 'no hp min 8 dan maks 13 karakter',
            'cellphone.numeric' => 'no hp harus angka',
            'email.email' => 'email tidak valid'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = Employee::create([
                    'city_id' => $request->city_id,
                    'name' => $request->name,
                    'address' => $request->address,
                    'postal_code' => $request->postal_code,
                    'phone' => $request->phone,
                    'cellphone' => $request->cellphone,
                    'email' => $request->email,
                    'marital_status' => $request->marital_status
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
        $data = Employee::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'postal_code' => 'nullable|digits:5|numeric',
            'phone' => 'nullable|digits_between:8,13|numeric',
            'cellphone' => 'nullable|digits_between:8,13|numeric',
            'email' => 'nullable|email'
        ], [
            'name.required' => 'nama tidak boleh kosong',
            'postal_code.digits' => 'kode pos harus 5 karakter',
            'postal_code.numeric' => 'kode pos harus angka',
            'phone.digits_between' => 'no telp min 8 dan maks 13 karakter',
            'phone.numeric' => 'no telp harus angka',
            'cellphone.digits_between' => 'no hp min 8 dan maks 13 karakter',
            'cellphone.numeric' => 'no hp harus angka',
            'email.email' => 'email tidak valid'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = Employee::findOrFail($id)->update([
                    'city_id' => $request->city_id,
                    'name' => $request->name,
                    'address' => $request->address,
                    'postal_code' => $request->postal_code,
                    'phone' => $request->phone,
                    'cellphone' => $request->cellphone,
                    'email' => $request->email,
                    'marital_status' => $request->marital_status,
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
            Employee::destroy($id);

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
