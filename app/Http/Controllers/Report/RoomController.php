<?php

namespace App\Http\Controllers\Report;

use App\Models\Room;
use App\Models\Unit;
use App\Helpers\Simrs;
use App\Models\RoomType;
use App\Models\ClassType;
use App\Models\Inpatient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class RoomController extends Controller
{
    public function index()
    {
        $data = [
            'unit' => Unit::where('type', 1)->get(),
            'room' => Room::all(),
            'classType' => ClassType::all(),
            'content' => 'report.room'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = RoomType::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search, $request) {
                if ($search) {
                    $query->where('name', 'like', "%$search%")
                        ->orWhereHas('room', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%")
                                ->orWhereHas('unit', function ($query) use ($search) {
                                    $query->where('name', 'like', "%$search%");
                                });
                        })
                        ->orWhereHas('classType', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }

                if ($request->unit_id || $request->room_id) {
                    $query->whereHas('room', function ($query) use ($request) {
                        if ($request->room_id) {
                            $query->where('id', $request->room_id);
                        }

                        if ($request->unit_id) {
                            $query->whereHas('unit', function ($query) use ($request) {
                                $query->where('id', $request->id);
                            });
                        }
                    });
                }

                if ($request->class_type_id) {
                    $query->where('class_type_id', $request->class_type_id);
                }

                if (!is_null($request->status)) {
                    $query->where('status', $request->status);
                }
            })
            ->editColumn('fee_room', '{{ Simrs::formatRupiah($fee_room) }}')
            ->editColumn('fee_meal', '{{ Simrs::formatRupiah($fee_meal) }}')
            ->editColumn('fee_nursing_care', '{{ Simrs::formatRupiah($fee_nursing_care) }}')
            ->editColumn('fee_nutritional_care', '{{ Simrs::formatRupiah($fee_nutritional_care) }}')
            ->addColumn('unit_name', function (RoomType $query) {
                $unitName = $query->room->unit->name ?? null;

                return $unitName;
            })
            ->addColumn('room_name', function (RoomType $query) {
                $roomName = $query->room->name ?? null;

                return $roomName;
            })
            ->addColumn('class_type_name', function (RoomType $query) {
                $classTypeName = $query->classType->name ?? null;

                return $classTypeName;
            })
            ->addColumn('status', function (RoomType $query) {
                return $query->status();
            })
            ->addColumn('action', function (RoomType $query) {
                return '
                    <button type="button" class="btn btn-primary btn-sm" onclick="detail(' . $query->id . ')">
                        <i class="ph-info me-1"></i>
                        Detail
                    </button>
                ';
            })
            ->rawColumns(['action', 'status'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function datatableDetail(Request $request)
    {
        $search = $request->search['value'];
        $roomTypeId = $request->room_type_id;
        $data = Inpatient::whereHas('bed', function ($query) use ($roomTypeId) {
            $query->whereHas('roomSpace', function ($query) use ($roomTypeId) {
                $query->whereHas('roomType', function ($query) use ($roomTypeId) {
                    $query->where('id', $roomTypeId);
                });
            });
        });

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->whereRaw("LPAD(id, 7, 0) LIKE '%$search%'");
                }
            })
            ->editColumn('fee_room', '{{ Simrs::formatRupiah($fee_room) }}')
            ->editColumn('fee_nursing_care', '{{ Simrs::formatRupiah($fee_nursing_care) }}')
            ->editColumn('date_of_entry', '{{ date("Y-m-d", strtotime($date_of_entry)) }}')
            ->addColumn('code', function (Inpatient $query) {
                return $query->code();
            })
            ->addColumn('fee_nutritional_care', function (Inpatient $query) {
                $feeNutritionalCare = Simrs::formatRupiah($query->fee_nutritional_care) . ' (x' . $query->fee_nutritional_care_qty . ')';

                return $feeNutritionalCare;
            })
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function detail(Request $request)
    {
        $id = $request->id;
        $roomType = RoomType::with(['classType', 'room.unit'])->find($id);

        $totalFeeRoom = Inpatient::whereHas('bed', function ($query) use ($id) {
            $query->whereHas('roomSpace', function ($query) use ($id) {
                $query->whereHas('roomType', function ($query) use ($id) {
                    $query->where('id', $id);
                });
            });
        })->sum('fee_room');

        $totalFeeNursingCare = Inpatient::whereHas('bed', function ($query) use ($id) {
            $query->whereHas('roomSpace', function ($query) use ($id) {
                $query->whereHas('roomType', function ($query) use ($id) {
                    $query->where('id', $id);
                });
            });
        })->sum('fee_nursing_care');

        $totalNutritionalCare = Inpatient::whereHas('bed', function ($query) use ($id) {
            $query->whereHas('roomSpace', function ($query) use ($id) {
                $query->whereHas('roomType', function ($query) use ($id) {
                    $query->where('id', $id);
                });
            });
        })->sum(DB::raw('fee_nutritional_care * fee_nutritional_care_qty'));

        $total = [
            'fee_room' => Simrs::formatRupiah($totalFeeRoom),
            'fee_nursing_care' => Simrs::formatRupiah($totalFeeNursingCare),
            'fee_nutritional_care' => Simrs::formatRupiah($totalNutritionalCare)
        ];

        return response()->json([
            'data' => $roomType,
            'total' => $total
        ]);
    }
}
