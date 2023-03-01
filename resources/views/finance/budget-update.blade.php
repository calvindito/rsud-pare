<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Keuangan - Anggaran - <span class="fw-normal">Ubah Data</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('finance/budget') }}" class="btn btn-flat-primary">
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
                <div class="form-group row">
                    <label class="col-form-label col-lg-1">Tanggal <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-11">
                        <input type="date" class="form-control" name="date" id="date" value="{{ $budget->date }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-1">Status <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-11">
                        <select class="form-select" name="status" id="status">
                            <option value="">-- Pilih --</option>
                            <option value="1" {{ $budget->status == 1 || $budget->status == 3 ? 'selected' : '' }}>Draft</option>
                            <option value="2" {{ $budget->status == 2 ? 'selected' : '' }}>Ajukan Sekarang</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-1">Keterangan <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-11">
                        <textarea class="form-control" name="description" id="description" style="resize:none;" placeholder="Masukan keterangan">{{ $budget->description }}</textarea>
                    </div>
                </div>
                @if($budget->status == 3)
                    <div class="alert alert-warning">
                        Anggaran anda sementara belum bisa disetujui dan ada beberapa hal yang harus anda perbaiki, mohon untuk merevisi data anggaran anda
                    </div>
                @endif
                <div class="form-group"><hr></div>
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
                                <input type="hidden" name="bd_chart_of_account_id[]" value="{{ $coa->id }}">
                                <td>{{ $coa->fullname }}</td>
                                <td>
                                    <input type="text" class="form-control number-format" name="bd_nominal[]" value="{{ $budget->budgetDetail()->firstWhere('chart_of_account_id', $coa->id)->nominal ?? '' }}" placeholder="0">
                                </td>
                                <td>
                                    <input type="text" class="form-control number-format" name="bd_limit_blud[]"value="{{ $budget->budgetDetail()->firstWhere('chart_of_account_id', $coa->id)->limit_blud ?? '' }}" placeholder="0">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
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
    </form>
</div>

<script>
    $(function() {
        sidebarMini();
        fullWidthAllDevice();
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

    function submitted() {
        $.ajax({
            url: '{{ url("finance/budget/update/" . $budget->id) }}',
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
                        window.location.replace('{{ url("finance/budget/update/" . $budget->id) }}');
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
