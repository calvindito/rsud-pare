<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Laporan - Rekam Medis - <span class="fw-normal">Rawat Jalan</span>
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
    <div class="card">
        <div class="card-header">
            <h6 class="hstack gap-2 mb-0">Filter</h6>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-form-label col-lg-1">Pasien</label>
                <div class="col-md-11">
                    <select class="form-select" name="patient_id" id="patient_id" onchange="loadData()"></select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-1">Poli</label>
                <div class="col-md-11">
                    <select class="form-select select2-form" name="unit_id" id="unit_id" onchange="loadData()">
                        <option value=""></option>
                        @foreach($unit as $u)
                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-1">Apotek</label>
                <div class="col-md-11">
                    <select class="form-select select2-form" name="dispensary_id" id="dispensary_id" onchange="loadData()">
                        <option value=""></option>
                        @foreach($dispensary as $d)
                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-1">Dokter</label>
                <div class="col-md-11">
                    <select class="form-select select2-form" name="doctor_id" id="doctor_id" onchange="loadData()">
                        <option value=""></option>
                        @foreach($doctor as $d)
                            <option value="{{ $d->id }}">{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-1">Golongan</label>
                <div class="col-md-11">
                    <select class="form-select select2-form" name="type" id="type" onchange="loadData()">
                        <option value=""></option>
                        @foreach($type as $key => $t)
                            <option value="{{ $key + 1 }}">{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-1">Tanggal</label>
                <div class="col-md-11">
                    <div class="input-group">
                        <select class="form-select w-auto flex-grow-0" name="column_date" id="column_date" onchange="loadData()">
                            <option value="created_at" selected>Tanggal Dibuat</option>
                            <option value="date_of_entry">Tanggal Masuk</option>
                            <option value="date_of_out">Tanggal Keluar</option>
                        </select>
                        <input type="text" class="form-control daterange-picker" name="date" id="date" placeholder="Pilih Tanggal" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-1">Kehadiran</label>
                <div class="col-md-11">
                    <select class="form-select select2-form" name="presence" id="presence" onchange="loadData()">
                        <option value="">Semua</option>
                        <option value="1">Datang Sendiri</option>
                        <option value="2">Rujukan Dari Puskesmas</option>
                        <option value="3">Rujukan Dokter</option>
                        <option value="4">Rujukan Dari Rumah Sakit Lain</option>
                        <option value="5">Lahir Didalam Rumah Sakit</option>
                        <option value="6">Rujukan Dari Bidan</option>
                        <option value="7">Rujukan Klinik</option>
                        <option value="8">Rujukan Balai Pengobatan</option>
                        <option value="9">Diantar Polisi</option>
                        <option value="10">Diantar Ambulans</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-1">Status</label>
                <div class="col-md-11">
                    <select class="form-select select2-form" name="status" id="status" onchange="loadData()">
                        <option value=""></option>
                        <option value="1">Dalam Antrian</option>
                        <option value="2">Pasien Tidak Ada</option>
                        <option value="3">Sedang Ditangani</option>
                        <option value="4">Selesai / Pulang</option>
                        <option value="5">Rujuk ke Poli Lain</option>
                    </select>
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
                        <th nowrap>Kode</th>
                        <th nowrap>Pasien</th>
                        <th nowrap>Poli</th>
                        <th nowrap>Apotek</th>
                        <th nowrap>Dokter</th>
                        <th nowrap>Golongan</th>
                        <th nowrap>Tanggal</th>
                        <th nowrap>Kehadiran</th>
                        <th class="text-center" nowrap>Pembayaran</th>
                        <th class="text-center" nowrap>Status</th>
                    </tr>
                </thead>
            </table>
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
                url: '{{ url("report/medical-record/outpatient/datatable") }}',
                dataType: 'JSON',
                data: {
                    patient_id: $('#patient_id').val(),
                    unit_id: $('#unit_id').val(),
                    dispensary_id: $('#dispensary_id').val(),
                    doctor_id: $('#doctor_id').val(),
                    type: $('#type').val(),
                    date: $('#date').val(),
                    column_date: $('#column_date').val(),
                    presence: $('#presence').val(),
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
                { data: 'code', name: 'id', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'patient_name', name: 'patient_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'unit_name', name: 'unit_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'dispensary_name', name: 'dispensary_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'doctor_name', name: 'doctor_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'type_format_result', name: 'type', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'date', name: 'date', orderable: false, searchable: false, className: 'align-middle' },
                { data: 'presence_format_result', name: 'presence', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'paid', name: 'paid', orderable: true, searchable: false, className: 'align-middle text-center' },
                { data: 'status', name: 'status', orderable: true, searchable: false, className: 'align-middle' },
            ]
        });
    }
</script>
