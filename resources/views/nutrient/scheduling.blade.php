<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Gizi - <span class="fw-normal">Penjadwalan</span>
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
    @if(session('success'))
        <div class="alert alert-success alert-icon-start fade show">
            <span class="alert-icon bg-success text-white">
                <i class="ph-check-circle"></i>
            </span>
            <span class="fw-semibold">Berhasil!</span> {{ session('success') }}
        </div>
    @elseif(session('failed'))
        <div class="alert alert-danger alert-icon-start fade show">
            <span class="alert-icon bg-danger text-white">
                <i class="ph-x-circle"></i>
            </span>
            {{ session('failed') }}
        </div>
    @endif
    <form action="{{ url('nutrient/scheduling/set') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header d-lg-flex align-items-sm-center py-sm-0">
                <h6 class="py-sm-3 mb-sm-0">Form Jadwal</h6>
                <div class="ms-sm-auto my-sm-auto">
                    <div class="input-group">
                        <span class="input-group-text"><i class="ph-calendar"></i></span>
                        <input type="date" class="form-control wmin-200" name="date" id="date" max="{{ date('Y-m-d') }}" value="{{ $date }}" onchange="onLoading('show', '.content'); location.replace('{{ url('nutrient/scheduling?date=') }}' + $('#date').val());">
                        @if($date != date('Y-m-d'))
                            <a href="{{ url('nutrient/scheduling') }}" class="btn btn-danger" onclick="onLoading('show', '.content')">Reset</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-primary sticky-top">
                        <tr>
                            <th>Pasien</th>
                            <th>Kamar</th>
                            <th>Kelas</th>
                            @foreach($eatingTime as $et)
                                <th>{{ $et->type_format_result }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @if($patient->count() > 0)
                            @foreach($patient as $p)
                                <tr>
                                    <input type="hidden" name="patient_id[]" value="{{ $p->id }}">
                                    <td rowspan="2">{{ $p->name }}</td>
                                    <td rowspan="2">{{ $p->inpatientActive->bed->roomSpace->roomType->room->name }}</td>
                                    <td rowspan="2" nowrap>{{ $p->inpatientActive->bed->roomSpace->roomType->classType->name }}</td>
                                    @foreach($eatingTime as $key => $et)
                                        @php
                                            $hasData = App\Models\Eating::whereDate('date', $date)->where('eating_time_id', $et->id)->where('patient_id', $p->id)->first();
                                            $timeNow = strtotime(date('H:i:s'));
                                            $timeStart = strtotime($et->time_start);
                                        @endphp
                                        <input type="hidden" name="eating_time_{{ $p->id }}[]" value="{{ $et->id }}">
                                        <td nowrap>
                                            @if($timeNow >= $timeStart || $date != date('Y-m-d') || $p->inpatientActive->status != 1)
                                                <input type="hidden" name="code_{{ $p->id }}[]" value="{{ isset($hasData->code) ? $hasData->code : null }}">
                                                <input type="hidden" name="food_{{ $p->id }}[]" value="{{ isset($hasData->food) ? $hasData->food->id : null }}">
                                                <div class="mb-1">
                                                    <input type="text" class="form-control form-control-sm" value="{{ isset($hasData->code) ? $hasData->code : 'Tidak ada kode' }}" disabled>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" value="{{ isset($hasData->food) ? $hasData->food->name : 'Tidak ada makanan' }}" disabled>
                                            @else
                                                <div class="mb-1">
                                                    <input type="text" class="form-control form-control-sm" name="code_{{ $p->id }}[]" value="{{ old("code_$p->id.$key", $hasData->code ?? '') }}" placeholder="Kode">
                                                </div>
                                                <select class="form-select form-select-sm" name="food_{{ $p->id }}[]">
                                                    <option value="">Tidak Ada</option>
                                                    @foreach($food as $f)
                                                        <option value="{{ $f->id }}" {{ old("food_$p->id.$key", $hasData->food_id ?? '') == $f->id ? 'selected' : '' }}>
                                                            {{ $f->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td colspan="{{ $eatingTime->count() }}" nowrap>{!! $p->inpatientActive->status('d-block') !!}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="{{ 3 + $eatingTime->count() }}" class="text-center">Tidak ada pasien</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        @if($date == date('Y-m-d') && $patient->count() > 0)
            <div class="card">
                <div class="card-body">
                    <div class="text-end">
                        <button type="submit" class="btn btn-warning" onclick="onLoading('show', '.content')">
                            <i class="ph-floppy-disk me-1"></i>
                            Simpan Jadwal Makan
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </form>
</div>
