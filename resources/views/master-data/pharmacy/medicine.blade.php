<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Master Data - Farmasi - <span class="fw-normal">Obat</span>
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
                        <th nowrap>Kode Barang</th>
                        <th nowrap>Kode T</th>
                        <th nowrap>Kode Jenis</th>
                        <th nowrap>Nama Barang</th>
                        <th nowrap>Nama Generik</th>
                        <th nowrap>Kekuatan</th>
                        <th nowrap>Harga Beli</th>
                        <th nowrap>Harga Jual</th>
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
                        <label class="col-form-label col-lg-3">Kode Barang <span class="text-danger fw-bold">*</span></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="code" id="code" placeholder="Masukan kode barang">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Kode T <span class="text-danger fw-bold">*</span></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="code_t" id="code_t" placeholder="Masukan kode t">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Kode Jenis</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="code_type" id="code_type" placeholder="Masukan kode jenis">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Nama Barang <span class="text-danger fw-bold">*</span></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Masukan nama barang">
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
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Stok</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" name="stock" id="stock" placeholder="Masukan stok">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Minimal Stok</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" name="stock_min" id="stock_min" placeholder="Masukan minimal stok">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Harga Jual <span class="text-danger fw-bold">*</span></label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" name="price" id="price" placeholder="Masukan harga jual">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Harga Beli</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" name="price_purchase" id="price_purchase" placeholder="Masukan harga beli">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Harga Nett</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" name="price_netto" id="price_netto" placeholder="Masukan harga nett">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Diskon</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" name="discount" id="discount" placeholder="Masukan diskon">
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
        sidebarMini();
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
                url: '{{ url("master-data/pharmacy/medicine/datatable") }}',
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
                { data: 'name', name: 'name', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'name_generic', name: 'name_generic', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'power', name: 'power', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'price_purchase', name: 'price_purchase', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'price', name: 'price', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'align-middle text-center' },
            ]
        });
    }

    function createData() {
        $.ajax({
            url: '{{ url("master-data/pharmacy/medicine/create-data") }}',
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
            url: '{{ url("master-data/pharmacy/medicine/show-data") }}',
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
                $('#stock').val(response.stock);
                $('#stock_min').val(response.stock_min);
                $('#price').val(response.price);
                $('#price_purchase').val(response.price_purchase);
                $('#price_netto').val(response.price_netto);
                $('#discount').val(response.discount);
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
            url: '{{ url("master-data/pharmacy/medicine/update-data") }}',
            type: 'PATCH',
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
                        url: '{{ url("master-data/pharmacy/medicine/destroy-data") }}',
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
