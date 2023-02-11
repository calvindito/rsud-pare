<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Pendataan - Rawat Jalan - <span class="fw-normal">SOAP</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('collection/outpatient') }}" class="btn btn-flat-primary">Kembali ke Daftar</a>
            <a href="{{ url()->full() }}" class="btn btn-flat-primary">Refresh</a>
        </div>
    </div>
</div>
<div class="content pt-0">
    <div class="card">
        <div class="card-header">
            <h6 class="hstack gap-2 mb-0">Data Pasien</h6>
        </div>
        <div class="card-body">
            <table class="table">
                <tbody>
                    <tr>
                        <th class="align-middle">Nama Pasien</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $patient->name }}</td>
                        <th class="align-middle">No RM</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $patient->id }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Tanggal Masuk</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $outpatient->date_of_entry }}</td>
                        <th class="align-middle">Tanggal Keluar</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ !empty($outpatient->date_of_out) ? $outpatient->date_of_out : '-' }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Poli</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $outpatient->unit->name }}</td>
                        <th class="align-middle">Kehadiran</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $outpatient->presence_format_result }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Alamat</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $patient->address }}</td>
                        <th class="align-middle">Status</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $outpatient->status() }}</tr>
                    <tr>
                        <th class="align-middle">Tanggal Lahir</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $patient->date_of_birth }}</td>
                        <th class="align-middle">Golongan</th>
                        <th class="align-middle" width="1%">:</th>
                        <td class="align-middle" width="30%">{{ $outpatient->type_format_result }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
            <h6 class="py-sm-3 mb-sm-0">S.O.A.P</h6>
            <div class="ms-sm-auto">
                <ul class="nav nav-pills mb-0">
                    <li class="nav-item">
                        <a href="#stacked-left-pill1" class="nav-link active" data-bs-toggle="tab">Askep</a>
                    </li>
                    <li class="nav-item">
                        <a href="#stacked-left-pill2" class="nav-link" data-bs-toggle="tab">Checkup</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <form id="form-data">
                <div class="tab-content flex-1">
                    <div class="tab-pane fade show active" id="stacked-left-pill1">
                        <div class="wizard-form steps-all-1">
                            <h6>Askep</h6>
                            <fieldset>
                                <textarea class="form-control text-editor" name="nursing_care_value" id="nursing_care_value">
                                    {!! $outpatientSoap->firstWhere('type', 1)->value ?? null !!}
                                </textarea>
                            </fieldset>
                            <h6>Subjective</h6>
                            <fieldset>
                                <textarea class="form-control text-editor" name="nursing_care_subjective" id="nursing_care_subjective">
                                    {!! $outpatientSoap->firstWhere('type', 1)->subjective ?? null !!}
                                </textarea>
                            </fieldset>
                            <h6>Objective</h6>
                            <fieldset>
                                <textarea class="form-control text-editor" name="nursing_care_objective" id="nursing_care_objective">
                                    {!! $outpatientSoap->firstWhere('type', 1)->objective ?? null !!}
                                </textarea>
                            </fieldset>
                            <h6>Assessment</h6>
                            <fieldset>
                                <textarea class="form-control text-editor" name="nursing_care_assessment" id="nursing_care_assessment">
                                    {!! $outpatientSoap->firstWhere('type', 1)->assessment ?? null !!}
                                </textarea>
                            </fieldset>
                            <h6>Planning</h6>
                            <fieldset>
                                <textarea class="form-control text-editor" name="nursing_care_planning" id="nursing_care_planning">
                                    {!! $outpatientSoap->firstWhere('type', 1)->planning ?? null !!}
                                </textarea>
                            </fieldset>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="stacked-left-pill2">
                        <div class="wizard-form steps-all-2">
                            <h6>Subjective</h6>
                            <fieldset>
                                <textarea class="form-control text-editor" name="checkup_subjective" id="checkup_subjective">
                                    {!! $outpatientSoap->firstWhere('type', 2)->subjective ?? null !!}
                                </textarea>
                            </fieldset>
                            <h6>Objective</h6>
                            <fieldset>
                                <textarea class="form-control text-editor" name="checkup_objective" id="checkup_objective">
                                    {!! $outpatientSoap->firstWhere('type', 2)->objective ?? null !!}
                                </textarea>
                            </fieldset>
                            <h6>Assessment</h6>
                            <fieldset>
                                <textarea class="form-control text-editor" name="checkup_assessment" id="checkup_assessment">
                                    {!! $outpatientSoap->firstWhere('type', 2)->assessment ?? null !!}
                                </textarea>
                            </fieldset>
                            <h6>Planning</h6>
                            <fieldset>
                                <textarea class="form-control text-editor" name="checkup_planning" id="checkup_planning">
                                    {!! $outpatientSoap->firstWhere('type', 2)->planning ?? null !!}
                                </textarea>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if($outpatient->status != 4)
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
    @endif
</div>

<script>
    $(function() {
        fullWidthAllDevice();
        initFormStep();
        checkStatus();
    });

    function checkStatus() {
        var status = '{{ $outpatient->status }}';

        if(status != 4) {
            textEditor('.text-editor');
        } else {
            $('.text-editor').each(function () {
                $(this).summernote('disable');
            });
        }
    }

    function initFormStep() {
        $('.steps-all-1, .steps-all-2').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            transitionEffect: 'none',
            enableAllSteps: true,
            titleTemplate: '<span class="number">#index#</span> #title#',
            onStepChanged: function(event, currentIndex) {
                $('.steps-all-1 ul:eq(0) li').removeClass('done');
                $('.steps-all-2 ul:eq(0) li').removeClass('done');
                initConfigFormStep();
            }
        });

        initConfigFormStep();
    }

    function initConfigFormStep() {
        $('.steps-all-1 a[href="#finish"]').parent().hide();
        $('.steps-all-1 a[href="#next"]').parent().hide();
        $('.steps-all-1 a[href="#previous"]').parent().hide();
        $('.steps-all-2 a[href="#finish"]').parent().hide();
        $('.steps-all-2 a[href="#next"]').parent().hide();
        $('.steps-all-2 a[href="#previous"]').parent().hide();
    }

    function submitted() {
        $.ajax({
            url: '{{ url("collection/outpatient/soap/" . $outpatient->id) }}',
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
                        window.location.replace('{{ url("collection/outpatient/soap/" . $outpatient->id) }}');
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
