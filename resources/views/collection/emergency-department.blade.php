<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Pendataan - <span class="fw-normal">IGD</span>
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
            <a href="{{ url('collection/emergency-department/register-patient') }}" class="btn btn-flat-primary">
                <i class="ph-plus-circle me-1"></i>
                Registrasi Pasien
            </a>
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
                        <th nowrap>Ref</th>
                        <th nowrap>No RM</th>
                        <th nowrap>Pasien</th>
                        <th nowrap>UPF</th>
                        <th nowrap>Tanggal Masuk</th>
                        <th nowrap>Tanggal Keluar</th>
                        <th nowrap>Hasil</th>
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
                url: '{{ url("collection/emergency-department/datatable") }}',
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
                { data: 'parentable', name: 'parent_id', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'patient_id', name: 'patient_id', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'patient_name', name: 'patient_name', orderable: false, searchable: false, className: 'align-middle' },
                { data: 'functional_service_name', name: 'functional_service_name', orderable: false, searchable: false, className: 'align-middle' },
                { data: 'date_of_entry', name: 'date_of_entry', orderable: true, searchable: false, className: 'align-middle nowrap' },
                { data: 'date_of_out', name: 'date_of_out', orderable: true, searchable: false, className: 'align-middle nowrap' },
                { data: 'ending_format_result', name: 'ending', orderable: true, searchable: false, className: 'align-middle nowrap' },
                { data: 'status', name: 'status', orderable: true, searchable: true, className: 'align-middle text-center' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'align-middle text-center' },
            ]
        });
    }

    function destroyData(id) {
        var notyConfirm = new Noty({
            text: '<div class="mb-3"><h5 class="text-dark">Hapus Data?</h5><span class="text-muted">Data yang telah dihapus tidak bisa dikembalikan lagi</span></div>',
            timeout: false,
            modal: true,
            layout: 'center',
            closeWith: 'button',
            type: 'confirm',
            buttons: [
                Noty.button('Tidak', 'btn btn-light', function () {
                    notyConfirm.close();
                }),
                Noty.button('Hapus', 'btn btn-danger ms-2', function () {
                    $.ajax({
                        url: '{{ url("collection/emergency-department/destroy-data") }}',
                        type: 'DELETE',
                        dataType: 'JSON',
                        data: {
                            id: id
                        },
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        beforeSend: function() {
                            onLoading('show', '.noty_bar');
                        },
                        success: function(response) {
                            onLoading('close', '.noty_bar');

                            if(response.code == 200) {
                                notyConfirm.close();
                                onReloadTable();
                                notification('success', response.message);
                            } else {
                                swalInit.fire({
                                    title: 'Error',
                                    text: response.message,
                                    icon: 'error',
                                    showCloseButton: true
                                });
                            }
                        },
                        error: function(response) {
                            onLoading('close', '.noty_bar');

                            swalInit.fire({
                                html: '<b>' + response.responseJSON.exception + '</b><br>' + response.responseJSON.message,
                                icon: 'error',
                                showCloseButton: true
                            });
                        }
                    });
                })
            ]
        }).show();
    }
</script>
