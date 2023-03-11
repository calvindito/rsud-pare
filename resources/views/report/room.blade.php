<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Laporan - <span class="fw-normal">Kamar</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-flat-primary dropdown-toggle" data-bs-toggle="dropdown">Refresh</button>
                <div class="dropdown-menu">
                    <a href="javascript:void(0);" class="dropdown-item" onclick="loadData()">Data</a>
                    <a href="{{ url()->full() }}" class="dropdown-item">Halaman</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content pt-0">
    <div class="accordion mb-3" id="accordion_collapsed">
        <div class="accordion-item bg-white">
            <h2 class="accordion-header">
                <button type="button" class="accordion-button fw-semibold collapsed fs-6" data-bs-toggle="collapse" data-bs-target="#collapsed-filter">Filter Data</button>
            </h2>
            <div id="collapsed-filter" class="accordion-collapse collapse bg-white" data-bs-parent="#accordion_collapsed">
                <div class="accordion-body">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-1">Unit</label>
                        <div class="col-md-11">
                            <select class="form-select select2-form" name="unit_id" id="unit_id">
                                <option value=""></option>
                                @foreach($unit as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-1">Kamar</label>
                        <div class="col-md-11">
                            <select class="form-select select2-form" name="room_id" id="room_id">
                                <option value=""></option>
                                @foreach($room as $r)
                                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-1">Kelas</label>
                        <div class="col-md-11">
                            <select class="form-select select2-form" name="class_type_id" id="class_type_id">
                                <option value=""></option>
                                @foreach($classType as $ct)
                                    <option value="{{ $ct->id }}">{{ $ct->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-1">Status</label>
                        <div class="col-md-11">
                            <select class="form-select select2-form" name="status" id="status">
                                <option value=""></option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group"><hr></div>
                    <div class="form-group mb-0">
                        <div class="text-end">
                            <a href="{{ url()->current() }}" class="btn btn-danger" onclick="onLoading('show', '.content')">
                                <i class="ph-arrows-counter-clockwise me-1"></i>
                                Reset Filter
                            </a>
                            <button type="button" class="btn btn-primary" onclick="loadData()">
                                <i class="ph-check-square-offset me-1"></i>
                                Terapkan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover table-xs display" id="datatable-serverside">
                <thead class="text-bg-light">
                    <tr>
                        <th class="text-center" nowrap><i class="ph-gear"></i></th>
                        <th nowrap>Unit</th>
                        <th nowrap>Kamar</th>
                        <th nowrap>Kelas</th>
                        <th nowrap>Nama</th>
                        <th nowrap>Biaya Kamar</th>
                        <th nowrap>Biaya Makan</th>
                        <th nowrap>Askep</th>
                        <th nowrap>Asupan Nutrisi</th>
                        <th nowrap>Tingkat</th>
                        <th class="text-center" nowrap>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div id="modal-detail" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rincian Kamar</h5>
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                    <i class="ph-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th width="20%">Kamar</th>
                            <th width="1%">:</th>
                            <td id="detail-room"></td>
                            <th width="20%">Total Biaya Kamar</th>
                            <th width="1%">:</th>
                            <td id="detail-fee-room"></td>
                        </tr>
                        <tr>
                            <th width="20%">Tempat</th>
                            <th width="1%">:</th>
                            <td id="detail-place"></td>
                            <th width="20%">Total Askep</th>
                            <th width="1%">:</th>
                            <td id="detail-fee-nursing-care"></td>
                        </tr>
                        <tr>
                            <th width="20%">Unit</th>
                            <th width="1%">:</th>
                            <td id="detail-unit"></td>
                            <th width="20%">Total Asupan Nutrisi</th>
                            <th width="1%">:</th>
                            <td id="detail-fee-nutritional-care"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group mb-0"><hr class="mb-0"></div>
                <table class="table table-bordered table-hover table-striped table-xs display" id="datatable-detail-serverside">
                    <thead class="table-primary">
                        <th class="text-center">No</th>
                        <th>Kode</th>
                        <th>Biaya Kamar</th>
                        <th>Askep</th>
                        <th>Asupan Nutrisi</th>
                        <th>Tanggal</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        loadData();

        $('.select2-form').select2({
            placeholder: '-- Pilih --'
        });
    });

    function loadData() {
        window.gDataTable = $('#datatable-serverside').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            scrollX: true,
            destroy: true,
            order: [[1, 'desc']],
            ajax: {
                url: '{{ url("report/room/datatable") }}',
                dataType: 'JSON',
                data: {
                    unit_id: $('#unit_id').val(),
                    room_id: $('#room_id').val(),
                    class_type_id: $('#class_type_id').val(),
                    status: $('#status').val()
                },
                beforeSend: function() {
                    onLoading('show', '.datatable-scroll');
                },
                complete: function() {
                    onLoading('close', '.datatable-scroll');
                },
                error: function(response) {
                    onLoading('close', '.datatable-scroll');

                    swalInit.fire({
                        html: '<b>' + response.responseJSON.exception + '</b><br>' + response.responseJSON.message,
                        icon: 'error',
                        showCloseButton: true
                    });
                }
            },
            columns: [
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'align-middle text-center' },
                { data: 'unit_name', name: 'unit_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'room_name', name: 'room_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'class_type_name', name: 'class_type_name', orderable: false, searchable: true, className: 'align-middle' },
                { data: 'name', name: 'name', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'fee_room', name: 'fee_room', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'fee_meal', name: 'fee_meal', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'fee_nursing_care', name: 'fee_nursing_care', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'fee_nutritional_care', name: 'fee_nutritional_care', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'tier', name: 'tier', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'status', name: 'status', orderable: true, searchable: false, className: 'align-middle text-center' },
            ]
        });
    }

    function loadDataDetail(roomTypeId) {
        window.gDataTable = $('#datatable-detail-serverside').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            scrollX: true,
            destroy: true,
            order: [[0, 'desc']],
            ajax: {
                url: '{{ url("report/room/datatable-detail") }}',
                dataType: 'JSON',
                data: {
                    room_type_id: roomTypeId
                },
                beforeSend: function() {
                    onLoading('show', '.modal-content');
                },
                complete: function() {
                    onLoading('close', '.modal-content');
                },
                error: function(response) {
                    onLoading('close', '.modal-content');

                    swalInit.fire({
                        html: '<b>' + response.responseJSON.exception + '</b><br>' + response.responseJSON.message,
                        icon: 'error',
                        showCloseButton: true
                    });
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'id', orderable: true, searchable: false, className: 'align-middle text-center' },
                { data: 'code', name: 'id', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'fee_room', name: 'fee_room', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'fee_nursing_care', name: 'fee_nursing_care', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'fee_nutritional_care', name: 'fee_nutritional_care', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'date_of_entry', name: 'date_of_entry', orderable: true, searchable: false, className: 'align-middle' },
            ]
        });
    }

    function detail(id) {
        $.ajax({
            url: '{{ url("report/room/detail") }}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                id: id
            },
            beforeSend: function() {
                $('#modal-detail').modal('show');
                onLoading('show', '.modal-content');
            },
            success: function(response) {
                loadDataDetail(id);

                $('#detail-room').html(response.data.room.name);
                $('#detail-place').html(response.data.name + ' - ' + response.data.class_type.name);
                $('#detail-unit').html(response.data.room.unit.name);
                $('#detail-fee-room').html(response.total.fee_room);
                $('#detail-fee-nursing-care').html(response.total.fee_nursing_care);
                $('#detail-fee-nutritional-care').html(response.total.fee_nutritional_care);

                onLoading('close', '.modal-content');
            },
            error: function(response) {
                onLoading('close', '.modal-content');

                swalInit.fire({
                    html: '<b>' + response.responseJSON.exception + '</b><br>' + response.responseJSON.message,
                    icon: 'error',
                    showCloseButton: true
                });
            }
        });
    }
</script>
