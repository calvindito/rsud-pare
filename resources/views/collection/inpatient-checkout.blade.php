<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Pendataan - Rawat Inap - <span class="fw-normal">Check-Out</span>
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
                <h6 class="hstack gap-2 mb-0">Form Check-Out</h6>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Status <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <select class="form-select" name="status" id="status" onchange="formStatus()">
                            <option value="">-- Pilih --</option>
                            <option value="2">Pindah Kamar</option>
                            <option value="3">Pulang</option>
                            <option value="4">Keluar Kamar</option>
                        </select>
                    </div>
                </div>
                <div id="form-status-2">
                    <div class="form-group">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3">Kamar Sebelumnya</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control form-control-plaintext" value="{{ $inpatient->roomType->name . ' | ' . $inpatient->roomType->classType->name }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3">Golongan Sebelumnya</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control form-control-plaintext" value="{{ $inpatient->type_format_result }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3">UPF Sebelumnya</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control form-control-plaintext" value="{{ $inpatient->functionalService->name }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3">Kamar Baru <span class="text-danger fw-bold">*</span></label>
                            <div class="col-lg-9">
                                <select class="form-select" name="room_type_id" id="room_type_id">
                                    <option value="">-- Pilih --</option>
                                    @foreach($roomType as $rt)
                                        <option value="{{ $rt->id }}">
                                            {{ $rt->name . ' | ' . $rt->classType->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3">Golongan Baru <span class="text-danger fw-bold">*</span></label>
                            <div class="col-lg-9">
                                <select class="form-select" name="type" id="type">
                                    <option value="">-- Pilih --</option>
                                    <option value="1">Umum</option>
                                    <option value="2">Jamkesda</option>
                                    <option value="3">BPJS Tenaga Kerja</option>
                                    <option value="4">In Health</option>
                                    <option value="5">JR Jamkesda</option>
                                    <option value="6">JR BPJS</option>
                                    <option value="7">JR Umum</option>
                                    <option value="8">BPJS Kesehatan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3">UPF Baru <span class="text-danger fw-bold">*</span></label>
                            <div class="col-lg-9">
                                <select class="form-select" name="functional_service_id" id="functional_service_id">
                                    <option value="">-- Pilih --</option>
                                    @foreach($functionalService as $fs)
                                        <option value="{{ $fs->id }}">{{ $fs->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="form-status-3-4">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Hasil <span class="text-danger fw-bold">*</span></label>
                        <div class="col-lg-9">
                            <select class="form-select" name="ending" id="ending">
                                <option value="">-- Pilih --</option>
                                <option value="1">Sembuh</option>
                                <option value="2">Rujuk</option>
                                <option value="3">Pulang Paksa</option>
                                <option value="4">Meninggal < 48 Jam</option>
                                <option value="5">Meninggal > 48 Jam</option>
                                <option value="6">Tidak Diketahui</option>
                                <option value="7">Konsul ke Poli Lain</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">Tanggal Keluar <span class="text-danger fw-bold">*</span></label>
                        <div class="col-lg-9">
                            <input type="datetime-local" class="form-control" name="date_of_out" id="date_of_entry" value="{{ date('Y-m-d H:i') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-end">
                    <button type="button" class="btn btn-success" onclick="submitted()">
                        <i class="ph-check me-2"></i>
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(function() {
        formStatus();
    });

    function formStatus() {
        var status = $('#status').val();

        if(status == 2) {
            $('#form-status-2').fadeIn(500);
            $('#form-status-3-4').hide();
        } else if(status == 3 || status == 4) {
            $('#form-status-2').hide();
            $('#form-status-3-4').fadeIn(500);
        } else {
            $('#form-status-2').hide();
            $('#form-status-3-4').hide();
        }
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
            url: '{{ url("collection/inpatient/checkout/" . $inpatient->id) }}',
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
                        window.location.replace('{{ url("collection/inpatient") }}');
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
