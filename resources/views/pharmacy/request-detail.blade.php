<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Farmasi - Permintaan - <span class="fw-normal">Detail</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('pharmacy/request') }}" class="btn btn-flat-primary">Kembali ke Daftar</a>
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
                        <th class="align-middle">Status</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{!! $recipe->statusable(true) !!}</td>
                        <th class="align-middle">Ref</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $recipe->ref() }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <form id="form-data">
        <div class="card">
            <div class="card-header">
                <h6 class="hstack gap-2 mb-0">Permintaan Barang</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center" nowrap>No</th>
                            <th nowrap>Barang</th>
                            <th nowrap>Jumlah</th>
                            <th nowrap>Harga</th>
                            <th nowrap>Diskon</th>
                            <th nowrap>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recipeItem as $key => $rm)
                            <tr>
                                <input type="hidden" name="id[]" value="{{ $rm->id }}">
                                <td class="align-middle text-center">{{ $key + 1 }}</td>
                                <td class="align-middle" nowrap>{{ $rm->itemStock->item->name }}</td>
                                <td class="align-middle" nowrap>{{ $rm->qty }}</td>
                                <td class="align-middle" nowrap>
                                    @if($rm->discount > 0)
                                        @php
                                            $discount = $rm->discount;
                                            $priceSell = $rm->price_sell;
                                            $price = $priceSell - (($discount / 100) * $priceSell);
                                        @endphp
                                        {{ Simrs::formatRupiah($price) }}
                                        <small class="ms-1">
                                            <strike>{{ Simrs::formatRupiah($priceSell) }}</strike>
                                        </small>
                                    @else
                                        {{ Simrs::formatRupiah($rm->price_sell) }}
                                    @endif
                                </td>
                                <td class="align-middle" nowrap>{{ $rm->discount }} %</td>
                                <td class="align-middle" nowrap>
                                    @if(!empty($rm->status))
                                        <input type="hidden" name="status[]" value="{{ null }}">
                                        <input type="text" class="form-control" value="{{ $rm->status() }}" disabled>
                                    @else
                                        <select class="form-select" name="status[]">
                                            <option value="">-- Pilih --</option>
                                            <option value="1" {{ $rm->status == 1 ? 'selected' : '' }}>Stok Tidak Cukup</option>
                                            <option value="2" {{ $rm->status == 2 ? 'selected' : '' }}>Stok Kosong</option>
                                            <option value="3" {{ $rm->status == 3 ? 'selected' : '' }}>Tolak</option>
                                            <option value="4" {{ $rm->status == 4 ? 'selected' : '' }}>Setujui</option>
                                        </select>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if($recipe->statusable() == false)
            <div class="card">
                <div class="card-body">
                    <div class="text-end">
                        <button type="button" class="btn btn-primary" onclick="submitted()">
                            <i class="ph-check me-1"></i>
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </form>
</div>

<script>
    $(function() {
        fullWidthAllDevice();
        sidebarMini();
        checkStatus();
    });

    function checkStatus() {
        var status = '{{ $recipe->statusable() }}';

        if(status == 1) {
            $('input').attr('disabled', true);
            $('select').attr('disabled', true);
        }
    }

    function submitted(param) {
        $.ajax({
            url: '{{ url("pharmacy/request/detail/" . $recipe->id) }}',
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
                        window.location.replace('{{ url("pharmacy/request/detail/" . $recipe->id) }}');
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
