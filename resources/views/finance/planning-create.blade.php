<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Keuangan - Perencanaan - <span class="fw-normal">Buat Perencanaan</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('finance/planning') }}" class="btn btn-flat-primary">
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
<div class="content pt-0">
    <div class="alert alert-danger d-none" id="validation-element">
        <ul class="mb-0" id="validation-data"></ul>
    </div>
    <form id="form-data">
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-form-label col-lg-1">Instalasi <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-11">
                        <select class="form-select" name="installation_id" id="installation_id" onchange="changeInstallation();">
                            <option value="">-- Pilih --</option>
                            @foreach($installation as $i)
                                <option value="{{ $i->id }}">{{ $i->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-1">Tanggal <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-11">
                        <input type="date" class="form-control" name="date" id="date">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-1">Status <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-11">
                        <select class="form-select" name="status" id="status">
                            <option value="">-- Pilih --</option>
                            <option value="1">Draft</option>
                            <option value="2">Ajukan Sekarang</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-1">Keterangan <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-11">
                        <textarea class="form-control" name="description" id="description" style="resize:none;" placeholder="Masukan keterangan"></textarea>
                    </div>
                </div>
                <div class="form-group"><hr></div>
                <div class="form-group">
                    <div class="text-center fw-semibold bg-light fs-6 p-3">Tambah Item</div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <select class="form-select" id="add-item"></select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control" id="add-qty" placeholder="Kuantitas">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-success col-12" id="add-button" onclick="addItem()"><i class="ph-plus"></i></button>
                    </div>
                </div>
                <div class="form-group"><hr></div>
                <div class="table-fix-header">
                    <table class="table table-bordered table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>Item</th>
                                <th>Kuantitas</th>
                                <th>Harga</th>
                                <th>Jenis</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody id="data-item"></tbody>
                    </table>
                </div>
                <div class="form-group"><hr></div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-1">Bagan Akun <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-11">
                        <select class="form-select select2-form" name="chart_of_account_id" id="chart_of_account_id">
                            @foreach($chartOfAccount as $coa)
                                <option value="{{ $coa->id }}">{{ $coa->fullname }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-1">Total</label>
                    <div class="col-md-11">
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control number-format" id="total" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="text-end">
                    <button type="button" class="btn btn-primary" onclick="submitted()">
                        <i class="ph-plus-circle me-2"></i>
                        Buat Perencanaan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(function() {
        sidebarMini();
        fullWidthAllDevice();
        loadItem();
        total();
        changeInstallation();

        $('.select2-form').select2({
            placeholder: '-- Pilih --'
        });
    });

    function changeInstallation() {
        var installationId = $('#installation_id').val();

        $('#data-item').html('');

        if(installationId == '') {
            $('#add-item').attr('disabled', true);
            $('#add-qty').attr('disabled', true);
            $('#add-button').attr('disabled', true);
        } else {
            $('#add-item').attr('disabled', false);
            $('#add-qty').attr('disabled', false);
            $('#add-button').attr('disabled', false);
        }

    }

    function addItem() {
        var item = $('#add-item');
        var qty = $('#add-qty');

        if(item.val() != '' && qty.val() != '') {
            valueItem = item.val().split(';');

            $('#data-item').append(`
                <tr>
                    <td>` + valueItem[1] + `</td>
                    <td width="15%">
                        <input type="hidden" name="bp_item_id[]" value="` + valueItem[0] + `">
                        <input type="number" class="form-control" name="bp_qty[]" value="` + qty.val() + `" min="1" placeholder="0">
                    </td>
                    <td>
                        <input type="hidden" name="bp_price[]" value="` + valueItem[2] + `">
                        Rp ` + $.number(valueItem[2]) + `
                    </td>
                    <td>
                        ` + valueItem[3] + `
                    </td>
                    <td width="3%">
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)"><i class="ph-trash"></i></button>
                    </td>
                </tr>
            `);

            item.html('');
            qty.val('');

            total();
            keyUpQty();
        } else {
            swalInit.fire({
                title: 'Oops...',
                text: 'Mohon memilih item dan mengisi kuantitas',
                icon: 'info',
                showCloseButton: true
            });
        }
    }

    function removeItem(param) {
        $(param).parents('tr').remove();
        total();
    }

    function total() {
        var total = 0;

        $('#data-item tr').each(function() {
            var qty = $(this).find('input[name="bp_qty[]"]').val();
            var price = $(this).find('input[name="bp_price[]"]').val();

            var subtotal = parseFloat(price) * parseInt(qty);
            total += subtotal;
        });

        $('#total').val(total);
    }

    function keyUpQty() {
        $('input[name="bp_qty[]"]').keyup(function() {
            total();
        });
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

    function loadItem() {
        $('#add-item').select2({
            placeholder: '-- Pilih Item --',
            minimumInputLength: 2,
            allowClear: true,
            cache: true,
            ajax: {
                url: '{{ url("finance/planning/load-item") }}',
                type: 'GET',
                dataType: 'JSON',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term,
                        installation_id: $('#installation_id').val(),
                        item_id: $('input[name="bp_item_id[]"]').map(function() {
                            return $(this).val();
                        }).get()
                    };
                },
                processResults: function(data) {
                    return { results: data }
                }
            }
        });
    }

    function submitted() {
        $.ajax({
            url: '{{ url("finance/planning/create") }}',
            type: 'POST',
            dataType: 'JSON',
            data: $('#form-data').serialize(),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            beforeSend: function() {
                onLoading('show', '.content');
                clearValidation();
            },
            success: function(response) {
                onLoading('close', '.content');

                if(response.code == 200) {
                    let timerInterval;
                    swalInit.fire({
                        title: 'Berhasil',
                        html: response.message + ', halaman akan disegarkan dalam waktu <b></b> detik',
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();

                            const b = Swal.getHtmlContainer().querySelector('b');
                            timerInterval = setInterval(() => {
                                var seconds = Math.floor((Swal.getTimerLeft() / 1000) % 60);
                                b.textContent = seconds;
                            }, 100);
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                    }).then((result) => {
                        window.location.replace('{{ url("finance/planning/create") }}');
                    });
                } else if(response.code == 400) {
                    $('.btn-to-top button').click();
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
                onLoading('close', '.content');

                swalInit.fire({
                    html: '<b>' + response.responseJSON.exception + '</b><br>' + response.responseJSON.message,
                    icon: 'error',
                    showCloseButton: true
                });
            }
        });
    }
</script>
