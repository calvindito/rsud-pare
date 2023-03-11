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
                    <a href="javascript:void(0);" class="dropdown-item" onclick="onReloadTable()">Data</a>
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
                <table class="table table-bordered table-hover">
                    <thead class="table-primary sticky-top">
                        <tr>
                            <th>Kamar</th>
                            @foreach($eatingTime as $et)
                                <th>{{ $et->type_format_result }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roomType as $rt)
                            <tr>
                                <input type="hidden" name="room_type_id[]" value="{{ $rt->id }}">
                                <td nowrap>{{ $rt->name . ' | ' . $rt->classType->name }}</td>
                                @foreach($eatingTime as $key => $et)
                                    @php $hasData = App\Models\Eating::whereDate('date', $date)->where('eating_time_id', $et->id)->where('room_type_id', $rt->id)->first(); @endphp
                                    <input type="hidden" name="eating_time_{{ $rt->id }}[]" value="{{ $et->id }}">
                                    <td>
                                        <div class="form-group">
                                            <input type="number" class="form-control" name="portion_{{ $rt->id }}[]" value="{{ old("portion_$rt->id.$key", $hasData->portion ?? '') }}" placeholder="Porsi">
                                        </div>
                                        <select class="form-select" name="food_{{ $rt->id }}[]">
                                            <option value="">Tidak Ada</option>
                                            @foreach($food as $f)
                                                <option value="{{ $f->id }}" {{ old("food_$rt->id.$key", $hasData->food_id ?? '') == $f->id ? 'selected' : '' }}>
                                                    {{ $f->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if($date == date('Y-m-d'))
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

<script>
    $(function() {
        sidebarMini();
    });
</script>
