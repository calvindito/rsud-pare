<?php

namespace App\Http\Controllers\Operation;

use App\Models\Unit;
use App\Models\Doctor;
use App\Models\Operation;
use Illuminate\Http\Request;
use App\Models\FunctionalService;
use App\Http\Controllers\Controller;
use App\Models\OperatingRoomAnesthetist;
use Illuminate\Database\Eloquent\Builder;

class SummaryController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->has('year') ? $request->year : date('Y');

        $functionalService = FunctionalService::withCount([
            'operation' => function (Builder $query) use ($year) {
                $query->whereYear('date_of_entry', $year);
            }
        ])->where('status', true)->get();

        $operatingRoomAnesthetist = OperatingRoomAnesthetist::withCount([
            'operation' => function (Builder $query) use ($year) {
                $query->whereYear('date_of_entry', $year);
            }
        ])->get();

        $doctor = Doctor::withCount([
            'operation' => function (Builder $query) use ($year) {
                $query->whereYear('date_of_entry', $year);
            }
        ])->get();

        $unit = Unit::withCount([
            'operation' => function (Builder $query) use ($year) {
                $query->whereYear('date_of_entry', $year);
            }
        ])->whereIn('type', [1, 2])->orderBy('name')->get();

        $status = [
            (object) [
                'name' => 'Belum Operasi',
                'total' => Operation::where('status', 1)->whereYear('date_of_entry', $year)->count()
            ],
            (object) [
                'name' => 'Sedang Operasi',
                'total' => Operation::where('status', 2)->whereYear('date_of_entry', $year)->count()
            ],
            (object) [
                'name' => 'Sudah Operasi',
                'total' => Operation::where('status', 3)->whereYear('date_of_entry', $year)->count()
            ]
        ];

        $data = [
            'functionalService' => $functionalService,
            'operatingRoomAnesthetist' => $operatingRoomAnesthetist,
            'doctor' => $doctor,
            'unit' => $unit,
            'status' => $status,
            'year' => $year,
            'content' => 'operation.summary'
        ];

        return view('layouts.index', ['data' => $data]);
    }
}
