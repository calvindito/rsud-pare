<div class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="hstack gap-2 mb-0">Daftar Poli</h6>
                </div>
                <div class="card-body" style="height:585px; overflow-y:scroll;">
                    <ul class="nav nav-sidebar" id="nav-long-line">
                        @foreach($unit as $u)
                            <li class="nav-item pt-0" onclick="changeLongLine(this, {{ $u->id }})">
                                <a href="javascript:void(0);" class="nav-link">
                                    {{ $u->name }}
                                    <span class="fs-sm fw-normal text-muted align-self-center ms-auto">
                                        {{ $u->outpatient()->whereDate('date_of_entry', now())->count() }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card" id="content-long-line">
                <div class="card-body">
                    <div class="text-center">
                        <div class="fw-semibold bg-light p-3 fs-4 text-uppercase" id="cll-name"></div>
                        <div class="form-group"><hr></div>
                        <div class="bg-light p-3">
                            <div class="fw-semibold fs-4 text-uppercase">Antrian Saat Ini</div>
                            <div class="fw-semibold text-uppercase" style="font-size:50px;" id="cll-active"></div>
                            <div class="form-group"><hr></div>
                            <div class="fw-normal fs-1 text-uppercase mb-0" id="cll-code"></div>
                        </div>
                        <div class="form-group"><hr></div>
                        <div class="fw-semibold bg-light p-3 fs-4 text-uppercase">Ringkasan</div>
                        <div class="mb-3"></div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="bg-light p-3 text-center">
                                    Total
                                    <div class="form-group"><hr></div>
                                    <span id="cll-total"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-light p-3 text-center">
                                    Selesai
                                    <div class="form-group"><hr></div>
                                    <span id="cll-done"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-light p-3 text-center">
                                    Menunggu
                                    <div class="form-group"><hr></div>
                                    <span id="cll-remaining"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#nav-long-line li:eq(0)').click();
    });

    function changeLongLine(param, unitId) {
        $.ajax({
            url: '{{ url("dashboard/poly-queue/load-long-line") }}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                unit_id: unitId
            },
            beforeSend: function() {
                $('#nav-long-line li').removeClass('bg-light');
                onLoading('show', '#content-long-line');
            },
            success: function(response) {
                onLoading('close', '#content-long-line');

                $(param).addClass('bg-light');
                $('#cll-name').html(response.poly);
                $('#cll-active').html(response.active);
                $('#cll-code').html(response.code);
                $('#cll-total').html(response.total);
                $('#cll-done').html(response.done);
                $('#cll-remaining').html(response.remaining);
            },
            error: function(response) {
                onLoading('close', '#content-long-line');

                swalInit.fire({
                    html: '<b>' + response.responseJSON.exception + '</b><br>' + response.responseJSON.message,
                    icon: 'error',
                    showCloseButton: true
                });
            }
        });
    }
</script>
