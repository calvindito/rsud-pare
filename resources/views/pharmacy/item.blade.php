<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Farmasi - <span class="fw-normal">Item</span>
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
                        <th nowrap>Kode Item</th>
                        <th nowrap>Kode T</th>
                        <th nowrap>Kode Jenis</th>
                        <th nowrap>Instalasi</th>
                        <th nowrap>Satuan</th>
                        <th nowrap>Pabrik</th>
                        <th nowrap>Distributor</th>
                        <th nowrap>Jenis</th>
                        <th nowrap>Nama Item</th>
                        <th nowrap>Nama Generik</th>
                        <th nowrap>Kekuatan</th>
                        <th nowrap>Stok</th>
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
                        <label class="col-form-label col-lg-3">Distributor <span class="text-danger fw-bold">*</span></label>
                        <div class="col-md-9">
                            <select class="form-select select2-basic" name="distributor_id" id="distributor_id">
                                @foreach($distributor as $d)
                                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Instalasi <span class="text-danger fw-bold">*</span></label>
                        <div class="col-md-9">
                            <select class="form-select" name="installation_id" id="installation_id">
                                <option value="">-- Pilih --</option>
                                @foreach($installation as $i)
                                    <option value="{{ $i->id }}">{{ $i->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Satuan <span class="text-danger fw-bold">*</span></label>
                        <div class="col-md-9">
                            <select class="form-select" name="item_unit_id" id="item_unit_id">
                                <option value="">-- Pilih --</option>
                                @foreach($itemUnit as $mu)
                                    <option value="{{ $mu->id }}">{{ $mu->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Jenis <span class="text-danger fw-bold">*</span></label>
                        <div class="col-md-9">
                            <select class="form-select" name="type" id="type">
                                <option value="">-- Pilih --</option>
                                <option value="1">Obat</option>
                                <option value="2">Alat Kesehatan</option>
                                <option value="3">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Kode Item <span class="text-danger fw-bold">*</span></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="code" id="code" placeholder="Masukan kode item">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Kode T</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="code_t" id="code_t" placeholder="Masukan kode t">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Kode Jenis <span class="text-danger fw-bold">*</span></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="code_type" id="code_type" placeholder="Masukan kode jenis">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Nama Item <span class="text-danger fw-bold">*</span></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Masukan nama item">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Nama Generik <span class="text-danger fw-bold">*</span></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="name_generic" id="name_generic" placeholder="Masukan nama generik">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Kekuatan</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="power" id="power" placeholder="Masukan kekuatan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Kekuatan Satuan</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="power_unit" id="power_unit" placeholder="Masukan kekuatan satuan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Satuan</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="unit" id="unit" placeholder="Masukan satuan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Persediaan</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="inventory" id="inventory" placeholder="Masukan persediaan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Bir</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="bir" id="bir" placeholder="Masukan bir">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Non Generik</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="non_generic" id="non_generic" placeholder="Masukan non generik">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Nar</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="nar" id="nar" placeholder="Masukan nar">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Oakrl</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="oakrl" id="oakrl" placeholder="Masukan oakrl">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Kronis</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="chronic" id="chronic" placeholder="Masukan kronis">
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
        $('.select2-basic').val('').change();
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
                url: '{{ url("pharmacy/item/datatable") }}',
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
                { data: 'code', name: 'code', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'code_t', name: 'code_t', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'code_type', name: 'code_type', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'installation_name', name: 'installation_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'item_unit_name', name: 'item_unit_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'factory_name', name: 'factory_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'distributor_name', name: 'distributor_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'type_format_result', name: 'type', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'name', name: 'name', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'name_generic', name: 'name_generic', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'power', name: 'power', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'stock', name: 'stock', orderable: false, searchable: false, className: 'align-middle' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'align-middle text-center' },
            ]
        });
    }

    function createData() {
        $.ajax({
            url: '{{ url("pharmacy/item/create-data") }}',
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
            url: '{{ url("pharmacy/item/show-data") }}',
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
                $('#distributor_id').val(response.distributor_id).change();
                $('#installation_id').val(response.installation_id).change();
                $('#item_unit_id').val(response.item_unit_id).change();
                $('#type').val(response.type).change();
                $('#code').val(response.code);
                $('#code_t').val(response.code_t);
                $('#code_type').val(response.code_type);
                $('#name').val(response.name);
                $('#name_generic').val(response.name_generic);
                $('#power').val(response.power);
                $('#power_unit').val(response.power_unit);
                $('#unit').val(response.unit);
                $('#inventory').val(response.inventory);
                $('#bir').val(response.bir);
                $('#non_generic').val(response.non_generic);
                $('#nar').val(response.nar);
                $('#oakrl').val(response.oakrl);
                $('#chronic').val(response.chronic);
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
            url: '{{ url("pharmacy/item/update-data") }}',
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
                        url: '{{ url("pharmacy/item/destroy-data") }}',
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
