<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Gizi - <span class="fw-normal">Waktu Makan</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-flat-primary dropdown-toggle" data-bs-toggle="dropdown">Refresh</button>
                <div class="dropdown-menu">
                    <a href="javascript:void(0);" class="dropdown-item" onclick="onReloadTable()">Data</a>
                    <a href="{{ url()->full() }}" class="dropdown-item">Halaman</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content pt-0">
    <form id="form-data">
        <div class="card">
            <div class="card-header">
                <h6 class="hstack gap-2 mb-0">Pagi</h6>
            </div>
            <div class="card-body">
                <input type="hidden" name="type[]" value="1">
                <div class="input-group">
                    <div class="input-group">
                        <input type="time" class="form-control" name="time_start[]" value="{{ App\Models\EatingTime::firstWhere('type', 1)->time_start ?? null }}">
                        <span class="input-group-text">s/d</span>
                        <input type="time" class="form-control" name="time_end[]" value="{{ App\Models\EatingTime::firstWhere('type', 1)->time_end ?? null }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h6 class="hstack gap-2 mb-0">Siang</h6>
            </div>
            <div class="card-body">
                <input type="hidden" name="type[]" value="2">
                <div class="input-group">
                    <div class="input-group">
                        <input type="time" class="form-control" name="time_start[]" value="{{ App\Models\EatingTime::firstWhere('type', 2)->time_start ?? null }}">
                        <span class="input-group-text">s/d</span>
                        <input type="time" class="form-control" name="time_end[]" value="{{ App\Models\EatingTime::firstWhere('type', 2)->time_end ?? null }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h6 class="hstack gap-2 mb-0">Sore</h6>
            </div>
            <div class="card-body">
                <input type="hidden" name="type[]" value="3">
                <div class="input-group">
                    <div class="input-group">
                        <input type="time" class="form-control" name="time_start[]" value="{{ App\Models\EatingTime::firstWhere('type', 3)->time_start ?? null }}">
                        <span class="input-group-text">s/d</span>
                        <input type="time" class="form-control" name="time_end[]" value="{{ App\Models\EatingTime::firstWhere('type', 3)->time_end ?? null }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h6 class="hstack gap-2 mb-0">Malam</h6>
            </div>
            <div class="card-body">
                <input type="hidden" name="type[]" value="4">
                <div class="input-group">
                    <div class="input-group">
                        <input type="time" class="form-control" name="time_start[]" value="{{ App\Models\EatingTime::firstWhere('type', 4)->time_start ?? null }}">
                        <span class="input-group-text">s/d</span>
                        <input type="time" class="form-control" name="time_end[]" value="{{ App\Models\EatingTime::firstWhere('type', 4)->time_end ?? null }}">
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="card">
        <div class="card-body">
            <div class="text-end">
                <button type="button" class="btn btn-warning" onclick="set()">
                    <i class="ph-floppy-disk me-1"></i>
                    Simpan Pengaturan Waktu
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('.select2-form').select2();
    });

    function set() {
        $.ajax({
            url: '{{ url("nutrient/eating-time/set") }}',
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
                        window.location.replace('{{ url("nutrient/eating-time") }}');
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
