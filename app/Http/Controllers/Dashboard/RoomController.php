<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Bed;
use App\Models\Room;
use App\Models\Unit;
use App\Models\RoomType;
use App\Models\ClassType;
use App\Models\RoomSpace;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $unitId = $request->has('unit_id') ? $request->unit_id : [];
        $roomId = $request->has('room_id') ? $request->room_id : [];
        $classTypeId = $request->has('class_type_id') ? $request->class_type_id : [];
        $roomTypeId = $request->has('room_type_id') ? $request->room_type_id : [];
        $roomSpaceId = $request->has('room_space_id') ? $request->room_space_id : [];
        $typeId = $request->has('type_id') ? $request->type_id : [];
        $search = $request->has('search') ? $request->search : null;
        $status = $request->has('status') ? $request->status : null;

        $bed = Bed::where(function ($query) use ($unitId, $roomId, $classTypeId, $roomTypeId, $roomSpaceId, $typeId, $search, $status) {
            if ($unitId || $roomId || $classTypeId || $roomTypeId || $roomSpaceId || $typeId) {
                if ($typeId) {
                    $query->whereIn('type', $typeId);
                }

                if ($unitId || $roomId || $classTypeId || $roomTypeId || $roomSpaceId) {
                    $query->whereHas('roomSpace', function ($query) use ($unitId, $roomId, $classTypeId, $roomTypeId, $roomSpaceId) {
                        if ($roomSpaceId) {
                            $query->whereIn('id', $roomSpaceId);
                        }

                        if ($unitId || $roomId || $classTypeId || $roomTypeId) {
                            $query->whereHas('roomType', function ($query) use ($unitId, $roomId, $classTypeId, $roomTypeId) {
                                if ($classTypeId) {
                                    $query->whereIn('class_type_id', $classTypeId);
                                }

                                if ($roomTypeId) {
                                    $query->whereIn('id', $roomTypeId);
                                }

                                if ($unitId || $roomId) {
                                    $query->whereHas('room', function ($query) use ($unitId, $roomId) {
                                        if ($unitId) {
                                            $query->whereIn('unit_id', $unitId);
                                        }

                                        if ($roomId) {
                                            $query->whereIn('id', $roomId);
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
            }

            if ($search || $status) {
                $query->whereHas('inpatient', function ($query) use ($search, $status) {
                    if ($status) {
                        if ($status == 'already-occupied') {
                            $query->havingRaw('COUNT(id) > 0');
                        } else if ($status == 'empty') {
                            $query->havingRaw('COUNT(id) < 1');
                        }
                    }

                    $query->whereHas('patient', function ($query) use ($search) {
                        $query->whereRaw("LPAD(id, 7, 0) LIKE '%$search%'")
                            ->orWhere('name', 'like', "%$search%")
                            ->orWhere('identity_number', 'like', "%$search%");
                    });
                });
            }
        })->paginate(8)->appends($request->except('page'));

        $type = [
            [
                'id' => 1,
                'name' => 'Laki - Laki'
            ],
            [
                'id' => 2,
                'name' => 'Perempuan'
            ],
            [
                'id' => 3,
                'name' => 'Campuran'
            ],
            [
                'id' => 4,
                'name' => 'Antrian'
            ],
        ];

        $data = [
            'room' => Room::whereNotIn('id', $roomId)->get(),
            'unit' => Unit::where('type', 1)->whereNotIn('id', $unitId)->get(),
            'classType' => ClassType::whereNotIn('id', $classTypeId)->get(),
            'roomType' => RoomType::whereNotIn('id', $roomTypeId)->get(),
            'roomSpace' => RoomSpace::whereNotIn('id', $roomSpaceId)->get(),
            'type' => $type,
            'unitId' => $unitId,
            'roomId' => $roomId,
            'classTypeId' => $classTypeId,
            'roomTypeId' => $roomTypeId,
            'roomSpaceId' => $roomSpaceId,
            'typeId' => $typeId,
            'bed' => $bed,
            'search' => $search,
            'status' => $status,
            'content' => 'dashboard.room'
        ];

        return view('layouts.index', ['data' => $data]);
    }
}
