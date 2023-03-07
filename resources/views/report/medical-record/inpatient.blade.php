<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Laporan - Rekam Medis - <span class="fw-normal">Rawat Inap</span>
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
                        <label class="col-form-label col-lg-1">Kelas</label>
                        <div class="col-md-11">
                            <select class="form-select select2-form" name="class_type_id" id="class_type_id">
                                <option value=""></option>
                                @foreach($classType as $ct)
                                    <option value="{{ $ct->id }}">{{ $ct->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-1">Kamar</label>
                        <div class="col-md-11">
                            <select class="form-select select2-form" name="room_type_id" id="room_type_id">
                                <option value=""></option>
                                @foreach($roomType as $ri)
                                    <option value="{{ $ri->id }}">{{ $ri->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-1">Tempat Tidur</label>
                        <div class="col-md-11">
                            <select class="form-select" name="bed_id" id="bed_id"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-1">UPF</label>
                        <div class="col-md-11">
                            <select class="form-select select2-form" name="functional_service_id" id="functional_service_id">
                                <option value=""></option>
                                @foreach($functionalService as $fs)
                                    <option value="{{ $fs->id }}">{{ $fs->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-1">Apotek</label>
                        <div class="col-md-11">
                            <select class="form-select select2-form" name="dispensary_id" id="dispensary_id">
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
                            <select class="form-select select2-form" name="doctor_id" id="doctor_id">
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
                            <select class="form-select select2-form" name="type" id="type">
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
                                <select class="form-select w-auto flex-grow-0" name="column_date" id="column_date">
                                    <option value="created_at" selected>Tanggal Dibuat</option>
                                    <option value="date_of_entry">Tanggal Masuk</option>
                                    <option value="date_of_out">Tanggal Keluar</option>
                                </select>
                                <input type="text" class="form-control daterange-picker" name="date" id="date" placeholder="Pilih Tanggal" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-1">Hasil</label>
                        <div class="col-md-11">
                            <select class="form-select select2-form" name="ending" id="ending">
                                <option value="">Semua</option>
                                <option value="1">Sembuh</option>
                                <option value="2">Rujuk</option>
                                <option value="3">Pulang Paksa</option>
                                <option value="4">Meninggal < 48 Jam</option>
                                <option value="5">Meniggal > 48 Jam</option>
                                <option value="6">Tidak Diketahui</option>
                                <option value="7">Konsul ke Poli Lain</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-1">Status</label>
                        <div class="col-md-11">
                            <select class="form-select select2-form" name="status" id="status">
                                <option value=""></option>
                                <option value="1">Dalam Antrian</option>
                                <option value="2">Pasien Tidak Ada</option>
                                <option value="3">Sedang Ditangani</option>
                                <option value="4">Selesai / Pulang</option>
                                <option value="5">Rujuk ke Poli Lain</option>
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
                        <th nowrap>Kode</th>
                        <th nowrap>Pasien</th>
                        <th nowrap>Kelas</th>
                        <th nowrap>Kamar</th>
                        <th nowrap>Tempat Tidur</th>
                        <th nowrap>UPF</th>
                        <th nowrap>Dokter</th>
                        <th nowrap>Apotek</th>
                        <th nowrap>Golongan</th>
                        <th nowrap>Tanggal</th>
                        <th nowrap>Hasil</th>
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
        select2Ajax('#bed_id', 'bed', false);

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
                url: '{{ url("report/medical-record/inpatient/datatable") }}',
                dataType: 'JSON',
                data: {
                    patient_id: $('#patient_id').val(),
                    class_type_id: $('#class_type_id').val(),
                    room_type_id: $('#room_type_id').val(),
                    bed_id: $('#bed_id').val(),
                    functional_service_id: $('#functional_service_id').val(),
                    doctor_id: $('#doctor_id').val(),
                    dispensary_id: $('#dispensary_id').val(),
                    type: $('#type').val(),
                    date: $('#date').val(),
                    column_date: $('#column_date').val(),
                    ending: $('#ending').val(),
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
                { data: 'class_type_name', name: 'class_type_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'room_type_name', name: 'room_type_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'bed_name', name: 'bed_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'functional_service_name', name: 'functional_service_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'doctor_name', name: 'doctor_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'dispensary_name', name: 'dispensary_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'type_format_result', name: 'type', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'date', name: 'date', orderable: false, searchable: false, className: 'align-middle' },
                { data: 'ending_format_result', name: 'ending', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'paid', name: 'paid', orderable: true, searchable: false, className: 'align-middle text-center' },
                { data: 'status', name: 'status', orderable: true, searchable: false, className: 'align-middle text-center' },
            ]
        });
    }
</script>
