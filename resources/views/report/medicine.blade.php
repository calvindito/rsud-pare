<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Laporan - <span class="fw-normal">Obat</span>
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
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Distributor</label>
                        <select class="form-select select2" name="distributor_id" id="distributor_id" onchange="loadData()">
                            <option value="">Semua</option>
                            @foreach($distributor as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Pabrik</label>
                        <select class="form-select select2" name="factory_id" id="factory_id" onchange="loadData()">
                            <option value="">Semua</option>
                            @foreach($factory as $f)
                                <option value="{{ $f->id }}">{{ $f->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Stok</label>
                        <select class="form-select" name="stock" id="stock" onchange="loadData()">
                            <option value="">Semua</option>
                            <option value="many">Lebih Dari 1000</option>
                            <option value="available">Lebih Dari 0</option>
                            <option value="empty">Kosong</option>
                        </select>
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
                        <th class="text-center" nowrap>No</th>
                        <th nowrap>Kode Barang</th>
                        <th nowrap>Kode T</th>
                        <th nowrap>Kode Jenis</th>
                        <th nowrap>Pabrik</th>
                        <th nowrap>Distributor</th>
                        <th nowrap>Nama Barang</th>
                        <th nowrap>Nama Generik</th>
                        <th nowrap>Kekuatan</th>
                        <th nowrap>Stok</th>
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
        $('.select2').select2();
    });

    function onReloadTable() {
        window.gDataTable.ajax.reload(null, false);
    }

    function loadData() {
        window.gDataTable = $('#datatable-serverside').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            scrollX: true,
            destroy: true,
            order: [[0, 'desc']],
            ajax: {
                url: '{{ url("report/medicine/datatable") }}',
                dataType: 'JSON',
                data: {
                    distributor_id: $('#distributor_id').val(),
                    factory_id: $('#factory_id').val(),
                    stock: $('#stock').val()
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
                { data: 'code', name: 'code', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'code_t', name: 'code_t', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'code_type', name: 'code_type', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'factory_name', name: 'factory_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'distributor_name', name: 'distributor_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'name', name: 'name', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'name_generic', name: 'name_generic', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'power', name: 'power', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'stock', name: 'stock', orderable: false, searchable: false, className: 'align-middle' },
            ]
        });
    }
</script>
