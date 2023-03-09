<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Tagihan - <span class="fw-normal">Keseluruhan</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-flat-primary dropdown-toggle" data-bs-toggle="dropdown">Refresh</button>
                <div class="dropdown-menu">
                    <a href="{{ url()->full() }}" class="dropdown-item">Data</a>
                    <a href="{{ url('bill/whole') }}" class="dropdown-item">Halaman</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content pt-0">
    @if(session('success'))
        <div class="alert alert-success alert-icon-start alert-dismissible fade show">
            <span class="alert-icon bg-success text-white">
                <i class="ph-check-circle"></i>
            </span>
            <span class="fw-semibold">Sukses!</span> {{ session('success') }}
        </div>
    @elseif(session('failed'))
        <div class="alert alert-danger alert-icon-start alert-dismissible fade show">
            <span class="alert-icon bg-danger text-white">
                <i class="ph-x-circle"></i>
            </span>
            <span class="fw-semibold">Gagal!</span> {{ session('error') }}
        </div>
    @endif
    <form>
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="alert alert-info text-center fw-bold">
                    @if($hasSearching == 'exists')
                        Pasien Ditemukan
                    @elseif($hasSearching == 'not-exists')
                        Pasien Tidak Ditemukan
                    @else
                        Cari Pasien Berdasarkan : nama, no rm, no ktp
                    @endif
                </div>
                <div class="d-sm-flex align-items-sm-start">
                    <div class="form-control-feedback form-control-feedback-start flex-grow-1 mb-3 mb-sm-0">
                        <select class="form-select" name="patient_id" id="patient_id" required>
                            @if($patient)
                                <option value="{{ $patient->id }}" selected>{{ $patient->name }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="ms-sm-3">
                        <button type="submit" class="btn btn-primary w-100 w-sm-auto" onclick="onLoading('show', '.content')">Cari Tagihan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @if($hasSearching == 'exists')
        <div class="d-lg-flex align-items-lg-start">
            <div class="sidebar sidebar-component sidebar-expand-lg bg-transparent shadow-none me-lg-3">
                <div class="sidebar-content">
                    <div class="card">
                        <ul class="nav nav-sidebar">
                            <li class="nav-item">
                                <a href="#tabs-1" class="nav-link active" data-bs-toggle="tab">
                                    <i class="ph-info me-2"></i>
                                    Informasi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tabs-2" class="nav-link" data-bs-toggle="tab">
                                    <i class="ph-person-simple-walk me-2"></i>
                                    Rawat Jalan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tabs-3" class="nav-link" data-bs-toggle="tab">
                                    <i class="ph-first-aid-kit me-2"></i>
                                    Rawat Inap
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tabs-4" class="nav-link" data-bs-toggle="tab">
                                    <i class="ph-first-aid me-2"></i>
                                    IGD
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tabs-5" class="nav-link" data-bs-toggle="tab">
                                    <i class="ph-flask me-2"></i>
                                    Laboratorium
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tabs-6" class="nav-link" data-bs-toggle="tab">
                                    <i class="ph-monitor me-2"></i>
                                    Radiologi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tabs-7" class="nav-link" data-bs-toggle="tab">
                                    <i class="ph-bed me-2"></i>
                                    Operasi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tabs-8" class="nav-link" data-bs-toggle="tab">
                                    <i class="ph-drop-half-bottom me-2"></i>
                                    Resep
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#tabs-9" class="nav-link" data-bs-toggle="tab">
                                    <i class="ph-money me-2"></i>
                                    Ringkasan
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="tab-content flex-fill">
                <div class="tab-pane fade active show" id="tabs-1">
                    <div class="card">
                        <div class="card-header d-sm-flex">
                            <h5 class="mb-0">Informasi Data Pasien</h5>
                        </div>
                        <div style="max-height:600px; overflow-y:auto;">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th class="bg-light" width="25%">Provinsi</th>
                                        <td>{{ $patient->province->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">Kota</th>
                                        <td>{{ $patient->city->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">Kecamatan</th>
                                        <td>{{ $patient->district->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">Agama</th>
                                        <td>{{ $patient->religion->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">Kode Lama</th>
                                        <td>{{ $patient->code_old }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">Kode Member</th>
                                        <td>{{ $patient->code_member }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">No KTP</th>
                                        <td>{{ $patient->identity_number }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">Nama</th>
                                        <td>{{ $patient->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">Sapaan</th>
                                        <td>{{ $patient->greeted_format_result }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">Jenis Kelamin</th>
                                        <td>{{ $patient->gender_format_result }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">Tempat Lahir</th>
                                        <td>{{ $patient->place_of_birth }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">Tanggal Lahir</th>
                                        <td>{{ $patient->date_of_birth }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">RT</th>
                                        <td>{{ $patient->rt }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">RW</th>
                                        <td>{{ $patient->rw }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">Desa / Kelurahan</th>
                                        <td>{{ $patient->village }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">Alamat</th>
                                        <td>{{ $patient->address }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">Suku</th>
                                        <td>{{ $patient->tribe }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">Berat</th>
                                        <td>{{ $patient->weight }} Kg</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">Golongan Darah</th>
                                        <td>{{ $patient->blood_group_format_result }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">Status Pernikahan</th>
                                        <td>{{ $patient->marital_status_format_result }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">Pekerjaan</th>
                                        <td>{{ $patient->job }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">No Telp</th>
                                        <td>{{ $patient->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">Nama Orang Tua</th>
                                        <td>{{ $patient->parent_name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">Nama Pasangan (Suami / Istri)</th>
                                        <td>{{ $patient->partner_name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">Tanggal Didaftarkan</th>
                                        <td>{{ $patient->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light" width="25%">Tanggal Diperbarui</th>
                                        <td>{{ $patient->updated_at }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tabs-2">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Tagihan Rawat Jalan</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-fix-header">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Kode</th>
                                            <th>Tanggal</th>
                                            <th>Golongan</th>
                                            <th>Poli</th>
                                            <th>Tertagih</th>
                                            <th class="text-center" nowrap><i class="ph-gear"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($outpatient->count() > 0)
                                            @foreach($outpatient as $key => $o)
                                                @php $totalOutpatient += $o->totalAction(); $total += $o->totalAction(); @endphp
                                                <tr>
                                                    <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                    <td class="align-middle">{{ $o->code() }}</td>
                                                    <td class="align-middle">{{ $o->created_at->format('Y-m-d') }}</td>
                                                    <td class="align-middle">{{ $o->type_format_result }}</td>
                                                    <td class="align-middle">{{ $o->unit->name ?? '-' }}</td>
                                                    <td class="align-middle">{{ Simrs::formatRupiah($o->totalAction()) }}</td>
                                                    <td class="align-middle">
                                                        <div class="text-center">
                                                            <a href="{{ url('bill/outpatient/detail/' . $o->id) }}" target="_blank" class="btn btn-primary btn-sm">
                                                                <i class="ph-info me-1"></i>
                                                                Detail
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="text-center">
                                                <td colspan="7">Tidak ada tagihan</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tabs-3">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Tagihan Rawat Inap</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-fix-header">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Kode</th>
                                            <th>Tanggal</th>
                                            <th>Golongan</th>
                                            <th>Kelas</th>
                                            <th>Tertagih</th>
                                            <th class="text-center" nowrap><i class="ph-gear"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($inpatient->count() > 0)
                                            @foreach($inpatient as $key => $i)
                                                @php $totalInpatient += $i->totalAction(); $total += $i->totalAction(); @endphp
                                                <tr>
                                                    <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                    <td class="align-middle">{{ $i->code() }}</td>
                                                    <td class="align-middle">{{ $i->created_at->format('Y-m-d') }}</td>
                                                    <td class="align-middle">{{ $i->type_format_result }}</td>
                                                    <td class="align-middle">{{ $i->bed->roomSpace->roomType->classType->name ?? '-' }}</td>
                                                    <td class="align-middle">{{ Simrs::formatRupiah($i->totalAction()) }}</td>
                                                    <td class="align-middle">
                                                        <div class="text-center">
                                                            <a href="{{ url('bill/inpatient/detail/' . $i->id) }}" target="_blank" class="btn btn-primary btn-sm">
                                                                <i class="ph-info me-1"></i>
                                                                Detail
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="text-center">
                                                <td colspan="7">Tidak ada tagihan</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tabs-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Tagihan IGD</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-fix-header">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Kode</th>
                                            <th>Tanggal</th>
                                            <th>Golongan</th>
                                            <th>UPF</th>
                                            <th>Tertagih</th>
                                            <th class="text-center" nowrap><i class="ph-gear"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($emergencyDepartment->count() > 0)
                                            @foreach($emergencyDepartment as $key => $ed)
                                                @php $totalEmergencyDepartment += $ed->totalAction(); $total += $ed->totalAction(); @endphp
                                                <tr>
                                                    <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                    <td class="align-middle">{{ $ed->code() }}</td>
                                                    <td class="align-middle">{{ $ed->created_at->format('Y-m-d') }}</td>
                                                    <td class="align-middle">{{ $ed->type_format_result }}</td>
                                                    <td class="align-middle">{{ $ed->functionalService->name ?? '-' }}</td>
                                                    <td class="align-middle">{{ Simrs::formatRupiah($ed->totalAction()) }}</td>
                                                    <td class="align-middle">
                                                        <div class="text-center">
                                                            <a href="{{ url('bill/emergency-department/detail/' . $ed->id) }}" target="_blank" class="btn btn-primary btn-sm">
                                                                <i class="ph-info me-1"></i>
                                                                Detail
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="text-center">
                                                <td colspan="7">Tidak ada tagihan</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tabs-5">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Tagihan Laboratorium</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-fix-header">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Ref</th>
                                            <th>User</th>
                                            <th>Tanggal Permintaan</th>
                                            <th>Tertagih</th>
                                            <th class="text-center" nowrap><i class="ph-gear"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($laboratorium->count() > 0)
                                            @foreach($laboratorium as $key => $l)
                                                @php $totalLab += $l->total(); $total += $l->total(); @endphp
                                                <tr>
                                                    <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                    <td class="align-middle">{{ $l->ref() }}</td>
                                                    <td class="align-middle">{{ $l->user ? $l->user->employee->name : 'Belum Ada' }}</td>
                                                    <td class="align-middle">{{ $l->date_of_request }}</td>
                                                    <td class="align-middle">{{ Simrs::formatRupiah($l->total()) }}</td>
                                                    <td class="align-middle">
                                                        <div class="text-center">
                                                            <a href="{{ url('bill/lab/detail/' . $l->id) }}" target="_blank" class="btn btn-primary btn-sm">
                                                                <i class="ph-info me-1"></i>
                                                                Detail
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="text-center">
                                                <td colspan="6">Tidak ada tagihan</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tabs-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Tagihan Radiologi</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-fix-header">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Hasil</th>
                                            <th>User</th>
                                            <th>Tindakan</th>
                                            <th>Tanggal Permintaan</th>
                                            <th>Tertagih</th>
                                            <th class="text-center" nowrap><i class="ph-gear"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($radiology->count() > 0)
                                            @foreach($radiology as $key => $r)
                                                @php $totalRadiology += $r->total(); $total += $r->total(); @endphp
                                                <tr>
                                                    <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                    <td class="text-center align-middle">
                                                        <a href="{{ $r->image() }}" data-bs-popup="glightbox">
                                                            <img src="{{ $r->image() }}" class="img-preview rounded">
                                                        </a>
                                                    </td>
                                                    <td class="align-middle">{{ $r->user ? $r->user->employee->name : 'Belum Ada' }}</td>
                                                    <td class="align-middle">{{ $r->radiology->type . ' - ' . $r->radiology->object . ' - ' . $r->radiology->projection }}</td>
                                                    <td class="align-middle">{{ $r->date_of_request }}</td>
                                                    <td class="align-middle">{{ Simrs::formatRupiah($r->total()) }}</td>
                                                    <td class="align-middle">
                                                        <div class="text-center">
                                                            <a href="{{ url('bill/radiology/detail/' . $r->id) }}" target="_blank" class="btn btn-primary btn-sm">
                                                                <i class="ph-info me-1"></i>
                                                                Detail
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="text-center">
                                                <td colspan="7">Tidak ada tagihan</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tabs-7">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Tagihan Operasi</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-fix-header">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Kode</th>
                                            <th>Tanggal</th>
                                            <th>Unit</th>
                                            <th>Ref</th>
                                            <th>Tertagih</th>
                                            <th class="text-center"><i class="ph-gear"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($operation->count() > 0)
                                            @foreach($operation as $key => $o)
                                                @php $totalOperation += $o->total(false); $total += $o->total(false); @endphp
                                                <tr>
                                                    <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                    <td class="align-middle">{{ $o->code() }}</td>
                                                    <td class="align-middle">{{ $o->created_at->format('Y-m-d') }}</td>
                                                    <td class="align-middle">{{ $o->unit->name ?? '-' }}</td>
                                                    <td class="align-middle">{{ $o->ref() ?? '-' }}</td>
                                                    <td class="align-middle">{{ Simrs::formatRupiah($o->total(false)) }}</td>
                                                    <td class="align-middle">
                                                        <div class="text-center">
                                                            <a href="{{ url('bill/operation/detail/' . $o->id) }}" target="_blank" class="btn btn-primary btn-sm">
                                                                <i class="ph-info me-1"></i>
                                                                Detail
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="text-center">
                                                <td colspan="7">Tidak ada tagihan</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tabs-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Tagihan Resep</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-fix-header">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Ref</th>
                                            <th>Apotek</th>
                                            <th>Tanggal</th>
                                            <th>Tertagih</th>
                                            <th class="text-center"><i class="ph-gear"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($recipe->count() > 0)
                                            @foreach($recipe as $key => $r)
                                                @php $totalRecipe += $r->total(); $total += $r->total(); @endphp
                                                <tr>
                                                    <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                    <td class="align-middle">{{ $r->ref() ?? '-' }}</td>
                                                    <td class="align-middle">{{ $r->dispensary->name ?? '-' }}</td>
                                                    <td class="align-middle">{{ $r->created_at->format('Y-m-d') }}</td>
                                                    <td class="align-middle">{{ Simrs::formatRupiah($r->total()) }}</td>
                                                    <td class="align-middle">
                                                        <div class="text-center">
                                                            <a href="{{ url('bill/medicine-and-tool/detail/' . $r->id) }}" target="_blank" class="btn btn-primary btn-sm">
                                                                <i class="ph-info me-1"></i>
                                                                Detail
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="text-center">
                                                <td colspan="6">Tidak ada tagihan</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tabs-9">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Ringkasan</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th>Rawat Jalan</th>
                                    <td>{{ Simrs::formatRupiah($totalOutpatient) }}</td>
                                </tr>
                                <tr>
                                    <th>Rawat Inap</th>
                                    <td>{{ Simrs::formatRupiah($totalInpatient) }}</td>
                                </tr>
                                <tr>
                                    <th>IGD</th>
                                    <td>{{ Simrs::formatRupiah($totalEmergencyDepartment) }}</td>
                                </tr>
                                <tr>
                                    <th>Laboratorium</th>
                                    <td>{{ Simrs::formatRupiah($totalLab) }}</td>
                                </tr>
                                <tr>
                                    <th>Radiologi</th>
                                    <td>{{ Simrs::formatRupiah($totalRadiology) }}</td>
                                </tr>
                                <tr>
                                    <th>Operasi</th>
                                    <td>{{ Simrs::formatRupiah($totalOperation) }}</td>
                                </tr>
                                <tr>
                                    <th>Resep</th>
                                    <td>{{ Simrs::formatRupiah($totalRecipe) }}</td>
                                </tr>
                            </table>
                            @if($total > 0)
                                <div class="form-group"><hr></div>
                                <div class="text-center">
                                    <h6 class="text-uppercase fw-bold">Total Yang Harus Dibayar</h6>
                                    <h3 class="text-primary fw-bold mb-0">{{ Simrs::formatRupiah($total) }}</h3>
                                </div>
                                <div class="form-group"><hr></div>
                                <div class="text-center fst-italic">Terbilang : {{ Simrs::numerator($total) }}</div>
                                <div class="form-group"><hr></div>
                                <div class="text-right">
                                    <form action="{{ url('bill/whole') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                                        <input type="hidden" name="pay" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-success col-12" onclick="onLoading('show', '.content')">
                                            <i class="ph-check-circle me-2"></i>
                                            Bayar Semua Tagihan
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    $(function() {
        sidebarMini();
        fullWidthAllDevice();
        select2Ajax('#patient_id', 'patient', false);
    });
</script>
