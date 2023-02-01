<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Master Data - Rekam Medis - <span class="fw-normal">Pasien</span>
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
            <table class="table table-bordered table-hover table-xs display" id="datatable-serverside">
                <thead class="text-bg-light">
                    <tr>
                        <th class="text-center" nowrap>No</th>
                        <th nowrap>No RM</th>
                        <th nowrap>Nama</th>
                        <th nowrap>Tanggal Lahir</th>
                        <th nowrap>Alamat</th>
                        <th nowrap>Tipe</th>
                        <th nowrap>Jenis Kelamin</th>
                        <th nowrap>Nama Ortu</th>
                        <th nowrap>Kecamatan</th>
                        <th class="text-center" nowrap><i class="ph-gear"></i></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div id="modal-form" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="validation-element">
                    <ul class="mb-0" id="validation-data"></ul>
                </div>
                <form id="form-data">
                    <ul class="nav nav-tabs nav-tabs-highlight nav-justified">
                        <li class="nav-item">
                            <a href="#tab-1" class="nav-link active" data-bs-toggle="tab">Data</a>
                        </li>
                        <li class="nav-item">
                            <a href="#tab-2" class="nav-link" data-bs-toggle="tab">Alamat</a>
                        </li>
                        <li class="nav-item">
                            <a href="#tab-3" class="nav-link" data-bs-toggle="tab">Info</a>
                        </li>
                    </ul>
                    <div class="tab-content flex-1">
                        <div class="tab-pane fade show active" id="tab-1">
                            <p class="mt-4">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">No RM</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="table_id" id="table_id" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">No Identitas</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="identity_number" id="identity_number" placeholder="Masukan no identitas (KTP)">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">Nama <span class="text-danger fw-bold">*</span></label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <select class="form-select w-auto flex-grow-0" name="greeted" id="greeted">
                                                <option value="">-- Pilih --</option>
												<option value="1">Tuan</option>
												<option value="2">Nyonya</option>
												<option value="3">Saudara</option>
												<option value="4">Nona</option>
												<option value="5">Anak</option>
											</select>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Masukan nama">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">Jenis Kelamin <span class="text-danger fw-bold">*</span></label>
                                    <div class="col-md-9">
                                        <select class="form-select" name="gender" id="gender">
                                            <option value="">-- Pilih --</option>
                                            <option value="1">Laki - Laki</option>
                                            <option value="2">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">Tanggal Lahir</label>
                                    <div class="col-md-9">
                                        <input type="date" class="form-control" name="date_of_birth" id="date_of_birth">
                                    </div>
                                </div>
                            </p>
                        </div>
                        <div class="tab-pane fade" id="tab-2">
                            <p class="mt-4">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">Wilayah <span class="text-danger fw-bold">*</span></label>
                                    <div class="col-md-9">
                                        <select class="form-select" name="location_id" id="location_id"></select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">Desa <span class="text-danger fw-bold">*</span></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="village" id="village" placeholder="Masukan desa">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">RT</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="rt" id="rt" placeholder="Masukan rt">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">RW</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="rw" id="rw" placeholder="Masukan rw">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">Alamat <span class="text-danger fw-bold">*</span></label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="address" id="address" style="resize:none;" placeholder="Masukan alamat"></textarea>
                                    </div>
                                </div>
                            </p>
                        </div>
                        <div class="tab-pane fade" id="tab-3">
                            <p class="mt-4">
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">Tempat Lahir</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="place_of_birth" id="place_of_birth" placeholder="Masukan tempat lahir">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">Suku</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="tribe" id="tribe" placeholder="Masukan suku">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">Berat Badan</label>
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="weight" id="weight" placeholder="Masukan berat badan">
											<span class="input-group-text">Kg</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">Golongan Darah</label>
                                    <div class="col-md-9">
                                        <select class="form-select" name="blood_group" id="blood_group">
                                            <option value="">-- Pilih --</option>
                                            <option value="1">A</option>
                                            <option value="2">B</option>
                                            <option value="3">AB</option>
                                            <option value="4">O</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">Agama <span class="text-danger fw-bold">*</span></label>
                                    <div class="col-md-9">
                                        <select class="form-select" name="religion_id" id="religion_id">
                                            <option value="">-- Pilih --</option>
                                            @foreach($religion as $r)
                                                <option value="{{ $r->id }}">{{ $r->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">Status Pernikahan</label>
                                    <div class="col-md-9">
                                        <select class="form-select" name="marital_status" id="marital_status">
                                            <option value="">-- Pilih --</option>
                                            <option value="1">Belum Menikah</option>
                                            <option value="2">Menikah</option>
                                            <option value="3">Cerai Hidup</option>
                                            <option value="4">Cerai Mati</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">Pekerjaan</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="job" id="job" placeholder="Masukan pekerjaan">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">No Telp</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Masukan no telp">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">Nama Ortu</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="parent_name" id="parent_name" placeholder="Masukan nama ortu">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-3">Nama Suami / Istri</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="partner_name" id="partner_name" placeholder="Masukan nama suami / istri">
                                    </div>
                                </div>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-end">
                <button class="btn btn-danger" id="btn-cancel" onclick="onCancel()">
                    <i class="ph-x me-1"></i>
                    Batalkan Perubahan
                </button>
                <button class="btn btn-warning" id="btn-update" onclick="updateData()">
                    <i class="ph-floppy-disk me-1"></i>
                    Simpan Perubahan Data
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        loadData();
        sidebarMini();

        select2Ajax('#location_id', 'location?show=district');
    });

    function onReloadTable() {
        window.gDataTable.ajax.reload(null, false);
    }

    function onReset() {
        clearValidation();
        resetNavTab();
        $('#modal-form').modal('hide');
        $('#form-data').trigger('reset');
        $('#location_id').val('').change();
        $('#location_id').html('');
    }

    function onCancel() {
        onReset();
    }

    function onUpdate() {
        onReset();
        $('#modal-form').modal('show');
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

    function resetNavTab() {
        $('.nav-tabs .nav-item a').removeClass('active');
        $('.nav-tabs .nav-item a[href="#tab-1"]').addClass('active');
        $('.tab-content .tab-pane').removeClass('show active');
        $('.tab-content #tab-1').addClass('show active');
    }

    function formSuccess() {
        onReset();
        onReloadTable();
    }

    function loadData() {
        window.gDataTable = $('#datatable-serverside').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            scrollX: true,
            destroy: true,
            order: [[0, 'desc']],
            ajax: {
                url: '{{ url("master-data/medical-record/patient/datatable") }}',
                dataType: 'JSON',
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
                { data: 'DT_RowIndex', name: 'id', orderable: true, searchable: false, className: 'align-middle text-center' },
                { data: 'id', name: 'id', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'name', name: 'name', orderable: true, searchable: true, className: 'align-middle' },
                { data: 'date_of_birth', name: 'name', orderable: true, searchable: false, className: 'align-middle' },
                { data: 'address', name: 'address', orderable: true, searchable: true, className: 'align-middle nowrap' },
                { data: 'type_format_result', name: 'type', orderable: true, searchable: false, className: 'align-middle nowrap' },
                { data: 'gender_format_result', name: 'gender', orderable: true, searchable: false, className: 'align-middle nowrap' },
                { data: 'parent_name', name: 'parent_name', orderable: true, searchable: true, className: 'align-middle nowrap' },
                { data: 'district_name', name: 'district_name', orderable: false, searchable: true, className: 'align-middle nowrap' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'align-middle text-center' },
            ]
        });
    }

    function showDataUpdate(id) {
        $.ajax({
            url: '{{ url("master-data/medical-record/patient/show-data") }}',
            type: 'GET',
            dataType: 'JSON',
            data: {
                id: id
            },
            beforeSend: function() {
                onLoading('show', '.modal-content');
                onUpdate();
            },
            success: function(response) {
                onLoading('close', '.modal-content');

                $('#table_id').val(response.id);
                $('#identity_number').val(response.identity_number);
                $('#greeted').val(response.greeted);
                $('#name').val(response.name);
                $('#gender').val(response.gender);
                $('#date_of_birth').val(response.date_of_birth);

                if(response.district_id != '') {
                    var provinceName = response.province ? response.province.name : 'Invalid Provinsi';
                    var cityName = response.city ? response.city.name : 'Invalid Kota';
                    var districtName = response.district ? response.district.name : 'Invalid Kecamatan';

                    $('#location_id').append(`
                        <option value="` + response.district_id + `" selected>
                            ` + provinceName + ` - ` + cityName + ` - ` + districtName + `
                        </option>
                    `);
                }

                $('#village').val(response.village);
                $('#rt').val(response.rt);
                $('#rw').val(response.rw);
                $('#address').val(response.address);
                $('#place_of_birth').val(response.place_of_birth);
                $('#tribe').val(response.tribe);
                $('#weight').val(response.weight);
                $('#blood_group').val(response.blood_group);
                $('#religion_id').val(response.religion_id);
                $('#marital_status').val(response.marital_status);
                $('#job').val(response.job);
                $('#phone').val(response.phone);
                $('#parent_name').val(response.parent_name);
                $('#partner_name').val(response.partner_name);
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

    function updateData() {
        $.ajax({
            url: '{{ url("master-data/medical-record/patient/update-data") }}',
            type: 'PATCH',
            dataType: 'JSON',
            data: $('#form-data').serialize(),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            beforeSend: function() {
                onLoading('show', '.modal-content');
                clearValidation();
            },
            success: function(response) {
                onLoading('close', '.modal-content');

                if(response.code == 200) {
                    formSuccess();
                    notification('success', response.message);
                } else if(response.code == 400) {
                    $('#modal-form .modal-body').scrollTop(0);
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
