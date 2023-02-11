<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Pendataan - Rawat Jalan - <span class="fw-normal">Tindakan</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('collection/outpatient') }}" class="btn btn-flat-primary">Kembali ke Daftar</a>
            <a href="{{ url()->full() }}" class="btn btn-flat-primary">Refresh</a>
            @if($outpatient->status != 1)
                <button type="button" class="btn btn-flat-primary" data-bs-toggle="modal" data-bs-target="#modal-form" onclick="onReset()">
                    <i class="ph-plus-circle me-1"></i>
                    Entry Tindakan
                </button>
            @endif
        </div>
    </div>
</div>
<div class="content pt-0">
    <div class="card">
        <div class="card-header">
            <h6 class="hstack gap-2 mb-0">Data Pasien</h6>
        </div>
        <div class="card-body">
            <table class="table">
                <tbody>
                    <tr>
                        <th class="align-middle">Nama Pasien</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $patient->name }}</td>
                        <th class="align-middle">No RM</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $patient->id }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Tanggal Masuk</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $outpatient->date_of_entry }}</td>
                        <th class="align-middle">Tanggal Keluar</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ !empty($outpatient->date_of_out) ? $outpatient->date_of_out : '-' }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Poli</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $unit->name }}</td>
                        <th class="align-middle">Kehadiran</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $outpatient->presence_format_result }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Alamat</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $patient->address }}</td>
                        <th class="align-middle">Status</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $outpatient->status() }}</tr>
                    <tr>
                        <th class="align-middle">Tanggal Lahir</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $patient->date_of_birth }}</td>
                        <th class="align-middle">Golongan</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $outpatient->type_format_result }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h6 class="hstack gap-2 mb-0">Data Tindakan</h6>
        </div>
        <div class="card-body">
            @if($outpatient->status != 4)
                <div class="alert alert-warning">
                    Harap klik <b>Simpan Data</b> terlebih dahulu setelah mengisi semua field agar semua aksi yang dibutuhkan muncul dan data tercatat dalam sistem
                </div>
            @endif
            <form id="form-data" class="plus-destroy-item">
                @foreach($outpatientAction as $oa)
                    <div id="item">
                        <input type="hidden" name="item[]" value="{{ true }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select class="form-select" name="doctor_id[]">
                                        <option value="">-- Pilih Dokter --</option>
                                        @foreach($doctor as $d)
                                            <option value="{{ $d->id }}" {{ $oa->doctor_id == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select class="form-select" name="unit_action_id[]">
                                        <option value="">-- Pilih Tindakan --</option>
                                        @foreach($unitAction as $ua)
                                            <option value="{{ $ua->id }}" {{ $oa->unit_action_id == $ua->id ? 'selected' : '' }}>{{ $ua->action->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select class="form-select" name="status[]">
                                        <option value="0" {{ $oa->status == 0 ? 'selected' : '' }}>Belum Terbayar</option>
                                        @if($oa->status == false)
                                            <option value="1" {{ $oa->status == 1 ? 'selected' : '' }}>Terbayar</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="row">
                                        @if($oa->status == true)
                                            <div class="col-md-12">
                                                <a href="{{ url('collection/outpatient/action/print/' . $oa->id . '?slug=proof-of-payment') }}" target="_blank" class="btn btn-teal btn-sm col-12">
                                                    <i class="ph-printer me-1"></i>
                                                    Bukti Bayar
                                                </a>
                                            </div>
                                        @else
                                            <div class="{{ $outpatient->status != 4 ? 'col-md-6' : 'col-md-12' }}">
                                                <a href="{{ url('collection/outpatient/action/print/' . $oa->id . '?slug=payment-letter') }}" target="_blank" class="btn btn-primary btn-sm col-12">
                                                    <i class="ph-printer me-1"></i>
                                                    Surat Bayar
                                                </a>
                                            </div>
                                            @if($outpatient->status != 4)
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-danger btn-sm col-12" onclick="removeItem(this)"><i class="ph-trash"></i></button>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </form>
            @if($outpatient->status != 4)
                <div class="form-group mb-0">
                    <button type="button" class="btn btn-success col-12" onclick="addItem()"><i class="ph-plus me-2"></i> Tambah Data</button>
                </div>
            @endif
        </div>
    </div>
    @if($outpatient->status != 4)
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
</div>

<script>
    $(function() {
        sidebarMini();
        fullWidthAllDevice();
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

    function addItem() {
        var formElement = $(`
            <div id="item">
                <input type="hidden" name="item[]" value="{{ true }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-select" name="doctor_id[]">
                                <option value="">-- Pilih Dokter --</option>
                                @foreach($doctor as $d)
                                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-select" name="unit_action_id[]">
                                <option value="">-- Pilih Tindakan --</option>
                                @foreach($unitAction as $ua)
                                    <option value="{{ $ua->id }}">{{ $ua->action->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="form-select" name="status[]">
                                <option value="0" selected>Belum Terbayar</option>
                                <option value="1">Terbayar</option>
                            </select>
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

        $('.plus-destroy-item').append(formElement);
    }

    function removeItem(paramObj) {
        $(paramObj).parents('#item').remove();
    }

    function submitted() {
        $.ajax({
            url: '{{ url("collection/outpatient/action/" . $outpatient->id) }}',
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
                        window.location.replace('{{ url("collection/outpatient/action/" . $outpatient->id) }}');
                    });
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
