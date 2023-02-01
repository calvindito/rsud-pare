<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Pendaftaran - Rawat Jalan - <span class="fw-normal">Kamar Operasi</span>
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
                @if($operation)
                    <div class="alert alert-warning text-center">
                        Ubah Data Kamar Operasi Pasien <b class="fst-italic">{{ $operation->patient->name }}</b>
                    </div>
                @else
                    <div class="alert alert-primary text-center">
                        Buat Data Rawat Jalan Pasien <b class="fst-italic">{{ $outpatient->patient->name }}</b>
                    </div>
                @endif
                <div class="text-center">
                    <a href="{{ url('collection/outpatient') }}">Kembali ke Daftar</a>
                </div>
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
                    <label class="col-form-label col-lg-3">Tanggal Lahir <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <input type="date" class="form-control" name="date_of_birth" id="date_of_birth">
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
                    <label class="col-form-label col-lg-3">Desa <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="village" id="village" placeholder="Masukan desa">
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
                <h5 class="mb-0">Kamar Operasi</h5>
            </div>
            <div class="card-body border-top">
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Poli <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <select class="form-select" name="unit_id" id="unit_id">
                            @foreach($unit as $u)
                                @if($u->id == $outpatientPoly->unit_id)
                                    <option value="{{ $u->id }}" selected>{{ $u->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Tanggal Masuk / Operasi <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="datetime-local" class="form-control" name="date_of_entry" id="date_of_entry" value="{{ $operation ? $operation->date_of_entry : date('Y-m-d H:i') }}">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Diagnosa</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="diagnosis" id="diagnosis" placeholder="Masukan diagnosa" value="{{ $operation ? $operation->diagnosis : '' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Operasi <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <select class="form-select" name="operating_room_action_id" id="operating_room_action_id">
                            <option value="">-- Pilih --</option>
                            @foreach($operatingRoomAction as $ora)
                                <option value="{{ $ora->id }}" {{ $operation ? $operation->operating_room_action_id == $ora->id ? 'selected' : '' : '' }}>
                                    {{ $ora->operatingRoomGroup->name }} -
                                    {{ $ora->operatingRoomActionType->name }} -
                                    {{ $ora->classType->name }}
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
                                <option value="{{ $pp->id }}" {{ $operation ? $operation->pharmacy_production_id == $pp->id ? 'selected' : '' : '' }}>{{ $pp->name }}</option>
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
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Anestesi <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <select class="form-select" name="operating_room_anesthetist_id" id="operating_room_anesthetist_id">
                            <option value="">-- Pilih --</option>
                            @foreach($operatingRoomAnesthetist as $opa)
                                <option value="{{ $opa->id }}" {{ $operation ? $operation->operating_room_anesthetist_id == $opa->id ? 'selected' : '' : '' }}>{{ $opa->code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Dokter Anestesi <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <select class="form-select" name="doctor_id" id="doctor_id">
                            <option value="">-- Pilih --</option>
                            @foreach($doctor as $d)
                                <option value="{{ $d->id }}" {{ $operation ? $operation->doctor_id == $d->id ? 'selected' : '' : '' }}>{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Spesimen <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <select class="form-select" name="specimen" id="specimen">
                            <option value="1"  {{ $operation ? $operation->specimen == 1 ? 'selected' : '' : '' }}>Ya</option>
                            <option value="0"  {{ $operation ? $operation->specimen == 0 ? 'selected' : '' : '' }}>Tidak</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row justify-content-end">
                    <label class="col-form-label col-lg-3">Asisten</label>
                    <div class="col-md-9">
                        <div id="plus-destroy-item">
                            @isset($operation->operationDoctorAssistant)
                                @if($operation->operationDoctorAssistant->count() > 0)
                                    @foreach($operation->operationDoctorAssistant as $oda)
                                        <div class="form-group">
                                            <input type="hidden" name="item[]" value="{{ true }}">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="operation_doctor_assistant_name[]" value="{{ $oda->name }}" placeholder="Masukan nama asisten">
                                                <button type="button" class="btn btn-light" onclick="removeItem(this)"><i class="ph-trash fw-bold text-danger"></i></button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-teal col-12" onclick="addItem()"><i class="ph-plus me-2"></i> Tambah Asisten</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="text-end">
                    <a href="{{ url('collection/outpatient') }}" class="btn btn-danger">
                        <i class="ph-x me-1"></i>
                        Batalkan Perubahan
                    </a>
                    <button type="button" class="btn btn-warning" onclick="updatePatient()">
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
        loadPatient();
    });

    function addItem() {
        var formElement = $(`
            <div class="form-group">
                <input type="hidden" name="item[]" value="{{ true }}">
                <div class="input-group">
                    <input type="text" class="form-control" name="operation_doctor_assistant_name[]" placeholder="Masukan nama asisten">
                    <button type="button" class="btn btn-light" onclick="removeItem(this)"><i class="ph-trash fw-bold text-danger"></i></button>
                </div>
            </div>
        `).hide().fadeIn(500);

        $('#plus-destroy-item').append(formElement);
    }

    function removeItem(paramObj) {
        $(paramObj).parents('.form-group').eq(0).remove();
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
            },
            success: function(response) {
                onLoading('close', '.content');

                $('#table_id').val(response.id);
                $('#identity_number').val(response.identity_number);
                $('#greeted').val(response.greeted);
                $('#name').val(response.name);
                $('#gender').val(response.gender);
                $('#date_of_birth').val(response.date_of_birth);
                $('#village').val(response.village);
                $('#address').val(response.address);
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
            url: '{{ url("collection/outpatient/operating-room/$outpatientPoly->id") }}',
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
                        window.location.replace('{{ url("collection/outpatient/operating-room/$outpatientPoly->id") }}');
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
