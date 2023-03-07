<?php

namespace App\Http\Controllers\MasterData\MedicalRecord;

use App\Helpers\Simrs;
use App\Models\Patient;
use App\Models\Religion;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function index()
    {
        $data = [
            'religion' => Religion::all(),
            'content' => 'master-data.medical-record.patient'
        ];

        return view('layouts.index', ['data' => $data]);
    }

    public function datatable(Request $request)
    {
        $search = $request->search['value'];
        $data = Patient::whereNotNull('verified_at');

        return DataTables::eloquent($data)
            ->filter(function ($query) use ($search) {
                if ($search) {
                    $query->whereRaw("LPAD(id, 7, 0) LIKE '%$search%'")
                        ->orWhere('name', 'like', "%$search%")
                        ->orWhere('address', 'like', "%$search%")
                        ->orWhere('parent_name', 'like', "%$search%")
                        ->orWhereHas('district', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }
            })
            ->addColumn('district_name', function (Patient $query) {
                $districtName = $query->district->name ?? null;

                return $districtName;
            })
            ->addColumn('action', function (Patient $query) {
                return '
                    <div class="btn-group">
                        <button type="button" class="btn btn-light text-primary btn-sm fw-semibold dropdown-toggle" data-bs-toggle="dropdown">Aksi</button>
                        <div class="dropdown-menu">
                            <a href="javascript:void(0);" class="dropdown-item fs-13" onclick="showDataUpdate(' . $query->id . ')">
                                <i class="ph-pen me-2"></i>
                                Ubah Data
                            </a>
                            <a href="' . url('master-data/medical-record/patient/print/' . $query->id) . '?slug=card" target="_blank" class="dropdown-item fs-13">
                                <i class="ph-identification-card me-2"></i>
                                Cetak Kartu
                            </a>
                            <a href="' . url('master-data/medical-record/patient/print/' . $query->id) . '?slug=ticket" target="_blank" class="dropdown-item fs-13">
                                <i class="ph-ticket me-2"></i>
                                Cetak E-Tiket
                            </a>
                        </div>
                    </div>
                ';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->escapeColumns()
            ->toJson();
    }

    public function showData(Request $request)
    {
        $id = $request->id;
        $data = Patient::with(['province', 'city', 'district'])->findOrFail($id);

        return response()->json($data);
    }

    public function updateData(Request $request)
    {
        $id = $request->table_id;
        $validation = Validator::make($request->all(), [
            'identity_number' => 'nullable|digits:16|numeric|unique:patients,identity_number,' . $id,
            'name' => 'required',
            'village' => 'required',
            'location_id' => 'required',
            'address' => 'required',
            'religion_id' => 'required',
            'phone' => 'nullable|digits_between:8,13|numeric',
        ], [
            'identity_number.digits' => 'no identitas harus 16 karakter',
            'identity_number.numeric' => 'no identitas harus angka',
            'identity_number.unique' => 'no identitas telah digunakan',
            'name.required' => 'nama tidak boleh kosong',
            'village.required' => 'nama tidak boleh kosong',
            'location_id.required' => 'mohon memilih wilayah',
            'address.required' => 'alamat tidak boleh kosong',
            'religion_id.required' => 'mohon memilih agama',
            'phone.required' => 'no telp tidak boleh kosong',
            'phone.digits_between' => 'no telp min 8 dan maks 13 karakter',
            'phone.numeric' => 'no telp harus angka'
        ]);

        if ($validation->fails()) {
            $response = [
                'code' => 400,
                'error' => $validation->errors()->all(),
            ];
        } else {
            try {
                $locationId = $request->location_id;
                $location = Simrs::locationById($locationId);

                $updateData = Patient::findOrFail($id)->update([
                    'province_id' => $locationId ? $location->city->province->id : null,
                    'city_id' => $locationId ? $location->city->id : null,
                    'district_id' => $locationId ? $location->id : null,
                    'religion_id' => $request->religion_id,
                    'identity_number' => $request->identity_number,
                    'greeted' => $request->greeted,
                    'gender' => $request->gender,
                    'place_of_birth' => $request->place_of_birth,
                    'date_of_birth' => $request->date_of_birth,
                    'rt' => $request->rt,
                    'rw' => $request->rw,
                    'village' => $request->village,
                    'address' => $request->address,
                    'tribe' => $request->tribe,
                    'weight' => $request->weight,
                    'blood_group' => $request->blood_group,
                    'marital_status' => $request->marital_status,
                    'job' => $request->job,
                    'phone' => $request->phone,
                    'parent_name' => $request->parent_name,
                    'partner_name' => $request->partner_name
                ]);

                $response = [
                    'code' => 200,
                    'message' => 'Data telah diubah'
                ];
            } catch (\Exception $e) {
                $response = [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ];
            }
        }

        return response()->json($response);
    }

    public function print(Request $request, $id)
    {
        $data = Patient::findOrFail($id);

        if ($request->has('slug')) {
            if ($request->slug == 'card') {
                $view = 'pdf.patient-card';
                $title = 'Kartu Pasien';
            } else if ($request->slug == 'ticket') {
                $view = 'pdf.patient-ticket';
                $title = 'E-Tiket Pasien';
            } else {
                abort(404);
            }

            $pdf = Pdf::setOptions([
                'dpi' => 102,
                'adminUsername' => auth()->user()->username
            ])->loadView($view, [
                'title' => $title,
                'data' => $data
            ])->setPaper([0, 0, 221.102, 255.118], 'portrait');

            return $pdf->download($title . ' - ' . date('YmdHis') . '.pdf');
        }

        abort(404);
    }
}
