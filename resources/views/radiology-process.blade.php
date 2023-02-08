<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Radiologi - <span class="fw-normal">Proses</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('radiology') }}" class="btn btn-flat-primary">Kembali ke Daftar</a>
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
                <h6 class="hstack gap-2 mb-0">Permintaan Cek</h6>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Klinis <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="clinical" id="clinical" value="{{ $radiologyRequest->clinical }}" placeholder="Masukan klinis" {{ $radiologyRequest->status == 3 ? 'disabled' : '' }}>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Kritis</label>
                    <div class="col-md-10">
                        <select class="form-select" name="critical" id="critical" {{ $radiologyRequest->status == 3 ? 'disabled' : '' }}>
                            <option value="1" {{ $radiologyRequest->critical == 1 ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ $radiologyRequest->critical == 2 ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="bg-light fw-bold p-3 text-center fs-6">Foto</div>
                </div>
                <div class="form-group">
                    @if($radiologyRequest->status == 3)
                        <div class="text-center">
                            <a href="{{ $radiologyRequest->image() }}" data-bs-popup="lightbox">
                                <img src="{{ $radiologyRequest->image() }}" class="img-fluid" style="max-width:150px;">
                            </a>
                        </div>
                    @else
                        <input type="file" class="file-input" name="image" id="image">
                    @endif
                </div>
                <div class="form-group">
                    <div class="bg-light fw-bold p-3 text-center fs-6">Expertise</div>
                </div>
                <div class="form-group">
                    @if($radiologyRequest->status == 3)
                        {!! $radiologyRequest->expertise !!}
                    @else
                        <textarea class="form-control w-100" name="expertise" id="expertise">{!! $radiologyRequest->expertise !!}</textarea>
                    @endif
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="text-end">
                    @if(in_array($radiologyRequest->status, [1, 2]))
                        <button type="button" class="btn btn-danger" onclick="createData('reject')">
                            <i class="ph-prohibit me-1"></i>
                            Tolak
                        </button>
                        <button type="button" class="btn btn-warning" onclick="createData('keep')">
                            <i class="ph-floppy-disk me-1"></i>
                            Simpan
                        </button>
                        <button type="button" class="btn btn-primary" onclick="createData('done')">
                            <i class="ph-check-circle me-1"></i>
                            Selesaikan
                        </button>
                    @else
                        @if($radiologyRequest->status == 4)
                            <div class="alert alert-danger text-center mb-0">
                                Mohon maaf data yang telah ditolak tidak dapat melakukan aksi apapun
                            </div>
                        @else
                            <a href="{{ url('radiology/print/' . $radiologyRequest->id . '?slug=result') }}" target="_blank" class="btn btn-teal">
                                <i class="ph-printer me-1"></i>
                                Cetak Hasil
                            </a>
                            <a href="{{ url('radiology/print/' . $radiologyRequest->id . '?slug=introduction') }}" target="_blank" class="btn btn-teal">
                                <i class="ph-money me-1"></i>
                                Cetak Surat Pembayaran
                            </a>
                        @endif
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
        imageable();
        textEditor('#expertise', 'Masukan expertise ...');
    });

    function imageable() {
        var hasImage = '{{ $radiologyRequest->image }}';
        var imageUrl = '{{ $radiologyRequest->image() }}';

        if(hasImage) {
            var previewImage = [imageUrl];
            var previewConfig = [
                {
                    caption: '',
                    size: '',
                    key: 1,
                    url: imageUrl
                }
            ]
        } else {
            var previewImage = '';
            var previewConfig = '';
        }

        dragAndDropFile({
            allowFile: ['jpg', 'jpeg', 'png'],
            maxFile: 1,
            preview: previewImage,
            previewConfig: previewConfig
        });
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

    function createData(param) {
        $.ajax({
            url: '{{ url("radiology/process/" . $radiologyRequest->id . "?submit=") }}' + param,
            type: 'POST',
            dataType: 'JSON',
            data: new FormData($('#form-data')[0]),
            contentType: false,
            processData: false,
            cache: false,
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
                        window.location.replace('{{ url("radiology") }}');
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
