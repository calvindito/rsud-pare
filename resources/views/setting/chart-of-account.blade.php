<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Pengaturan - <span class="fw-normal">Bagan Akun</span>
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
    <div class="card">
        <div class="card-body">
            <form id="form-data">
                <fieldset>
                    <legend class="fs-base fw-bold border-bottom pb-2 mb-3">Tagihan</legend>
                    <div class="form-group">
                        <input type="hidden" name="slug[]" value="coa-bill">
                        <select class="form-select select2-form" name="settingable_id[]">
                            <option value="">-- Pilih --</option>
                            @php $coaBillId = App\Models\Setting::firstWhere('slug', 'coa-bill')->settingable_id ?? null; @endphp
                            @foreach($chartOfAccount as $coa)
                                <option value="{{ $coa->id }}" {{ $coaBillId == $coa->id ? 'selected' : '' }}>{{ $coa->fullname }}</option>
                            @endforeach
                        </select>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="card-footer">
            <div class="text-end">
                <button type="button" class="btn btn-warning" onclick="update()">
                    <i class="ph-floppy-disk me-1"></i>
                    Simpan Pengaturan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('.select2-form').select2();
    });

    function update() {
        $.ajax({
            url: '{{ url("setting/chart-of-account/update") }}',
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
                    notification('success', response.message);
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
