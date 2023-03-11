<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Pendataan - IGD - <span class="fw-normal">Tindakan</span>
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
                            <td class="align-middle" width="30%">{{ $emergencyDepartment->status == 1 ? '-' : $emergencyDepartment->date_of_out }}</td>
                        </tr>
                        <tr>
                            <th class="align-middle">UPF</th>
                            <th class="align-middle" width="1%">:</th>
                            <td class="align-middle" width="30%">{{ $functionalService->name ?? '-' }}</td>
                            <th class="align-middle">Kamar</th>
                            <th class="align-middle" width="1%">:</th>
                            <td class="align-middle" width="30%">IGD</td>
                        </tr>
                        <tr>
                            <th class="align-middle">Alamat</th>
                            <th class="align-middle" width="1%">:</th>
                            <td class="align-middle" width="30%">{{ $patient->address }}</td>
                            <th class="align-middle">Dokter</th>
                            <th class="align-middle" width="1%">:</th>
                            <td class="align-middle" width="30%">{{ $emergencyDepartment->doctor->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="align-middle">Hasil</th>
                            <th class="align-middle" width="1%">:</th>
                            <td class="align-middle" width="30%">{{ $emergencyDepartment->ending_format_result }}</td>
                            <th class="align-middle">Golongan</th>
                            <th class="align-middle" width="1%">:</th>
                            <td class="align-middle" width="30%">{{ $emergencyDepartment->type_format_result }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-pills nav-pills-outline nav-justified overflow-auto">
                    <li class="nav-item">
                        <a href="#stacked-left-pill1" class="nav-link active" data-bs-toggle="tab">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a href="#stacked-left-pill2" class="nav-link" data-bs-toggle="tab">Non Operatif</a>
                    </li>
                    <li class="nav-item">
                        <a href="#stacked-left-pill3" class="nav-link" data-bs-toggle="tab">Penunjang</a>
                    </li>
                    <li class="nav-item">
                        <a href="#stacked-left-pill4" class="nav-link" data-bs-toggle="tab">Obat & Alkes</a>
                    </li>
                    <li class="nav-item">
                        <a href="#stacked-left-pill5" class="nav-link" data-bs-toggle="tab">Lainnya</a>
                    </li>
                    <li class="nav-item">
                        <a href="#stacked-left-pill6" class="nav-link" data-bs-toggle="tab">Perawat</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content flex-1">
                    <div class="tab-pane fade show active" id="stacked-left-pill1">
                        <table class="table table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>Nama</th>
                                    <th colspan="2">Rawat Darurat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-light">
                                    <td colspan="3" class="fw-bold text-uppercase">Layanan</td>
                                </tr>
                                <tr>
                                    <td class="align-middle" nowrap>
                                        <input type="hidden" name="observation_action_emergency_care_id" id="observation_action_emergency_care_id" value="2">
                                        Observasi
                                    </td>
                                    <td class="align-middle"></td>
                                    <td class="align-middle">
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" class="form-control number-format" name="observation_nominal" id="observation_nominal" value="{{ $emergencyDepartment->observation->nominal ?? (App\Models\ActionEmergencyCare::find(2)->fee ?? 0) }}" placeholder="0">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle" nowrap>
                                        <input type="hidden" name="supervision_doctor_action_emergency_care_id" id="supervision_doctor_action_emergency_care_id" value="4">
                                        Pengawasan Dokter
                                    </td>
                                    <td class="align-middle">
                                        <select class="form-select" name="supervision_doctor_doctor_id" id="supervision_doctor_doctor_id">
                                            @foreach($doctor as $key => $d)
                                                <option value="{{ $d->id }}" {{ ($emergencyDepartment->supervision_doctor->doctor_id ?? 1) == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" class="form-control number-format" name="supervision_doctor_nominal" id="supervision_doctor_nominal" value="{{ $emergencyDepartment->supervision_doctor->nominal ?? (App\Models\ActionEmergencyCare::find(4)->fee ?? 0) }}" placeholder="0">
                                        </div>
                                    </td>
                                </tr>
                                <tr class="bg-light">
                                    <td colspan="3" class="fw-bold text-uppercase">Pelayanan Medis</td>
                                </tr>
                                @if($medicalService->count() > 0)
                                    @foreach($medicalService as $ms)
                                        @php $check = $emergencyDepartmentService->firstWhere('medical_service_id', $ms->id); @endphp
                                        <tr>
                                            <input type="hidden" name="emergency_department_service[]" value="{{ true }}">
                                            <td class="align-middle">
                                                <input type="hidden" name="eds_medical_service_id[]" value="{{ $ms->id }}">
                                                {{ $ms->name }}
                                            </td>
                                            <td class="align-middle">
                                                <select class="form-select" name="eds_doctor_id[]">
                                                    @foreach($doctor as $key => $d)
                                                        <option value="{{ $d->id }}" {{ ($check->doctor_id ?? 1) == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="align-middle">
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="text" class="form-control number-format" name="eds_nominal[]" value="{{ $check->nominal ?? $ms->emergency_care }}" placeholder="0">
                                                    <select class="form-select w-auto flex-grow-0" name="eds_qty[]">
                                                        @for($i = 1; $i <= 100; $i++)
                                                            <option value="{{ $i }}" {{ ($check->qty ?? 1) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="3">Tidak Ada Data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="stacked-left-pill2">
                        <table class="table table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>Nama</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($actionNonOperative->count() > 0)
                                    @foreach($actionNonOperative as $ano)
                                        @php $check = $emergencyDepartmentNonOperative->firstWhere('action_non_operative_id', $ano->id); @endphp
                                        <tr>
                                            <input type="hidden" name="emergency_department_non_operative[]" value="{{ true }}">
                                            <td class="align-middle">
                                                <input type="hidden" name="edno_action_non_operative_id[]" value="{{ $ano->id }}">
                                                {{ $ano->name }}
                                            </td>
                                            <td class="align-middle">
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="text" class="form-control number-format" name="edno_nominal[]" value="{{ $check->nominal ?? $ano->emergency_care }}" placeholder="0">
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="2">Tidak Ada Data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="stacked-left-pill3">
                        <table class="table table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>Nama</th>
                                    <th>Dokter</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($actionSupporting->count() > 0)
                                    @foreach($actionSupporting as $as)
                                        @php $check = $emergencyDepartmentSupporting->firstWhere('action_supporting_id', $as->id); @endphp
                                        <tr>
                                            <input type="hidden" name="emergency_department_supporting[]" value="{{ true }}">
                                            <td class="align-middle">
                                                <input type="hidden" name="edss_action_supporting_id[]" value="{{ $as->id }}">
                                                {{ $as->name }}
                                            </td>
                                            <td class="align-middle">
                                                <select class="form-select" name="edss_doctor_id[]">
                                                    <option value="">Tidak Ada Dokter</option>
                                                    @foreach($doctor as $key => $d)
                                                        <option value="{{ $d->id }}" {{ ($check->doctor_id ?? '') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="align-middle">
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="text" class="form-control number-format" name="edss_nominal[]" value="{{ $check->nominal ?? $as->emergency_care }}" placeholder="0">
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="3">Tidak Ada Data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="stacked-left-pill4">
                        <table class="table table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>Nama</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($tool) > 0)
                                    @foreach($tool as $key => $t)
                                        @php $check = $emergencyDepartmentHealth->firstWhere('tool_id', $key + 1); @endphp
                                        <tr>
                                            <input type="hidden" name="emergency_department_health[]" value="{{ true }}">
                                            <td class="align-middle">
                                                <input type="hidden" name="edh_tool_id[]" value="{{ $key + 1 }}">
                                                {{ $t }}
                                            </td>
                                            <td class="align-middle">
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="text" class="form-control number-format" name="edh_nominal[]" value="{{ $check->nominal ?? '' }}" placeholder="0">
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="2">Tidak Ada Data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="stacked-left-pill5">
                        <table class="table table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>Nama</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($actionOther->count() > 0)
                                    @foreach($actionOther as $ao)
                                        @php $check = $emergencyDepartmentOther->firstWhere('action_other_id', $ao->id); @endphp
                                        <tr>
                                            <input type="hidden" name="emergency_department_other[]" value="{{ true }}">
                                            <td class="align-middle">
                                                <input type="hidden" name="edo_action_other_id[]" value="{{ $ao->id }}">
                                                {{ $ao->name }}
                                            </td>
                                            <td class="align-middle">
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="text" class="form-control number-format" name="edo_nominal[]" value="{{ $check->nominal ?? $ao->emergency_care }}" placeholder="0">
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="2">Tidak Ada Data</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="stacked-left-pill6">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>User</th>
                                    <th>Tindakan</th>
                                    <th>Nominal</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($emergencyDepartment->emergencyDepartmentNursing->count() > 0)
                                    @foreach($emergencyDepartment->emergencyDepartmentNursing as $key => $edn)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $edn->user->employee->name }}</td>
                                            <td>{{ $edn->action->name }}</td>
                                            <td>{{ Simrs::formatRupiah($edn->fee) }}</td>
                                            <td>{{ $edn->created_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada tindakan</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h6 class="hstack gap-2 mb-0">Paket</h6>
            </div>
            <div class="card-body">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="align-middle">
                                <div class="input-group">
                                    <span class="input-group-text">1</span>
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control number-format" name="emergency_department_package[]" value="{{ $emergencyDepartmentPackage[0]->nominal ?? '' }}" placeholder="0">
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="input-group">
                                    <span class="input-group-text">2</span>
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control number-format" name="emergency_department_package[]" value="{{ $emergencyDepartmentPackage[1]->nominal ?? '' }}" placeholder="0">
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="input-group">
                                    <span class="input-group-text">3</span>
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control number-format" name="emergency_department_package[]" value="{{ $emergencyDepartmentPackage[2]->nominal ?? '' }}" placeholder="0">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
        checkStatus();
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
            url: '{{ url("collection/emergency-department/action/" . $emergencyDepartment->id) }}',
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
                        window.location.replace('{{ url("collection/emergency-department/action/" . $emergencyDepartment->id) }}');
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
