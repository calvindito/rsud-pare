<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Tagihan - Radiologi - <span class="fw-normal">Detail</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('bill/radiology') }}" class="btn btn-flat-primary">Kembali ke Daftar</a>
            <a href="{{ url()->full() }}" class="btn btn-flat-primary">Refresh</a>
        </div>
    </div>
</div>
<div class="content pt-0">
    <div class="alert alert-danger d-none" id="validation-element">
        <ul class="mb-0" id="validation-data"></ul>
    </div>
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
                        <th class="align-middle">Tanggal Permintaan</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $radiologyRequest->date_of_request }}</td>
                        <th class="align-middle">Ref</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $radiologyRequest->ref() }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Dokter</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $radiologyRequest->doctor->name ?? '-' }}</td>
                        <th class="align-middle">Status</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{!! $radiologyRequest->status() !!}</td>
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
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Klinis <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="clinical" id="clinical" value="{{ $radiologyRequest->clinical }}" disabled>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Kritis</label>
                    <div class="col-md-10">
                        <select class="form-select" name="critical" id="critical" disabled>
                            <option value="1" {{ $radiologyRequest->critical == 1 ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ $radiologyRequest->critical == 2 ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="bg-light fw-bold p-3 text-center fs-6">Foto</div>
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <a href="{{ $radiologyRequest->image() }}" data-bs-popup="glightbox">
                            <img src="{{ $radiologyRequest->image() }}" class="img-fluid" style="max-width:150px;">
                        </a>
                    </div>
                </div>
                <div class="form-group">
                    <div class="bg-light fw-bold p-3 text-center fs-6">Expertise</div>
                </div>
                <div class="form-group">
                    {!! !empty($radiologyRequest->expertise) ? $radiologyRequest->expertise : '<div class="text-center">Belum ada expertise</div>' !!}
                </div>
                <div class="form-group"><hr></div>
                <div class="text-center">
                    <h6 class="text-uppercase fw-bold">Total Yang Harus Dibayar</h6>
                    <h3 class="text-primary fw-bold mb-0">{{ Simrs::formatRupiah($radiologyRequest->total()) }}</h3>
                </div>
                <div class="form-group"><hr></div>
                <span class="fst-italic">Terbilang : {{ Simrs::numerator($radiologyRequest->total()) }}</span>
                <span class="float-end">{!! $radiologyRequest->paid() !!}</span>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="text-end">
                    @if($radiologyRequest->paid == false)
                        <button type="button" class="btn btn-success" onclick="submitted()">
                            <i class="ph-check-circle me-2"></i>
                            Tandai Sudah Terbayar
                        </button>
                    @else
                        <a href="{{ url('bill/radiology/print/' . $radiologyRequest->id) }}" target="_blank" class="btn btn-teal">
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
    function submitted() {
        $.ajax({
            url: '{{ url("bill/radiology/detail/" . $radiologyRequest->id) }}',
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
                        window.location.replace('{{ url("bill/radiology/detail/" . $radiologyRequest->id) }}');
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
