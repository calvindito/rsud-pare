<?php

namespace App\Http\Controllers\MasterData\OperatingRoom;

use App\Models\ClassType;
use Illuminate\Http\Request;
use App\Models\OperatingRoomGroup;
use App\Models\OperatingRoomAction;
use App\Http\Controllers\Controller;
use App\Models\OperatingRoomActionType;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ActionController extends Controller
{
    public function index()
    {
        $data = [
            'classType' => ClassType::all(),
            'operatingRoomActionType' => OperatingRoomActionType::all(),
            'operatingRoomGroup' => OperatingRoomGroup::all(),
            'content' => 'master-data.operating-room.action'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = OperatingRoomAction::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->whereHas('operatingRoomGroup', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });

                    $query->orWhereHas('operatingRoomActionType', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });

                    $query->orWhereHas('classType', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });
                }
            })
            ->editColumn('status', function (OperatingRoomAction $query) {
                return $query->status();
            })
            ->addColumn('operating_room_group_name', function (OperatingRoomAction $query) {
                $operatingRoomGroupName = null;

                if (isset($query->operatingRoomGroup)) {
                    $operatingRoomGroupName = $query->operatingRoomGroup->name;
                }

                return $operatingRoomGroupName;
            })
            ->addColumn('operating_room_action_type_name', function (OperatingRoomAction $query) {
                $operatingRoomActionTypeName = null;

                if (isset($query->operatingRoomActionType)) {
                    $operatingRoomActionTypeName = $query->operatingRoomActionType->name;
                }

                return $operatingRoomActionTypeName;
            })
            ->addColumn('class_type_name', function (OperatingRoomAction $query) {
                $classTypeName = null;

                if (isset($query->classType)) {
                    $classTypeName = $query->classType->name;
                }

                return $classTypeName;
            })
            ->addColumn('action', function (OperatingRoomAction $query) {
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
            'class_type_id' => 'required',
            'operating_room_action_type_id' => 'required',
            'operating_room_group_id' => 'required',
            'fee_hospital_service' => 'required|numeric',
            'fee_doctor_operating_room' => 'required|numeric',
            'fee_doctor_anesthetist' => 'required|numeric',
            'fee_nurse_operating_room' => 'required|numeric',
            'fee_nurse_anesthetist' => 'required|numeric'
        ], [
            'class_type_id.required' => 'mohon memilih kelas perawatan',
            'operating_room_action_type_id.required' => 'mohon memilih jenis tindakan',
            'operating_room_group_id.required' => 'mohon memilih golongan operasi',
            'fee_hospital_service.required' => 'biaya jrs tidak boleh kosong',
            'fee_hospital_service.numeric' => 'biaya jrs harus angka yang valid',
            'fee_doctor_operating_room.required' => 'biaya dr operasi tidak boleh kosong',
            'fee_doctor_operating_room.numeric' => 'biaya dr operasi harus angka yang valid',
            'fee_doctor_anesthetist.required' => 'biaya dr anestesi tidak boleh kosong',
            'fee_doctor_anesthetist.numeric' => 'biaya dr anestesi harus angka yang valid',
            'fee_nurse_operating_room.required' => 'biaya perawat operasi tidak boleh kosong',
            'fee_nurse_operating_room.numeric' => 'biaya perawat operasi harus angka yang valid',
            'fee_nurse_anesthetist.required' => 'biaya perawat anestesi tidak boleh kosong',
            'fee_nurse_anesthetist.numeric' => 'biaya perawat anestesi harus angka yang valid'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = OperatingRoomAction::create([
                    'class_type_id' => $request->class_type_id,
                    'operating_room_action_type_id' => $request->operating_room_action_type_id,
                    'operating_room_group_id' => $request->operating_room_group_id,
                    'fee_hospital_service' => $request->fee_hospital_service,
                    'fee_doctor_operating_room' => $request->fee_doctor_operating_room,
                    'fee_doctor_anesthetist' => $request->fee_doctor_anesthetist,
                    'fee_nurse_operating_room' => $request->fee_nurse_operating_room,
                    'fee_nurse_anesthetist' => $request->fee_nurse_anesthetist
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
        $data = OperatingRoomAction::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'class_type_id' => 'required',
            'operating_room_action_type_id' => 'required',
            'operating_room_group_id' => 'required',
            'fee_hospital_service' => 'required|numeric',
            'fee_doctor_operating_room' => 'required|numeric',
            'fee_doctor_anesthetist' => 'required|numeric',
            'fee_nurse_operating_room' => 'required|numeric',
            'fee_nurse_anesthetist' => 'required|numeric'
        ], [
            'class_type_id.required' => 'mohon memilih kelas perawatan',
            'operating_room_action_type_id.required' => 'mohon memilih jenis tindakan',
            'operating_room_group_id.required' => 'mohon memilih golongan operasi',
            'fee_hospital_service.required' => 'biaya jrs tidak boleh kosong',
            'fee_hospital_service.numeric' => 'biaya jrs harus angka yang valid',
            'fee_doctor_operating_room.required' => 'biaya dr operasi tidak boleh kosong',
            'fee_doctor_operating_room.numeric' => 'biaya dr operasi harus angka yang valid',
            'fee_doctor_anesthetist.required' => 'biaya dr anestesi tidak boleh kosong',
            'fee_doctor_anesthetist.numeric' => 'biaya dr anestesi harus angka yang valid',
            'fee_nurse_operating_room.required' => 'biaya perawat operasi tidak boleh kosong',
            'fee_nurse_operating_room.numeric' => 'biaya perawat operasi harus angka yang valid',
            'fee_nurse_anesthetist.required' => 'biaya perawat anestesi tidak boleh kosong',
            'fee_nurse_anesthetist.numeric' => 'biaya perawat anestesi harus angka yang valid'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = OperatingRoomAction::findOrFail($id)->update([
                    'class_type_id' => $request->class_type_id,
                    'operating_room_action_type_id' => $request->operating_room_action_type_id,
                    'operating_room_group_id' => $request->operating_room_group_id,
                    'fee_hospital_service' => $request->fee_hospital_service,
                    'fee_doctor_operating_room' => $request->fee_doctor_operating_room,
                    'fee_doctor_anesthetist' => $request->fee_doctor_anesthetist,
                    'fee_nurse_operating_room' => $request->fee_nurse_operating_room,
                    'fee_nurse_anesthetist' => $request->fee_nurse_anesthetist,
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
            OperatingRoomAction::destroy($id);

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
