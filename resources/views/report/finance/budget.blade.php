<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Laporan - Keuangan - <span class="fw-normal">Anggaran</span>
            </h5>
        </div>
    </div>
</div>
<div class="content pt-0">
    <form action="">
        <div class="card">
            <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
                <h6 class="py-sm-3 mb-sm-0">Rencana Bisnis & Anggaran</h6>
                <small class="text-muted ms-2">
                    @if($year)
                        Tahun {{ $year }}
                    @else
                        Semua Tahun
                    @endif
                </small>
                <div class="ms-sm-auto my-sm-auto">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ph-calendar"></i></span>
                        <select class="form-select wmin-100" name="year" id="year" onchange="onLoading('show', '.content'); this.form.submit()">
                            <option value="">Semua Tahun</option>
                            @for($i = date('Y'); $i >= 2015; $i--)
                                <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>Tahun {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-columned">
                    <thead class="table-primary">
                        <tr>
                            <th>Kode</th>
                            <th>Akun</th>
                            <th>Nominal</th>
                            <th>BLUD</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalNominal = 0;
                            $totalLimitBlud = 0;
                        @endphp
                        @foreach($chartOfAccount as $coa)
                            @php
                                $sumNominal = $coa->budgetDetail()->when($year, function($query, $year) {
                                    $query->whereYear('date', $year);
                                })->sum('nominal');

                                $sumLimitBlud = $coa->budgetDetail()->when($year, function($query, $year) {
                                    $query->whereYear('date', $year);
                                })->sum('limit_blud');

                                $totalNominal += $sumNominal;
                                $totalLimitBlud += $totalLimitBlud;
                            @endphp
                            <tr>
                                <td class="align-middle">{{ $coa->code }}</td>
                                <td class="align-middle">{{ $coa->fullname }}</td>
                                <td class="align-middle text-end">{{ Simrs::formatRupiah($sumNominal) }}</td>
                                <td class="align-middle text-end">{{ Simrs::formatRupiah($sumLimitBlud) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-light">
                        <tr>
                            <th colspan="2" class="align-middle text-uppercase fw-bold">Total</th>
                            <th class="align-middle fw-bold text-end">{{ Simrs::formatRupiah($totalNominal) }}</th>
                            <th class="align-middle fw-bold text-end">{{ Simrs::formatRupiah($totalNominal) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </form>
</div>
