<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Keuangan - Pengajuan - <span class="fw-normal">Detail Data</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('finance/submission') }}" class="btn btn-flat-primary">
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
<div class="content pt-0">
    <div class="alert alert-danger d-none" id="validation-element">
        <ul class="mb-0" id="validation-data"></ul>
    </div>
    <form id="form-data">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th width="15%">User</th>
                            <th width="1%" class="text-center">:</th>
                            <td>{{ $budget->user->employee->name }}</td>
                        </tr>
                        <tr>
                            <th width="15%">Tanggal Dibuat</th>
                            <th width="1%" class="text-center">:</th>
                            <td>{{ $budget->created_at->format('Y-m-d') }}</td>
                        </tr>
                        <tr>
                            <th width="15%">Tanggal Anggaran</th>
                            <th width="1%" class="text-center">:</th>
                            <td>{{ $budget->date }}</td>
                        </tr>
                        <tr>
                            <th width="15%">Status</th>
                            <th width="1%" class="text-center">:</th>
                            <td>{!! $budget->status() !!}</td>
                        </tr>
                        <tr>
                            <th width="15%">Keterangan</th>
                            <th width="1%" class="text-center">:</th>
                            <td>{{ $budget->description }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group"><hr></div>
                <ul class="nav nav-tabs nav-tabs-solid nav-justified mb-3">
                    <li class="nav-item">
                        <a href="#tabs-1" class="nav-link active" data-bs-toggle="tab">Form</a>
                    </li>
                    <li class="nav-item">
                        <a href="#tabs-2" class="nav-link" data-bs-toggle="tab">Histori</a>
                    </li>
                </ul>
                <div class="tab-content flex-lg-fill">
                    <div class="tab-pane fade show active" id="tabs-1">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>Bagan Akun</th>
                                    <th>Nominal</th>
                                    <th>Limit BLUD</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($chartOfAccount as $coa)
                                    <tr>
                                        <td>{{ $coa->fullname }}</td>
                                        <td>
                                            {{ Simrs::formatRupiah($budget->budgetDetail()->firstWhere('chart_of_account_id', $coa->id)->nominal ?? 0) }}
                                        </td>
                                        <td>
                                            {{ Simrs::formatRupiah($budget->budgetDetail()->firstWhere('chart_of_account_id', $coa->id)->limit_blud ?? 0) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="tabs-2">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($budget->budgetHistory->count() > 0)
                                    @foreach($budget->budgetHistory as $key => $bh)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $bh->user->employee->name }}</td>
                                            <td>{{ $bh->status }}</td>
                                            <td>{{ $bh->reason }}</td>
                                            <td>{{ $bh->created_at }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada histori</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($budget->status == 2)
                    <div class="form-group"><hr></div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="status" id="status-3" value="3" autocomplete="off" onchange="changeStatus()">
                                <label class="btn btn-outline-warning col-12" for="status-3">Revisi</label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="status" id="status-4" value="4" autocomplete="off" onchange="changeStatus()">
                                <label class="btn btn-outline-success col-12" for="status-4">Setujui</label>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" class="btn-check" name="status" id="status-5" value="5" autocomplete="off" onchange="changeStatus()">
                                <label class="btn btn-outline-danger col-12" for="status-5">Tolak</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group d-none" id="field-reason">
                        <textarea class="form-control" name="reason" id="reason" placeholder="Alasan ..." style="resize:none;"></textarea>
                    </div>
                @endif
            </div>
        </div>
        @if($budget->status != 1)
            <div class="card">
                <div class="card-body">
                    @if($budget->status == 2)
                        <div class="text-end">
                            <button type="button" class="btn btn-primary" onclick="submitted()">
                                <i class="ph-check-circle me-2"></i>
                                Submit
                            </button>
                        </div>
                    @else
                        @if($budget->status == 3)
                            <div class="alert alert-warning text-center mb-0">
                                Anggaran Direvisi
                                <div class="form-group"><hr></div>
                                <span class="fw-semibold">Alasan : {{ $budget->budgetHistory()->latest()->first()->reason ?? '-' }}</span>
                            </div>
                        @elseif($budget->status == 4)
                            <div class="alert alert-success text-center mb-0">Anggaran telah disetujui</div>
                        @elseif($budget->status == 5)
                            <div class="alert alert-danger text-center mb-0">
                                Anggaran ditolak
                                <div class="form-group"><hr></div>
                                <span class="fw-semibold">Alasan : {{ $budget->budgetHistory()->latest()->first()->reason ?? '-' }}</span>
                            </div>
                        @else
                            <div class="alert alert-warning text-center mb-0">Invalid</div>
                        @endif
                    @endif
                </div>
            </div>
        @endif
    </form>
</div>

<script>
    $(function() {
        sidebarMini();
        fullWidthAllDevice();
    });

    function changeStatus() {
        var status = $('input[name="status"]:checked').val();

        $('#reason').val('');

        if(status == 3 || status == 5) {
            $('#field-reason').removeClass('d-none');
        } else if(status == 4) {
            $('#field-reason').addClass('d-none');
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
            url: '{{ url("finance/submission/detail/" . $budget->id) }}',
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
                        window.location.replace('{{ url("finance/submission/detail/" . $budget->id) }}');
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
