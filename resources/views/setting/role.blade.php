<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">Role</h5>
        </div>
        <div class="my-auto ms-auto">
            <button type="button" class="btn btn-primary">
                <i class="ph-plus-circle me-1"></i>
                Tambah Data
            </button>
        </div>
    </div>
    <div class="page-header-content border-top">
        <div class="breadcrumb">
            <a href="{{ url('dashboard/general') }}" class="breadcrumb-item py-2"><i class="ph-house"></i></a>
            <a href="javascript:void(0);" class="breadcrumb-item py-2">Pengaturan</a>
            <span class="breadcrumb-item active py-2">Role</span>
        </div>
    </div>
</div>
<div class="content container pt-0">
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

<script>
    $(function() {
        loadData();
    });

    function loadData() {
        $('#datatable-serverside').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url("setting/role/load-data") }}'
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'align-middle text-center' },
                { data: 'name', name: 'name', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'align-middle text-center' },
            ]
        });
    }
</script>
