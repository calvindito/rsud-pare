<?php

namespace App\Http\Controllers\Dispensary;

use Illuminate\Http\Request;
use App\Models\DispensaryItem;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'dispensary.item'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = DispensaryItem::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->whereHas('dispensary', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });

                    $query->orWhereHas('item', function ($query) use ($search) {
                        $query->where('code', 'like', "%$search%")
                            ->orWhere('code_t', 'like', "%$search%")
                            ->orWhere('code_type', 'like', "%$search%")
                            ->orWhere('name', 'like', "%$search%")
                            ->orWhere('name_generic', 'like', "%$search%");
                    });
                }
            })
            ->addColumn('dispensary_name', function (DispensaryItem $query) {
                $dispensaryName = null;

                if ($query->dispensary) {
                    $dispensaryName = $query->dispensary->name;
                }

                return $dispensaryName;
            })
            ->addColumn('item_code', function (DispensaryItem $query) {
                $itemCode = null;

                if ($query->item) {
                    $itemCode = $query->item->code;
                }

                return $itemCode;
            })
            ->addColumn('item_code_t', function (DispensaryItem $query) {
                $itemCodeT = null;

                if ($query->item) {
                    $itemCodeT = $query->item->code_t;
                }

                return $itemCodeT;
            })
            ->addColumn('item_code_type', function (DispensaryItem $query) {
                $itemCodeType = null;

                if ($query->item) {
                    $itemCodeType = $query->item->code_type;
                }

                return $itemCodeType;
            })
            ->addColumn('item_unit_name', function (DispensaryItem $query) {
                $itemUnitName = null;

                if ($query->item) {
                    if ($query->item->itemUnit) {
                        $itemUnitName = $query->item->itemUnit->name;
                    }
                }

                return $itemUnitName;
            })
            ->addColumn('item_type', function (DispensaryItem $query) {
                $itemType = null;

                if ($query->item) {
                    $itemType = $query->item->type_format_result;
                }

                return $itemType;
            })
            ->addColumn('item_name', function (DispensaryItem $query) {
                $itemName = null;

                if ($query->item) {
                    $itemName = $query->item->name;
                }

                return $itemName;
            })
            ->addColumn('stock', function (DispensaryItem $query) {
                $html = '<div><small><b>Total : </b>' . $query->stock() . '</small></div>';
                $html .= '<div><small><b>Terjual : </b>' . $query->stock('sold') . '</small></div>';
                $html .= '<div><small><b>Tersedia : </b>' . $query->stock('available') . '</small></div>';

                return '<button type="button" class="btn btn-light btn-sm" onclick="onPopover(this, ' . "'$html'" . ')">Klik Disini</button>';
            })
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }
}
