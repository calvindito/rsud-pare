<?php

namespace App\Http\Controllers\Report\Lab;

use Carbon\Carbon;
use App\Helpers\Simrs;
use App\Models\LabItem;
use App\Models\LabCategory;
use App\Models\LabItemGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller
{
    public function index()
    {
        $data = [
            'labCategory' => LabCategory::all(),
            'labItemGroup' => LabItemGroup::all(),
            'content' => 'report.lab.item'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = LabItem::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search, $request) {
                if ($search) {
                    $query->where('name', 'like', "%$search%")
                        ->orWhereHas('labCategory', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('labItemGroup', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }

                if ($request->lab_category_id) {
                    $query->where('lab_category_id', $request->lab_category_id);
                }

                if ($request->lab_item_group_id) {
                    $query->where('lab_item_group_id', $request->lab_item_group_id);
                }

                if (!is_null($request->status)) {
                    $query->where('status', $request->status);
                }
            })
            ->addColumn('lab_category_name', function (LabItem $query) {
                $labCategoryName = $query->labCategory->name ?? null;

                return $labCategoryName;
            })
            ->addColumn('lab_item_group_name', function (LabItem $query) {
                $labItemGroupName = $query->labItemGroup->name ?? null;

                return $labItemGroupName;
            })
            ->addColumn('date', function (LabItem $query) use ($request) {
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
                $nominal = $query->labRequestDetail()->whereHas('labRequest', function ($query) use ($request) {
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
                $nominal = $query->labRequestDetail()->whereHas('labRequest', function ($query) use ($request) {
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
                $nominal = $query->labRequestDetail()->whereHas('labRequest', function ($query) use ($request) {
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
            ->addColumn('status', function (LabItem $query) {
                return $query->status();
            })
            ->rawColumns(['status'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }
}
