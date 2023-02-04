<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Master Data - Laboratorium - <span class="fw-normal">Item Parent</span>
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
            <button type="button" class="btn btn-flat-primary" onclick="onCreate()">
                <i class="ph-plus-circle me-1"></i>
                Tambah Data
            </button>
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
                        <th nowrap>Parent</th>
                        <th nowrap>Item</th>
                        <th nowrap>Level</th>
                        <th nowrap>Metode</th>
                        <th nowrap>Satuan</th>
                        <th class="text-center" nowrap>Status</th>
                        <th class="text-center" nowrap><i class="ph-gear"></i></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div id="modal-form" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                    <i class="ph-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="validation-element">
                    <ul class="mb-0" id="validation-data"></ul>
                </div>
                <form id="form-data">
                    <input type="hidden" name="table_id" id="table_id">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Parent <span class="text-danger fw-bold">*</span></label>
                        <div class="col-md-9">
                            <select class="form-select" name="parent_id" id="parent_id">
                                <option value="">-- Pilih --</option>
                                @foreach($labItem as $li)
                                    <option value="{{ $li->id }}">{{ $li->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Item <span class="text-danger fw-bold">*</span></label>
                        <div class="col-md-9">
                            <select class="form-select" name="lab_item_id" id="lab_item_id">
                                <option value="">-- Pilih --</option>
                                @foreach($labItem as $li)
                                    <option value="{{ $li->id }}">{{ $li->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Level <span class="text-danger fw-bold">*</span></label>
                        <div class="col-md-9">
                            <select class="form-select" name="level" id="level">
                                <option value="">-- Pilih --</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Batas Bawah</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" name="limit_lower" id="limit_lower" placeholder="Masukan batas bawah">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Batas Atas</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" name="limit_upper" id="limit_upper" placeholder="Masukan batas atas">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Batas Bawah Kritis</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" name="limit_critical_lower" id="limit_critical_lower" placeholder="Masukan batas bawah kritis">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Batas Atas Kritis</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" name="limit_critical_upper" id="limit_critical_upper" placeholder="Masukan batas atas kritis">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Batas Bawah Kritis Pasien</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" name="limit_critical_lower_patient" id="limit_critical_lower_patient" placeholder="Masukan batas bawah kritis pasien">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Batas Atas Kritis Pasien</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" name="limit_critical_upper_patient" id="limit_critical_upper_patient" placeholder="Masukan batas atas kritis pasien">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Dropdown</label>
                        <div class="col-md-9">
                            <select class="form-select" name="dropdown" id="dropdown">
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Metode</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="method" id="method" placeholder="Masukan metode">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Satuan</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="unit" id="unit" placeholder="Masukan satuan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Status</label>
                        <div class="col-md-9">
                            <select class="form-select" name="status" id="status">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-end">
                <button class="btn btn-danger d-none" id="btn-cancel" onclick="onCancel()">
                    <i class="ph-x me-1"></i>
                    Batalkan Perubahan
                </button>
                <button class="btn btn-warning d-none" id="btn-update" onclick="updateData()">
                    <i class="ph-floppy-disk me-1"></i>
                    Simpan Perubahan Data
                </button>
                <button class="btn btn-primary d-none" id="btn-create" onclick="createData()">
                    <i class="ph-plus-circle me-1"></i>
                    Simpan Data
                </button>
            </div>
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

    function onReset() {
        clearValidation();
        $('#modal-form').modal('hide');
        $('#form-data').trigger('reset');
        $('#btn-create').removeClass('d-none');
        $('#btn-update').addClass('d-none');
        $('#btn-cancel').addClass('d-none');
        $('#status').attr('disabled', true);
        $('#status').val(1);
        $('#dropdown').val(1);
    }

    function onCreate() {
        onReset();
        $('#modal-form .modal-title').text('Tambah Data');
        $('#modal-form').modal('show');
    }

    function onCancel() {
        onReset();
    }

    function onUpdate() {
        onReset();
        $('#btn-create').addClass('d-none');
        $('#btn-update').removeClass('d-none');
        $('#btn-cancel').removeClass('d-none');
        $('#modal-form .modal-title').text('Edit Data');
        $('#modal-form').modal('show');
        $('#status').attr('disabled', false);
    }

    function clearValidation() {
        $('#validation-element').addClass('d-none');
        $('#validation-data').html('');
    }

    function showValidation(data) {
        $('#validation-element').removeClass('d-none');
        $('#validation-data').html('');

        $.each(data, function(index, value) {
            $('#validation-data').append('<li>' + value + '</li>');
        });
    }

    function formSuccess() {
        onReset();
        onReloadTable();
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
                url: '{{ url("master-data/lab/item-parent/datatable") }}',
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
                { data: 'parent_name', name: 'parent_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'lab_item_name', name: 'lab_item_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'level', name: 'level', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'method', name: 'method', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'unit', name: 'unit', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'status', name: 'status', orderable: true, searchable: false, className: 'align-middle text-center' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'align-middle text-center' },
            ]
        });
    }

    function createData() {
        $.ajax({
            url: '{{ url("master-data/lab/item-parent/create-data") }}',
            type: 'POST',
            dataType: 'JSON',
            data: $('#form-data').serialize(),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            beforeSend: function() {
                onLoading('show', '.modal-content');
                clearValidation();
            },
            success: function(response) {
                onLoading('close', '.modal-content');

                if(response.code == 200) {
                    formSuccess();
                    notification('success', response.message);
                } else if(response.code == 400) {
                    $('#modal-form .modal-body').scrollTop(0);
                    showValidation(response.error);
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
                onLoading('close', '.modal-content');

                swalInit.fire({
                    html: '<b>' + response.responseJSON.exception + '</b><br>' + response.responseJSON.message,
                    icon: 'error',
                    showCloseButton: true
                });
            }
        });
    }

    function showDataUpdate(id) {
        $.ajax({
            url: '{{ url("master-data/lab/item-parent/show-data") }}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                id: id
            },
            beforeSend: function() {
                onLoading('show', '.modal-content');
                onUpdate();
            },
            success: function(response) {
                onLoading('close', '.modal-content');

                $('#table_id').val(response.id);
                $('#parent_id').val(response.parent_id);
                $('#lab_item_id').val(response.lab_item_id);
                $('#level').val(response.level);
                $('#limit_lower').val(response.limit_lower);
                $('#limit_critical_lower').val(response.limit_critical_lower);
                $('#limit_upper').val(response.limit_upper);
                $('#limit_critical_upper').val(response.limit_critical_upper);
                $('#limit_lower_patient').val(response.limit_lower_patient);
                $('#limit_critical_lower_patient').val(response.limit_critical_lower_patient);
                $('#limit_upper_patient').val(response.limit_upper_patient);
                $('#limit_critical_upper_patient').val(response.limit_critical_upper_patient);
                $('#dropdown').val(response.dropdown);
                $('#method').val(response.method);
                $('#unit').val(response.unit);
                $('#status').val(response.status);
            },
            error: function(response) {
                onLoading('close', '.modal-content');

                swalInit.fire({
                    html: '<b>' + response.responseJSON.exception + '</b><br>' + response.responseJSON.message,
                    icon: 'error',
                    showCloseButton: true
                });
            }
        });
    }

    function updateData() {
        $.ajax({
            url: '{{ url("master-data/lab/item-parent/update-data") }}',
            type: 'POST',
            dataType: 'JSON',
            data: $('#form-data').serialize(),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            beforeSend: function() {
                onLoading('show', '.modal-content');
                clearValidation();
            },
            success: function(response) {
                onLoading('close', '.modal-content');

                if(response.code == 200) {
                    formSuccess();
                    notification('success', response.message);
                } else if(response.code == 400) {
                    $('#modal-form .modal-body').scrollTop(0);
                    showValidation(response.error);
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
                onLoading('close', '.modal-content');

                swalInit.fire({
                    html: '<b>' + response.responseJSON.exception + '</b><br>' + response.responseJSON.message,
                    icon: 'error',
                    showCloseButton: true
                });
            }
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
                        url: '{{ url("master-data/lab/item-parent/destroy-data") }}',
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
