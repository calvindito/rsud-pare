<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Master Data - Umum - <span class="fw-normal">Kelas</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <button type="button" class="btn btn-primary" onclick="onCreate()">
                <i class="ph-plus-circle me-1"></i>
                Tambah Data
            </button>
        </div>
    </div>
</div>
<div class="content pt-0">
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="datatable-serverside">
                <thead class="bg-light">
                    <tr>
                        <th class="text-center" nowrap>No</th>
                        <th nowrap>Nama</th>
                        <th class="text-center" nowrap><i class="ph-gear"></i></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div id="modal-form" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Basic modal</h5>
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                    <i class="ph-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <div class="form-group">
                        <label class="form-label">Kode <span class="text-danger fw-bold">*</span></label>
                        <input type="text" class="form-control" name="code" id="code">
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-end">
                <button class="btn btn-flat-danger btn-icon">
                    <i class="ph-trash"></i>
                </button>
                <button class="btn btn-primary" data-bs-dismiss="modal">
                    <i class="ph-check me-1"></i>
                    Save
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        loadData();
    });

    function onReset() {
        onCreate();
    }

    function onCreate() {
        $('#modal-form').modal('show');
    }

    function loadData() {
        $('#datatable-serverside').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            destroy: true,
            ajax: {
                url: '{{ url("master-data/general/class-type/datatable") }}'
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'align-middle text-center' },
                { data: 'name', name: 'name', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'align-middle text-center' },
            ]
        });
    }
</script>
