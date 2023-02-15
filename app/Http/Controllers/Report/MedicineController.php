<?php

namespace App\Http\Controllers\Report;

use App\Models\Factory;
use App\Models\Medicine;
use App\Models\Distributor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class MedicineController extends Controller
{
    public function index()
    {
        $data = [
            'distributor' => Distributor::all(),
            'factory' => Factory::all(),
            'content' => 'report.medicine'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Medicine::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search, $request) {
                if ($search) {
                    $query->where('code', 'like', "%$search%")
                        ->orWhere('code_t', 'like', "%$search%")
                        ->orWhere('code_type', 'like', "%$search%")
                        ->orWhere('name', 'like', "%$search%")
                        ->orWhere('name_generic', 'like', "%$search%");
                }

                if (!empty($request->distributor_id)) {
                    $query->where('distributor_id', $request->distributor_id);
                }

                if (!empty($request->factory_id)) {
                    $query->whereHas('distributor', function ($query) use ($request) {
                        $query->whereHas('distributorFactory', function ($query) use ($request) {
                            $query->where('factory_id', $request->factory_id);
                        });
                    });
                }

                if (!empty($request->stock)) {
                    $query->whereHas('medicineStock', function ($query) use ($request) {
                        $query->groupBy('medicine_id');

                        if ($request->stock == 'many') {
                            $query->havingRaw('SUM(stock) > 1000');
                        } else if ($request->stock == 'available') {
                            $query->havingRaw('SUM(stock) > 0');
                        } else if ($request->stock == 'empty') {
                            $query->havingRaw('SUM(stock) < 1');
                        }
                    });
                }
            })
            ->addColumn('stock', function (Medicine $query) {
                $html = '<div><small><b>Total : </b>' . $query->stock() . '</small></div>';
                $html .= '<div><small><b>Terjual : </b>' . $query->stock('sold') . '</small></div>';
                $html .= '<div><small><b>Tersedia : </b>' . $query->stock('available') . '</small></div>';

                return '<button type="button" class="btn btn-light btn-sm" onclick="onPopover(this, ' . "'$html'" . ')">Klik Disini</button>';
            })
            ->addColumn('distributor_name', function (Medicine $query) {
                $distributorName = null;

                if (isset($query->distributor)) {
                    $distributorName = $query->distributor->name;
                }

                return $distributorName;
            })
            ->editColumn('factory_name', function (Medicine $query) {
                $factoryName = '';

                if ($query->distributor) {
                    if ($query->distributor->distributorFactory->count() > 0) {
                        foreach ($query->distributor->distributorFactory as $df) {
                            $factoryName .= '<div><small>- ' . $df->factory->name . '</small></div>';
                        }
                    }
                }

                if ($factoryName) {
                    $implodeName = $factoryName;
                } else {
                    $implodeName = 'Tidak ada data';
                }

                return '
                    <button type="button" class="btn btn-light btn-sm" onclick="onPopover(this, ' . "'$implodeName'" . ')">Klik Disini</button>
                ';
            })
            ->rawColumns(['factory_name', 'stock'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }
}