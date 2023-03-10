<?php

namespace App\Http\Controllers\Operation;

use App\Models\Doctor;
use App\Models\Operation;
use Illuminate\Http\Request;
use App\Models\DispensaryItem;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DispensaryItemStock;
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
                    $query->whereRaw("LPAD(id, 7, 0) LIKE '%$search%'")
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
                $employeeName = $query->user->employee->name ?? 'Belum Ada';

                return $employeeName;
            })
            ->addColumn('patient_name', function (Operation $query) {
                $patientName = $query->patient->name ?? null;

                return $patientName;
            })
            ->addColumn('doctor_name', function (Operation $query) {
                $doctorName = $query->doctor->name ?? 'Tidak Ada';

                return $doctorName;
            })
            ->addColumn('unit_name', function (Operation $query) {
                $unitName = $query->unit->name ?? null;

                return $unitName;
            })
            ->addColumn('functional_service_name', function (Operation $query) {
                $functionalServiceName = $query->functionalService->name ?? null;

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
        $dispensaryId = $operation->operationable->dispensary_id;

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
                        $dispensaryItemStockId = isset($request->om_dispensary_item_stock_id[$key]) ? $request->om_dispensary_item_stock_id[$key] : null;
                        $qty = isset($request->om_qty[$key]) ? $request->om_qty[$key] : null;

                        if ($dispensaryItemStockId && $qty > 0) {
                            $dispensaryItemStock = DispensaryItemStock::find($dispensaryItemStockId);

                            if ($dispensaryItemStock) {
                                $qtyAvailable = $dispensaryItemStock->qty;

                                if ($qty > $qtyAvailable) {
                                    $qty = $qtyAvailable;
                                }

                                $operation->operationMaterial()->create([
                                    'dispensary_item_stock_id' => $dispensaryItemStockId,
                                    'dispensary_id' => $dispensaryId,
                                    'qty' => $qty,
                                    'price_purchase' => $dispensaryItemStock->price_purchase,
                                    'price_sell' => $dispensaryItemStock->price_sell,
                                    'discount' => $dispensaryItemStock->discount
                                ]);

                                if ($operation->status == 3) {
                                    $dispensaryItemStock->replicate()->fill([
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
            'dispensaryItem' => DispensaryItem::available()->where('dispensary_id', $dispensaryId)->get(),
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
