<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Keuangan - Anggaran - <span class="fw-normal">Detail Data</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('finance/budget') }}" class="btn btn-flat-primary">
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
<div class="content pt-0">
    <div class="alert alert-danger d-none" id="validation-element">
        <ul class="mb-0" id="validation-data"></ul>
    </div>
    <form id="form-data">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th width="15%">Tanggal Dibuat</th>
                            <th width="1%" class="text-center">:</th>
                            <td>{{ $budget->created_at->format('Y-m-d') }}</td>
                        </tr>
                        <tr>
                            <th width="15%">Tanggal Anggaran</th>
                            <th width="1%" class="text-center">:</th>
                            <td>{{ $budget->date }}</td>
                        </tr>
                        <tr>
                            <th width="15%">Status</th>
                            <th width="1%" class="text-center">:</th>
                            <td>{!! $budget->status() !!}</td>
                        </tr>
                        <tr>
                            <th width="15%">Keterangan</th>
                            <th width="1%" class="text-center">:</th>
                            <td>{{ $budget->description }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group"><hr></div>
                <ul class="nav nav-tabs nav-tabs-solid nav-justified mb-3">
                    <li class="nav-item">
                        <a href="#tabs-1" class="nav-link active" data-bs-toggle="tab">Form</a>
                    </li>
                    <li class="nav-item">
                        <a href="#tabs-2" class="nav-link" data-bs-toggle="tab">Histori</a>
                    </li>
                </ul>
                <div class="tab-content flex-lg-fill">
                    <div class="tab-pane fade show active" id="tabs-1">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>Bagan Akun</th>
                                    <th>Nominal</th>
                                    <th>Limit BLUD</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($chartOfAccount as $coa)
                                    <tr>
                                        <td>{{ $coa->fullname }}</td>
                                        <td>
                                            {{ Simrs::formatRupiah($budget->budgetDetail()->firstWhere('chart_of_account_id', $coa->id)->nominal ?? 0) }}
                                        </td>
                                        <td>
                                            {{ Simrs::formatRupiah($budget->budgetDetail()->firstWhere('chart_of_account_id', $coa->id)->limit_blud ?? 0) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="tabs-2">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($budget->budgetHistory->count() > 0)
                                    @foreach($budget->budgetHistory as $key => $bh)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $bh->user->employee->name }}</td>
                                            <td>{{ $bh->status }}</td>
                                            <td>{{ $bh->reason }}</td>
                                            <td>{{ $bh->created_at }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada histori</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                @if($budget->status == 2)
                    <div class="alert alert-primary text-center mb-0">Data anda sedang diajukan, dimohon menunggu, data anggaran yang anda ajukan akan segera diproses</div>
                @elseif($budget->status == 4)
                    <div class="alert alert-success text-center mb-0">Selamat, anggaran anda telah disetujui</div>
                @elseif($budget->status == 5)
                    <div class="alert alert-danger text-center mb-0">
                        Mohon maaf sekali, anggaran yang anda ajukan telah ditolak
                        <div class="form-group"><hr></div>
                        <span class="fw-semibold">Alasan : {{ $budget->budgetHistory()->latest()->first()->reason ?? '-' }}</span>
                    </div>
                @else
                    <div class="alert alert-warning text-center mb-0">Invalid</div>
                @endif
            </div>
        </div>
    </form>
</div>

<script>
    $(function() {
        sidebarMini();
        fullWidthAllDevice();
    });
</script>
