<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Operasi - Data - <span class="fw-normal">Kelola</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('operation/data') }}" class="btn btn-flat-primary">Kembali ke Daftar</a>
        </div>
    </div>
</div>
<div class="content pt-0">
    <div class="alert alert-danger d-none" id="validation-element">
        <ul class="mb-0" id="validation-data"></ul>
    </div>
    <div class="card">
        <div class="card-header">
            <h6 class="hstack gap-2 mb-0">Informasi</h6>
        </div>
        <div class="card-body">
            <table class="table">
                <tbody>
                    <tr>
                        <th class="align-middle">No RM</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $patient->id }}</td>
                        <th class="align-middle">Kode</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $operation->code() }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Pasien</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $patient->name }}</td>
                        <th class="align-middle">Kelas</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $operation->operatingRoomAction->classType->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Tanggal Operasi</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $operation->date_of_entry }}</td>
                        <th class="align-middle">Ref</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $operation->ref() }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Diagnosa</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ !empty($operation->diagnosis) ? $operation->diagnosis : '-' }}</td>
                        <th class="align-middle">Spesimen</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $operation->spesimen ? 'Ya' : 'Tidak' }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Golongan Operasi</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $operation->operatingRoomAction->operatingRoomGroup->name ?? '-' }}</td>
                        <th class="align-middle">Jenis Tindakan</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $operation->operatingRoomAction->operatingRoomActionType->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Unit</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $operation->unit->name ?? '-' }}</td>
                        <th class="align-middle">Dokter Anestesi</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $operation->doctor->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Anestesi</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $operation->operatingRoomAnesthetist->name ?? '-' }}</td>
                        <th class="align-middle">UPF</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $operation->functionalService->name ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h6 class="hstack gap-2 mb-0">Asisten Dokter</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="bg-light">
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama</th>
                    </tr>
                </thead>
                <tbody>
                    @if($operation->operationDoctorAssistant->count() > 0)
                        @foreach($operation->operationDoctorAssistant as $key => $oda)
                            <tr>
                                <td class="align-middle text-center" width="5%">{{ $key + 1 }}</td>
                                <td class="align-middle">{{ $oda->employee->name }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2" class="text-center">Tidak ada asisten</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <form id="form-data">
        <div class="card">
            <div class="card-header">
                <h6 class="hstack gap-2 mb-0">Data Kamar Operasi</h6>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Dokter Operasi</label>
                    <div class="col-md-10">
                        <select class="form-select" name="doctor_operation_id" id="doctor_operation_id">
                            <option value="">-- Pilih --</option>
                            @foreach($doctor as $d)
                                <option value="{{ $d->id }}" {{ $operation->doctor_operation_id == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Biaya Rumah Sakit</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control number-format" name="hospital_service" id="hospital_service" value="{{ $operation->hospital_service ?? '' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Biaya Dokter Operasi</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control number-format" name="doctor_operating_room" id="doctor_operating_room" value="{{ $operation->doctor_operating_room ?? '' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Biaya Dokter Anestesi</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control number-format" name="doctor_anesthetist" id="doctor_anesthetist" value="{{ $operation->doctor_anesthetist ?? '' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Biaya Perawat Operasi</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control number-format" name="nurse_operating_room" id="nurse_operating_room" value="{{ $operation->nurse_operating_room ?? '' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Biaya Perawat Anestesi</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control number-format" name="nurse_anesthetist" id="nurse_anesthetist" value="{{ $operation->nurse_anesthetist ?? '' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Biaya RR Monitoring</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control number-format" name="monitoring" id="monitoring" value="{{ $operation->monitoring ?? '' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Biaya RR Askep</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control number-format" name="nursing_care" id="nursing_care" value="{{ $operation->nursing_care ?? '' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Tanggal Selesai</label>
                    <div class="col-md-10">
                        <input type="datetime-local" class="form-control rounded-bottom-0" name="date_of_out" id="date_of_out" value="{{ $operation->date_of_out ?? '' }}">
                        <div class="form-text bg-light border border-top-0 rounded-bottom px-2 py-1 mt-0">kosongi jika belum selesai operasi</div>
                    </div>
                </div>
                <fieldset>
                    <legend class="fs-base fw-bold border-bottom pb-2 mb-3">Biaya Bahan</legend>
                    <div id="plus-destroy-item">
                        @foreach($operationMaterial as $om)
                            <div id="item">
                                <input type="hidden" name="item[]" value="{{ true }}">
                                <div class="row">
                                    <div class="{{ $operation->status != 3 ? 'col-md-6' : 'col-md-7' }}">
                                        <div class="form-group">
                                            @if($operation->status == 3 || $om->dispensary_id != $operation->operationable->dispensary_id)
                                                <input type="hidden" name="om_dispensary_item_stock_id[]" value="{{ $om->dispensary_item_stock_id }}">
                                            @endif
                                            @if($om->dispensary_id == $operation->operationable->dispensary_id)
                                                <select class="form-select select2" name="om_dispensary_item_stock_id[]" {{ $operation->status == 3 || $om->dispensary_id != $operation->operationable->dispensary_id ? 'disabled' : '' }}>
                                                    <option value="">-- Pilih Item --</option>
                                                    @foreach($dispensaryItem as $di)
                                                        <option value="{{ $di->fifoStock()->id }}" {{ ($om->dispensary_item_stock_id ?? null) == $di->fifoStock()->id ? 'selected' : '' }}>{{ $di->item->name }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input type="text" class="form-control" value="{{ $om->dispensaryItemStock->dispensaryItem->item->name ?? '-' }}" disabled>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" value="{{ $om->dispensary->name ?? '-' }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="form-group">
                                                @if($operation->status == 3 || $om->dispensary_id != $operation->operationable->dispensary_id)
                                                    <input type="hidden" name="om_qty[]" value="{{ $om->qty }}">
                                                @endif
                                                @if($om->dispensary_id == $operation->operationable->dispensary_id)
                                                    <input type="number" class="form-control" name="om_qty[]" value="{{ $om->qty }}" placeholder="Jumlah" {{ $operation->status == 3 || $om->dispensary_id != $operation->operationable->dispensary_id ? 'disabled' : '' }}>
                                                @else
                                                    <input type="number" class="form-control" value="{{ $om->qty }}" placeholder="0" disabled>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if($operation->status != 3)
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <button type="button" class="btn btn-danger col-12" onclick="removeItem(this)"><i class="ph-trash"></i></button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($operation->status != 3)
                        <div class="form-group">
                            <button type="button" class="btn btn-teal col-12" onclick="addItem()"><i class="ph-plus me-2"></i> Tambah Biaya</button>
                        </div>
                    @endif
                </fieldset>
                <div class="form-group"><hr class="mt-0 mb-0"></div>
                <div class="form-group text-center mb-0">
                    @if($operation->status != 3)
                        <div class="row">
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="status" id="status-1" value="1" autocomplete="off" {{ $operation->status == 1 ? 'checked' : '' }}>
                                <label class="btn btn-outline-danger btn-sm col-12" for="status-1">Belum Operasi</label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="status" id="status-2" value="2" autocomplete="off" {{ $operation->status == 2 ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary btn-sm col-12" for="status-2">Sedang Operasi</label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="status" id="status-3" value="3" autocomplete="off" {{ $operation->status == 3 ? 'checked' : '' }}>
                                <label class="btn btn-outline-success btn-sm col-12" for="status-3">Selesai Operasi</label>
                            </div>
                        </div>
                    @else
                        {!! $operation->status() !!}
                    @endif
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="text-end">
                    @if($operation->status != 3)
                        <button type="button" class="btn btn-warning" onclick="submitted()">
                            <i class="ph-floppy-disk me-2"></i>
                            Simpan Data
                        </button>
                    @else
                        <a href="{{ url('operation/data/print/' . $operation->id) }}" class="btn btn-teal" target="_blank">
                            <i class="ph-printer me-2"></i>
                            Cetak
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(function() {
        checkStatus();
        sidebarMini();
        fullWidthAllDevice();
    });

    function checkStatus() {
        var status = '{{ $operation->status }}';

        if(status == 3) {
            $('.form-control').attr('disabled', true);
            $('.form-select').attr('disabled', true);
        }
    }

    function addItem() {
        var formElement = $(`
            <div id="item">
                <input type="hidden" name="item[]" value="{{ true }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="form-select select2" name="om_dispensary_item_stock_id[]">
                                <option value="">-- Pilih Item --</option>
                                @foreach($dispensaryItem as $di)
                                    <option value="{{ $di->fifoStock()->id }}">{{ $di->item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" class="form-control" value="{{ $operation->operationable->dispensary->name ?? '-' }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="number" class="form-control" name="om_qty[]" min="1" placeholder="Jumlah">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <button type="button" class="btn btn-danger col-12" onclick="removeItem(this)"><i class="ph-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        `).hide().fadeIn(500);

        $('#plus-destroy-item').append(formElement);
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
            url: '{{ url("operation/data/manage/" . $operation->id) }}',
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
                        window.location.replace('{{ url("operation/data/manage/" . $operation->id) }}');
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
