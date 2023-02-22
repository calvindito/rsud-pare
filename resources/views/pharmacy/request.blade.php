<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Farmasi - <span class="fw-normal">Permintaan</span>
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
                <div class="table-fix-header">
                    <table class="table table-bordered">
                        <thead class="bg-light">
                            <tr>
                                <th>Status</th>
                                <th>Item</th>
                                <th>Apotek</th>
                                <th>Jumlah Permintaan</th>
                                <th>Ketersediaan Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($dispensaryItemStock->count() > 0)
                                @foreach($dispensaryItemStock as $dis)
                                    <tr>
                                        <input type="hidden" name="id[]" value="{{ $dis->id }}">
                                        <td class="align-middle text-center" width="5%">
                                            <input type="checkbox" class="form-checkbox" name="status_{{ $dis->id }}" data-toggle="switcher" data-onlabel="Setujui" data-offlabel="Tolak" data-size="sm" data-onstyle="success" data-offstyle="danger" checked>
                                        </td>
                                        <td class="align-middle">{{ $dis->dispensaryItem->item->name }}</td>
                                        <td class="align-middle">{{ $dis->dispensaryItem->dispensary->name ?? '-' }}</td>
                                        <td class="align-middle">
                                            {{ $dis->qty }}
                                            <span class="float-end">{{ $dis->dispensaryItem->item->itemUnit->name ?? '' }}</span>
                                        </td>
                                        <td class="align-middle">
                                            {{ $dis->dispensaryItem->item->stock('available') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="text-center">
                                    <td colspan="5">Tidak ada permintaan</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
    @if($dispensaryItemStock->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="text-end">
                    <button type="button" class="btn btn-primary" onclick="submitted()">
                        <i class="ph-check-circle me-2"></i>
                        Submit
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    function submitted() {
        $.ajax({
            url: '{{ url("pharmacy/request/submitted") }}',
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
                        window.location.replace('{{ url("pharmacy/request") }}');
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
