<?php

namespace App\Http\Controllers\MasterData\General;

use App\Models\ClassType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ClassTypeController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'master-data.general.class-type'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = ClassType::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('code', 'like', "%$search%")
                        ->orWhere('code_bpjs', 'like', "%$search%")
                        ->orWhere('name', 'like', "%$search%");
                }
            })
            ->editColumn('fee_nursing_care', '{{ number_format($fee_nursing_care, 2) }}')
            ->editColumn('fee_monitoring', '{{ number_format($fee_monitoring, 2) }}')
            ->addColumn('action', function (ClassType $query) {
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
            'code' => 'required|unique:class_types,code',
            'name' => 'required',
            'code_bpjs' => 'required',
            'fee_monitoring' => 'required|numeric',
            'fee_nursing_care' => 'required|numeric'
        ], [
            'code.required' => 'kode kelas tidak boleh kosong',
            'code.unique' => 'kode kelas telah digunakan',
            'name.required' => 'nama kelas tidak boleh kosong',
            'code_bpjs.required' => 'kode bpjs tidak boleh kosong',
            'fee_monitoring.required' => 'biaya rr monitor tidak boleh kosong',
            'fee_monitoring.numeric' => 'biaya rr monitor harus angka yang valid',
            'fee_nursing_care.required' => 'biaya rr askep tidak boleh kosong',
            'fee_nursing_care.numeric' => 'biaya rr askep harus angka yang valid'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = ClassType::create([
                    'code' => $request->code,
                    'code_bpjs' => $request->code_bpjs,
                    'name' => $request->name,
                    'fee_monitoring' => str_replace(',', '', $request->fee_monitoring),
                    'fee_nursing_care' => str_replace(',', '', $request->fee_nursing_care)
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
        $data = ClassType::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'code' => 'required|unique:class_types,code,' . $id,
            'name' => 'required',
            'code_bpjs' => 'required',
            'fee_monitoring' => 'required|numeric',
            'fee_nursing_care' => 'required|numeric'
        ], [
            'code.required' => 'kode kelas tidak boleh kosong',
            'code.unique' => 'kode kelas telah digunakan',
            'name.required' => 'nama kelas tidak boleh kosong',
            'code_bpjs.required' => 'kode bpjs tidak boleh kosong',
            'fee_monitoring.required' => 'biaya rr monitor tidak boleh kosong',
            'fee_monitoring.numeric' => 'biaya rr monitor harus angka yang valid',
            'fee_nursing_care.required' => 'biaya rr askep tidak boleh kosong',
            'fee_nursing_care.numeric' => 'biaya rr askep harus angka yang valid'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = ClassType::findOrFail($id)->update([
                    'code' => $request->code,
                    'code_bpjs' => $request->code_bpjs,
                    'name' => $request->name,
                    'fee_monitoring' => str_replace(',', '', $request->fee_monitoring),
                    'fee_nursing_care' => str_replace(',', '', $request->fee_nursing_care)
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
            ClassType::destroy($id);

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
