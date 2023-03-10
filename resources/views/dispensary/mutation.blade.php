<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Apotek - <span class="fw-normal">Mutasi</span>
            </h5>
        </div>
    </div>
</div>
<div class="content pt-0">
    <div class="alert alert-danger d-none" id="validation-element">
        <ul class="mb-0" id="validation-data"></ul>
    </div>
    <form id="form-search">
        <div class="card">
            <div class="card-header">
                <h6 class="hstack gap-2 mb-0">Pencarian</h6>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-form-label col-lg-1">Apotek <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-11">
                        <select class="form-select" name="dispensary_id" id="dispensary_id">
                            <option value="">-- Pilih --</option>
                            @foreach($dispensary as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-1">Item <span class="text-danger fw-bold">*</span></label>
                    <div class="col-md-11">
                        <select class="form-select" name="item_id" id="item_id"></select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-lg-1">Tanggal</label>
                    <div class="col-md-11">
                        <div class="input-group">
                            <select class="form-select w-auto flex-grow-0" name="column_date" id="column_date">
                                <option value="created_at" selected>Tanggal Masuk</option>
                                <option value="expired_date">Tanggal Kadaluwarsa</option>
                            </select>
                            <input type="text" class="form-control daterange-picker" name="date" id="date" placeholder="Pilih Tanggal" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-end">
                    <button type="button" class="btn btn-primary" onclick="loadData()">
                        <i class="ph-magnifying-glass me-1"></i>
                        Tampilkan
                    </button>
                </div>
            </div>
        </div>
    </form>
    <div class="card d-none" id="data-mutation">
        <div class="card-header d-flex align-items-center py-0">
            <h6 class="py-3 mb-0">Data Mutasi</h6>
            <div class="ms-auto my-auto">
                <a href="javascript:void(0);" class="btn btn-teal" onclick="printData()">
                    <i class="ph-printer me-1"></i>
                    Cetak Mutasi
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover table-xs">
                <thead class="bg-light">
                    <tr class="text-center">
                        <th class="align-middle" rowspan="2">Tanggal</th>
                        <th class="align-middle" colspan="2">Stok</th>
                        <th class="align-middle" rowspan="2">Sisa</th>
                    </tr>
                    <tr class="text-center">
                        <th class="align-middle">Masuk</th>
                        <th class="align-middle">Keluar</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(function() {
        select2Ajax('#item_id', 'item', false);
        datePickerableBasic('.daterange-picker');
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

    function loadData() {
        $.ajax({
            url: '{{ url("dispensary/mutation/load-data") }}',
            type: 'GET',
            dataType: 'JSON',
            data: $('#form-search').serialize(),
            beforeSend: function() {
                onLoading('show', '.content');
                clearValidation();

                $('#data-mutation table tbody').html('');
                $('#data-mutation').addClass('d-none');
            },
            success: function(response) {
                onLoading('close', '.content');

                if(response.code == 200) {
                    $('#data-mutation').removeClass('d-none');

                    $.each(response.data, function(i, val) {
                        $('#data-mutation table tbody').append(`
                            <tr class="text-center">
                                <td class="align-middle">` + val.date + `</td>
                                <td class="align-middle">` + val.stock_in + `</td>
                                <td class="align-middle">` + val.stock_out + `</td>
                                <td class="align-middle">` + val.remaining + `</td>
                            </tr>
                        `);
                    });
                } else {
                    $('.btn-to-top button').click();
                    showValidation(response.error);
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

    function printData() {
        var dispensaryid = $('#dispensary_id').val();
        var itemId = $('#item_id').val();
        var date = $('#date').val();
        var columnDate = $('#column_date').val();

        if(dispensaryid != '' && itemId != '' && date != '' && columnDate != '') {
            var parseUrl = '{{ url("dispensary/mutation/print?") }}' + $.param({
                _token: '{{ csrf_token() }}',
                dispensary_id: dispensaryid,
                item_id: itemId,
                date: date,
                column_date: columnDate
            });

            window.open(parseUrl, '_blank');
        }
    }
</script>
