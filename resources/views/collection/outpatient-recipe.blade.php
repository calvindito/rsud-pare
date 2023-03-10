<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Pendataan - Rawat Jalan - <span class="fw-normal">E-Resep</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('collection/outpatient') }}" class="btn btn-flat-primary">Kembali ke Daftar</a>
        </div>
    </div>
</div>
<div class="content pt-0">
    <div class="alert alert-danger d-none" id="validation-element">
        <ul class="mb-0" id="validation-data"></ul>
    </div>
    <div class="card">
        <div class="card-header">
            <h6 class="hstack gap-2 mb-0">Data Pasien</h6>
        </div>
        <div class="card-body">
            <table class="table">
                <tbody>
                    <tr>
                        <th class="align-middle">No RM</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $patient->id }}</td>
                        <th class="align-middle">Jenis Kelamin</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $patient->gender_format_result }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Nama</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $patient->name }}</td>
                        <th class="align-middle">Alamat</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $patient->address }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Tanggal Masuk</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $outpatient->date_of_entry }}</td>
                        <th class="align-middle">Poli</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $outpatient->unit->name }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <form id="form-data">
        <div class="card">
            <div class="card-header">
                <h6 class="hstack gap-2 mb-0">Form Resep</h6>
            </div>
            <div class="card-body">
                <div id="plus-destroy-item">
                    @foreach($dispensaryRequest as $dr)
                        <div id="item">
                            <input type="hidden" name="item[]" value="{{ true }}">
                            <input type="hidden" name="dr_status[]" value="{{ $dr->status }}">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        @if(!empty($dr->status) || $outpatient->dispensary_id != $dr->dispensary_id)
                                            <input type="hidden" name="dr_dispensary_item_stock_id[]" value="{{ $dr->dispensary_item_stock_id }}">
                                        @endif
                                        @if($outpatient->dispensary_id == $dr->dispensary_id)
                                            <select class="form-select select2" name="dr_dispensary_item_stock_id[]" {{ !empty($dr->status) || !in_array($outpatient->status, [1, 3]) ? 'disabled' : '' }}>
                                                <option value="">-- Pilih Item --</option>
                                                @foreach($dispensaryItem as $di)
                                                    <option value="{{ $di->fifoStock()->id }}" {{ ($dr->dispensary_item_stock_id ?? null) == $di->fifoStock()->id ? 'selected' : '' }}>{{ $di->item->name }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="text" class="form-control" value="{{ $dr->dispensaryItemStock->dispensaryItem->item->name ?? '-' }}" disabled>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ $dr->dispensary->name ?? '-' }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        @if(!empty($dr->status) || $outpatient->dispensary_id != $dr->dispensary_id)
                                            <input type="hidden" name="dr_qty[]" value="{{ $dr->qty }}">
                                        @endif
                                        @if($outpatient->dispensary_id == $dr->dispensary_id)
                                            <input type="number" class="form-control" name="dr_qty[]" value="{{ $dr->qty }}" placeholder="Kuantitas" {{ !empty($dr->status) || !in_array($outpatient->status, [1, 3]) ? 'disabled' : '' }}>
                                        @else
                                            <input type="number" class="form-control" value="{{ $dr->qty }}" placeholder="0" disabled>
                                        @endif
                                    </div>
                                </div>
                                @if(!empty($dr->status) || !in_array($outpatient->status, [1, 3]))
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="{{ $dr->status() }}" disabled>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-danger col-12" onclick="removeItem(this)"><i class="ph-trash"></i></button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if(!empty($dr->status) || $outpatient->dispensary_id != $dr->dispensary_id)
                                <input type="hidden" name="dr_consumed[]" value="{{ $dr->consumed }}">
                            @endif
                            @if($outpatient->dispensary_id == $dr->dispensary_id)
                                <div class="form-group">
                                    <input type="text" class="form-control" name="dr_consumed[]" value="{{ $dr->consumed }}" placeholder="Aturan pemakaian ..." {{ !empty($dr->status) || !in_array($outpatient->status, [1, 3]) ? 'disabled' : '' }}>
                                </div>
                            @else
                                <div class="form-group">
                                    <input type="text" class="form-control" value="{{ $dr->consumed }}" placeholder="Aturan pemakaian ..." disabled>
                                </div>
                            @endif
                            <div class="form-group"><hr class="mt-0 mb-0"></div>
                        </div>
                    @endforeach
                </div>
                @if(in_array($outpatient->status, [1, 3]))
                    <div class="form-group mb-0">
                        <button type="button" class="btn btn-success col-12" onclick="addItem()"><i class="ph-plus me-2"></i> Tambah Data</button>
                    </div>
                @endif
            </div>
            @if(in_array($outpatient->status, [1, 3]))
                <div class="card-footer">
                    <div class="text-end">
                        <button type="button" class="btn btn-primary" onclick="submitted()">
                            <i class="ph-paper-plane-tilt me-2"></i>
                            Resepkan
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </form>
</div>

<script>
    $(function() {
        checkStatus();

        $('.select2').select2();
    });

    function checkStatus() {
        var status = '{{ $outpatient->status }}';

        if(status == 2 || status == 4) {
            $('.form-control').attr('disabled', true);
            $('.form-select').attr('disabled', true);
        }
    }

    function addItem() {
        var formElement = $(`
            <div id="item">
                <input type="hidden" name="item[]" value="{{ true }}">
                <input type="hidden" name="dr_status[]" value="{{ null }}">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <select class="form-select select2" name="dr_dispensary_item_stock_id[]">
                                <option value="">-- Pilih Item --</option>
                                @foreach($dispensaryItem as $di)
                                    <option value="{{ $di->fifoStock()->id }}">{{ $di->item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" class="form-control" value="{{ $outpatient->dispensary->name ?? '-' }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="number" class="form-control" name="dr_qty[]" placeholder="Kuantitas">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="button" class="btn btn-danger col-12" onclick="removeItem(this)"><i class="ph-trash"></i></button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="dr_consumed[]" placeholder="Aturan pemakaian ...">
                </div>
                <div class="form-group"><hr class="mt-0 mb-0"></div>
            </div>
        `).hide().fadeIn(500);

        $('#plus-destroy-item').append(formElement);
        $('.select2').select2();
    }

    function removeItem(paramObj) {
        $(paramObj).parents('#item').remove();
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

    function submitted() {
        $.ajax({
            url: '{{ url("collection/outpatient/recipe/" . $outpatient->id) }}',
            type: 'POST',
            dataType: 'JSON',
            data: $('#form-data').serialize(),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            beforeSend: function() {
                onLoading('show', '.content');
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
                        window.location.replace('{{ url("collection/outpatient/recipe/" . $outpatient->id) }}');
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
