<?php

namespace App\Http\Controllers\Operation;

use App\Models\Item;
use App\Models\Doctor;
use App\Models\ItemStock;
use App\Models\Operation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class DataController extends Controller
{
    public function index()
    {
        $data = [
            'content' => 'operation.data'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Operation::query();

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->whereRaw("LPAD(id, 6, 0) LIKE '%$search%'")
                        ->orWhere('patient_id', 'like', "%$search%")
                        ->orWhereHas('patient', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        })
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->whereHas('employee', function ($query) use ($search) {
                                $query->where('name', 'like', "%$search%");
                            });
                        })
                        ->orWhereHas('doctor', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }
            })
            ->addColumn('status', function (Operation $query) {
                return $query->status();
            })
            ->addColumn('code', function (Operation $query) {
                return $query->code();
            })
            ->addColumn('employee_name', function (Operation $query) {
                $employeeName = 'Belum Ada';

                if (isset($query->user->employee)) {
                    $employeeName = $query->user->employee->name;
                }

                return $employeeName;
            })
            ->addColumn('patient_name', function (Operation $query) {
                $patientName = null;

                if (isset($query->patient)) {
                    $patientName = $query->patient->name;
                }

                return $patientName;
            })
            ->addColumn('doctor_name', function (Operation $query) {
                $doctorName = 'Tidak Ada';

                if (isset($query->doctor)) {
                    $doctorName = $query->doctor->name;
                }

                return $doctorName;
            })
            ->addColumn('unit_name', function (Operation $query) {
                $unitName = null;

                if (isset($query->unit)) {
                    $unitName = $query->unit->name;
                }

                return $unitName;
            })
            ->addColumn('functional_service_name', function (Operation $query) {
                $functionalServiceName = null;

                if (isset($query->functionalService)) {
                    $functionalServiceName = $query->functionalService->name;
                }

                return $functionalServiceName;
            })
            ->addColumn('ref', function (Operation $query) {
                return $query->ref();
            })
            ->addColumn('action', function (Operation $query) {
                $fullAction = '';
                if ($query->status == 1) {
                    $fullAction = '
                        <a href="javascript:void(0);" class="dropdown-item fs-13" onclick="destroyData(' . $query->id . ')">
                            <i class="ph-trash-simple me-2"></i>
                            Hapus Data
                        </a>
                    ';
                }

                return '
                    <div class="btn-group">
                        <button type="button" class="btn btn-light text-primary btn-sm btn-block fw-semibold dropdown-toggle" data-bs-toggle="dropdown">Aksi</button>
                        <div class="dropdown-menu">
                            <a href="' . url('operation/data/manage/' . $query->id) . '" class="dropdown-item fs-13">
                                <i class="ph-webcam me-2"></i>
                                Kelola
                            </a>
                            <a href="' . url('operation/data/print/' . $query->id) . '" class="dropdown-item fs-13">
                                <i class="ph-printer me-2"></i>
                                Cetak
                            </a>
                            ' . $fullAction . '
                        </div>
                    </div>
                ';
            })
            ->rawColumns(['action', 'status'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function manage(Request $request, $id)
    {
        $operation = Operation::findOrFail($id);

        if ($request->ajax()) {
            try {
                $operation->update([
                    'doctor_operation_id' => $request->doctor_operation_id,
                    'date_of_out' => $request->date_of_out,
                    'hospital_service' => $request->hospital_service,
                    'doctor_operating_room' => $request->doctor_operating_room,
                    'doctor_anesthetist' => $request->doctor_anesthetist,
                    'nurse_operating_room' => $request->nurse_operating_room,
                    'nurse_anesthetist' => $request->nurse_anesthetist,
                    'material' => $request->material,
                    'monitoring' => $request->monitoring,
                    'nursing_care' => $request->nursing_care,
                    'status' => $request->status
                ]);

                $operation->fresh();
                $operation->operationMaterial()->delete();

                if ($request->has('item')) {
                    foreach ($request->item as $key => $i) {
                        $itemId = isset($request->om_item_id[$key]) ? $request->om_item_id[$key] : null;
                        $qty = isset($request->om_qty[$key]) ? $request->om_qty[$key] : null;

                        if ($itemId && $qty > 0) {
                            $itemStock = ItemStock::selectRaw("*, SUM(CASE WHEN type = '1' THEN qty END) as stock, SUM(CASE WHEN type = '2' THEN qty END) as sold")
                                ->where('item_id', $itemId)
                                ->groupBy('item_id')
                                ->havingRaw('stock > IF(sold > 0, sold, 0)')
                                ->oldest('expired_date')
                                ->first();

                            if ($itemStock) {
                                $stock = $itemStock->stock;
                                $sold = $itemStock->sold;
                                $qtyAvailable = $stock - $sold;

                                if ($qty > $qtyAvailable) {
                                    $qty = $qtyAvailable;
                                }

                                $operation->operationMaterial()->create([
                                    'item_stock_id' => $itemStock->id,
                                    'qty' => $qty,
                                    'price_purchase' => $itemStock->price_purchase,
                                    'price_sell' => $itemStock->price_sell,
                                    'discount' => $itemStock->discount
                                ]);

                                if ($operation->status == 3) {
                                    ItemStock::find($itemStock->id)->replicate()->fill([
                                        'type' => 2,
                                        'qty' => $qty
                                    ])->save();
                                }
                            }
                        }
                    }
                }

                $response = [
                    'code' => 200,
                    'message' => 'Data operasi berhasil disimpan'
                ];
            } catch (\Exception $e) {
                $response = [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ];
            }

            return response()->json($response);
        }

        $data = [
            'operation' => $operation,
            'operationMaterial' => $operation->operationMaterial,
            'patient' => $operation->patient,
            'doctor' => Doctor::all(),
            'item' => Item::available()->get(),
            'content' => 'operation.data-manage'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function print($id)
    {
        $data = Operation::findOrFail($id);
        $title = 'Rincian Biaya Operasi';
        $pdf = Pdf::setOptions([
            'adminUsername' => auth()->user()->username
        ])->loadView('pdf.operation-detail', [
            'title' => $title,
            'data' => $data
        ]);

        return $pdf->stream($title . ' - ' . date('YmdHis') . '.pdf');
    }

    public function destroyData(Request $request)
    {
        $id = $request->id;

        try {
            Operation::destroy($id);

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
