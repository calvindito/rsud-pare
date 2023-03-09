<?php

namespace App\Http\Controllers\Report\Radiology;

use Carbon\Carbon;
use App\Helpers\Simrs;
use App\Models\ClassType;
use App\Models\Radiology;
use Illuminate\Http\Request;
use App\Models\ActionSupporting;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ActionController extends Controller
{
    public function index()
    {
        $data = [
            'classType' => ClassType::all(),
            'actionSupporting' => ActionSupporting::all(),
            'content' => 'report.radiology.action'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Radiology::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search, $request) {
                if ($search) {
                    $query->where('code', 'like', "%$search%")
                        ->orWhere('type', 'like', "%$search%")
                        ->orWhere('object', 'like', "%$search%")
                        ->orWhere('projection', 'like', "%$search%")
                        ->orWhereHas('actionSupporting', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%")
                                ->orWhereHas('classType', function ($query) use ($search) {
                                    $query->where('name', 'like', "%$search%");
                                });
                        });
                }

                if ($request->action_supporting_id || $request->class_type_id) {
                    $query->whereHas('actionSupporting', function ($query) use ($request) {
                        if ($request->action_supporting_id) {
                            $query->where('id', $request->action_supporting_id);
                        }

                        if ($request->class_type_id) {
                            $query->whereHas('classType', function ($query) use ($request) {
                                $query->where('id', $request->class_type_id);
                            });
                        }
                    });
                }
            })
            ->addColumn('action_supporting_name', function (Radiology $query) {
                $actionSupportingName = $query->actionSupporting->name ?? null;

                return $actionSupportingName;
            })
            ->addColumn('class_type_name', function (Radiology $query) {
                $classTypeName = $query->actionSupporting->classType->name ?? null;

                return $classTypeName;
            })
            ->addColumn('date', function (Radiology $query) use ($request) {
                $date = 'Semua Tanggal';

                if ($request->date) {
                    $explodeDate = explode(' - ', $request->date);
                    $startDate = Carbon::parse($explodeDate[0])->isoFormat('D MMM Y');
                    $endDate = Carbon::parse($explodeDate[1])->isoFormat('D MMM Y');
                    $date = $startDate . ' - ' . $endDate;
                }

                return $date;
            })
            ->addColumn('income_consumables', function ($query) use ($request) {
                $nominal = $query->radiologyRequest()->where(function ($query) use ($request) {
                    $query->where('status', '!=', 4);

                    if ($request->date) {
                        $explodeDate = explode(' - ', $request->date);
                        $startDate = Carbon::parse($explodeDate[0])->format('Y-m-d');
                        $endDate = Carbon::parse($explodeDate[1])->format('Y-m-d');

                        $query->whereDate('date_of_request', '>=', $startDate)->whereDate('date_of_request', '<=', $endDate);
                    }
                })->sum('consumables');

                return Simrs::formatRupiah($nominal);
            })
            ->addColumn('income_hospital_service', function ($query) use ($request) {
                $nominal = $query->radiologyRequest()->where(function ($query) use ($request) {
                    $query->where('status', '!=', 4);

                    if ($request->date) {
                        $explodeDate = explode(' - ', $request->date);
                        $startDate = Carbon::parse($explodeDate[0])->format('Y-m-d');
                        $endDate = Carbon::parse($explodeDate[1])->format('Y-m-d');

                        $query->whereDate('date_of_request', '>=', $startDate)->whereDate('date_of_request', '<=', $endDate);
                    }
                })->sum('hospital_service');

                return Simrs::formatRupiah($nominal);
            })
            ->addColumn('income_service', function ($query) use ($request) {
                $nominal = $query->radiologyRequest()->where(function ($query) use ($request) {
                    $query->where('status', '!=', 4);

                    if ($request->date) {
                        $explodeDate = explode(' - ', $request->date);
                        $startDate = Carbon::parse($explodeDate[0])->format('Y-m-d');
                        $endDate = Carbon::parse($explodeDate[1])->format('Y-m-d');

                        $query->whereDate('date_of_request', '>=', $startDate)->whereDate('date_of_request', '<=', $endDate);
                    }
                })->sum('service');

                return Simrs::formatRupiah($nominal);
            })
            ->addColumn('income_fee', function ($query) use ($request) {
                $nominal = $query->radiologyRequest()->where(function ($query) use ($request) {
                    $query->where('status', '!=', 4);

                    if ($request->date) {
                        $explodeDate = explode(' - ', $request->date);
                        $startDate = Carbon::parse($explodeDate[0])->format('Y-m-d');
                        $endDate = Carbon::parse($explodeDate[1])->format('Y-m-d');

                        $query->whereDate('date_of_request', '>=', $startDate)->whereDate('date_of_request', '<=', $endDate);
                    }
                })->sum('fee');

                return Simrs::formatRupiah($nominal);
            })
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }
}
