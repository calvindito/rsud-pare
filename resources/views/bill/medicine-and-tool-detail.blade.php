<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Tagihan - Obat & Alkes - <span class="fw-normal">Detail</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('bill/medicine-and-tool') }}" class="btn btn-flat-primary">Kembali ke Daftar</a>
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
                        <th class="align-middle">No RM</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $patient->no_medical_record }}</td>
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
                        <th class="align-middle">Status</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{!! $dispensaryRequest->statusable(true) !!}</td>
                        <th class="align-middle">Ref</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $dispensaryRequest->ref() }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <form id="form-data">
        <div class="card">
            <div class="card-header">
                <h6 class="hstack gap-2 mb-0">Data Tagihan</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-secondary text-center fs-5 fw-bold">{{ $dispensaryRequest->dispensary->name ?? '-' }}</div>
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center" nowrap>No</th>
                            <th nowrap>Item</th>
                            <th nowrap>Jumlah</th>
                            <th nowrap>Satuan</th>
                            <th nowrap>Harga</th>
                            <th nowrap>Diskon</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dispensaryRequestItem as $key => $dri)
                            <tr>
                                <td class="align-middle text-center">{{ $key + 1 }}</td>
                                <td class="align-middle" nowrap>{{ $dri->dispensaryItemStock->dispensaryItem->item->name }}</td>
                                <td class="align-middle" nowrap>{{ $dri->qty }}</td>
                                <td class="align-middle" nowrap>{{ $dri->dispensaryItemStock->dispensaryItem->item->itemUnit->name ?? '-' }}</td>
                                <td class="align-middle" nowrap>
                                    @if($dri->discount > 0)
                                        @php
                                            $discount = $dri->discount;
                                            $priceSell = $dri->price_sell;
                                            $price = $priceSell - (($discount / 100) * $priceSell);
                                        @endphp
                                        {{ Simrs::formatRupiah($price) }}
                                        <small class="ms-1">
                                            <strike>{{ Simrs::formatRupiah($priceSell) }}</strike>
                                        </small>
                                    @else
                                        {{ Simrs::formatRupiah($dri->price_sell) }}
                                    @endif
                                </td>
                                <td class="align-middle" nowrap>{{ $dri->discount }} %</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="form-group"><hr></div>
                <div class="text-center">
                    <h6 class="text-uppercase fw-bold">Jumlah Yang Harus Dibayar</h6>
                    <h3 class="text-primary fw-bold mb-0">{{ Simrs::formatRupiah($dispensaryRequest->total()) }}</h3>
                </div>
                <div class="form-group"><hr></div>
                <span class="fst-italic">Terbilang : {{ Simrs::numerator($dispensaryRequest->total()) }}</span>
                <span class="float-end">{!! $dispensaryRequest->paid() !!}</span>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="text-end">
                    @if($dispensaryRequest->paid == false)
                        <button type="button" class="btn btn-success" onclick="submitted()">
                            <i class="ph-check-circle me-2"></i>
                            Tandai Sudah Terbayar
                        </button>
                    @else
                        <a href="{{ url('bill/medicine-and-tool/print/' . $dispensaryRequest->id) }}" target="_blank" class="btn btn-teal">
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
        fullWidthAllDevice();
        sidebarMini();
    });

    function submitted(param) {
        $.ajax({
            url: '{{ url("bill/medicine-and-tool/detail/" . $dispensaryRequest->id) }}',
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
                        window.location.replace('{{ url("bill/medicine-and-tool/detail/" . $dispensaryRequest->id) }}');
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
