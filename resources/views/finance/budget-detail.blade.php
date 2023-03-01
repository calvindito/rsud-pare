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
                <div class="form-group row">
                    <label class="col-form-label col-lg-1">Tanggal <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-11">
                        <input type="date" class="form-control" name="date" id="date" value="{{ $budget->date }}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-1">Status <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-11">
                        <select class="form-select" name="status" id="status" disabled>
                            <option value="">-- Pilih --</option>
                            <option value="1" {{ $budget->status == 1 || $budget->status == 3 ? 'selected' : '' }}>Draft</option>
                            <option value="2" {{ $budget->status == 2 ? 'selected' : '' }}>Ajukan Sekarang</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-1">Keterangan <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-11">
                        <textarea class="form-control" name="description" id="description" style="resize:none;" placeholder="Masukan keterangan" disabled>{{ $budget->description }}</textarea>
                    </div>
                </div>
                @if($budget->status == 3)
                    <div class="alert alert-warning">
                        Anggaran anda sementara belum bisa disetujui dan ada beberapa hal yang harus anda perbaiki, mohon untuk merevisi data anggaran anda
                    </div>
                @endif
                <div class="form-group"><hr></div>
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
                                <input type="hidden" name="bd_chart_of_account_id[]" value="{{ $coa->id }}">
                                <td>{{ $coa->fullname }}</td>
                                <td>
                                    <input type="text" class="form-control number-format" name="bd_nominal[]" value="{{ $budget->budgetDetail()->firstWhere('chart_of_account_id', $coa->id)->nominal ?? '' }}" placeholder="0" disabled>
                                </td>
                                <td>
                                    <input type="text" class="form-control number-format" name="bd_limit_blud[]"value="{{ $budget->budgetDetail()->firstWhere('chart_of_account_id', $coa->id)->limit_blud ?? '' }}" placeholder="0" disabled>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                @if($budget->status == 2)
                    <div class="alert alert-primary text-center mb-0">Data anda sedang diajukan, dimohon menunggu data anggaran yang anda kirim akan segera diproses</div>
                @elseif($budget->status == 4)
                    <div class="alert alert-success text-center mb-0">Selamat, anggaran anda telah disetujui</div>
                @elseif($budget->status == 5)
                    <div class="alert alert-danger text-center mb-0">Mohon maaf sekali, anggaran yang anda ajukan telah ditolak</div>
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
