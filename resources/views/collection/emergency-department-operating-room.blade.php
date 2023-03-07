<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Pendataan - IGD - <span class="fw-normal">Kamar Operasi</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('collection/emergency-department') }}" class="btn btn-flat-primary">Kembali ke Daftar</a>
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
                    <div class="alert alert-warning text-center mb-0">
                        Ubah Data Kamar Operasi Pasien <b class="fst-italic">{{ $operation->patient->name }}</b>
                    </div>
                @else
                    <div class="alert alert-primary text-center mb-0">
                        Buat Data Kamar Operasi Pasien <b class="fst-italic">{{ $emergencyDepartment->patient->name }}</b>
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
                    <label class="col-form-label col-lg-3">Unit <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <select class="form-select" name="unit_id" id="unit_id">
                            <option value="">-- Pilih --</option>
                            @foreach($unit as $u)
                                <option value="{{ $u->id }}" {{ ($operation->unit_id ?? null) == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Tanggal Masuk / Operasi <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="datetime-local" class="form-control" name="date_of_entry" id="date_of_entry" value="{{ $operation->date_of_entry ?? date('Y-m-d H:i') }}">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Diagnosa</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="diagnosis" id="diagnosis" placeholder="Masukan diagnosa" value="{{ $operation->diagnosis ?? '' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Operasi <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <select class="form-select" name="operating_room_action_id" id="operating_room_action_id">
                            <option value="">-- Pilih --</option>
                            @foreach($operatingRoomAction as $ora)
                                <option value="{{ $ora->id }}" {{ ($operation->operating_room_action_id ?? null) == $ora->id ? 'selected' : '' }}>
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
                        <select class="form-select" name="functional_service_id" id="functional_service_id">
                            <option value="">-- Pilih --</option>
                            @foreach($functionalService as $fs)
                                <option value="{{ $fs->id }}" {{ ($operation->functional_service_id ?? null) == $fs->id ? 'selected' : '' }}>{{ $fs->name }}</option>
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
                                <option value="{{ $opa->id }}" {{ ($operation->operating_room_anesthetist_id ?? null) == $opa->id ? 'selected' : '' }}>{{ $opa->code }}</option>
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
                                <option value="{{ $d->id }}" {{ ($operation->doctor_id ?? null) == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-3">Spesimen <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-9">
                        <select class="form-select" name="specimen" id="specimen">
                            <option value="1"  {{ ($operation->specimen ?? null) == 1 ? 'selected' : '' }}>Ya</option>
                            <option value="0"  {{ ($operation->specimen ?? null) == 0 ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row justify-content-end">
                    <label class="col-form-label col-lg-3">Asisten Dokter</label>
                    <div class="col-md-9">
                        <div id="plus-destroy-item">
                            @if($operation)
                                @if($operation->operationDoctorAssistant->count() > 0)
                                    @foreach($operation->operationDoctorAssistant as $oda)
                                        <div class="form-group">
                                            <input type="hidden" name="item[]" value="{{ true }}">
                                            <div class="row">
                                                <div class="{{ $emergencyDepartment->status == 1 ? 'col-md-11' : 'col-md-12' }}">
                                                    <select class="form-select select2" name="o_employee_id[]">
                                                        <option value="">-- Pilih --</option>
                                                        @foreach($employee as $e)
                                                            <option value="{{ $e->id }}" {{ $oda->employee_id == $e->id ? 'selected' : '' }}>{{ $e->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @if($emergencyDepartment->status == 1)
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-light col-12 btn-sm" onclick="removeItem(this)"><i class="ph-trash fw-bold text-danger"></i></button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                @if($emergencyDepartment->status == 1)
                    <div class="form-group">
                        <button type="button" class="btn btn-teal col-12" onclick="addItem()"><i class="ph-plus me-2"></i> Tambah Asisten</button>
                    </div>
                @endif
            </div>
        </div>
        @if($emergencyDepartment->status == 1)
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
        loadPatient();
        checkStatus();

        $('.select2').select2();
    });

    function checkStatus() {
        var status = '{{ $emergencyDepartment->status }}';

        if(status == 1) {
            $('.form-control').attr('disabled', false);
            $('.form-select').attr('disabled', false);
        } else {
            $('.form-control').attr('disabled', true);
            $('.form-select').attr('disabled', true);
        }
    }

    function addItem() {
        var formElement = $(`
            <div class="form-group">
                <input type="hidden" name="item[]" value="{{ true }}">
                <div class="row">
                    <div class="col-md-11">
                        <select class="form-select select2" name="o_employee_id[]">
                            <option value="">-- Pilih --</option>
                            @foreach($employee as $e)
                                <option value="{{ $e->id }}">{{ $e->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-light col-12 btn-sm" onclick="removeItem(this)"><i class="ph-trash fw-bold text-danger"></i></button>
                    </div>
                </div>
            </div>
        `).hide().fadeIn(500);

        $('#plus-destroy-item').append(formElement);
        $('.select2').select2();
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
            url: '{{ url("collection/emergency-department/load-patient") }}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                id: '{{ $emergencyDepartment->patient->id }}'
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

    function submitted() {
        $.ajax({
            url: '{{ url("collection/emergency-department/operating-room/" . $emergencyDepartment->id) }}',
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
                        window.location.replace('{{ url("collection/emergency-department/operating-room/" . $emergencyDepartment->id) }}');
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
