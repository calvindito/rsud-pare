<?php

namespace App\Http\Controllers\Pharmacy;

use App\Models\City;
use App\Models\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class FactoryController extends Controller
{
    public function index()
    {
        $data = [
            'city' => City::all(),
            'content' => 'pharmacy.factory'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Factory::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('address', 'like', "%$search%")
                        ->whereHas('city', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }
            })
            ->addColumn('city_name', function (Factory $query) {
                $cityName = null;

                if (isset($query->city)) {
                    $cityName = $query->city->name;
                }

                return $cityName;
            })
            ->addColumn('action', function (Factory $query) {
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
            ->rawColumns(['action', 'distributor_name'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function createData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'city_id' => 'required',
            'name' => 'required',
            'phone' => 'required|digits_between:8,13|numeric',
            'email' => 'required|email',
            'address' => 'required'
        ], [
            'city_id.required' => 'mohon memilih kota',
            'name.required' => 'nama tidak boleh kosong',
            'phone.required' => 'no telp tidak boleh kosong',
            'phone.digits_between' => 'no telp min 8 dan maks 13 karakter',
            'phone.numeric' => 'no telp harus angka',
            'email.required' => 'email tidak boleh kosong',
            'email.email' => 'email tidak valid',
            'address.required' => 'alamat tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = Factory::create([
                    'city_id' => $request->city_id,
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'address' => $request->address
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
        $data = Factory::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'city_id' => 'required',
            'name' => 'required',
            'phone' => 'required|digits_between:8,13|numeric',
            'email' => 'required|email',
            'address' => 'required'
        ], [
            'city_id.required' => 'mohon memilih kota',
            'name.required' => 'nama tidak boleh kosong',
            'phone.required' => 'no telp tidak boleh kosong',
            'phone.digits_between' => 'no telp min 8 dan maks 13 karakter',
            'phone.numeric' => 'no telp harus angka',
            'email.required' => 'email tidak boleh kosong',
            'email.email' => 'email tidak valid',
            'address.required' => 'alamat tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                Factory::findOrFail($id)->update([
                    'city_id' => $request->city_id,
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'address' => $request->address
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
            Factory::destroy($id);

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
