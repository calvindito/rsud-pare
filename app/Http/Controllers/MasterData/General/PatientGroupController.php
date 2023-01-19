<?php

namespace App\Http\Controllers\MasterData\General;

use App\Models\PatientGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PatientGroupController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'master-data.general.patient-group'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = PatientGroup::latest('id');

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('code', 'like', "%$search%")
                        ->orWhere('name', 'like', "%$search%");
                }
            })
            ->addColumn('action', function (PatientGroup $query) {
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
            'code' => 'required|unique:patient_groups,code',
            'name' => 'required'
        ], [
            'name.required' => 'nama golongan tidak boleh kosong',
            'code.required' => 'kode golongan tidak boleh kosong',
            'code.unique' => 'kode golongan telah digunakan'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = PatientGroup::create([
                    'code' => $request->code,
                    'name' => $request->name,
                    'kpid' => $request->kpid,
                    'initial' => $request->initial,
                    'privilege_class_code' => $request->privilege_class_code,
                    'privilege_class_type' => $request->privilege_class_type,
                    'rule_code' => $request->rule_code,
                    'first_number' => $request->first_number,
                    'contribution_assistance' => $request->contribution_assistance,
                    'car_free_ambulance' => $request->car_free_ambulance,
                    'car_free_corpse' => $request->car_free_corpse,
                    'code_member' => $request->code_member,
                    'code_membership' => $request->code_membership,
                    'employeeable' => $request->employeeable
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
        $data = PatientGroup::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'code' => 'required|unique:patient_groups,code,' . $id,
            'name' => 'required'
        ], [
            'name.required' => 'nama golongan tidak boleh kosong',
            'code.required' => 'kode golongan tidak boleh kosong',
            'code.unique' => 'kode golongan telah digunakan'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = PatientGroup::findOrFail($id)->update([
                    'code' => $request->code,
                    'name' => $request->name,
                    'kpid' => $request->kpid,
                    'initial' => $request->initial,
                    'privilege_class_code' => $request->privilege_class_code,
                    'privilege_class_type' => $request->privilege_class_type,
                    'rule_code' => $request->rule_code,
                    'first_number' => $request->first_number,
                    'contribution_assistance' => $request->contribution_assistance,
                    'car_free_ambulance' => $request->car_free_ambulance,
                    'car_free_corpse' => $request->car_free_corpse,
                    'code_member' => $request->code_member,
                    'code_membership' => $request->code_membership,
                    'employeeable' => $request->employeeable
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
            PatientGroup::destroy($id);

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
