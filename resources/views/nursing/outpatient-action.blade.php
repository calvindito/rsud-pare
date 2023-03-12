<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Keperawatan - Rawat Jalan - <span class="fw-normal">Tindakan</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('nursing/outpatient') }}" class="btn btn-flat-primary">Kembali ke Daftar</a>
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
            <h6 class="py-sm-3 mb-sm-0">Form Tindakan</h6>
            <div class="ms-sm-auto my-sm-auto">
                <form>
                    @csrf
                    <div class="input-group">
                        <span class="input-group-text"><i class="ph-calendar"></i></span>
                        <input type="date" name="date" id="date" class="form-control wmin-250" min="{{ date('Y-m-d', strtotime($outpatient->date_of_entry)) }}" max="{{ !empty($outpatient->date_of_out) ? date('Y-m-d', strtotime($outpatient->date_of_entry)) : date('Y-m-d') }}" value="{{ $date }}" onchange="onLoading('show', '.content'); this.form.submit()">
                        @if($date != date('Y-m-d'))
                            <a href="{{ url('nursing/outpatient/action/' . $outpatient->id) }}" class="btn btn-danger">Reset</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <form id="form-data">
                <select class="form-select form-select-picker" name="unit_action_id[]" multiple>
                    @foreach($unitAction as $u)
                        @php
                            $limit = $outpatient->outpatientActionLimit()->where('unit_action_id', $u->id)->first()->limit ?? 0;
                            $used = $outpatient->outpatientNursing()->whereDate('created_at', $date)->where('unit_action_id', $u->id)->count();
                            $available = $limit - $used;
                        @endphp

                        @for($i = 1; $i <= $available; $i++)
                            <option value="{{ Str::random(3) }}_{{ $u->id }}">{{ $u->action->name }}</option>
                        @endfor
                    @endforeach
                    @foreach($outpatient->outpatientNursing()->whereDate('created_at', $date)->where('user_id', auth()->id())->get() as $on)
                        <option value="{{ Str::random(3) }}_{{ $on->unit_action_id }}" selected>{{ $on->unitAction->action->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    @if($date == date('Y-m-d') && in_array($outpatient->status, [1, 3]))
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
        listBox('.form-select-picker');

        $('.dual-listbox__container .dual-listbox__search').attr('placeholder', 'Cari ...');
        $('.dual-listbox__container .dual-listbox__title:eq(0)').html('Tindakan Tersedia');
        $('.dual-listbox__container .dual-listbox__title:eq(1)').html('Tindakan Yang Telah Dilakukan');
        $('.dual-listbox__container .dual-listbox__buttons button:eq(0)').text('Tambah Semua');
        $('.dual-listbox__container .dual-listbox__buttons button:eq(1)').text('Tambah');
        $('.dual-listbox__container .dual-listbox__buttons button:eq(2)').text('Hapus');
        $('.dual-listbox__container .dual-listbox__buttons button:eq(3)').text('Hapus Semua');
    });

    function submitted() {
        $.ajax({
            url: '{{ url("nursing/outpatient/action/" . $outpatient->id) }}',
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
                        window.location.replace('{{ url("nursing/outpatient/action/" . $outpatient->id) }}');
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
