<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Apotek - <span class="fw-normal">Item</span>
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
        <div class="card-body">
            <table class="table table-bordered table-hover table-xs display" id="datatable-serverside">
                <thead class="text-bg-light">
                    <tr>
                        <th class="text-center" nowrap>No</th>
                        <th nowrap>Apotek</th>
                        <th nowrap>Item</th>
                        <th nowrap>Kode Item</th>
                        <th nowrap>Kode T</th>
                        <th nowrap>Kode Jenis</th>
                        <th nowrap>Satuan</th>
                        <th nowrap>Jenis</th>
                        <th class="text-center" nowrap>Stok</th>
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
                url: '{{ url("dispensary/item/datatable") }}',
                dataType: 'JSON',
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
                { data: 'dispensary_name', name: 'dispensary_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'item_name', name: 'item_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'item_code', name: 'item_code', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'item_code_t', name: 'item_code_t', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'item_code_type', name: 'item_code_type', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'item_unit_name', name: 'item_unit_name', orderable: false, searchable: false, className: 'align-middle' },
                { data: 'item_type', name: 'item_type', orderable: false, searchable: false, className: 'align-middle' },
                { data: 'stock', name: 'stock', orderable: false, searchable: false, className: 'align-middle text-center' },
            ]
        });
    }
</script>
