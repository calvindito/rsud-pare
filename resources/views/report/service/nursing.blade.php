<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Laporan - Jasa Pelayanan - <span class="fw-normal">Perawat</span>
            </h5>
        </div>
    </div>
</div>
<div class="content pt-0">
    @if(session('validation'))
        <div class="alert alert-warning alert-icon-start fade show">
            <span class="alert-icon bg-warning text-white">
                <i class="ph-warning-circle"></i>
            </span>
            <span class="fw-semibold">Oppss!</span> {{ session('validation') }}
        </div>
    @endif
    <div class="accordion mb-3" id="accordion_collapsed">
        <div class="accordion-item bg-white">
            <h2 class="accordion-header">
                <button type="button" class="accordion-button fw-semibold collapsed fs-6" data-bs-toggle="collapse" data-bs-target="#collapsed-filter">Cari Data</button>
            </h2>
            <div id="collapsed-filter" class="accordion-collapse collapse bg-white show" data-bs-parent="#accordion_collapsed">
                <div class="accordion-body">
                    <form>
                        @csrf
                        <div class="form-group row">
                            <label class="col-form-label col-lg-1">Perawat</label>
                            <div class="col-md-11">
                                <select class="form-select select2-form" name="employee_id" id="employee_id" required>
                                    <option value=""></option>
                                    @foreach($employee as $e)
                                        <option value="{{ $e->id }}" {{ $employeeId == $e->id ? 'selected' : '' }}>{{ $e->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-1">Tanggal</label>
                            <div class="col-md-11">
                                <input type="text" class="form-control daterange-picker" name="date" id="date" value="{{ $date }}" placeholder="Pilih Tanggal" readonly required>
                            </div>
                        </div>
                        <div class="form-group"><hr></div>
                        <div class="form-group mb-0">
                            <div class="text-end">
                                <a href="{{ url('report/service/nursing') }}" class="btn btn-danger" onclick="onLoading('show', '.content')">
                                    <i class="ph-arrows-counter-clockwise me-1"></i>
                                    Reset Pencarian
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ph-magnifying-glass me-1"></i>
                                    Terapkan Pencarian
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if($contentable === true)
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead class="bg-light">
                        <tr>
                            <th>Name</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Operasi</td>
                            <td>{{ Simrs::formatRupiah($operation) }}</td>
                        </tr>
                        <tr>
                            <td>Laboratorium</td>
                            <td>{{ Simrs::formatRupiah($lab) }}</td>
                        </tr>
                        <tr>
                            <td>Radiologi</td>
                            <td>{{ Simrs::formatRupiah($radiology) }}</td>
                        </tr>
                        <tr>
                            <td>Tindakan</td>
                            <td>{{ Simrs::formatRupiah($action) }}</td>
                        </tr>
                    </tbody>
                    <tfoot class="bg-light">
                        <tr class="bg-light">
                            <th>TOTAL KESELURUHAN</th>
                            <th>{{ Simrs::formatRupiah($operation + $lab + $radiology + $action) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endif
</div>

<script>
    $(function() {
        datePickerable('.daterange-picker');

        $('.select2-form').select2({
            placeholder: '-- Pilih --'
        });
    });
</script>
