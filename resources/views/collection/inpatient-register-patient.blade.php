<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Pendataan - Rawat Inap - <span class="fw-normal">Registrasi Pasien</span>
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
    <form id="form-data">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-info text-center">
                    Silahkan pilih pasien terlebih dahulu dan cari data pasien yang telah terdaftar dibawah ini dengan kata kunci
                    <b class="fst-italic">
                        No Rekam Medik, No KTP, Nama Pasien
                    </b>
                </div>
                <select class="form-select" name="patient_id" id="patient_id" onchange="loadPatient()"></select>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Data Pasien</h5>
            </div>
            <div class="card-body border-top">
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">No Identitas</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="identity_number" id="identity_number" placeholder="Masukan no identitas (KTP)">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Nama <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <select class="form-select w-auto flex-grow-0" name="greeted" id="greeted">
                                <option value="">-- Pilih --</option>
                                <option value="1">Tuan</option>
                                <option value="2">Nyonya</option>
                                <option value="3">Saudara</option>
                                <option value="4">Nona</option>
                                <option value="5">Anak</option>
                            </select>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Masukan nama">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Jenis Kelamin <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <select class="form-select" name="gender" id="gender" onchange="loadBed()">
                            <option value="">-- Pilih --</option>
                            <option value="1">Laki - Laki</option>
                            <option value="2">Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Tanggal Lahir</label>
                    <div class="col-md-9">
                        <input type="date" class="form-control" name="date_of_birth" id="date_of_birth">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Agama <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <select class="form-select" name="religion_id" id="religion_id">
                            <option value="">-- Pilih --</option>
                            @foreach($religion as $r)
                                <option value="{{ $r->id }}">{{ $r->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Riwayat Kunjungan Rawat Inap</h5>
            </div>
            <div class="card-body border-top">
                <table class="table table-bordered table-hover table-xs" id="table-history-inpatient">
                    <thead>
                        <tr>
                            <th nowrap>Tanggal Masuk</th>
                            <th nowrap>Golongan</th>
                            <th nowrap>Kamar Tujuan</th>
                            <th nowrap>UPF</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Kamar Tujuan</h5>
            </div>
            <div class="card-body border-top">
                <div class="form-group mb-4 text-center">
                    <div class="btn-group">
                        @foreach (Simrs::nursingType() as $key => $nt)
                            <div class="me-2">
                                <input type="radio" class="btn-check" name="type" id="type-{{ Str::slug($nt) }}" value="{{ $key + 1 }}" autocomplete="off">
                                <label class="btn btn-outline-primary rounded-pill" for="type-{{ Str::slug($nt) }}">{{ $nt }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Tanggal Masuk / Daftar <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="datetime-local" class="form-control" name="date_of_entry" id="date_of_entry" value="{{ date('Y-m-d H:i') }}">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Kamar Tempat Tidur <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <select class="form-select select2-form" name="bed_id" id="bed_id"></select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">UPF <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <select class="form-select select2-form" name="functional_service_id" id="functional_service_id">
                            <option value="">-- Pilih --</option>
                            @foreach($functionalService as $fs)
                                <option value="{{ $fs->id }}">
                                    {{ $fs->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Dokter <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <select class="form-select select2-form" name="doctor_id" id="doctor_id">
                            <option value="">-- Pilih --</option>
                            @foreach($doctor as $d)
                                <option value="{{ $d->id }}">
                                    {{ $d->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Apotek <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <select class="form-select" name="dispensary_id" id="dispensary_id">
                            <option value="">-- Pilih --</option>
                            @foreach($dispensary as $d)
                                <option value="{{ $d->id }}">
                                    {{ $d->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tindakan</h5>
            </div>
            <div class="card-body border-top">
                <table class="table table-bordered table-hover table-xs">
                    <thead>
                        <tr>
                            <th class="text-center" nowrap>No</th>
                            <th nowrap>Nama</th>
                            <th nowrap>Batas Per Hari</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($action->count() > 0)
                            @foreach($action as $key => $a)
                                <tr>
                                    <td class="text-center" width="10%">{{ $key + 1 }}</td>
                                    <td>
                                        <input type="hidden" name="ial_action_id[]" value="{{ $a->id }}">
                                        {{ $a->name }}
                                    </td>
                                    <td width="20%">
                                        <input type="number" class="form-control" name="ial_limit[]" value="2">
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada tindakan</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="text-end">
                    <button type="button" class="btn btn-primary" onclick="registerPatient()">
                        <i class="ph-checks me-2"></i>
                        Daftarkan Pasien Sekarang
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(function() {
        $('.select2-form').select2({
            placeholder: '-- Pilih --'
        });

        select2Ajax('#patient_id', 'patient', false);
        loadBed();
    });

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

    function clearTableHistory(emptyTable = false) {
        $('#table-history-inpatient tbody').html('');
    }

    function loadBed() {
        $.ajax({
            url: '{{ url("collection/inpatient/load-bed") }}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                gender: $('#gender').val()
            },
            beforeSend: function() {
                onLoading('show', '.content');
                $('#bed_id').html('');
            },
            success: function(response) {
                onLoading('close', '.content');

                $.each(response, function(i, val) {
                    $('#bed_id').append(`
                        <option value="` + val.id + `">
                            ` + val.room_space.room_type.room.name + ` |
                            ` + val.room_space.room_type.name + ` |
                            ` + val.room_space.room_type.class_type.name + ` |
                            ` + val.room_space.name + ` |
                            ` + val.name + `
                            (` + val.type_format_result + `)
                        </option>
                    `);
                });
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

    function loadPatient() {
        $.ajax({
            url: '{{ url("collection/inpatient/load-patient") }}',
            type: 'GET',
            dataType: 'JSON',
            async: false,
            data: {
                id: $('#patient_id').val()
            },
            beforeSend: function() {
                onLoading('show', '.content');
                clearTableHistory();
            },
            success: function(response) {
                onLoading('close', '.content');

                $('#table_id').val(response.id);
                $('#identity_number').val(response.identity_number);
                $('#greeted').val(response.greeted);
                $('#name').val(response.name);
                $('#gender').val(response.gender);
                $('#date_of_birth').val(response.date_of_birth);
                $('#religion_id').val(response.religion_id);

                $.each(response.inpatient, function(i, val) {
                    $('#table-history-inpatient tbody').append(`
                        <tr>
                            <td nowrap>` + val.date_of_entry + `</td>
                            <td nowrap>` + val.type_format_result + `</td>
                            <td nowrap>` + val.bed.room_space.room_type.name + ` - ` + val.bed.room_space.room_type.class_type.name + `</td>
                            <td nowrap>` + val.functional_service.name + `</td>
                        </tr>
                    `);
                });

                loadBed();
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

    function registerPatient() {
        $.ajax({
            url: '{{ url("collection/inpatient/register-patient") }}',
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
                        window.location.replace('{{ url("collection/inpatient/register-patient") }}');
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
