<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Keperawatan - IGD - <span class="fw-normal">Tindakan</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('nursing/emergency-department') }}" class="btn btn-flat-primary">Kembali ke Daftar</a>
            <a href="{{ url()->full() }}" class="btn btn-flat-primary">Refresh</a>
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
                        <td class="align-middle" width="30%">{{ $emergencyDepartment->date_of_entry }}</td>
                        <th class="align-middle">Tanggal Keluar</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ !empty($emergencyDepartment->date_of_out) ? $emergencyDepartment->date_of_out : '-' }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">UPF</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $emergencyDepartment->functionalService->name }}</td>
                        <th class="align-middle">Dokter</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $emergencyDepartment->doctor->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Alamat</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $patient->address }}</td>
                        <th class="align-middle">Status</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{!! $emergencyDepartment->status() !!}</tr>
                    <tr>
                        <th class="align-middle">Tanggal Lahir</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $patient->date_of_birth }}</td>
                        <th class="align-middle">Golongan</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $emergencyDepartment->type_format_result }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
            <h6 class="py-sm-3 mb-sm-0">Form Tindakan</h6>
            <div class="ms-sm-auto my-sm-auto">
                <form>
                    @csrf
                    <div class="input-group">
                        <span class="input-group-text"><i class="ph-calendar"></i></span>
                        <input type="date" name="date" id="date" class="form-control wmin-250" min="{{ date('Y-m-d', strtotime($emergencyDepartment->date_of_entry)) }}" max="{{ !empty($emergencyDepartment->date_of_out) ? date('Y-m-d', strtotime($emergencyDepartment->date_of_entry)) : date('Y-m-d') }}" value="{{ $date }}" onchange="onLoading('show', '.content'); this.form.submit()">
                        @if($date != date('Y-m-d'))
                            <a href="{{ url('nursing/emergency-department/action/' . $emergencyDepartment->id) }}" class="btn btn-danger">Reset</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <form id="form-data">
                <div id="plus-destroy-item">
                    @if($emergencyDepartmentNursing->count() > 0)
                        @foreach($emergencyDepartmentNursing as $edn)
                            <div class="row item-content">
                                <input type="hidden" name="item[]" value="{{ true }}">
                                <div class="{{ ($date != date('Y-m-d') || $edn->user_id != auth()->id() || $emergencyDepartment->status != 1) ? 'col-md-6' : 'col-md-5' }}">
                                    <div class="form-group">
                                        @if($date != date('Y-m-d') || $edn->user_id != auth()->id() || $emergencyDepartment->status != 1)
                                            <input type="hidden" name="action_id[]" value="{{ $edn->action_id }}">
                                            <input type="text" class="form-control" value="{{ $edn->action->name }}" disabled>
                                        @else
                                            <select class="form-select" name="action_id[]">
                                                <option value="">-- Pilih Tindakan --</option>
                                                @foreach($action as $a)
                                                    <option value="{{ $a->id }}" {{ $edn->action_id == $a->id ? 'selected' : '' }}>{{ $a->name }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="{{ ($date != date('Y-m-d') || $edn->user_id != auth()->id() || $emergencyDepartment->status != 1) ? 'col-md-6' : 'col-md-5' }}">
                                    <div class="form-group">
                                        <input type="hidden" name="user_id[]" value="{{ $edn->user_id }}">
                                        <input type="text" class="form-control" value="{{ $edn->user->employee->name }}" disabled>
                                    </div>
                                </div>
                                @if($date == date('Y-m-d') && $edn->user_id == auth()->id() && $emergencyDepartment->status == 1)
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-danger col-12" onclick="removeItem(this)"><i class="ph-trash"></i></button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        @if($date != date('Y-m-d'))
                            <div class="alert alert-info text-center fw-semibold mb-0">Tidak ada tindakan</div>
                        @endif
                    @endif
                </div>
                <div class="form-group mb-0 {{ $date == date('Y-m-d') && $emergencyDepartmentNursing->count() < $limitAction && $emergencyDepartment->status == 1 ? '' : 'd-none' }}" id="btn-add-item">
                    <button type="button" class="btn btn-teal col-12" onclick="addItem('action')"><i class="ph-plus me-2"></i> Tambah Tindakan</button>
                </div>
            </form>
        </div>
    </div>
    @if($date == date('Y-m-d') && $emergencyDepartment->status == 1)
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
    function checkLimitable() {
        var limit = parseInt('{{ $limitAction }}');
        var length = $('.item-content').length + 1;
    }

    function addItem(param) {
        var limit = parseInt('{{ $limitAction }}');
        var length = $('.item-content').length + 1;

        var formElement = $(`
            <div class="row item-content">
                <input type="hidden" name="item[]" value="{{ true }}">
                <div class="col-md-5">
                    <div class="form-group">
                        <select class="form-select" name="action_id[]">
                            <option value="">-- Pilih Tindakan --</option>
                            @foreach($action as $a)
                                <option value="{{ $a->id }}">{{ $a->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="hidden" name="user_id[]" value="{{ auth()->id() }}">
                        <input type="text" class="form-control" value="{{ auth()->user()->employee->name }}" disabled>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <button type="button" class="btn btn-danger col-12" onclick="removeItem(this)"><i class="ph-trash"></i></button>
                    </div>
                </div>
            </div>
        `).hide().fadeIn(500);

        if(length >= limit) {
            swalInit.fire({
                title: 'Informasi',
                text: 'Anda telah mencapai batas maksimal tindakan dalam sehari yang hanya diperbolehkan sebanyak ' + limit + 'x tindakan'
            });

            $('#btn-add-item').addClass('d-none');
        }

        $('#plus-destroy-item').append(formElement);
    }

    function removeItem(paramObj) {
        $(paramObj).parents('.item-content').remove();

        $('#btn-add-item').removeClass('d-none');
    }

    function submitted() {
        $.ajax({
            url: '{{ url("nursing/emergency-department/action/" . $emergencyDepartment->id) }}',
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
                        window.location.replace('{{ url("nursing/emergency-department/action/" . $emergencyDepartment->id) }}');
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
