<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Tagihan - Rawat Jalan - <span class="fw-normal">Detail</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('bill/outpatient') }}" class="btn btn-flat-primary">Kembali ke Daftar</a>
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
            <h6 class="hstack gap-2 mb-0">Data Tagihan</h6>
        </div>
        <div class="card-body">
            <ul class="nav nav-pills nav-pills-outline nav-justified overflow-auto mb-3">
                <li class="nav-item">
                    <a href="#stacked-left-pill1" class="nav-link active" data-bs-toggle="tab">Dokter</a>
                </li>
                <li class="nav-item">
                    <a href="#stacked-left-pill2" class="nav-link" data-bs-toggle="tab">Perawat</a>
                </li>
            </ul>
            <div class="tab-content flex-1">
                <div class="tab-pane fade show active" id="stacked-left-pill1">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <th>Dokter</th>
                            <th>Tindakan</th>
                            <th>Nominal</th>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @if($outpatientAction->count() > 0)
                                @foreach($outpatientAction as $oa)
                                    @php
                                        $subtotal = $oa->consumables + $oa->hospital_service + $oa->service + $oa->fee;
                                        $total += $subtotal;
                                    @endphp
                                    <tr>
                                        <td class="align-middle">{{ $oa->doctor->name ?? '-' }}</td>
                                        <td class="align-middle">{{ $oa->unitAction->action->name ?? '-' }}</td>
                                        <td class="align-middle">{{ Simrs::formatRupiah($subtotal) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="text-center">
                                    <td colspan="3">Tidak ada tagihan</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="stacked-left-pill2">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center">No</th>
                                <th>User</th>
                                <th>Tindakan</th>
                                <th>Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($outpatient->outpatientNursing->count() > 0)
                                @foreach($outpatient->outpatientNursing as $key => $on)
                                    @php
                                        $subtotal = $on->consumables + $on->hospital_service + $on->service + $on->fee;
                                        $total += $subtotal;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td>{{ $on->user->employee->name }}</td>
                                        <td>{{ $on->unitAction->action->name }}</td>
                                        <td class="align-middle">{{ Simrs::formatRupiah($subtotal) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada tagihan</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @if($total > 0)
                <div class="form-group"><hr></div>
                <div class="text-center">
                    <h6 class="text-uppercase fw-bold">Total Yang Harus Dibayar</h6>
                    <h3 class="text-primary fw-bold mb-0">{{ Simrs::formatRupiah($total) }}</h3>
                </div>
                <div class="form-group"><hr></div>
                <span class="fst-italic">Terbilang : {{ Simrs::numerator($total) }}</span>
                <span class="float-end">{!! $outpatient->paid() !!}</span>
            @endif
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="text-end">
                @if($outpatient->paid == false)
                    <button type="button" class="btn btn-success" onclick="submitted()">
                        <i class="ph-check-circle me-2"></i>
                        Tandai Sudah Terbayar
                    </button>
                @else
                    <a href="{{ url('bill/outpatient/print/' . $outpatient->id) }}" target="_blank" class="btn btn-teal">
                        <i class="ph-printer me-1"></i>
                        Cetak Bukti Bayar
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        sidebarMini();
        fullWidthAllDevice();
    });

    function submitted() {
        $.ajax({
            url: '{{ url("bill/outpatient/detail/" . $outpatient->id) }}',
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
                        window.location.replace('{{ url("bill/outpatient/detail/" . $outpatient->id) }}');
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
