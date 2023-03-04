<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Laporan - Rekam Medis - Pasien - <span class="fw-normal">Detail</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('report/medical-record/patient') }}" class="btn btn-flat-primary">Kembali ke Daftar</a>
        </div>
    </div>
</div>
<div class="content pt-0">
    <div class="d-lg-flex align-items-lg-start">
        <div class="sidebar sidebar-component sidebar-expand-lg bg-transparent shadow-none me-lg-3">
            <div class="sidebar-content">
                <div class="card">
                    <div class="sidebar-section-body text-center">
                        <div class="card-img-actions d-inline-block mb-3">
                            <img class="img-fluid rounded-circle" src="{{ asset('assets/patient.png') }}" width="150" height="150">
                        </div>
                        <h6 class="mb-0">{{ $patient->name }}</h6>
                        <span class="text-muted">{{ $patient->no_medical_record }}</span>
                    </div>
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
                                <span class="badge bg-primary rounded-pill ms-auto">{{ $outpatient->count() }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabs-3" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-first-aid-kit me-2"></i>
                                Rawat Inap
                                <span class="badge bg-primary rounded-pill ms-auto">{{ $inpatient->count() }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabs-4" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-first-aid me-2"></i>
                                IGD
                                <span class="badge bg-primary rounded-pill ms-auto">{{ $emergencyDepartment->count() }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabs-5" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-bezier-curve me-2"></i>
                                Diagnosa
                                <span class="badge bg-primary rounded-pill ms-auto">{{ $diagnosisTotal }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabs-6" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-flask me-2"></i>
                                Laboratorium
                                <span class="badge bg-primary rounded-pill ms-auto">{{ $laboratorium->count() }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabs-7" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-monitor me-2"></i>
                                Radiologi
                                <span class="badge bg-primary rounded-pill ms-auto">{{ $radiology->count() }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabs-8" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-bed me-2"></i>
                                Operasi
                                <span class="badge bg-primary rounded-pill ms-auto">{{ $operation->count() }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabs-9" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-drop-half-bottom me-2"></i>
                                Resep
                                <span class="badge bg-primary rounded-pill ms-auto">{{ $recipe->count() }}</span>
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
                        <div class="mt-2 mt-sm-0 ms-auto">
                            <span>
                                <i class="ph-clock-counter-clockwise me-1"></i>
                                Diperbarui {{ $patient->updated_at->diffForHumans() }}
                            </span>
                        </div>
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
                        <h5 class="mb-0">Histori Rawat Jalan</h5>
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
                                        <th>Status</th>
                                        <th class="text-center" nowrap><i class="ph-gear"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($outpatient->count() > 0)
                                        @foreach($outpatient as $key => $o)
                                            <tr>
                                                <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                <td class="align-middle">{{ $o->code() }}</td>
                                                <td class="align-middle">{{ $o->created_at->format('Y-m-d') }}</td>
                                                <td class="align-middle">{{ $o->type_format_result }}</td>
                                                <td class="align-middle">{{ $o->unit->name ?? '-' }}</td>
                                                <td class="align-middle">{{ $o->status() }}</td>
                                                <td class="align-middle">
                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#outpatient-{{ $o->code() }}">
                                                            <i class="ph-info me-1"></i>
                                                            Selengkapnya
                                                        </button>
                                                    </div>
                                                    <div id="outpatient-{{ $o->code() }}" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Detail Rawat Jalan</h5>
                                                                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                                                                        <i class="ph-x"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body p-0">
                                                                    <table class="table table-bordered">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">User</th>
                                                                                <td>{{ $o->user->name ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Poli</th>
                                                                                <td>{{ $o->unit->name ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Apotek</th>
                                                                                <td>{{ $o->dispensary->name ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Dokter</th>
                                                                                <td>{{ $o->doctor->name ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Golongan</th>
                                                                                <td>{{ $o->type_format_result }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Tanggal Masuk</th>
                                                                                <td>{{ $o->created_at }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Tanggal Keluar</th>
                                                                                <td>{{ $o->updated_at }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Kehadiran</th>
                                                                                <td>{{ $o->presence_format_result }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Keterangan</th>
                                                                                <td>{{ $o->description }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Status</th>
                                                                                <td>{{ $o->status() }}</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td colspan="7">Tidak ada histori</td>
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
                        <h5 class="mb-0">Histori Rawat Inap</h5>
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
                                        <th>Status</th>
                                        <th class="text-center" nowrap><i class="ph-gear"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($inpatient->count() > 0)
                                        @foreach($inpatient as $key => $i)
                                            <tr>
                                                <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                <td class="align-middle">{{ $i->code() }}</td>
                                                <td class="align-middle">{{ $i->created_at->format('Y-m-d') }}</td>
                                                <td class="align-middle">{{ $i->type_format_result }}</td>
                                                <td class="align-middle">{{ $i->bed->roomSpace->roomType->classType->name ?? '-' }}</td>
                                                <td class="align-middle">{!! $i->status() !!}</td>
                                                <td class="align-middle">
                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#inpatient-{{ $i->code() }}">
                                                            <i class="ph-info me-1"></i>
                                                            Selengkapnya
                                                        </button>
                                                    </div>
                                                    <div id="inpatient-{{ $i->code() }}" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Detail Rawat Inap</h5>
                                                                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                                                                        <i class="ph-x"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body p-0">
                                                                    <table class="table table-bordered">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">User</th>
                                                                                <td>{{ $i->user->name ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Kamar</th>
                                                                                <td>{{ $i->bed->roomSpace->roomType->name ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Kelas</th>
                                                                                <td>{{ $i->bed->roomSpace->roomType->classType->name ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">UPF</th>
                                                                                <td>{{ $i->functionalService->name ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Apotek</th>
                                                                                <td>{{ $i->dispensary->name ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Ref</th>
                                                                                <td>{{ isset($i->parent) ? $i->parent->code() : '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Dokter</th>
                                                                                <td>{{ $i->doctor->name ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Golongan</th>
                                                                                <td>{{ $i->type_format_result }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Tanggal Masuk</th>
                                                                                <td>{{ $i->created_at }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Tanggal Keluar</th>
                                                                                <td>{{ $i->updated_at }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Status</th>
                                                                                <td>{!! $i->status() !!}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Hasil</th>
                                                                                <td>{{ $i->ending_format_result }}</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td colspan="7">Tidak ada histori</td>
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
                        <h5 class="mb-0">Histori IGD</h5>
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
                                        <th>Status</th>
                                        <th class="text-center" nowrap><i class="ph-gear"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($emergencyDepartment->count() > 0)
                                        @foreach($emergencyDepartment as $key => $ed)
                                            <tr>
                                                <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                <td class="align-middle">{{ $ed->code() }}</td>
                                                <td class="align-middle">{{ $ed->created_at->format('Y-m-d') }}</td>
                                                <td class="align-middle">{{ $ed->type_format_result }}</td>
                                                <td class="align-middle">{{ $ed->functionalService->name ?? '-' }}</td>
                                                <td class="align-middle">{!! $ed->status() !!}</td>
                                                <td class="align-middle">
                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#emergency-department-{{ $ed->code() }}">
                                                            <i class="ph-info me-1"></i>
                                                            Selengkapnya
                                                        </button>
                                                    </div>
                                                    <div id="emergency-department-{{ $ed->code() }}" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Detail IGD</h5>
                                                                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                                                                        <i class="ph-x"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body p-0">
                                                                    <table class="table table-bordered">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">User</th>
                                                                                <td>{{ $ed->user->name ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">UPF</th>
                                                                                <td>{{ $ed->functionalService->name ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Apotek</th>
                                                                                <td>{{ $ed->dispensary->name ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Dokter</th>
                                                                                <td>{{ $ed->doctor->name ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Golongan</th>
                                                                                <td>{{ $ed->type_format_result }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Tanggal Masuk</th>
                                                                                <td>{{ $ed->created_at }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Tanggal Keluar</th>
                                                                                <td>{{ $ed->updated_at }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Status</th>
                                                                                <td>{!! $ed->status() !!}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Hasil</th>
                                                                                <td>{{ $ed->ending_format_result }}</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td colspan="7">Tidak ada histori</td>
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
                        <h5 class="mb-0">Histori Diagnosa</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-fix-header">
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Ref</th>
                                        <th>Tanggal</th>
                                        <th>Diagnosa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($diagnosis[1])
                                        @if($diagnosis[1]->count() > 0)
                                            @foreach($diagnosis[1] as $key => $d)
                                                <tr>
                                                    <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                    <td class="align-middle">{{ $d->ref }}</td>
                                                    <td class="align-middle">{{ $d->created_at->format('Y-m-d') }}</td>
                                                    <td class="align-middle">{{ $d->value }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="text-center">
                                                <td colspan="4">Tidak ada histori</td>
                                            </tr>
                                        @endif
                                    @else
                                        <tr class="text-center">
                                            <td colspan="4">Tidak ada histori</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Histori Tindakan</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-fix-header">
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Ref</th>
                                        <th>Tanggal</th>
                                        <th>Diagnosa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($diagnosis[1])
                                        @if($diagnosis[2]->count() > 0)
                                            @foreach($diagnosis[2] as $key => $d)
                                                <tr>
                                                    <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                    <td class="align-middle">{{ $d->ref }}</td>
                                                    <td class="align-middle">{{ $d->created_at->format('Y-m-d') }}</td>
                                                    <td class="align-middle">{{ $d->value }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="text-center">
                                                <td colspan="4">Tidak ada histori</td>
                                            </tr>
                                        @endif
                                    @else
                                        <tr class="text-center">
                                            <td colspan="4">Tidak ada histori</td>
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
                        <h5 class="mb-0">Histori Laboratorium</h5>
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
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Hasil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($laboratorium->count() > 0)
                                        @foreach($laboratorium as $key => $l)
                                            <tr>
                                                <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                <td class="align-middle">{{ $l->ref() }}</td>
                                                <td class="align-middle">{{ $l->user ? $l->user->employee->name : 'Belum Ada' }}</td>
                                                <td class="align-middle">{{ $l->date_of_request }}</td>
                                                <td class="text-center align-middle">{!! $l->status() !!}</td>
                                                <td class="align-middle">
                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#laboratorium-{{ $l->id }}">
                                                            <i class="ph-info me-1"></i>
                                                            Lihat
                                                        </button>
                                                    </div>
                                                    <div id="laboratorium-{{ $l->id }}" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                                        <div class="modal-dialog modal-fullscreen modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Hasil Cek</h5>
                                                                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                                                                        <i class="ph-x"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    @if($l->status == 1)
                                                                        <div class="alert alert-secondary">
                                                                            Mohon bersabar, permintaan anda akan segera diproses
                                                                        </div>
                                                                    @elseif($l->status == 2)
                                                                        <div class="alert alert-primary">
                                                                            Permintaan anda saat ini sedang diproses
                                                                            <span class="float-end fst-italic"><b>diproses oleh : {{ $l->user->employee->name }}</b></span>
                                                                        </div>
                                                                    @elseif($l->status == 4)
                                                                        <div class="alert alert-danger">
                                                                            Mohon maaf sekali, permintaan anda saat ini ditolak
                                                                            <span class="float-end fst-italic"><b>ditolak oleh : {{ $l->user->employee->name }}</b></span>
                                                                        </div>
                                                                    @else
                                                                        <table class="table table-bordered table-xs">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th nowrap>Grup</th>
                                                                                    <th nowrap>Item</th>
                                                                                    <th nowrap>Hasil</th>
                                                                                    <th nowrap>Normal</th>
                                                                                    <th nowrap>Satuan</th>
                                                                                    <th nowrap>Kondisi</th>
                                                                                    <th nowrap>Metode</th>
                                                                                    <th class="text-center" nowrap>Status</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach($l->labRequestDetail as $ld)
                                                                                    <tr>
                                                                                        <td class="align-middle">{{ $ld->labItem->labItemGroup->name }}</td>
                                                                                        <td class="align-middle">{{ $ld->labItem->name }}</td>
                                                                                        <td class="align-middle" nowrap>{{ $ld->result }}</td>
                                                                                        <td class="align-middle" nowrap>
                                                                                            @isset($ld->labItemParent)
                                                                                                @if($ld->labItemParent->limit_lower && $ld->labItemParent->limit_upper)
                                                                                                    {{ $ld->labItemParent->limit_lower . ' - ' . $ld->labItemParent->limit_upper }}
                                                                                                @elseif($ld->labItemParent->limit_upper)
                                                                                                    {{ $ld->labItemParent->limit_upper }}
                                                                                                @elseif($ld->labItemParent->limit_lower)
                                                                                                    {{ $ld->labItemParent->limit_lower }}
                                                                                                @else
                                                                                                    -
                                                                                                @endif
                                                                                            @else
                                                                                                -
                                                                                            @endif
                                                                                        </td>
                                                                                        <td class="align-middle" nowrap>{{ $ld->labItemParent->unit ?? '-' }}</td>
                                                                                        <td class="align-middle" nowrap>{{ $ld->labItemCondition->name ?? '-' }}</td>
                                                                                        <td class="align-middle" nowrap>{{ $ld->labItemParent->method ?? '-' }}</td>
                                                                                        <td class="align-middle text-center">
                                                                                            @isset($ld->labItemParent)
                                                                                                @if(!empty($ld->result))
                                                                                                    @if(!empty($ld->labItemParent->limit_lower) && !empty($ld->result <= $ld->labItemParent->limit_upper))
                                                                                                        @if($ld->result >= $ld->labItemParent->limit_lower && $ld->result <= $ld->labItemParent->limit_upper)
                                                                                                            <span class="badge bg-primary d-block">Normal</span>
                                                                                                        @else
                                                                                                            <span class="badge bg-danger d-block">Danger</span>
                                                                                                        @endif
                                                                                                    @elseif((!empty($ld->labItemParent->limit_lower) && empty($ld->labItemParent->limit_upper)))
                                                                                                        @if($ld->result >= $ld->labItemParent->limit_lower && $ld->result <= $ld->labItemParent->limit_lower)
                                                                                                            <span class="badge bg-primary d-block">Normal</span>
                                                                                                        @else
                                                                                                            <span class="badge bg-danger d-block">Danger</span>
                                                                                                        @endif
                                                                                                    @elseif((!empty($ld->labItemParent->limit_upper) && empty($ld->labItemParent->limit_lower)))
                                                                                                        @if($ld->result >= $ld->labItemParent->limit_upper && $ld->result <= $ld->labItemParent->limit_upper)
                                                                                                            <span class="badge bg-primary d-block">Normal</span>
                                                                                                        @else
                                                                                                            <span class="badge bg-danger d-block">Danger</span>
                                                                                                        @endif
                                                                                                    @else
                                                                                                        <span class="badge bg-secondary d-block">Tidak ada pembatas</span>
                                                                                                    @endif
                                                                                                @else
                                                                                                    <span class="badge bg-secondary d-block">Tidak ada pembatas</span>
                                                                                                @endif
                                                                                            @else
                                                                                                <span class="badge bg-secondary d-block">Tidak ada pembatas</span>
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td colspan="6">Tidak ada histori</td>
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
                        <h5 class="mb-0">Histori Radiologi</h5>
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
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($radiology->count() > 0)
                                        @foreach($radiology as $key => $r)
                                            <tr>
                                                <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                <td class="text-center align-middle">
                                                    <a href="{{ $r->image() }}" data-bs-popup="lightbox">
                                                        <img src="{{ $r->image() }}" class="img-preview rounded">
                                                    </a>
                                                </td>
                                                <td class="align-middle">{{ $r->user ? $r->user->employee->name : 'Belum Ada' }}</td>
                                                <td class="align-middle">{{ $r->radiology->type . ' - ' . $r->radiology->object . ' - ' . $r->radiology->projection }}</td>
                                                <td class="align-middle">{{ $r->date_of_request }}</td>
                                                <td class="text-center align-middle">{!! $r->status() !!}</td>
                                                <td class="align-middle">
                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-detail-{{ $key }}">
                                                            <i class="ph-eye me-1"></i>
                                                            Lihat
                                                        </button>
                                                    </div>
                                                    <div id="modal-detail-{{ $key }}" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                                        <div class="modal-dialog modal-fullscreen modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Hasil Radiologi</h5>
                                                                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                                                                        <i class="ph-x"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    @if($r->status == 1)
                                                                        <div class="alert alert-secondary">
                                                                            Mohon bersabar, permintaan anda akan segera diproses
                                                                        </div>
                                                                    @elseif($r->status == 2)
                                                                        <div class="alert alert-primary">
                                                                            Permintaan anda saat ini sedang diproses
                                                                            <span class="float-end fst-italic"><b>diproses oleh : {{ $r->user->employee->name }}</b></span>
                                                                        </div>
                                                                    @elseif($r->status == 4)
                                                                        <div class="alert alert-danger">
                                                                            Mohon maaf sekali, permintaan anda saat ini ditolak
                                                                            <span class="float-end fst-italic"><b>ditolak oleh : {{ $r->user->employee->name }}</b></span>
                                                                        </div>
                                                                    @else
                                                                        <table class="table">
                                                                            <tr class="bg-light">
                                                                                <th colspan="3">Data</th>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Pemeriksa</td>
                                                                                <td width="1%">:</td>
                                                                                <td>{{ $r->user->employee->name ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Tindakan</td>
                                                                                <td width="1%">:</td>
                                                                                <td>{{ $r->radiology->type . ' - ' . $r->radiology->object . ' - ' . $r->radiology->projection }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Foto</td>
                                                                                <td width="1%">:</td>
                                                                                <td><a href="{{ $r->image() }}" data-bs-popup="lightbox">Lihat Hasil Foto</a></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Tanggal Permintaan</td>
                                                                                <td width="1%">:</td>
                                                                                <td>{{ $r->date_of_request }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Klinis</td>
                                                                                <td width="1%">:</td>
                                                                                <td>{{ $r->clinical }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Kritis</td>
                                                                                <td width="1%">:</td>
                                                                                <td>{{ $r->critical ? 'Ya' : 'Tidak' }}</td>
                                                                            </tr>
                                                                            <tr class="bg-light">
                                                                                <th colspan="3">Expertise</th>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="3">
                                                                                    {!! $r->expertise !!}
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td colspan="7">Tidak ada histori</td>
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
                        <h5 class="mb-0">Histori Operasi</h5>
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
                                        <th class="text-center">Status</th>
                                        <th class="text-center"><i class="ph-gear"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($operation->count() > 0)
                                        @foreach($operation as $key => $o)
                                            <tr>
                                                <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                <td class="align-middle">{{ $o->code() }}</td>
                                                <td class="align-middle">{{ $o->created_at->format('Y-m-d') }}</td>
                                                <td class="align-middle">{{ $o->unit->name ?? '-' }}</td>
                                                <td class="align-middle">{{ $o->ref() ?? '-' }}</td>
                                                <td class="align-middle">{!! $o->status() !!}</td>
                                                <td class="align-middle">
                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#operation-{{ $o->code() }}">
                                                            <i class="ph-info me-1"></i>
                                                            Selengkapnya
                                                        </button>
                                                    </div>
                                                    <div id="operation-{{ $o->code() }}" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Detail Operasi</h5>
                                                                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                                                                        <i class="ph-x"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body p-0">
                                                                    <table class="table table-bordered">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">User</th>
                                                                                <td>{{ $o->user->name ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Tindakan</th>
                                                                                <td>{{ $o->operatingRoomAction->operatingRoomActionType->name ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">UPF</th>
                                                                                <td>{{ $o->functionalService->name ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Anestesi</th>
                                                                                <td>{{ $o->operatingRoomAnesthetist->code ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Dokter</th>
                                                                                <td>{{ $o->doctor->name ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Unit</th>
                                                                                <td>{{ $o->unit->name ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Dokter Operasi</th>
                                                                                <td>{{ $o->doctorOperation->name ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Ref</th>
                                                                                <td>{{ $o->ref() ?? '-' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Tanggal Masuk</th>
                                                                                <td>{{ $o->created_at }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Tanggal Keluar</th>
                                                                                <td>{{ $o->updated_at }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Diagnosa</th>
                                                                                <td>{{ $o->diagnosis }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Spesimen</th>
                                                                                <td>{{ $o->specimen == true ? 'Ya' : 'Tidak' }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th class="bg-light" width="25%">Status</th>
                                                                                <td>{!! $o->status() !!}</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td colspan="7">Tidak ada histori</td>
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
                        <h5 class="mb-0">Histori Resep</h5>
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
                                        <th>Status</th>
                                        <th class="text-center"><i class="ph-gear"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($recipe->count() > 0)
                                        @foreach($recipe as $key => $r)
                                            <tr>
                                                <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                <td class="align-middle">{{ $r->ref() ?? '-' }}</td>
                                                <td class="align-middle">{{ $r->dispensary->name ?? '-' }}</td>
                                                <td class="align-middle">{{ $r->created_at->format('Y-m-d') }}</td>
                                                <td class="align-middle">{!! $r->status() !!}</td>
                                                <td class="align-middle">
                                                    <div class="text-center">
                                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#medicine-{{ $key }}">
                                                            <i class="ph-info me-1"></i>
                                                            Selengkapnya
                                                        </button>
                                                    </div>
                                                    <div id="medicine-{{ $key }}" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Detail Obat & Alkes</h5>
                                                                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                                                                        <i class="ph-x"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <table class="table table-bordered">
                                                                        <thead class="bg-light">
                                                                            <tr>
                                                                                <th>Item</th>
                                                                                <th>Tanggal Kadaluwarsa</th>
                                                                                <th>Jenis</th>
                                                                                <th>Kuantitas</th>
                                                                                <th>Status</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($r->dispensaryRequestItem() as $dri)
                                                                                <tr>
                                                                                    <td class="align-middle">{{ $dri->dispensaryItemStock->dispensaryItem->item->name ?? '-' }}</td>
                                                                                    <td class="align-middle">{{ $dri->expired_date }}</td>
                                                                                    <td class="align-middle">
                                                                                        {{ $dri->dispensaryItemStock->dispensaryItem->item->type_format_result ?? '-' }}
                                                                                    </td>
                                                                                    <td class="align-middle">
                                                                                        {{ $dri->qty }}
                                                                                        <span class="float-end">
                                                                                            {{ $dri->dispensaryItemStock->dispensaryItem->item->itemUnit->name ?? '' }}
                                                                                        </span>
                                                                                    </td>
                                                                                    <td class="align-middle">{!! $dri->status() !!}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td colspan="6">Tidak ada histori</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        sidebarMini();
    });
</script>
