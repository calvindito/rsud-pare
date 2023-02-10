<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Pendataan - IGD - <span class="fw-normal">Radiologi</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('collection/emergency-department') }}" class="btn btn-flat-primary">Kembali ke Daftar</a>
            <a href="{{ url()->full() }}" class="btn btn-flat-primary">Refresh</a>
            @if($emergencyDepartment->status == 1)
                <button type="button" class="btn btn-flat-primary" data-bs-toggle="modal" data-bs-target="#modal-form" onclick="onReset()">
                    <i class="ph-plus-circle me-1"></i>
                    Permintaan
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
                        <td class="align-middle">{{ $emergencyDepartment->date_of_entry }}</td>
                        <th class="align-middle">UPF</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $functionalService->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Dokter</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $emergencyDepartment->doctor->name ?? '-' }}</td>
                        <th class="align-middle">Golongan</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $emergencyDepartment->type_format_result }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h6 class="hstack gap-2 mb-0">Data Permintaan</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover table-xs">
                <thead class="text-bg-light">
                    <tr>
                        <th class="text-center" nowrap>No</th>
                        <th class="text-center" nowrap>Hasil</th>
                        <th nowrap>User</th>
                        <th nowrap>Tindakan</th>
                        <th nowrap>Tanggal Permintaan</th>
                        <th class="text-center" nowrap>Status</th>
                        <th class="text-center" nowrap>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @if($radiologyRequest->count() > 0)
                        @foreach($radiologyRequest as $key => $rr)
                            <tr>
                                <td class="text-center align-middle">{{ $key + 1 }}</td>
                                <td class="text-center align-middle">
                                    <a href="{{ $rr->image() }}" data-bs-popup="lightbox">
                                        <img src="{{ $rr->image() }}" class="img-preview rounded">
                                    </a>
                                </td>
                                <td class="align-middle">{{ $rr->user ? $rr->user->employee->name : 'Belum Ada' }}</td>
                                <td class="align-middle">{{ $rr->radiology->type . ' - ' . $rr->radiology->object . ' - ' . $rr->radiology->projection }}</td>
                                <td class="align-middle">{{ $rr->date_of_request }}</td>
                                <td class="text-center align-middle">{!! $rr->status() !!}</td>
                                <td class="align-middle">
                                    <div class="text-center">
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-detail-{{ $key }}">
                                            <i class="ph-eye me-1"></i>
                                            Lihat
                                        </button>
                                    </div>
                                    <div id="modal-detail-{{ $key }}" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                                        <div class="modal-dialog modal-fullscreen modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Hasil Radiologi</h5>
                                                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                                                        <i class="ph-x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    @if($rr->status == 1)
                                                        <div class="alert alert-secondary">
                                                            Mohon bersabar, permintaan anda akan segera diproses
                                                        </div>
                                                    @elseif($rr->status == 2)
                                                        <div class="alert alert-primary">
                                                            Permintaan anda saat ini sedang diproses
                                                            <span class="float-end fst-italic"><b>diproses oleh : {{ $rr->user->employee->name }}</b></span>
                                                        </div>
                                                    @elseif($rr->status == 4)
                                                        <div class="alert alert-danger">
                                                            Mohon maaf sekali, permintaan anda saat ini ditolak
                                                            <span class="float-end fst-italic"><b>ditolak oleh : {{ $rr->user->employee->name }}</b></span>
                                                        </div>
                                                    @else
                                                        <table class="table">
                                                            <tr class="bg-light">
                                                                <th colspan="3">Data</th>
                                                            </tr>
                                                            <tr>
                                                                <td>Pemeriksa</td>
                                                                <td width="1%">:</td>
                                                                <td>{{ $rr->user->employee->name ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Tindakan</td>
                                                                <td width="1%">:</td>
                                                                <td>{{ $rr->radiology->type . ' - ' . $rr->radiology->object . ' - ' . $rr->radiology->projection }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Foto</td>
                                                                <td width="1%">:</td>
                                                                <td><a href="{{ $rr->image() }}" data-bs-popup="lightbox">Lihat Hasil Foto</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Tanggal Permintaan</td>
                                                                <td width="1%">:</td>
                                                                <td>{{ $rr->date_of_request }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Klinis</td>
                                                                <td width="1%">:</td>
                                                                <td>{{ $rr->clinical }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Kritis</td>
                                                                <td width="1%">:</td>
                                                                <td>{{ $rr->critical ? 'Ya' : 'Tidak' }}</td>
                                                            </tr>
                                                            <tr class="bg-light">
                                                                <th colspan="3">Expertise</th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    {!! $rr->expertise !!}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    @endif
                                                </div>
                                                @if($rr->status == 3)
                                                    <div class="modal-footer justify-content-end">
                                                        <a href="{{ url('collection/emergency-department/radiology/print/' . $rr->id) }}" target="_blank" class="btn btn-teal">
                                                            <i class="ph-printer me-1"></i>
                                                            Cetak Hasil
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="7">Belum ada permintaan</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($emergencyDepartment->status == 1)
    <div id="modal-form" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Permintaan</h5>
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                        <i class="ph-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="validation-element">
                        <ul class="mb-0" id="validation-data"></ul>
                    </div>
                    <form id="form-data">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3">Tanggal Permintaan <span class="text-danger fw-bold">*</span></label>
                            <div class="col-md-9">
                                <input type="datetime-local" class="form-control" name="date_of_request" id="date_of_request">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3">Tindakan <span class="text-danger fw-bold">*</span></label>
                            <div class="col-md-9">
                                <select class="form-select select2-basic" name="radiology_id" id="radiology_id">
                                    <option value="">-- Pilih --</option>
                                    @foreach($radiology as $r)
                                        <option value="{{ $r->id }}">
                                            {{ $r->type . ' - ' . $r->object . ' - ' . $r->projection }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-end">
                    <button class="btn btn-primary" onclick="createData()">
                        <i class="ph-plus-circle me-1"></i>
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
    $(function() {
        fullWidthAllDevice();
    });

    function onReset() {
        clearValidation();
        $('#form-data').trigger('reset');
        $('#date_of_request').val('{{ date("Y-m-d H:i") }}');
        $('#radiology_id').val('').change();
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

    function createData() {
        $.ajax({
            url: '{{ url("collection/emergency-department/radiology/" . $emergencyDepartment->id) }}',
            type: 'POST',
            dataType: 'JSON',
            data: $('#form-data').serialize(),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            beforeSend: function() {
                onLoading('show', '.modal-content');
                clearValidation();
            },
            success: function(response) {
                onLoading('close', '.modal-content');

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
                        window.location.replace('{{ url("collection/emergency-department/radiology/" . $emergencyDepartment->id) }}');
                    });
                } else if(response.code == 400) {
                    $('#modal-form .modal-body').scrollTop(0);
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
                onLoading('close', '.modal-content');

                swalInit.fire({
                    html: '<b>' + response.responseJSON.exception + '</b><br>' + response.responseJSON.message,
                    icon: 'error',
                    showCloseButton: true
                });
            }
        });
    }
</script>
