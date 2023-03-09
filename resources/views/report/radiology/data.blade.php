<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Laporan - Radiologi - <span class="fw-normal">Data</span>
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
                        <label class="col-form-label col-lg-1">Pasien</label>
                        <div class="col-md-11">
                            <select class="form-select" name="patient_id" id="patient_id"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-1">Tindakan</label>
                        <div class="col-md-11">
                            <select class="form-select select2-form" name="radiology_id" id="radiology_id">
                                <option value=""></option>
                                @foreach($radiology as $r)
                                    <option value="{{ $r->id }}">{{ $r->type . ' - ' . $r->object . ' - ' . $r->projection }}</option>
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
                        <label class="col-form-label col-lg-1">Kritis</label>
                        <div class="col-md-11">
                            <select class="form-select select2-form" name="critical" id="critical">
                                <option value=""></option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
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
                        <th nowrap>Dokter</th>
                        <th nowrap>Pasien</th>
                        <th nowrap>Tindakan</th>
                        <th nowrap>Ref</th>
                        <th nowrap>Tanggal</th>
                        <th nowrap>Kritis</th>
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
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
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
                            <th width="25%">Dokter</th>
                            <th width="1%">:</th>
                            <td id="detail-doctor"></td>
                        </tr>
                        <tr>
                            <th width="25%">Pasien</th>
                            <th width="1%">:</th>
                            <td id="detail-patient"></td>
                        </tr>
                        <tr>
                            <th width="25%">Tindakan</th>
                            <th width="1%">:</th>
                            <td id="detail-radiology"></td>
                        </tr>
                        <tr>
                            <th width="25%">Ref</th>
                            <th width="1%">:</th>
                            <td id="detail-ref"></td>
                        </tr>
                        <tr>
                            <th width="25%">Foto</th>
                            <th width="1%">:</th>
                            <td id="detail-image"></td>
                        </tr>
                        <tr>
                            <th width="25%">Tanggal Permintaan</th>
                            <th width="1%">:</th>
                            <td id="detail-date-of-request"></td>
                        </tr>
                        <tr>
                            <th width="25%">Tanggal Dibuat</th>
                            <th width="1%">:</th>
                            <td id="detail-created-at"></td>
                        </tr>
                        <tr>
                            <th width="25%">Klinis</th>
                            <th width="1%">:</th>
                            <td id="detail-clinical"></td>
                        </tr>
                        <tr>
                            <th width="25%">Kritis</th>
                            <th width="1%">:</th>
                            <td id="detail-critical"></td>
                        </tr>
                        <tr>
                            <th width="25%">BHP</th>
                            <th width="1%">:</th>
                            <td id="detail-consumables"></td>
                        </tr>
                        <tr>
                            <th width="25%">JRS</th>
                            <th width="1%">:</th>
                            <td id="detail-hospital-service"></td>
                        </tr>
                        <tr>
                            <th width="25%">Layanan</th>
                            <th width="1%">:</th>
                            <td id="detail-service"></td>
                        </tr>
                        <tr>
                            <th width="25%">Tarif</th>
                            <th width="1%">:</th>
                            <td id="detail-fee"></td>
                        </tr>
                        <tr>
                            <th width="25%">Pembayaran</th>
                            <th width="1%">:</th>
                            <td id="detail-paid"></td>
                        </tr>
                        <tr>
                            <th width="25%">Status</th>
                            <th width="1%">:</th>
                            <td id="detail-status"></td>
                        </tr>
                        <tr class="bg-light">
                            <th colspan="3" class="text-center">Expertise</th>
                        </tr>
                        <tr>
                            <td colspan="3" id="detail-expertise"></td>
                        </tr>
                    </tbody>
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
                url: '{{ url("report/radiology/data/datatable") }}',
                dataType: 'JSON',
                data: {
                    doctor_id: $('#doctor_id').val(),
                    patient_id: $('#patient_id').val(),
                    radiology_id: $('#radiology_id').val(),
                    ref: $('#ref').val(),
                    column_date: $('#column_date').val(),
                    date: $('#date').val(),
                    critical: $('#critical').val(),
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
                { data: 'doctor_name', name: 'doctor_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'patient_name', name: 'patient_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'radiology_name', name: 'radiology_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'ref', name: 'ref', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'date', name: 'date', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'critical_format_result', name: 'critical', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'nominal', name: 'nominal', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'paid', name: 'paid', orderable: true, searchable: false, className: 'align-middle text-center' },
                { data: 'status', name: 'status', orderable: true, searchable: false, className: 'align-middle text-center' },
            ]
        });
    }

    function detail(id) {
        $.ajax({
            url: '{{ url("report/radiology/data/detail") }}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                id: id
            },
            beforeSend: function() {
                $('#modal-detail').modal('show');
                onLoading('show', '.modal-content');
            },
            success: function(response) {
                $('#detail-doctor').html(response.doctor);
                $('#detail-patient').html(response.patient);
                $('#detail-radiology').html(response.radiology);
                $('#detail-ref').html(response.ref);
                $('#detail-image').html(response.image);
                $('#detail-date-of-request').html(response.date_of_request);
                $('#detail-created-at').html(response.created_at);
                $('#detail-clinical').html(response.clinical);
                $('#detail-critical').html(response.critical);
                $('#detail-expertise').html(response.expertise);
                $('#detail-consumables').html(response.consumables);
                $('#detail-hospital-service').html(response.hospital_service);
                $('#detail-service').html(response.service);
                $('#detail-fee').html(response.fee);
                $('#detail-paid').html(response.paid);
                $('#detail-status').html(response.status);

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
