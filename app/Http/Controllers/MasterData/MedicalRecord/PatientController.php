<?php

namespace App\Http\Controllers\MasterData\MedicalRecord;

use PDF;
use App\Helpers\Simrs;
use App\Models\Patient;
use App\Models\Religion;
use Illuminate\Http\Request;
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
                    $query->where('id', 'like', "%$search%")
                        ->orWhere('name', 'like', "%$search%")
                        ->orWhere('address', 'like', "%$search%")
                        ->orWhere('parent_name', 'like', "%$search%")
                        ->orWhereHas('district', function ($query) use ($search) {
                            $query->where('name', 'like', "%$search%");
                        });
                }
            })
            ->editColumn('type', function (Patient $query) {
                return $query->type();
            })
            ->editColumn('gender', function (Patient $query) {
                return $query->gender();
            })
            ->addColumn('district_name', function (Patient $query) {
                $districtName = null;

                if (isset($query->district)) {
                    $districtName = $query->district->name;
                }

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
            'identity_number.required' => 'no identitas tidak boleh kosong',
            'identity_number.digits' => 'no identitas harus 16 karakter',
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
                $pageSize = [85, 54];
                $title = 'Kartu Pasien';
            } else if ($request->slug == 'ticket') {
                $view = 'pdf.patient-ticket';
                $pageSize = [68, 43];
                $title = 'E-Tiket Pasien';
            } else {
                abort(404);
            }

            $pdf = PDF::loadView($view, [
                'title' => $title . ' - ' . $data->name . ' (' . $data->id . ')',
                'data' => $data
            ], [], [
                'mode' => 'utf-8',
                'format' => $pageSize,
                'display_mode' => 'fullwidth',
                'margin_top' => 3,
                'margin_right' => 3,
                'margin_bottom' => 3,
                'margin_left' => 3,
                'author' => session('name'),
                'subject' => $title,
            ]);

            return $pdf->stream('Kartu Pasien ' . $data->id . '.pdf');
        }

        abort(404);
    }
}
