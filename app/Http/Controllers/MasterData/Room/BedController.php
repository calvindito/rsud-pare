<?php

namespace App\Http\Controllers\MasterData\Room;

use App\Models\Bed;
use App\Models\RoomSpace;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class BedController extends Controller
{
    public function index()
    {
        $data = [
            'roomSpace' => RoomSpace::all(),
            'content' => 'master-data.room.bed'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Bed::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', "%$search%")
                        ->orWhere('facility', 'like', "%$search%")
                        ->orWhereHas('roomType', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }
            })
            ->editColumn('created_at', '{{ date("Y-m-d H:i:s", strtotime($created_at)) }}')
            ->editColumn('updated_at', '{{ date("Y-m-d H:i:s", strtotime($updated_at)) }}')
            ->editColumn('type', function (Bed $query) {
                return $query->type();
            })
            ->addColumn('room_type_name', function (Bed $query) {
                $roomTypeName = null;

                if (isset($query->roomSpace->roomType)) {
                    $roomTypeName = $query->roomSpace->roomType->name;

                    if (isset($query->roomSpace->roomType->classType)) {
                        $roomTypeName = $roomTypeName . ' - ' . $query->roomSpace->roomType->classType->name;
                    }
                }

                return $roomTypeName;
            })
            ->addColumn('room_space_name', function (Bed $query) {
                $roomSpaceName = null;

                if (isset($query->roomSpace)) {
                    $roomSpaceName = $query->roomSpace->name;

                    if (isset($query->roomSpace->roomType)) {
                        $roomSpaceName = $query->roomSpace->roomType->name . ' - ' . $roomSpaceName;
                    }
                }

                return $roomSpaceName;
            })
            ->addColumn('action', function (Bed $query) {
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
            'type' => 'required',
            'room_space_id' => 'required',
            'name' => 'required'
        ], [
            'type.required' => 'mohon memilih jenis',
            'room_space_id.required' => 'mohon memilih ruang kamar',
            'name.required' => 'nama tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $createData = Bed::create([
                    'room_space_id' => $request->room_space_id,
                    'name' => $request->name,
                    'type' => $request->type,
                    'keywords' => $request->keywords
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
        $data = Bed::findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'type' => 'required',
            'room_space_id' => 'required',
            'name' => 'required'
        ], [
            'type.required' => 'mohon memilih jenis',
            'room_space_id.required' => 'mohon memilih ruang kamar',
            'name.required' => 'nama tidak boleh kosong'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $updateData = Bed::findOrFail($id)->update([
                    'room_space_id' => $request->room_space_id,
                    'name' => $request->name,
                    'type' => $request->type,
                    'keywords' => $request->keywords
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
            Bed::destroy($id);

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
