<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Laporan - Rekam Medis - <span class="fw-normal">Pasien</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-flat-primary dropdown-toggle" data-bs-toggle="dropdown">Refresh</button>
                <div class="dropdown-menu">
                    <a href="javascript:void(0);" class="dropdown-item" onclick="loadData()">Data</a>
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
                        <label class="col-form-label col-lg-2">Wilayah</label>
                        <div class="col-lg-10">
                            <select class="form-select" name="location_id" id="location_id"></select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Status Pernikahan</label>
                        <div class="col-lg-10">
                            <select class="form-select" name="marital_status" id="marital_status">
                                <option value="">Semua</option>
                                <option value="1">Belum Menikah</option>
                                <option value="2">Menikah</option>
                                <option value="3">Cerai Hidup</option>
                                <option value="4">Cerai Mati</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Agama</label>
                        <div class="col-lg-10">
                            <select class="form-select" name="religion_id" id="religion_id">
                                <option value="">Semua</option>
                                @foreach($religion as $r)
                                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Jenis Kelamin</label>
                        <div class="col-lg-10">
                            <select class="form-select" name="gender" id="gender">
                                <option value="">Semua</option>
                                <option value="1">Laki - Laki</option>
                                <option value="2">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Golongan Darah</label>
                        <div class="col-lg-10">
                            <select class="form-select" name="blood_group" id="blood_group">
                                <option value="">Semua</option>
                                <option value="1">A</option>
                                <option value="2">B</option>
                                <option value="3">AB</option>
                                <option value="4">O</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Tanggal Terdaftar</label>
                        <div class="col-lg-10">
                            <input type="date" class="form-control" name="date_of_register" max="{{ date('Y-m-d') }}">
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
                        <th nowrap>No RM</th>
                        <th nowrap>Kode Lama</th>
                        <th nowrap>Kode Member</th>
                        <th nowrap>No KTP</th>
                        <th nowrap>Nama</th>
                        <th nowrap>No Telp</th>
                        <th nowrap>Tempat Lahir</th>
                        <th nowrap>Tanggal Lahir</th>
                        <th nowrap>Desa / Kelurahan</th>
                        <th nowrap>Suku</th>
                        <th nowrap>Golongan Darah</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script>
    $(function() {
        loadData();

        select2Ajax('#location_id', 'location', false);
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
                url: '{{ url("report/medical-record/patient/datatable") }}',
                dataType: 'JSON',
                data: {
                    location_id: $('#location_id').val(),
                    religion_id: $('#religion_id').val(),
                    gender: $('#gender').val(),
                    blood_group: $('#blood_group').val(),
                    marital_status: $('#marital_status').val(),
                    date_of_register: $('#date_of_register').val(),
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
                { data: 'no_medical_record', name: 'id', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'code_old', name: 'code_old', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'code_member', name: 'code_member', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'identity_number', name: 'identity_number', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'name', name: 'name', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'phone', name: 'phone', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'place_of_birth', name: 'place_of_birth', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'date_of_birth', name: 'date_of_birth', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'village', name: 'village', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'tribe', name: 'tribe', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'blood_group_format_result', name: 'blood_group', orderable: true, searchable: false, className: 'align-middle' },
            ]
        });
    }
</script>
