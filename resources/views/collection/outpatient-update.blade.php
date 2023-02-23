<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Pendaftaran - Rawat Jalan - <span class="fw-normal">Ubah Data</span>
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
    <form id="form-data">
        <div class="card">
            <div class="card-body">
                @if($outpatient->status == 4)
                    <div class="alert alert-success text-center mb-0">
                        Kunjungan Telah Selesai
                    </div>
                @else
                    <div class="alert alert-warning text-center mb-0">
                        Ubah Data Rawat Jalan Pasien <b class="fst-italic">{{ $outpatient->patient->name }}</b>
                    </div>
                @endif
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
                <h5 class="mb-0">Alamat Pasien</h5>
            </div>
            <div class="card-body border-top">
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Wilayah <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <select class="form-select" name="location_id" id="location_id"></select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Desa <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="village" id="village" placeholder="Masukan desa">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">RT</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="rt" id="rt" placeholder="Masukan rt">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">RW</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="rw" id="rw" placeholder="Masukan rw">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Alamat <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <textarea class="form-control" name="address" id="address" style="resize:none;" placeholder="Masukan alamat"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Pasien</h5>
            </div>
            <div class="card-body border-top">
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Tempat Lahir</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="place_of_birth" id="place_of_birth" placeholder="Masukan tempat lahir">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Suku</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="tribe" id="tribe" placeholder="Masukan suku">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Berat Badan</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="number" class="form-control" name="weight" id="weight" placeholder="Masukan berat badan">
                            <span class="input-group-text">Kg</span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Golongan Darah</label>
                    <div class="col-md-9">
                        <select class="form-select" name="blood_group" id="blood_group">
                            <option value="">-- Pilih --</option>
                            <option value="1">A</option>
                            <option value="2">B</option>
                            <option value="3">AB</option>
                            <option value="4">O</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Status Pernikahan</label>
                    <div class="col-md-9">
                        <select class="form-select" name="marital_status" id="marital_status">
                            <option value="">-- Pilih --</option>
                            <option value="1">Belum Menikah</option>
                            <option value="2">Menikah</option>
                            <option value="3">Cerai Hidup</option>
                            <option value="4">Cerai Mati</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Pekerjaan</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="job" id="job" placeholder="Masukan pekerjaan">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">No Telp</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Masukan no telp">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Nama Ortu</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="parent_name" id="parent_name" placeholder="Masukan nama ortu">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Nama Suami / Istri</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="partner_name" id="partner_name" placeholder="Masukan nama suami / istri">
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Riwayat Kunjungan Rawat Jalan</h5>
            </div>
            <div class="card-body border-top">
                <table class="table table-bordered table-hover table-xs" id="table-history-outpatient">
                    <thead>
                        <tr>
                            <th nowrap>Tanggal Masuk</th>
                            <th nowrap>Golongan</th>
                            <th nowrap>Keterangan</th>
                            <th nowrap>Poli</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
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
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Poli Tujuan</h5>
            </div>
            <div class="card-body border-top">
                <div class="form-group mb-4 text-center">
                    <div class="btn-group">
                        @foreach (Simrs::nursingType() as $key => $nt)
                            <div class="me-2">
                                <input type="radio" class="btn-check" name="type" id="type-{{ Str::slug($nt) }}" value="{{ $key + 1 }}" autocomplete="off" {{ $outpatient->type == $key + 1 ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary rounded-pill" for="type-{{ Str::slug($nt) }}">{{ $nt }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Tanggal Masuk / Daftar <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="datetime-local" class="form-control" name="date_of_entry" id="date_of_entry" value="{{ $outpatient->date_of_entry }}">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Kehadiran <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <select class="form-select" name="presence" id="presence">
                            <option value="">-- Pilih --</option>
                            <option value="1" {{ $outpatient->presence == 1 ? 'selected' : '' }}>Datang Sendiri</option>
                            <option value="2" {{ $outpatient->presence == 2 ? 'selected' : '' }}>Rujukan Dari Puskesmas</option>
                            <option value="3" {{ $outpatient->presence == 3 ? 'selected' : '' }}>Rujukan Dokter</option>
                            <option value="4" {{ $outpatient->presence == 4 ? 'selected' : '' }}>Rujukan Dari Rumah Sakit Lain</option>
                            <option value="5" {{ $outpatient->presence == 5 ? 'selected' : '' }}>Lahir Didalam Rumah Sakit</option>
                            <option value="6" {{ $outpatient->presence == 6 ? 'selected' : '' }}>Rujukan Dari Bidan</option>
                            <option value="7" {{ $outpatient->presence == 7 ? 'selected' : '' }}>Rujukan Klinik</option>
                            <option value="8" {{ $outpatient->presence == 8 ? 'selected' : '' }}>Rujukan Balai Pengobatan</option>
                            <option value="9" {{ $outpatient->presence == 9 ? 'selected' : '' }}>Diantar Polisi</option>
                            <option value="10" {{ $outpatient->presence == 10 ? 'selected' : '' }}>Diantar Ambulans</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Poli <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <select class="form-select" name="unit_id" id="unit_id">
                            <option value="">-- Pilih --</option>
                            @foreach($unit as $u)
                                <option value="{{ $u->id }}" {{ $outpatient->unit_id == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Status <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <select class="form-select" name="status" id="status">
                            <option value="">-- Pilih --</option>
                            <option value="1" {{ $outpatient->status == 1 ? 'selected' : '' }}>Dalam Antrian</option>
                            <option value="2" {{ $outpatient->status == 2 ? 'selected' : '' }}>Pasien Tidak Ada</option>
                            <option value="3" {{ $outpatient->status == 3 ? 'selected' : '' }}>Sedang Ditangani</option>
                            <option value="4" {{ $outpatient->status == 4 ? 'selected' : '' }}>Selesai / Pulang</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Apotek <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <select class="form-select" name="dispensary_id" id="dispensary_id">
                            <option value="">-- Pilih --</option>
                            @foreach($dispensary as $d)
                                <option value="{{ $d->id }}" {{ $outpatient->dispensary_id == $d->id ? 'selected' : '' }}>
                                    {{ $d->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Keterangan</label>
                    <div class="col-md-9">
                        <textarea class="form-control" name="description" id="description" style="resize:none;" placeholder="Masukan keterangan">{{ $outpatient->description }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        @if($outpatient->status != 4)
            <div class="card">
                <div class="card-body">
                    <div class="text-end">
                        <a href="{{ url('collection/outpatient') }}" class="btn btn-danger">
                            <i class="ph-x me-1"></i>
                            Batalkan Perubahan
                        </a>
                        <button type="button" class="btn btn-warning" onclick="updatePatient()">
                            <i class="ph-floppy-disk me-2"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </form>
</div>

<script>
    $(function() {
        select2Ajax('#location_id', 'location?show=district', false);
        select2Ajax('#patient_id', 'patient', false);
        loadPatient();
        checkStatus();
    });

    function checkStatus() {
        var status = '{{ $outpatient->status }}';

        if(status != 4) {
            $('.form-control').attr('disabled', false);
            $('.form-select').attr('disabled', false);
        } else {
            $('.form-control').attr('disabled', true);
            $('.form-select').attr('disabled', true);
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

    function clearTableHistory(emptyTable = false) {
        $('#table-history-outpatient tbody').html('');
        $('#table-history-inpatient tbody').html('');
    }

    function loadPatient() {
        $.ajax({
            url: '{{ url("collection/outpatient/load-patient") }}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                id: '{{ $outpatient->patient->id }}'
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

                if(response.district_id != '') {
                    var provinceName = response.province ? response.province.name : 'Invalid Provinsi';
                    var cityName = response.city ? response.city.name : 'Invalid Kota';
                    var districtName = response.district ? response.district.name : 'Invalid Kecamatan';

                    $('#location_id').append(`
                        <option value="` + response.district_id + `" selected>
                            ` + provinceName + ` - ` + cityName + ` - ` + districtName + `
                        </option>
                    `);
                }

                $('#village').val(response.village);
                $('#rt').val(response.rt);
                $('#rw').val(response.rw);
                $('#address').val(response.address);
                $('#place_of_birth').val(response.place_of_birth);
                $('#tribe').val(response.tribe);
                $('#weight').val(response.weight);
                $('#blood_group').val(response.blood_group);
                $('#religion_id').val(response.religion_id);
                $('#marital_status').val(response.marital_status);
                $('#job').val(response.job);
                $('#phone').val(response.phone);
                $('#parent_name').val(response.parent_name);
                $('#partner_name').val(response.partner_name);

                $.each(response.outpatient, function(i, val) {
                    $('#table-history-outpatient tbody').append(`
                        <tr>
                            <td nowrap>` + val.date_of_entry + `</td>
                            <td nowrap>` + val.type_format_result + `</td>
                            <td nowrap>` + val.presence_format_result + `</td>
                            <td nowrap>` + val.unit.name + `</td>
                        </tr>
                    `);
                });

                $.each(response.inpatient, function(i, val) {
                    $('#table-history-inpatient tbody').append(`
                        <tr>
                            <td nowrap>` + val.date_of_entry + `</td>
                            <td nowrap>` + val.type_format_result + `</td>
                            <td nowrap>` + val.room_type.name + ` - ` + val.room_type.class_type.name + `</td>
                            <td nowrap>` + val.functional_service.name + `</td>
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

    function updatePatient() {
        $.ajax({
            url: '{{ url("collection/outpatient/update-data/" . $outpatient->id) }}',
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
                        window.location.replace('{{ url("collection/outpatient/update-data/" . $outpatient->id) }}');
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
