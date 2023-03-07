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
                $dispensaryName = $query->dispensary->name ?? null;

                return $dispensaryName;
            })
            ->addColumn('item_code', function (DispensaryItem $query) {
                $itemCode = $query->item->code ?? null;

                return $itemCode;
            })
            ->addColumn('item_code_t', function (DispensaryItem $query) {
                $itemCodeT = $query->item->code_t ?? null;

                return $itemCodeT;
            })
            ->addColumn('item_code_type', function (DispensaryItem $query) {
                $itemCodeType = $query->item->code_type ?? null;

                return $itemCodeType;
            })
            ->addColumn('item_unit_name', function (DispensaryItem $query) {
                $itemUnitName = $query->item->itemUnit->name ?? null;

                return $itemUnitName;
            })
            ->addColumn('item_type', function (DispensaryItem $query) {
                $itemType = $query->item->type_format_result ?? null;

                return $itemType;
            })
            ->addColumn('item_name', function (DispensaryItem $query) {
                $itemName = $query->item->name ?? null;

                return $itemName;
            })
            ->addColumn('stock', function (DispensaryItem $query) {
                $html = '<div><small><b>Total : </b>' . $query->stock() . '</small></div>';
                $html .= '<div><small><b>Terjual : </b>' . $query->stock('sold') . '</small></div>';
                $html .= '<div><small><b>Tersedia : </b>' . $query->stock('available') . '</small></div>';

                return '<button type="button" class="btn btn-light btn-sm" onclick="onPopover(this, ' . "'$html'" . ')">Klik Disini</button>';
            })
            ->rawColumns(['stock'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }
}
