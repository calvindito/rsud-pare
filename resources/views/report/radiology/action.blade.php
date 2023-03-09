<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Laporan - Radiologi - <span class="fw-normal">Tindakan</span>
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
                        <label class="col-form-label col-lg-1">Penunjang</label>
                        <div class="col-md-11">
                            <select class="form-select select2-form" name="action_supporting_id" id="action_supporting_id">
                                <option value=""></option>
                                @foreach($actionSupporting as $as)
                                    <option value="{{ $as->id }}">{{ $as->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-1">Tanggal</label>
                        <div class="col-md-11">
                            <input type="text" class="form-control daterange-picker" name="date" id="date" placeholder="Pilih Tanggal" readonly>
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
                        <th nowrap>No</th>
                        <th nowrap>Kelas</th>
                        <th nowrap>Penunjang</th>
                        <th nowrap>Kode</th>
                        <th nowrap>Jenis</th>
                        <th nowrap>Objek</th>
                        <th nowrap>Proyeksi</th>
                        <th nowrap>Tanggal</th>
                        <th nowrap>Pendapatan BHP</th>
                        <th nowrap>Pendapatan JRS</th>
                        <th nowrap>Pendapatan Layanan</th>
                        <th nowrap>Pendapatan Tarif</th>
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
                url: '{{ url("report/radiology/action/datatable") }}',
                dataType: 'JSON',
                data: {
                    action_supporting_id: $('#action_supporting_id').val(),
                    class_type_id: $('#class_type_id').val(),
                    date: $('#date').val()
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
                { data: 'DT_RowIndex', name: 'id', orderable: true, searchable: false, className: 'align-middle text-center' },
                { data: 'class_type_name', name: 'class_type_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'action_supporting_name', name: 'action_supporting_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'code', name: 'code', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'type', name: 'type', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'object', name: 'object', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'projection', name: 'projection', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'date', name: 'date', orderable: false, searchable: false, className: 'align-middle' },
                { data: 'income_consumables', name: 'income_consumables', orderable: false, searchable: false, className: 'align-middle' },
                { data: 'income_hospital_service', name: 'income_hospital_service', orderable: false, searchable: false, className: 'align-middle' },
                { data: 'income_service', name: 'income_service', orderable: false, searchable: false, className: 'align-middle' },
                { data: 'income_fee', name: 'income_fee', orderable: false, searchable: false, className: 'align-middle' },
            ]
        });
    }
</script>
