<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Pendataan - Rawat Inap - <span class="fw-normal">E-Resep</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('collection/inpatient') }}" class="btn btn-flat-primary">Kembali ke Daftar</a>
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
                        <td class="align-middle">{{ $inpatient->date_of_entry }}</td>
                        <th class="align-middle">Kamar</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $inpatient->roomType->name . ' | ' . $inpatient->roomType->classType->name }}</td>
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
                    @foreach($recipe as $r)
                        <div id="item">
                            <input type="hidden" name="item[]" value="{{ true }}">
                            <input type="hidden" name="status[]" value="{{ $r->status }}">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <select class="form-select select2" name="r_medicine_stock_id[]" {{ !empty($r->status) || $inpatient->status != 1 ? 'disabled' : '' }}>
                                            <option value="">-- Pilih Obat --</option>
                                            @foreach($medicine as $m)
                                                <option value="{{ $m->fifoStock->id }}" {{ ($r->medicine_stock_id ?? null) == $m->fifoStock->id ? 'selected' : '' }}>{{ $m->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="r_qty[]" value="{{ $r->qty }}" placeholder="Jumlah" {{ !empty($r->status) || $inpatient->status != 1 ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                @if(!empty($r->status) || $inpatient->status != 1)
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="{{ $r->status() }}" disabled>
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
                        </div>
                    @endforeach
                </div>
                @if($inpatient->status == 1)
                    <div class="form-group mb-0">
                        <button type="button" class="btn btn-success col-12" onclick="addItem()"><i class="ph-plus me-2"></i> Tambah Data</button>
                    </div>
                @endif
            </div>
            @if($inpatient->status == 1)
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
    </div>
</div>

<script>
    $(function() {
        checkStatus();
        sidebarMini();
        fullWidthAllDevice();

        $('.select2').select2();
    });

    function checkStatus() {
        var status = '{{ $inpatient->status }}';

        if(status != 1) {
            $('.form-control').attr('disabled', true);
            $('.form-select').attr('disabled', true);
        }
    }

    function addItem() {
        var formElement = $(`
            <div id="item">
                <input type="hidden" name="item[]" value="{{ true }}">
                <input type="hidden" name="r_status[]" value="{{ null }}">
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <select class="form-select select2" name="r_medicine_stock_id[]">
                                <option value="">-- Pilih Obat --</option>
                                @foreach($medicine as $m)
                                    <option value="{{ $m->fifoStock->id }}">{{ $m->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="number" class="form-control" name="r_qty[]" placeholder="Jumlah">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="button" class="btn btn-danger col-12" onclick="removeItem(this)"><i class="ph-trash"></i></button>
                        </div>
                    </div>
                </div>
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
            url: '{{ url("collection/inpatient/recipe/" . $inpatient->id) }}',
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
                        window.location.replace('{{ url("collection/inpatient/recipe/" . $inpatient->id) }}');
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
