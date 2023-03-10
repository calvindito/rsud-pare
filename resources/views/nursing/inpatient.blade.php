<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Keperawatan - <span class="fw-normal">Rawat Inap</span>
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
                        <th nowrap>Kode</th>
                        <th nowrap>No RM</th>
                        <th nowrap>Pasien</th>
                        <th nowrap>Kamar</th>
                        <th nowrap>Tempat Tidur</th>
                        <th nowrap>Tanggal Masuk</th>
                        <th nowrap>Tanggal Keluar</th>
                        <th class="text-center" nowrap>Status</th>
                        <th class="text-center" nowrap><i class="ph-gear"></i></th>
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
                url: '{{ url("nursing/inpatient/datatable") }}',
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
                { data: 'code', name: 'id', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'patient_id', name: 'patient_id', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'patient_name', name: 'patient_name', orderable: false, searchable: false, className: 'align-middle' },
                { data: 'room_type_name', name: 'room_type_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'bed_name', name: 'bed_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'date_of_entry', name: 'date_of_entry', orderable: true, searchable: false, className: 'align-middle nowrap' },
                { data: 'date_of_out', name: 'date_of_out', orderable: true, searchable: false, className: 'align-middle nowrap' },
                { data: 'status', name: 'status', orderable: true, searchable: true, className: 'align-middle text-center' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'align-middle text-center' },
            ]
        });
    }
</script>
