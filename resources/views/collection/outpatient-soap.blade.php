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
                                <textarea class="form-control text-editor" name="nursing_care_value" id="nursing_care_value"></textarea>
                            </fieldset>
                            <h6>Subjective</h6>
                            <fieldset>
                                <textarea class="form-control text-editor" name="nursing_care_subjective" id="nursing_care_subjective"></textarea>
                            </fieldset>
                            <h6>Objective</h6>
                            <fieldset>
                                <textarea class="form-control text-editor" name="nursing_care_objective" id="nursing_care_objective"></textarea>
                            </fieldset>
                            <h6>Assessment</h6>
                            <fieldset>
                                <textarea class="form-control text-editor" name="nursing_care_assessment" id="nursing_care_assessment"></textarea>
                            </fieldset>
                            <h6>Planning</h6>
                            <fieldset>
                                <textarea class="form-control text-editor" name="nursing_care_planning" id="nursing_care_planning"></textarea>
                            </fieldset>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="stacked-left-pill2">
                        <div class="wizard-form steps-all-2">
                            <h6>Subjective</h6>
                            <fieldset>
                                <textarea class="form-control text-editor" name="checkup_subjective" id="checkup_subjective"></textarea>
                            </fieldset>
                            <h6>Objective</h6>
                            <fieldset>
                                <textarea class="form-control text-editor" name="checkup_objective" id="checkup_objective"></textarea>
                            </fieldset>
                            <h6>Assessment</h6>
                            <fieldset>
                                <textarea class="form-control text-editor" name="checkup_assessment" id="checkup_assessment"></textarea>
                            </fieldset>
                            <h6>Planning</h6>
                            <fieldset>
                                <textarea class="form-control text-editor" name="checkup_planning" id="checkup_planning"></textarea>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        fullWidthAllDevice();
        initFormStep();
        checkStatus();
        setValueAllSOAP();

        $('#form-data .actions').addClass('mt-3');
    });

    function setValueAllSOAP() {
        $('#nursing_care_value').summernote('code', '{!! $outpatientSoap->firstWhere("type", 1)->value ?? "" !!}');
        $('#nursing_care_subjective').summernote('code', '{!! $outpatientSoap->firstWhere("type", 1)->subjective ?? "" !!}');
        $('#nursing_care_objective').summernote('code', '{!! $outpatientSoap->firstWhere("type", 1)->objective ?? "" !!}');
        $('#nursing_care_assessment').summernote('code', '{!! $outpatientSoap->firstWhere("type", 1)->assessment ?? "" !!}');
        $('#nursing_care_planning').summernote('code', '{!! $outpatientSoap->firstWhere("type", 1)->planning ?? "" !!}');
        $('#checkup_subjective').summernote('code', '{!! $outpatientSoap->firstWhere("type", 2)->subjective ?? "" !!}');
        $('#checkup_objective').summernote('code', '{!! $outpatientSoap->firstWhere("type", 2)->objective ?? "" !!}');
        $('#checkup_assessment').summernote('code', '{!! $outpatientSoap->firstWhere("type", 2)->assessment ?? "" !!}');
        $('#checkup_planning').summernote('code', '{!! $outpatientSoap->firstWhere("type", 2)->planning ?? "" !!}');
    }

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
        $('.steps-all-1').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            transitionEffect: 'none',
            labels: {
                previous: document.dir == 'rtl' ? '<i class="ph-arrow-circle-right me-2"></i> Sebelumnya' : '<i class="ph-arrow-circle-left me-2"></i> Sebelumnya',
                next: document.dir == 'rtl' ? 'Selanjutnya <i class="ph-arrow-circle-left ms-2"></i>' : 'Selanjutnya <i class="ph-arrow-circle-right ms-2"></i>',
                finish: 'Simpan <i class="ph-floppy-disk ms-2"></i>'
            },
            autoFocus: true,
            titleTemplate: '<span class="number">#index#</span> #title#',
            onStepChanged: function(event, currentIndex) {
                $('.steps-all-2 ul:eq(0) li').removeClass('done');
            },
            onStepChanging: function (event, currentIndex, newIndex) {
                var value = $('#nursing_care_value').summernote('isEmpty');
                var valueLength = $('#nursing_care_value').summernote('code').replace(/(<([^>]+)>)/ig, "").length;
                var subjective = $('#nursing_care_subjective').summernote('isEmpty');
                var subjectiveLength = $('#nursing_care_subjective').summernote('code').replace(/(<([^>]+)>)/ig, "").length;
                var objective = $('#nursing_care_objective').summernote('isEmpty');
                var objectiveLength = $('#nursing_care_objective').summernote('code').replace(/(<([^>]+)>)/ig, "").length;
                var assessment = $('#nursing_care_assessment').summernote('isEmpty');
                var assessmentLength = $('#nursing_care_assessment').summernote('code').replace(/(<([^>]+)>)/ig, "").length;
                var planning = $('#nursing_care_planning').summernote('isEmpty');
                var planningLength = $('#nursing_care_planning').summernote('code').replace(/(<([^>]+)>)/ig, "").length;

                if(currentIndex > newIndex) {
                    return true;
                }

                if (currentIndex == 0) {
                    if(value || valueLength < 10) {
                        Swal.fire('Oops...', 'mohon mengisi askep terlebih dahulu (minimal 10 karakter)', 'info');

                        return false;
                    }
                }

                if (currentIndex == 1) {
                    if(subjective || subjectiveLength < 10) {
                        Swal.fire('Oops...', 'mohon mengisi subjective terlebih dahulu (minimal 10 karakter)', 'info');

                        return false;
                    }
                }

                if (currentIndex == 2) {
                    if(objective || objectiveLength < 10) {
                        Swal.fire('Oops...', 'mohon mengisi objective terlebih dahulu (minimal 10 karakter)', 'info');

                        return false;
                    }
                }

                if (currentIndex == 3) {
                    if(assessment || assessmentLength < 10) {
                        Swal.fire('Oops...', 'mohon mengisi assessment terlebih dahulu (minimal 10 karakter)', 'info');

                        return false;
                    }
                }

                if (planning == 4) {
                    if(planning || planningLength < 10) {
                        Swal.fire('Oops...', 'mohon mengisi planning terlebih dahulu (minimal 10 karakter)', 'info');

                        return false;
                    }
                }

                var status = '{{ $outpatient->status }}';

                if(status == 4) {
                    $('#form-data a[href="#finish"]').hide();
                }

                return true;
            },
            onFinished: function (event, currentIndex) {
                submitted();
            }
        });

        $('.steps-all-2').steps({
            headerTag: 'h6',
            bodyTag: 'fieldset',
            transitionEffect: 'none',
            labels: {
                previous: document.dir == 'rtl' ? '<i class="ph-arrow-circle-right me-2"></i> Sebelumnya' : '<i class="ph-arrow-circle-left me-2"></i> Sebelumnya',
                next: document.dir == 'rtl' ? 'Selanjutnya <i class="ph-arrow-circle-left ms-2"></i>' : 'Selanjutnya <i class="ph-arrow-circle-right ms-2"></i>',
                finish: 'Simpan <i class="ph-floppy-disk ms-2"></i>'
            },
            autoFocus: true,
            titleTemplate: '<span class="number">#index#</span> #title#',
            onStepChanged: function(event, currentIndex) {
                $('.steps-all-2 ul:eq(0) li').removeClass('done');
            },
            onStepChanging: function (event, currentIndex, newIndex) {
                var subjective = $('#checkup_subjective').summernote('isEmpty');
                var subjectiveLength = $('#checkup_subjective').summernote('code').replace(/(<([^>]+)>)/ig, "").length;
                var objective = $('#checkup_objective').summernote('isEmpty');
                var objectiveLength = $('#checkup_objective').summernote('code').replace(/(<([^>]+)>)/ig, "").length;
                var assessment = $('#checkup_assessment').summernote('isEmpty');
                var assessmentLength = $('#checkup_assessment').summernote('code').replace(/(<([^>]+)>)/ig, "").length;
                var planning = $('#checkup_planning').summernote('isEmpty');
                var planningLength = $('#checkup_planning').summernote('code').replace(/(<([^>]+)>)/ig, "").length;

                if(currentIndex > newIndex) {
                    return true;
                }

                if (currentIndex == 0) {
                    if(subjective || subjectiveLength < 10) {
                        Swal.fire('Oops...', 'mohon mengisi subjective terlebih dahulu (minimal 10 karakter)', 'info');

                        return false;
                    }
                }

                if (currentIndex == 1) {
                    if(objective || objectiveLength < 10) {
                        Swal.fire('Oops...', 'mohon mengisi objective terlebih dahulu (minimal 10 karakter)', 'info');

                        return false;
                    }
                }

                if (currentIndex == 2) {
                    if(assessment || assessmentLength < 10) {
                        Swal.fire('Oops...', 'mohon mengisi assessment terlebih dahulu (minimal 10 karakter)', 'info');

                        return false;
                    }
                }

                if (planning == 3) {
                    if(planning || planningLength < 10) {
                        Swal.fire('Oops...', 'mohon mengisi planning terlebih dahulu (minimal 10 karakter)', 'info');

                        return false;
                    }
                }

                var status = '{{ $outpatient->status }}';

                if(status == 4) {
                    $('#form-data a[href="#finish"]').hide();
                }

                return true;
            },
            onFinished: function (event, currentIndex) {
                submitted();
            }
        });
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
