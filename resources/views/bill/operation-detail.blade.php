<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Tagihan - Operasi - <span class="fw-normal">Detail</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('bill/operation') }}" class="btn btn-flat-primary">Kembali ke Daftar</a>
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
                        <select class="form-select" disabled>
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
                        <input type="text" class="form-control number-format" value="{{ $operation->hospital_service ?? 0 }}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Biaya Dokter Operasi</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control number-format" value="{{ $operation->doctor_operating_room ?? 0 }}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Biaya Dokter Anestesi</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control number-format" value="{{ $operation->doctor_anesthetist ?? 0 }}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Biaya Perawat Operasi</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control number-format" value="{{ $operation->nurse_operating_room ?? 0 }}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Biaya Perawat Anestesi</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control number-format" value="{{ $operation->nurse_anesthetist ?? 0 }}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Biaya RR Monitoring</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control number-format" value="{{ $operation->monitoring ?? 0 }}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Biaya RR Askep</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control number-format" value="{{ $operation->nursing_care ?? 0 }}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Tanggal Selesai</label>
                    <div class="col-md-10">
                        <input type="datetime-local" class="form-control rounded-bottom-0" value="{{ $operation->date_of_out ?? 0 }}" disabled>
                    </div>
                </div>
                <div class="form-group text-center">
                    {!! $operation->status() !!}
                </div>
                <div class="form-group"><hr></div>
                <div class="text-center">
                    <h6 class="text-uppercase fw-bold">Total Yang Harus Dibayar</h6>
                    <h3 class="text-primary fw-bold mb-0">{{ Simrs::formatRupiah($operation->total(false)) }}</h3>
                </div>
                <div class="form-group"><hr></div>
                <span class="fst-italic">Terbilang : {{ Simrs::numerator($operation->total(false)) }}</span>
                <span class="float-end">{!! $operation->paid() !!}</span>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="text-end">
                    @if($operation->paid == false)
                        <button type="button" class="btn btn-success" onclick="submitted()">
                            <i class="ph-check-circle me-2"></i>
                            Tandai Sudah Terbayar
                        </button>
                    @else
                        <a href="{{ url('bill/operation/print/' . $operation->id) }}" target="_blank" class="btn btn-teal">
                            <i class="ph-printer me-1"></i>
                            Cetak Bukti Bayar
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(function() {
        sidebarMini();
        fullWidthAllDevice();
    });

    function submitted() {
        $.ajax({
            url: '{{ url("bill/operation/detail/" . $operation->id) }}',
            type: 'POST',
            dataType: 'JSON',
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
                        window.location.replace('{{ url("bill/operation/detail/" . $operation->id) }}');
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
