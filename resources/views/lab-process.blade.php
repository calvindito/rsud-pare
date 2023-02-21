<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Laboratorium - <span class="fw-normal">Proses</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('lab') }}" class="btn btn-flat-primary">Kembali ke Daftar</a>
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
                        <td class="align-middle">{{ $labRequest->date_of_request }}</td>
                        <th class="align-middle">Ref</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $labRequest->ref() }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Dokter</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $labRequest->doctor->name ?? '-' }}</td>
                        <th class="align-middle">Status</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{!! $labRequest->status() !!}</td>
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
                <table class="table table-xs">
                    <thead class="bg-light">
                        <tr>
                            <th nowrap>Grup</th>
                            <th nowrap>Item</th>
                            <th nowrap>Hasil</th>
                            <th nowrap>Normal</th>
                            <th nowrap>Satuan</th>
                            <th nowrap>Kondisi</th>
                            <th nowrap>Metode</th>
                            @if($labRequest->status == 3)
                                <th class="text-center" nowrap>Status</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if($labRequestDetail->count() > 0)
                            @foreach($labRequestDetail as $lrd)
                                <tr>
                                    <input type="hidden" name="lab_request_detail_id[]" value="{{ $lrd->id }}">
                                    <td class="align-middle">{{ $lrd->labItem->labItemGroup->name }}</td>
                                    <td class="align-middle">{{ $lrd->labItem->name }}</td>
                                    <td class="align-middle" nowrap>
                                        @if(in_array($labRequest->status, [1, 2]))
                                            <input type="text" class="form-control form-control-sm" name="lrd_result[]" value="{{ $lrd->result }}" placeholder="Masukan hasil">
                                        @else
                                            {{ $lrd->result }}
                                        @endif
                                    </td>
                                    <td class="align-middle" nowrap>
                                        @isset($lrd->labItemParent)
                                            @if($lrd->labItemParent->limit_lower && $lrd->labItemParent->limit_upper)
                                                {{ $lrd->labItemParent->limit_lower . ' - ' . $lrd->labItemParent->limit_upper }}
                                            @elseif($lrd->labItemParent->limit_upper)
                                                {{ $lrd->labItemParent->limit_upper }}
                                            @elseif($lrd->labItemParent->limit_lower)
                                                {{ $lrd->labItemParent->limit_lower }}
                                            @else
                                                -
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="align-middle" nowrap>{{ $lrd->labItemParent->unit ?? '-' }}</td>
                                    <td class="align-middle" nowrap>
                                        @if(in_array($labRequest->status, [1, 2]))
                                            <select class="form-select form-select-sm" name="lrd_lab_item_condition_id[]">
                                                <option value="">Tidak Ada</option>
                                                @foreach($labItemCondition as $lic)
                                                    <option value="{{ $lic->id }}" {{ $lrd->lab_item_condition_id == $lic->id ? 'selected' : '' }}>{{ $lic->name }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                        {{ $lrd->labItemCondition->name ?? 'Tidak Ada' }}
                                        @endif
                                    </td>
                                    <td class="align-middle" nowrap>{{ $lrd->labItemParent->method ?? '-' }}</td>
                                    @if($labRequest->status == 3)
                                        <td class="align-middle text-center">
                                            @isset($lrd->labItemParent)
                                                @if(!empty($lrd->result))
                                                    @if(!empty($lrd->labItemParent->limit_lower) && !empty($lrd->result <= $lrd->labItemParent->limit_upper))
                                                        @if($lrd->result >= $lrd->labItemParent->limit_lower && $lrd->result <= $lrd->labItemParent->limit_upper)
                                                            <span class="badge bg-primary d-block">Normal</span>
                                                        @else
                                                            <span class="badge bg-danger d-block">Danger</span>
                                                        @endif
                                                    @elseif((!empty($lrd->labItemParent->limit_lower) && empty($lrd->labItemParent->limit_upper)))
                                                        @if($lrd->result >= $lrd->labItemParent->limit_lower && $lrd->result <= $lrd->labItemParent->limit_lower)
                                                            <span class="badge bg-primary d-block">Normal</span>
                                                        @else
                                                            <span class="badge bg-danger d-block">Danger</span>
                                                        @endif
                                                    @elseif((!empty($lrd->labItemParent->limit_upper) && empty($lrd->labItemParent->limit_lower)))
                                                        @if($lrd->result >= $lrd->labItemParent->limit_upper && $lrd->result <= $lrd->labItemParent->limit_upper)
                                                            <span class="badge bg-primary d-block">Normal</span>
                                                        @else
                                                            <span class="badge bg-danger d-block">Danger</span>
                                                        @endif
                                                    @else
                                                        <span class="badge bg-secondary d-block">Tidak ada pembatas</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary d-block">Tidak ada pembatas</span>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary d-block">Tidak ada pembatas</span>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="7">Tidak ada data</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="text-end">
                    @if(in_array($labRequest->status, [1, 2]))
                        <button type="button" class="btn btn-danger" onclick="submitted('reject')">
                            <i class="ph-prohibit me-1"></i>
                            Tolak
                        </button>
                        <button type="button" class="btn btn-warning" onclick="submitted('keep')">
                            <i class="ph-floppy-disk me-1"></i>
                            Simpan
                        </button>
                        <button type="button" class="btn btn-primary" onclick="submitted('done')">
                            <i class="ph-check-circle me-1"></i>
                            Selesaikan
                        </button>
                    @else
                        @if($labRequest->status == 4)
                            <div class="alert alert-danger text-center mb-0">
                                Mohon maaf data yang telah ditolak tidak dapat melakukan aksi apapun
                            </div>
                        @else
                            <a href="{{ url('lab/print/' . $labRequest->id . '?slug=result') }}" target="_blank" class="btn btn-teal">
                                <i class="ph-printer me-1"></i>
                                Cetak Hasil
                            </a>
                            <a href="{{ url('lab/print/' . $labRequest->id . '?slug=detail') }}" target="_blank" class="btn btn-teal">
                                <i class="ph-money me-1"></i>
                                Cetak Rincian Biaya
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
    });

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

    function submitted(param) {
        $.ajax({
            url: '{{ url("lab/process/" . $labRequest->id . "?submit=") }}' + param,
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
                        window.location.replace('{{ url("lab") }}');
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
