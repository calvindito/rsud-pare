<?php

namespace App\Http\Controllers\MasterData\Room;

use App\Models\Room;
use App\Models\User;
use App\Models\RoomType;
use App\Models\ClassType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class RoomClassController extends Controller
{
    public function index()
    {
        $data = [
            'room' => Room::all(),
            'classType' => ClassType::all(),
            'user' => User::where('status', true)->where('role_id', 5)->get(),
            'content' => 'master-data.room.room-class'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = RoomType::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "%$search%")
                        ->orWhereHas('classType', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('room', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->whereHas('employee', function ($query) use ($search) {
                                $query->where('name', 'like', "%$search%");
                            });
                        });
                }
            })
            ->editColumn('fee_room', '{{ Simrs::formatRupiah($fee_room) }}')
            ->editColumn('fee_meal', '{{ Simrs::formatRupiah($fee_meal) }}')
            ->editColumn('fee_nursing_care', '{{ Simrs::formatRupiah($fee_nursing_care) }}')
            ->editColumn('fee_nutritional_care', '{{ Simrs::formatRupiah($fee_nutritional_care) }}')
            ->editColumn('status', function (RoomType $query) {
                return $query->status();
            })
            ->addColumn('class_type_name', function (RoomType $query) {
                $classTypeName = $query->classType->name ?? null;

                return $classTypeName;
            })
            ->addColumn('room_name', function (RoomType $query) {
                $roomName = $query->room->name ?? null;

                if (isset($query->room)) {
                    $roomName = $query->room->name;
                }

                return $roomName;
            })
            ->addColumn('employee_name', function (RoomType $query) {
                $employeeName = $query->user->employee->name ?? null;

                if (isset($query->user)) {
                    if (isset($query->user->employee)) {
                        $employeeName = $query->user->employee->name;
                    }
                }

                return $employeeName;
            })
            ->addColumn('action', function (RoomType $query) {
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
            'room_id' => 'required',
            'name' => 'required',
            'class_type_id' => 'required',
            'fee_room' => 'required',
            'fee_meal' => 'required',
            'fee_nursing_care' => 'required',
            'fee_nutritional_care' => 'required',
            'user_id' => 'required',
            'tier' => 'required'
        ], [
            'room_id.required' => 'mohon memilih kamar',
            'name.required' => 'nama tidak boleh kosong',
            'class_type_id.required' => 'mohon memilih kelas',
            'fee_room.required' => 'biaya kamar tidak boleh kosong',
            'fee_meal.required' => 'biaya makan tidak boleh kosong',
            'fee_nursing_care.required' => 'biaya askep tidak boleh kosong',
            'fee_nutritional_care.required' => 'asupan nutrisi tidak boleh kosong',
            'user_id.required' => 'mohon memilih user kamar',
            'tier.required' => 'tingkatan kamar tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = RoomType::create([
                    'room_id' => $request->room_id,
                    'class_type_id' => $request->class_type_id,
                    'user_id' => $request->user_id,
                    'name' => $request->name,
                    'fee_room' => $request->fee_room,
                    'fee_meal' => $request->fee_meal,
                    'fee_nursing_care' => $request->fee_nursing_care,
                    'fee_nutritional_care' => $request->fee_nutritional_care,
                    'total_bed' => $request->total_bed,
                    'tier' => $request->tier
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
        $data = RoomType::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'room_id' => 'required',
            'name' => 'required',
            'class_type_id' => 'required',
            'fee_room' => 'required',
            'fee_meal' => 'required',
            'fee_nursing_care' => 'required',
            'fee_nutritional_care' => 'required',
            'user_id' => 'required',
            'tier' => 'required'
        ], [
            'room_id.required' => 'mohon memilih kamar',
            'name.required' => 'nama tidak boleh kosong',
            'class_type_id.required' => 'mohon memilih kelas',
            'fee_room.required' => 'biaya kamar tidak boleh kosong',
            'fee_meal.required' => 'biaya makan tidak boleh kosong',
            'fee_nursing_care.required' => 'biaya askep tidak boleh kosong',
            'fee_nutritional_care.required' => 'asupan nutrisi tidak boleh kosong',
            'user_id.required' => 'mohon memilih anggota kamar',
            'tier.required' => 'tingkatan kamar tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = RoomType::findOrFail($id)->update([
                    'room_id' => $request->room_id,
                    'class_type_id' => $request->class_type_id,
                    'user_id' => $request->user_id,
                    'name' => $request->name,
                    'fee_room' => $request->fee_room,
                    'fee_meal' => $request->fee_meal,
                    'fee_nursing_care' => $request->fee_nursing_care,
                    'fee_nutritional_care' => $request->fee_nutritional_care,
                    'total_bed' => $request->total_bed,
                    'tier' => $request->tier,
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
            RoomType::destroy($id);

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
