<?php

namespace App\Http\Controllers\MasterData\Action;

use App\Models\ClassType;
use Illuminate\Http\Request;
use App\Models\ActionNonOperative;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class NonOperativeController extends Controller
{
    public function index()
    {
        $data = [
            'classType' => ClassType::all(),
            'content' => 'master-data.action.non-operative'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = ActionNonOperative::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('code', 'like', "%$search%")
                        ->orWhere('name', 'like', "%$search%")
                        ->orWhereHas('classType', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }
            })
            ->editColumn('hospital_service', '{{ Simrs::formatRupiah($hospital_service) }}')
            ->editColumn('doctor_operating', '{{ Simrs::formatRupiah($doctor_operating) }}')
            ->editColumn('fee', '{{ Simrs::formatRupiah($fee) }}')
            ->editColumn('emergency_care', '{{ Simrs::formatRupiah($emergency_care) }}')
            ->addColumn('class_type_name', function (ActionNonOperative $query) {
                $classTypeName = null;

                if (isset($query->classType)) {
                    $classTypeName = $query->classType->name;
                }

                return $classTypeName;
            })
            ->addColumn('action', function (ActionNonOperative $query) {
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
            'code' => 'required|unique:action_non_operatives,code',
            'class_type_id' => 'required',
            'hospital_service' => 'required|numeric|max:100',
            'doctor_operating' => 'required|numeric',
            'doctor_anesthetist' => 'required|numeric',
            'nurse_operating_room' => 'required|numeric',
            'nurse_anesthetist' => 'required|numeric',
            'total' => 'required|numeric|max:100',
            'fee' => 'required|numeric',
            'emergency_care' => 'required|numeric'
        ], [
            'name.required' => 'nama tindakan tidak boleh kosong',
            'code.required' => 'kode tindakan tidak boleh kosong',
            'code.unique' => 'kode tindakan telah digunakan',
            'class_type_id.required' => 'mohon memilih kelas',
            'hospital_service.required' => 'jrs tidak boleh kosong',
            'hospital_service.numeric' => 'jrs harus angka yang valid',
            'hospital_service.max' => 'jrs maksimal 100',
            'doctor_operating.required' => 'dr operasi tidak boleh kosong',
            'doctor_operating.numeric' => 'dr operasi harus angka yang valid',
            'doctor_anesthetist.required' => 'dr anestesi tidak boleh kosong',
            'doctor_anesthetist.numeric' => 'dr anestesi harus angka yang valid',
            'nurse_operating_room.required' => 'perawat operasi tidak boleh kosong',
            'nurse_operating_room.numeric' => 'perawat operasi harus angka yang valid',
            'nurse_anesthetist.required' => 'perawat anestesi tidak boleh kosong',
            'nurse_anesthetist.numeric' => 'perawat anestesi harus angka yang valid',
            'total.required' => 'total tidak boleh kosong',
            'total.numeric' => 'total harus angka yang valid',
            'total.max' => 'total maksimal 100',
            'fee.required' => 'tarif tidak boleh kosong',
            'fee.numeric' => 'tarif harus angka yang valid',
            'emergency_care.required' => 'ird tidak boleh kosong',
            'emergency_care.numeric' => 'ird harus angka yang valid'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = ActionNonOperative::create([
                    'class_type_id' => $request->class_type_id,
                    'code' => $request->code,
                    'name' => $request->name,
                    'hospital_service' => $request->hospital_service,
                    'doctor_operating' => $request->doctor_operating,
                    'doctor_anesthetist' => $request->doctor_anesthetist,
                    'nurse_operating_room' => $request->nurse_operating_room,
                    'nurse_anesthetist' => $request->nurse_anesthetist,
                    'total' => $request->total,
                    'fee' => $request->fee,
                    'emergency_care' => $request->emergency_care
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
        $data = ActionNonOperative::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required|unique:action_non_operatives,code,' . $id,
            'class_type_id' => 'required',
            'hospital_service' => 'required|numeric|max:100',
            'doctor_operating' => 'required|numeric',
            'doctor_anesthetist' => 'required|numeric',
            'nurse_operating_room' => 'required|numeric',
            'nurse_anesthetist' => 'required|numeric',
            'total' => 'required|numeric|max:100',
            'fee' => 'required|numeric',
            'emergency_care' => 'required|numeric'
        ], [
            'name.required' => 'nama tindakan tidak boleh kosong',
            'code.required' => 'kode tindakan tidak boleh kosong',
            'code.unique' => 'kode tindakan telah digunakan',
            'class_type_id.required' => 'mohon memilih kelas',
            'hospital_service.required' => 'jrs tidak boleh kosong',
            'hospital_service.numeric' => 'jrs harus angka yang valid',
            'hospital_service.max' => 'jrs maksimal 100',
            'doctor_operating.required' => 'dr operasi tidak boleh kosong',
            'doctor_operating.numeric' => 'dr operasi harus angka yang valid',
            'doctor_anesthetist.required' => 'dr anestesi tidak boleh kosong',
            'doctor_anesthetist.numeric' => 'dr anestesi harus angka yang valid',
            'nurse_operating_room.required' => 'perawat operasi tidak boleh kosong',
            'nurse_operating_room.numeric' => 'perawat operasi harus angka yang valid',
            'nurse_anesthetist.required' => 'perawat anestesi tidak boleh kosong',
            'nurse_anesthetist.numeric' => 'perawat anestesi harus angka yang valid',
            'total.required' => 'total tidak boleh kosong',
            'total.numeric' => 'total harus angka yang valid',
            'total.max' => 'total maksimal 100',
            'fee.required' => 'tarif tidak boleh kosong',
            'fee.numeric' => 'tarif harus angka yang valid',
            'emergency_care.required' => 'ird tidak boleh kosong',
            'emergency_care.numeric' => 'ird harus angka yang valid'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = ActionNonOperative::findOrFail($id)->update([
                    'class_type_id' => $request->class_type_id,
                    'code' => $request->code,
                    'name' => $request->name,
                    'hospital_service' => $request->hospital_service,
                    'doctor_operating' => $request->doctor_operating,
                    'doctor_anesthetist' => $request->doctor_anesthetist,
                    'nurse_operating_room' => $request->nurse_operating_room,
                    'nurse_anesthetist' => $request->nurse_anesthetist,
                    'total' => $request->total,
                    'fee' => $request->fee,
                    'emergency_care' => $request->emergency_care
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
            ActionNonOperative::destroy($id);

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
