<?php

namespace App\Http\Controllers\MasterData\General;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'master-data.general.doctor'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $data = Doctor::orderByDesc('id');
        $search = $request->search['value'];

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "%$search%")
                        ->orWhere('calling', 'like', "%$search%")
                        ->orWhere('address', 'like', "%$search%");
                }
            })
            ->editColumn('percentage', '{{ $percentage }}%')
            ->editColumn('type', function (Doctor $query) {
                return $query->type();
            })
            ->addColumn('action', function (Doctor $query) {
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
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function createData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'calling' => 'required',
            'type' => 'required',
            'percentage' => 'required',
            'phone' => 'required|digits_between:8,13|numeric',
            'address' => 'required'
        ], [
            'name.required' => 'nama dokter tidak boleh kosong',
            'calling.required' => 'nama panggilan tidak boleh kosong',
            'type.required' => 'mohon memilih jenis dokter',
            'percentage.required' => 'persentase jasa tidak boleh kosong',
            'phone.required' => 'no telp tidak boleh kosong',
            'phone.digits_between' => 'no telp min 8 dan maks 13 karakter',
            'phone.numeric' => 'no telp harus angka',
            'address.required' => 'alamat praktek tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = Doctor::create([
                    'name' => $request->name,
                    'calling' => $request->calling,
                    'type' => $request->type,
                    'percentage' => $request->percentage,
                    'address' => $request->address,
                    'phone' => $request->phone
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
        $data = Doctor::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'calling' => 'required',
            'type' => 'required',
            'percentage' => 'required',
            'phone' => 'required|digits_between:8,13|numeric',
            'address' => 'required'
        ], [
            'name.required' => 'nama dokter tidak boleh kosong',
            'calling.required' => 'nama panggilan tidak boleh kosong',
            'type.required' => 'mohon memilih jenis dokter',
            'percentage.required' => 'persentase jasa tidak boleh kosong',
            'phone.required' => 'no telp tidak boleh kosong',
            'phone.digits_between' => 'no telp min 8 dan maks 13 karakter',
            'phone.numeric' => 'no telp harus angka',
            'address.required' => 'alamat praktek tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = Doctor::findOrFail($id)->update([
                    'name' => $request->name,
                    'calling' => $request->calling,
                    'type' => $request->type,
                    'percentage' => $request->percentage,
                    'address' => $request->address,
                    'phone' => $request->phone
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
            Doctor::destroy($id);

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
