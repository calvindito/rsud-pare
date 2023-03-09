<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Laporan - Laboratorium - <span class="fw-normal">Item</span>
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
                        <label class="col-form-label col-lg-1">Kategori</label>
                        <div class="col-md-11">
                            <select class="form-select select2-form" name="lab_category_id" id="lab_category_id">
                                <option value=""></option>
                                @foreach($labCategory as $lc)
                                    <option value="{{ $lc->id }}">{{ $lc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-1">Grup</label>
                        <div class="col-md-11">
                            <select class="form-select select2-form" name="lab_item_group_id" id="lab_item_group_id">
                                <option value=""></option>
                                @foreach($labItemGroup as $lig)
                                    <option value="{{ $lig->id }}">{{ $lig->name }}</option>
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
                    <div class="form-group row">
                        <label class="col-form-label col-lg-1">Status</label>
                        <div class="col-md-11">
                            <select class="form-select select2-form" name="status" id="status">
                                <option value=""></option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
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
                        <th nowrap>No</th>
                        <th nowrap>Kategori</th>
                        <th nowrap>Grup</th>
                        <th nowrap>Nama</th>
                        <th nowrap>Tanggal</th>
                        <th nowrap>Pendapatan BHP</th>
                        <th nowrap>Pendapatan JRS</th>
                        <th nowrap>Pendapatan Layanan</th>
                        <th nowrap>Status</th>
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
                url: '{{ url("report/lab/item/datatable") }}',
                dataType: 'JSON',
                data: {
                    lab_category_id: $('#lab_category_id').val(),
                    lab_item_group_id: $('#lab_item_group_id').val(),
                    date: $('#date').val(),
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
                { data: 'DT_RowIndex', name: 'id', orderable: true, searchable: false, className: 'align-middle text-center' },
                { data: 'lab_category_name', name: 'lab_category_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'lab_item_group_name', name: 'lab_item_group_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'name', name: 'name', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'date', name: 'date', orderable: false, searchable: false, className: 'align-middle' },
                { data: 'income_consumables', name: 'income_consumables', orderable: false, searchable: false, className: 'align-middle' },
                { data: 'income_hospital_service', name: 'income_hospital_service', orderable: false, searchable: false, className: 'align-middle' },
                { data: 'income_service', name: 'income_service', orderable: false, searchable: false, className: 'align-middle' },
                { data: 'status', name: 'status', orderable: true, searchable: false, className: 'align-middle text-center' },
            ]
        });
    }
</script>
