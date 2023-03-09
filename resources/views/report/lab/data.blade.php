<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Laporan - Laboratorium - <span class="fw-normal">Data</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-flat-primary dropdown-toggle" data-bs-toggle="dropdown">Refresh</button>
                <div class="dropdown-menu">
                    <a href="javascript:void(0);" class="dropdown-item" onclick="onReloadTable()">Data</a>
                    <a href="{{ url()->full() }}" class="dropdown-item">Halaman</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content pt-0">
    <div class="accordion mb-3" id="accordion_collapsed">
        <div class="accordion-item bg-white">
            <h2 class="accordion-header">
                <button type="button" class="accordion-button fw-semibold collapsed fs-6" data-bs-toggle="collapse" data-bs-target="#collapsed-filter">Filter Data</button>
            </h2>
            <div id="collapsed-filter" class="accordion-collapse collapse bg-white" data-bs-parent="#accordion_collapsed">
                <div class="accordion-body">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-1">Pasien</label>
                        <div class="col-md-11">
                            <select class="form-select" name="patient_id" id="patient_id"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-1">Dokter</label>
                        <div class="col-md-11">
                            <select class="form-select select2-form" name="doctor_id" id="doctor_id">
                                <option value=""></option>
                                @foreach($doctor as $d)
                                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-1">Ref</label>
                        <div class="col-md-11">
                            <select class="form-select select2-form" name="ref" id="ref">
                                <option value=""></option>
                                <option value="{{ App\Models\Outpatient::class }}">Rawat Jalan</option>
                                <option value="{{ App\Models\Inpatient::class }}">Rawat Inap</option>
                                <option value="{{ App\Models\EmergencyDepartment::class }}">IGD</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-1">Tanggal</label>
                        <div class="col-md-11">
                            <div class="input-group">
                                <select class="form-select w-auto flex-grow-0" name="column_date" id="column_date">
                                    <option value="created_at" selected>Tanggal Dibuat</option>
                                    <option value="date_of_request">Tanggal Permintaan</option>
                                </select>
                                <input type="text" class="form-control daterange-picker" name="date" id="date" placeholder="Pilih Tanggal" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-1">Pembayaran</label>
                        <div class="col-md-11">
                            <select class="form-select select2-form" name="paid" id="paid">
                                <option value=""></option>
                                <option value="1">Terbayar</option>
                                <option value="0">Belum Bayar</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-1">Status</label>
                        <div class="col-md-11">
                            <select class="form-select select2-form" name="status" id="status">
                                <option value=""></option>
                                <option value="1">Menunggu Diproses</option>
                                <option value="2">Sedang Diproses</option>
                                <option value="3">Selesai</option>
                                <option value="4">Ditolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group"><hr></div>
                    <div class="form-group mb-0">
                        <div class="text-end">
                            <a href="{{ url()->current() }}" class="btn btn-danger" onclick="onLoading('show', '.content')">
                                <i class="ph-arrows-counter-clockwise me-1"></i>
                                Reset Filter
                            </a>
                            <button type="button" class="btn btn-primary" onclick="loadData()">
                                <i class="ph-check-square-offset me-1"></i>
                                Terapkan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover table-xs display" id="datatable-serverside">
                <thead class="text-bg-light">
                    <tr>
                        <th class="text-center" nowrap><i class="ph-gear"></i></th>
                        <th nowrap>Pasien</th>
                        <th nowrap>Dokter</th>
                        <th nowrap>Ref</th>
                        <th nowrap>Tanggal</th>
                        <th nowrap>Nominal</th>
                        <th nowrap>Pembayaran</th>
                        <th nowrap>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div id="modal-detail" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data</h5>
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                    <i class="ph-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td rowspan="3" class="text-center">
                                <h6 class="text-uppercase">Total Biaya</h6>
                                <h3 class="fw-bold text-primary mb-0" id="detail-total"></h3>
                            </td>
                            <th width="20%">BHP</th>
                            <th width="1%">:</th>
                            <td id="detail-consumables"></td>
                        </tr>
                        <tr>
                            <th width="20%">JRS</th>
                            <th width="1%">:</th>
                            <td id="detail-hospital-service"></td>
                        </tr>
                        <tr>
                            <th width="20%">Pelayanan</th>
                            <th width="1%">:</th>
                            <td id="detail-service"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group"><hr></div>
                <table class="table table-bordered table-hover table-xs display">
                    <thead class="table-primary">
                        <th>Grup</th>
                        <th>Item</th>
                        <th>Hasil</th>
                        <th>Normal</th>
                        <th>Satuan</th>
                        <th>Kondisi</th>
                        <th>Metode</th>
                        <th>Status</th>
                    </thead>
                    <tbody id="detail-data"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        loadData();
        sidebarMini();
        datePickerable('.daterange-picker');
        select2Ajax('#patient_id', 'patient', false);

        $('.select2-form').select2({
            placeholder: '-- Pilih --'
        });

        $('.daterange-picker').on('apply.daterangepicker', function() {
            loadData();
        });
    });

    function loadData() {
        window.gDataTable = $('#datatable-serverside').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            scrollX: true,
            destroy: true,
            order: [[1, 'desc']],
            ajax: {
                url: '{{ url("report/lab/data/datatable") }}',
                dataType: 'JSON',
                data: {
                    patient_id: $('#patient_id').val(),
                    doctor_id: $('#doctor_id').val(),
                    ref: $('#ref').val(),
                    column_date: $('#column_date').val(),
                    date: $('#date').val(),
                    paid: $('#paid').val(),
                    status: $('#status').val()
                },
                beforeSend: function() {
                    onLoading('show', '.datatable-scroll');
                },
                complete: function() {
                    onLoading('close', '.datatable-scroll');
                },
                error: function(response) {
                    onLoading('close', '.datatable-scroll');

                    swalInit.fire({
                        html: '<b>' + response.responseJSON.exception + '</b><br>' + response.responseJSON.message,
                        icon: 'error',
                        showCloseButton: true
                    });
                }
            },
            columns: [
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'align-middle text-center' },
                { data: 'patient_name', name: 'patient_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'doctor_name', name: 'doctor_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'ref', name: 'ref', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'date', name: 'date', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'nominal', name: 'nominal', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'paid', name: 'paid', orderable: true, searchable: false, className: 'align-middle text-center' },
                { data: 'status', name: 'status', orderable: true, searchable: false, className: 'align-middle text-center' },
            ]
        });
    }

    function detail(id) {
        $.ajax({
            url: '{{ url("report/lab/data/detail") }}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                id: id
            },
            beforeSend: function() {
                $('#modal-detail').modal('show');
                onLoading('show', '.modal-content');
                $('#detail-data').html('');
            },
            success: function(response) {
                $('#detail-consumables').html(response.total.consumables);
                $('#detail-hospital-service').html(response.total.hospital_service);
                $('#detail-service').html(response.total.service);
                $('#detail-total').html(response.total.total);

                $.each(response.data, function(i, val) {
                    $('#detail-data').append(`
                        <tr>
                            <td>` + val.group + `</td>
                            <td>` + val.item + `</td>
                            <td>` + val.result + `</td>
                            <td>` + val.normal + `</td>
                            <td>` + val.unit + `</td>
                            <td>` + val.condition + `</td>
                            <td>` + val.method + `</td>
                            <td>` + val.status + `</td>
                        </tr>
                    `);
                });

                onLoading('close', '.modal-content');
            },
            error: function(response) {
                onLoading('close', '.modal-content');

                swalInit.fire({
                    html: '<b>' + response.responseJSON.exception + '</b><br>' + response.responseJSON.message,
                    icon: 'error',
                    showCloseButton: true
                });
            }
        });
    }
</script>
