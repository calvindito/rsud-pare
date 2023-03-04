<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Keuangan - Perencanaan - <span class="fw-normal">Ubah Data</span>
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
                                <option value="{{ $i->id }}" {{ $budget->installation_id == $i->id ? 'selected' : '' }}>{{ $i->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-1">Tanggal <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-11">
                        <input type="date" class="form-control" name="date" id="date" value="{{ $budget->date }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-1">Status <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-11">
                        <select class="form-select" name="status" id="status">
                            <option value="">-- Pilih --</option>
                            <option value="1" {{ $budget->status == 1 || $budget->status == 3 ? 'selected' : '' }}>Draft</option>
                            <option value="2" {{ $budget->status == 2 ? 'selected' : '' }}>Ajukan Sekarang</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-1">Keterangan <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-11">
                        <textarea class="form-control" name="description" id="description" style="resize:none;" placeholder="Masukan keterangan">{{ $budget->description }}</textarea>
                    </div>
                </div>
                @if($budget->status == 3)
                    <div class="alert alert-warning">
                        Anggaran anda sementara belum bisa disetujui dan ada beberapa hal yang harus anda perbaiki, mohon untuk merevisi data anggaran anda
                        <div class="form-group"><hr></div>
                        <span class="fw-semibold">Alasan : {{ $budget->budgetHistory()->latest()->first()->reason ?? '-' }}</span>
                    </div>
                @endif
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
                <ul class="nav nav-tabs nav-tabs-solid nav-justified mb-3">
                    <li class="nav-item">
                        <a href="#tabs-1" class="nav-link active" data-bs-toggle="tab">Form</a>
                    </li>
                    <li class="nav-item">
                        <a href="#tabs-2" class="nav-link" data-bs-toggle="tab">Histori</a>
                    </li>
                </ul>
                <div class="tab-content flex-lg-fill">
                    <div class="tab-pane fade show active" id="tabs-1">
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
                                <tbody id="data-item">
                                    @foreach($budget->budgetPlanning as $bp)
                                        <tr>
                                            <td>{{ $bp->item->name ?? '-' }}</td>
                                            <td width="15%">
                                                <input type="hidden" name="bp_item_id[]" value="{{ $bp->item_id }}">
                                                <input type="number" class="form-control" name="bp_qty[]" value="{{ $bp->qty }}" min="1" placeholder="0">
                                            </td>
                                            <td>
                                                <input type="hidden" name="bp_price[]" value="{{ $bp->price }}">
                                                Rp {{ number_format($bp->price) }}
                                            </td>
                                            <td>{{ $bp->item->type_format_result ?? '-' }}</td>
                                            <td width="3%">
                                                <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)"><i class="ph-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group"><hr></div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-1">Bagan Akun <span class="text-danger fw-bold">*</span></label>
                            <div class="col-md-11">
                                <select class="form-select select2-form" name="chart_of_account_id" id="chart_of_account_id">
                                    @foreach($chartOfAccount as $coa)
                                        <option value="{{ $coa->id }}" {{ $budget->budgetDetail()->first()->chart_of_account_id == $coa->id ? 'selected' : '' }}>
                                            {{ $coa->fullname }}
                                        </option>
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
                    <div class="tab-pane fade" id="tabs-2">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($budget->budgetHistory->count() > 0)
                                    @foreach($budget->budgetHistory as $key => $bh)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $bh->user->employee->name }}</td>
                                            <td>{{ $bh->status }}</td>
                                            <td>{{ $bh->reason }}</td>
                                            <td>{{ $bh->created_at }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada histori</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="text-end">
                    <button type="button" class="btn btn-warning" onclick="submitted()">
                        <i class="ph-floppy-disk me-2"></i>
                        Simpan Data
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
        keyUpQty();

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
            url: '{{ url("finance/planning/update/" . $budget->id) }}',
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
                        window.location.replace('{{ url("finance/planning") }}');
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
