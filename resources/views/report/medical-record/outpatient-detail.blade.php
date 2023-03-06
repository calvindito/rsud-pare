<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Laporan - Rekam Medis - Rawat Jalan - <span class="fw-normal">Detail</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('report/medical-record/outpatient') }}" class="btn btn-flat-primary">Kembali ke Daftar</a>
        </div>
    </div>
</div>
<div class="content pt-0">
    <div class="d-lg-flex align-items-lg-start">
        <div class="sidebar sidebar-component sidebar-expand-lg bg-transparent shadow-none me-lg-3">
            <div class="sidebar-content">
                <div class="card">
                    <ul class="nav nav-sidebar">
                        <li class="nav-item">
                            <a href="#tabs-1" class="nav-link active" data-bs-toggle="tab">
                                <i class="ph-info me-2"></i>
                                Data
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabs-2" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-person-simple-run me-2"></i>
                                Tindakan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabs-3" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-chat-centered-text me-2"></i>
                                SOAP
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tabs-4" class="nav-link" data-bs-toggle="tab">
                                <i class="ph-bezier-curve me-2"></i>
                                Diagnosa
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
                    <div style="max-height:470px; overflow-y:auto;">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="bg-light" width="25%">Kode</th>
                                    <td>{{ $outpatient->code() }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light" width="25%">User</th>
                                    <td>{{ $outpatient->user->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light" width="25%">Pasien</th>
                                    <td>{{ $outpatient->patient->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light" width="25%">Poli</th>
                                    <td>{{ $outpatient->unit->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light" width="25%">Apotek</th>
                                    <td>{{ $outpatient->dispensary->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light" width="25%">Dokter</th>
                                    <td>{{ $outpatient->doctor->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light" width="25%">Ref</th>
                                    <td>{{ isset($outpatient->parent) ? $outpatient->parent->code() : 'Tidak Ada' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light" width="25%">Golongan</th>
                                    <td>{{ $outpatient->type_format_result }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light" width="25%">Tanggal Dibuat</th>
                                    <td>{{ $outpatient->created_at }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light" width="25%">Tanggal Masuk</th>
                                    <td>{{ $outpatient->date_of_entry }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light" width="25%">Tanggal Keluar</th>
                                    <td>{{ $outpatient->date_of_out }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light" width="25%">Kehadiran</th>
                                    <td>{{ $outpatient->presence_format_result }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light" width="25%">Keterangan</th>
                                    <td>{{ $outpatient->description }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light" width="25%">Pembayaran</th>
                                    <td>{!! $outpatient->paid() !!}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light" width="25%">Status</th>
                                    <td>{{ $outpatient->status() }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tabs-2">
                <div class="card">
                    <div class="card-body">
                        <div class="table-fix-header">
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Dokter</th>
                                        <th>Tindakan</th>
                                        <th>Nominal</th>
                                        <th class="text-center">Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($outpatient->outpatientAction->count() > 0)
                                        @foreach($outpatient->outpatientAction as $key => $oa)
                                            <tr>
                                                <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                <td class="align-middle">{{ $oa->doctor->name ?? '-' }}</td>
                                                <td class="align-middle">{{ $oa->unitAction->action->name ?? '-' }}</td>
                                                <td class="align-middle">{{ Simrs::formatRupiah($oa->total()) }}</td>
                                                <td class="text-center align-middle">{!! $oa->status() !!}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td colspan="5">Tidak ada tindakan</td>
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
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-tabs-solid nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#tabs-soap-1" class="nav-link active" data-bs-toggle="tab">Askep</a>
                            </li>
                            <li class="nav-item">
                                <a href="#tabs-soap-2" class="nav-link" data-bs-toggle="tab">Chekup</a>
                            </li>
                        </ul>
                        <div class="tab-content flex-lg-fill">
                            <div class="tab-pane fade show active" id="tabs-soap-1">
                                <div class="mb-5 mt-5">
                                    <div class="fw-semibold border-bottom pb-2 mb-3 fs-5">Askep</div>
                                    {!! $soap->where('type', 1)->value ?? 'Tidak Ada' !!}
                                </div>
                                <div class="mb-5">
                                    <div class="fw-semibold border-bottom pb-2 mb-3 fs-5">Subjective</div>
                                    {!! $soap->where('type', 1)->subjective ?? 'Tidak Ada' !!}
                                </div>
                                <div class="mb-5">
                                    <div class="fw-semibold border-bottom pb-2 mb-3 fs-5">Objective</div>
                                    {!! $soap->where('type', 1)->objective ?? 'Tidak Ada' !!}
                                </div>
                                <div class="mb-5">
                                    <div class="fw-semibold border-bottom pb-2 mb-3 fs-5">Assessment</div>
                                    {!! $soap->where('type', 1)->assessment ?? 'Tidak Ada' !!}
                                </div>
                                <div class="mb-5">
                                    <div class="fw-semibold border-bottom pb-2 mb-3 fs-5">Planning</div>
                                    {!! $soap->where('type', 1)->planning ?? 'Tidak Ada' !!}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-soap-2">
                                <div class="mb-5 mt-5">
                                    <div class="fw-semibold border-bottom pb-2 mb-3 fs-5">Subjective</div>
                                    {!! $soap->where('type', 2)->subjective ?? 'Tidak Ada' !!}
                                </div>
                                <div class="mb-5">
                                    <div class="fw-semibold border-bottom pb-2 mb-3 fs-5">Objective</div>
                                    {!! $soap->where('type', 2)->objective ?? 'Tidak Ada' !!}
                                </div>
                                <div class="mb-5">
                                    <div class="fw-semibold border-bottom pb-2 mb-3 fs-5">Assessment</div>
                                    {!! $soap->where('type', 2)->assessment ?? 'Tidak Ada' !!}
                                </div>
                                <div class="mb-5">
                                    <div class="fw-semibold border-bottom pb-2 mb-3 fs-5">Planning</div>
                                    {!! $soap->where('type', 2)->planning ?? 'Tidak Ada' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tabs-4">
                <div class="card">
                    <div class="card-body">
                        <div class="table-fix-header">
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Jenis</th>
                                        <th>Isian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($diagnosis->count() > 0)
                                        @foreach($diagnosis as $key => $d)
                                            <tr>
                                                <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                <td class="align-middle">{{ $d->type() }}</td>
                                                <td class="align-middle">{{ $d->value }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td colspan="3">Tidak ada data</td>
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
                    <div class="card-body">
                        <div class="table-fix-header">
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>User</th>
                                        <th>Tanggal Permintaan</th>
                                        <th>Nominal</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Hasil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($laboratorium->count() > 0)
                                        @foreach($laboratorium as $key => $l)
                                            <tr>
                                                <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                <td class="align-middle">{{ $l->user ? $l->user->employee->name : 'Belum Ada' }}</td>
                                                <td class="align-middle">{{ $l->date_of_request }}</td>
                                                <td class="align-middle">{{ Simrs::formatRupiah($l->total()) }}</td>
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
            <div class="tab-pane fade" id="tabs-6">
                <div class="card">
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
                                                                            <tr>
                                                                                <td>Nominal</td>
                                                                                <td width="1%">:</td>
                                                                                <td>{{ Simrs::formatRupiah($r->total()) }}</td>
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
            <div class="tab-pane fade" id="tabs-7">
                <div class="card">
                    <div class="card-body">
                        @if($operation)
                            <div class="table-fix-header">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th class="bg-light" width="25%">Nominal</th>
                                            <td>{{ Simrs::formatRupiah(isset($operation) ? $operation->total() : 0) }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light" width="25%">User</th>
                                            <td>{{ $operation->user->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light" width="25%">Tindakan</th>
                                            <td>{{ $operation->operatingRoomAction->operatingRoomActionType->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light" width="25%">UPF</th>
                                            <td>{{ $operation->functionalService->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light" width="25%">Anestesi</th>
                                            <td>{{ $operation->operatingRoomAnesthetist->code ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light" width="25%">Dokter</th>
                                            <td>{{ $operation->doctor->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light" width="25%">Unit</th>
                                            <td>{{ $operation->unit->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light" width="25%">Dokter Operasi</th>
                                            <td>{{ $operation->doctorOperation->name ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light" width="25%">Tanggal Masuk</th>
                                            <td>{{ $operation->created_at ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light" width="25%">Tanggal Keluar</th>
                                            <td>{{ $operation->updated_at ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light" width="25%">Diagnosa</th>
                                            <td>{{ $operation->diagnosis ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light" width="25%">Spesimen</th>
                                            <td>{{ $operation ? $operation->specimen == true ? 'Ya' : 'Tidak' : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light" width="25%">Status</th>
                                            <td>{!! isset($operation) ? $operation->status() : '-' !!}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info text-center fw-semibold mb-0">Belum ada operasi</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tabs-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-fix-header">
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Apotek</th>
                                        <th>Tanggal</th>
                                        <th>Nominal</th>
                                        <th>Status</th>
                                        <th class="text-center"><i class="ph-gear"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($recipe->count() > 0)
                                        @foreach($recipe as $key => $r)
                                            <tr>
                                                <td class="text-center align-middle">{{ $key + 1 }}</td>
                                                <td class="align-middle">{{ $r->dispensary->name ?? '-' }}</td>
                                                <td class="align-middle">{{ $r->created_at->format('Y-m-d') }}</td>
                                                <td class="align-middle">{{ Simrs::formatRupiah($r->total()) }}</td>
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
                                            <td colspan="6">Tidak ada data</td>
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
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Tindakan</th>
                                <td>{{ Simrs::formatRupiah($outpatient->costBreakdown()->action) }}</td>
                            </tr>
                            <tr>
                                <th>Laboratorium</th>
                                <td>{{ Simrs::formatRupiah($outpatient->costBreakdown()->lab) }}</td>
                            </tr>
                            <tr>
                                <th>Radiologi</th>
                                <td>{{ Simrs::formatRupiah($outpatient->costBreakdown()->radiology) }}</td>
                            </tr>
                            <tr>
                                <th>Operasi</th>
                                <td>{{ Simrs::formatRupiah($outpatient->costBreakdown()->operation) }}</td>
                            </tr>
                            <tr>
                                <th>Resep</th>
                                <td>{{ Simrs::formatRupiah($outpatient->costBreakdown()->dispensaryRequest) }}</td>
                            </tr>
                        </table>
                        @if($outpatient->total() > 0)
                            <div class="form-group"><hr></div>
                            <div class="text-center">
                                <h6 class="text-uppercase fw-bold">Total Keseluruhan</h6>
                                <h3 class="text-primary fw-bold mb-0">{{ Simrs::formatRupiah($outpatient->total()) }}</h3>
                            </div>
                            <div class="form-group"><hr></div>
                            <div class="text-center fst-italic">Terbilang : {{ Simrs::numerator($outpatient->total()) }}</div>
                        @endif
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
