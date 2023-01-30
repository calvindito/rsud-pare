<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Pendaftaran - <span class="fw-normal">Rawat Inap</span>
            </h5>
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
        <div id="content-inpatient" style="display:none;">
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
                            <select class="form-select" name="gender" id="gender">
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
                    <h5 class="mb-0">Riwayat Kunjungan Poli</h5>
                </div>
                <div class="card-body border-top">
                    <table class="table table-bordered table-hover table-xs" id="table-history-poly">
                        <thead>
                            <tr>
                                <th nowrap>Tanggal Masuk</th>
                                <th nowrap>Golongan</th>
                                <th nowrap>Keterangan</th>
                                <th nowrap>Poli</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-light">
                                <td class="text-center" colspan="4">Belum ada kunjungan</td>
                            </tr>
                        </tbody>
                    </table>
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
                        <tbody>
                            <tr class="bg-light">
                                <td class="text-center" colspan="4">Belum ada kunjungan</td>
                            </tr>
                        </tbody>
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
                            <div class="me-2">
                                <input type="radio" class="btn-check" name="type" id="type-general" value="1" autocomplete="off">
                                <label class="btn btn-outline-primary rounded-pill" for="type-general">Umum</label>
                            </div>
                            <div class="me-2">
                                <input type="radio" class="btn-check" name="type" id="type-jamkesda" value="2" autocomplete="off">
                                <label class="btn btn-outline-primary rounded-pill" for="type-jamkesda">Jamkesda</label>
                            </div>
                            <div class="me-2">
                                <input type="radio" class="btn-check" name="type" id="type-bpjs-labor" value="3" autocomplete="off">
                                <label class="btn btn-outline-primary rounded-pill" for="type-bpjs-labor">BPJS Tenaga Kerja</label>
                            </div>
                            <div class="me-2">
                                <input type="radio" class="btn-check" name="type" id="type-in-health" value="4" autocomplete="off">
                                <label class="btn btn-outline-primary rounded-pill" for="type-in-health">In Health</label>
                            </div>
                            <div class="me-2">
                                <input type="radio" class="btn-check" name="type" id="type-jr-jamkesda" value="5" autocomplete="off">
                                <label class="btn btn-outline-primary rounded-pill" for="type-jr-jamkesda">JR Jamkesda</label>
                            </div>
                            <div class="me-2">
                                <input type="radio" class="btn-check" name="type" id="type-jr-bpjs" value="6" autocomplete="off">
                                <label class="btn btn-outline-primary rounded-pill" for="type-jr-bpjs">JR BPJS</label>
                            </div>
                            <div class="me-2">
                                <input type="radio" class="btn-check" name="type" id="type-jr-general" value="7" autocomplete="off">
                                <label class="btn btn-outline-primary rounded-pill" for="type-jr-general">JR Umum</label>
                            </div>
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
                        <label class="col-form-label col-lg-3">Kamar <span class="text-danger fw-bold">*</span></label>
                        <div class="col-md-9">
                            <select class="form-select" name="room_type_id" id="room_type_id">
                                <option value="">-- Pilih --</option>
                                @foreach($roomType as $rt)
                                    <option value="{{ $rt->id }}">
                                        {{ $rt->name }}

                                        @if($rt->classType)
                                            - {{ $rt->classType->name }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3">UPF <span class="text-danger fw-bold">*</span></label>
                        <div class="col-md-9">
                            <select class="form-select" name="pharmacy_production_id" id="pharmacy_production_id">
                                <option value="">-- Pilih --</option>
                                @foreach($pharmacyProduction as $pp)
                                    <option value="{{ $rt->id }}">
                                        {{ $pp->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
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
        </div>
    </form>
</div>

<script>
    $(function() {
        select2Ajax('#patient_id', 'patient', false);
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
        if(emptyTable == false) {
            $('#table-history-poly tbody').html(`
                <tr>
                    <td class="text-center" colspan="5">Belum ada kunjungan</td>
                </tr>
            `);

            $('#table-history-inpatient tbody').html(`
                <tr>
                    <td class="text-center" colspan="5">Belum ada kunjungan</td>
                </tr>
            `);
        } else {
            $('#table-history-poly tbody').html('');
            $('#table-history-inpatient tbody').html('');
        }
    }

    function loadPatient() {
        $.ajax({
            url: '{{ url("register/inpatient/load-patient") }}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                id: $('#patient_id').val()
            },
            beforeSend: function() {
                onLoading('show', '.content');
                clearTableHistory();
                $('#content-inpatient').hide();
            },
            success: function(response) {
                onLoading('close', '.content');
                clearTableHistory(true);
                $('#content-inpatient').fadeIn(500);

                $('#table_id').val(response.id);
                $('#identity_number').val(response.identity_number);
                $('#greeted').val(response.greeted);
                $('#name').val(response.name);
                $('#gender').val(response.gender);
                $('#date_of_birth').val(response.date_of_birth);
                $('#religion_id').val(response.religion_id);

                $.each(response.outpatient, function(io, o) {
                    $.each(o.outpatient_poly, function(iop, op) {
                        $('#table-history-poly tbody').append(`
                            <tr>
                                <td nowrap>` + o.date_of_entry + `</td>
                                <td nowrap>` + o.type + `</td>
                                <td nowrap>` + o.presence_format_result + `</td>
                                <td nowrap>` + op.unit.name + `</td>
                            </tr>
                        `);
                    });
                });

                $.each(response.inpatient, function(i, val) {
                    $('#table-history-inpatient tbody').append(`
                        <tr>
                            <td nowrap>` + val.date_of_entry + `</td>
                            <td nowrap>` + val.type_format_result + `</td>
                            <td nowrap>` + val.room_type.name + ` - ` + val.room_type.class_type.name + `</td>
                            <td nowrap>` + val.pharmacy_production.name + `</td>
                        </tr>
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

    function registerPatient() {
        $.ajax({
            url: '{{ url("register/inpatient/register-patient") }}',
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
                        window.location.replace('{{ url("register/inpatient") }}');
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
