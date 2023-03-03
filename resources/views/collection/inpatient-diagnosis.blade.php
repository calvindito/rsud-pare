<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Pendataan - Rawat Inap - <span class="fw-normal">Diagnosa</span>
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
                        <td class="align-middle">
                            {{ $inpatient->bed->roomSpace->roomType->name . ' | ' . $inpatient->bed->roomSpace->roomType->classType->name }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <form id="form-data">
        <div class="card">
            <div class="card-header">
                <h6 class="hstack gap-2 mb-0">Diagnosa</h6>
            </div>
            <div class="card-body">
                <div id="plus-destroy-diagnosis">
                    @if($inpatientDiagnosis->where('type', 1)->count() > 0)
                        @foreach($inpatientDiagnosis->where('type', 1) as $id)
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="diagnosis[]" value="{{ $id->value }}" placeholder="Masukan diagnosa">
                                    @if($inpatient->status == 1)
                                        <button type="button" class="btn btn-light" onclick="removeItem(this)"><i class="ph-trash fw-bold text-danger"></i></button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                @if($inpatient->status == 1)
                    <div class="form-group">
                        <button type="button" class="btn btn-teal col-12" onclick="addItem('diagnosis')"><i class="ph-plus me-2"></i> Tambah Diagnosa</button>
                    </div>
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h6 class="hstack gap-2 mb-0">Tindakan</h6>
            </div>
            <div class="card-body">
                <div id="plus-destroy-action">
                    @if($inpatientDiagnosis->where('type', 2)->count() > 0)
                        @foreach($inpatientDiagnosis->where('type', 2) as $id)
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="action[]" value="{{ $id->value }}" placeholder="Masukan tindakan">
                                    @if($inpatient->status == 1)
                                        <button type="button" class="btn btn-light" onclick="removeItem(this)"><i class="ph-trash fw-bold text-danger"></i></button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                @if($inpatient->status == 1)
                    <div class="form-group">
                        <button type="button" class="btn btn-teal col-12" onclick="addItem('action')"><i class="ph-plus me-2"></i> Tambah Tindakan</button>
                    </div>
                @endif
            </div>
        </div>
        @if($inpatient->status == 1)
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
        @endif
    </form>
</div>

<script>
    $(function() {
        checkStatus();
    });

    function checkStatus() {
        var status = '{{ $inpatient->status }}';

        if(status == 1) {
            $('.form-control').attr('disabled', false);
            $('.form-select').attr('disabled', false);
        } else {
            $('.form-control').attr('disabled', true);
            $('.form-select').attr('disabled', true);
        }
    }

    function addItem(param) {
        if(param == 'diagnosis') {
            var input = '<input type="text" class="form-control" name="diagnosis[]" placeholder="Masukan diagnosa">';
        } else {
            var input = '<input type="text" class="form-control" name="action[]" placeholder="Masukan tindakan">';
        }

        var formElement = $(`
            <div class="form-group">
                <div class="input-group">
                    ` + input + `
                    <button type="button" class="btn btn-light" onclick="removeItem(this)"><i class="ph-trash fw-bold text-danger"></i></button>
                </div>
            </div>
        `).hide().fadeIn(500);

        $('#plus-destroy-' + param).append(formElement);
    }

    function removeItem(paramObj) {
        $(paramObj).parents('.form-group').remove();
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
            url: '{{ url("collection/inpatient/diagnosis/" . $inpatient->id) }}',
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
                        window.location.replace('{{ url("collection/inpatient/diagnosis/" . $inpatient->id) }}');
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
