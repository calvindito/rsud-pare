<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Dashboard - <span class="fw-normal">Kamar</span>
            </h5>
        </div>
    </div>
</div>
<div class="content">
    <div class="d-flex flex-column flex-lg-row">
        <div class="flex-1 order-2 order-lg-1">
            @if($bed->total() > 0)
                <div class="row">
                    @foreach($bed as $b)
                        <div class="col-md-6">
                            <div class="card">
			                    <div class="card-body text-center">
		                            <h4 class="mt-2 mb-3">{{ $b->name }}</h4>
		                            <h1 class="display-6 fw-semibold mb-0">
                                        {!! $b->inpatient()->where('status', 1)->count() > 0 ? '<i class="ph-check fw-bold text-success ph-3x"></i>' : '<i class="ph-prohibit fw-bold text-danger ph-3x"></i>' !!}
                                    </h1>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th class="text-start" width="10%">Pasien</th>
                                                <th width="1%">:</th>
                                                <td class="text-start">
                                                    @if($b->inpatient()->where('status', 1)->count() > 0)
                                                        {{ $b->inpatient()->where('status', 1)->orderByDesc('date_of_entry')->first()->patient->name ?? '-' }}
                                                    @else
                                                        Tidak Ada
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-start" width="10%">Unit</th>
                                                <th width="1%">:</th>
                                                <td class="text-start">{{ $b->roomSpace->roomType->room->unit->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-start" width="10%">Kamar</th>
                                                <th width="1%">:</th>
                                                <td class="text-start">{{ $b->roomSpace->roomType->room->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-start" width="10%">Kelas</th>
                                                <th width="1%">:</th>
                                                <td class="text-start">{{ $b->roomSpace->roomType->classType->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-start" width="10%">Tempat</th>
                                                <th width="1%">:</th>
                                                <td class="text-start">{{ $b->roomSpace->roomType->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-start" width="10%">Ruang</th>
                                                <th width="1%">:</th>
                                                <td class="text-start">{{ $b->roomSpace->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-start" width="10%">Status</th>
                                                <th width="1%">:</th>
                                                <td class="text-start">{{ $b->inpatient()->where('status', 1)->count() > 0 ? 'Sudah Ditempati' : 'Kosong' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
			                    </div>
		                        <div class="ribbon-container">
									<div class="ribbon @if($b->type == 1) {{ 'bg-primary' }} @elseif($b->type == 2) {{ 'bg-pink' }} @elseif($b->type == 3) {{ 'bg-indigo' }} @elseif($b->type == 4) {{ 'bg-secondary' }} @else {{ 'bg-warning' }} @endif text-white text-uppercase fs-sm fw-semibold shadow-sm">{{ $b->type_format_result }}</div>
								</div>
							</div>
                        </div>
                    @endforeach
                </div>
                {{ $bed->withQueryString()->onEachSide(1)->links('pagination') }}
            @else
                <div class="text-center">
                    <img src="{{ asset('template/assets/images/error_bg.svg') }}" class="img-fluid mb-3" height="230" alt="">
                    <h1 class="display-4 fw-semibold lh-1 mb-3">Mohon Maaf</h1>
                    <h5 class="mx-md-auto">Data Tidak Ada</h5>
                </div>
            @endif
        </div>
        <div class="sidebar sidebar-component sidebar-expand-lg border rounded shadow-sm order-1 order-lg-2 ms-lg-3 mb-3">
            <form action="">
                @csrf
                <div class="sidebar-content">
                    <div class="sidebar-section">
                        <div class="sidebar-section-header border-bottom">
                            <span class="fw-semibold">Cari Pasien</span>
                        </div>

                        <div class="sidebar-section-body">
                            <div class="form-control-feedback form-control-feedback-end">
                                <input type="search" class="form-control" name="search" value="{{ $search }}" placeholder="Nama / No KTP / No RM">
                                <div class="form-control-feedback-icon">
                                    <i class="ph-magnifying-glass"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-section">
                        <div class="sidebar-section-header border-bottom">
                            <span class="fw-semibold">Unit</span>
                        </div>
                        <div class="sidebar-section-body">
                            <div class="overflow-auto" style="max-height:181px;">
                                @if($unitId)
                                    @foreach($unitId as $ui)
                                        @php $row = App\Models\Unit::find($ui); @endphp
                                        <label class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" name="unit_id[]" value="{{ $row->id }}" onclick="this.form.submit(); onLoading('show', '.content')" checked>
                                            <span class="form-check-label">{{ $row->name }}</span>
                                        </label>
                                    @endforeach
                                @endif
                                @foreach($unit as $u)
                                    <label class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" name="unit_id[]" value="{{ $u->id }}" onclick="this.form.submit(); onLoading('show', '.content')">
                                        <span class="form-check-label">{{ $u->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-section">
                        <div class="sidebar-section-header border-bottom">
                            <span class="fw-semibold">Kamar</span>
                        </div>
                        <div class="sidebar-section-body">
                            <div class="overflow-auto" style="max-height:181px;">
                                @if($roomId)
                                    @foreach($roomId as $ri)
                                        @php $row = App\Models\Room::find($ri); @endphp
                                        <label class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" name="room_id[]" value="{{ $row->id }}" onclick="this.form.submit(); onLoading('show', '.content')" checked>
                                            <span class="form-check-label">{{ $row->name }}</span>
                                        </label>
                                    @endforeach
                                @endif
                                @foreach($room as $r)
                                    <label class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" name="room_id[]" value="{{ $r->id }}" onclick="this.form.submit(); onLoading('show', '.content')">
                                        <span class="form-check-label">{{ $r->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-section">
                        <div class="sidebar-section-header border-bottom">
                            <span class="fw-semibold">Kelas</span>
                        </div>
                        <div class="sidebar-section-body">
                            <div class="overflow-auto" style="max-height:181px;">
                                @if($classTypeId)
                                    @foreach($classTypeId as $cti)
                                        @php $row = App\Models\ClassType::find($cti); @endphp
                                        <label class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" name="class_type_id[]" value="{{ $row->id }}" onclick="this.form.submit(); onLoading('show', '.content')" checked>
                                            <span class="form-check-label">{{ $row->name }}</span>
                                        </label>
                                    @endforeach
                                @endif
                                @foreach($classType as $ct)
                                    <label class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" name="class_type_id[]" value="{{ $ct->id }}" onclick="this.form.submit(); onLoading('show', '.content')">
                                        <span class="form-check-label">{{ $ct->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-section">
                        <div class="sidebar-section-header border-bottom">
                            <span class="fw-semibold">Tempat</span>
                        </div>
                        <div class="sidebar-section-body">
                            <div class="overflow-auto" style="max-height:181px;">
                                @if($roomTypeId)
                                    @foreach($roomTypeId as $rti)
                                        @php $row = App\Models\RoomType::find($rti); @endphp
                                        <label class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" name="room_type_id[]" value="{{ $row->id }}" onclick="this.form.submit(); onLoading('show', '.content')" checked>
                                            <span class="form-check-label">{{ $row->name }}</span>
                                        </label>
                                    @endforeach
                                @endif
                                @foreach($roomType as $rt)
                                    <label class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" name="room_type_id[]" value="{{ $rt->id }}" onclick="this.form.submit(); onLoading('show', '.content')">
                                        <span class="form-check-label">{{ $rt->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-section">
                        <div class="sidebar-section-header border-bottom">
                            <span class="fw-semibold">Ruang</span>
                        </div>
                        <div class="sidebar-section-body">
                            <div class="overflow-auto" style="max-height:181px;">
                                @if($roomSpaceId)
                                    @foreach($roomSpaceId as $rsi)
                                        @php $row = App\Models\RoomSpace::find($rsi); @endphp
                                        <label class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" name="room_space_id[]" value="{{ $row->id }}" onclick="this.form.submit(); onLoading('show', '.content')" checked>
                                            <span class="form-check-label">{{ $row->name }}</span>
                                        </label>
                                    @endforeach
                                @endif
                                @foreach($roomSpace as $rs)
                                    <label class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" name="room_space_id[]" value="{{ $rs->id }}" onclick="this.form.submit(); onLoading('show', '.content')">
                                        <span class="form-check-label">{{ $rs->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-section">
                        <div class="sidebar-section-header border-bottom">
                            <span class="fw-semibold">Jenis</span>
                        </div>
                        <div class="sidebar-section-body">
                            @foreach($type as $t)
                                <label class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" name="type_id[]" value="{{ $t['id'] }}" onclick="this.form.submit(); onLoading('show', '.content')" {{ in_array($t['id'], $typeId) ? 'checked' : '' }}>
                                    <span class="form-check-label">{{ $t['name'] }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="sidebar-section">
                        <div class="sidebar-section-header border-bottom">
                            <span class="fw-semibold">Status</span>
                        </div>
                        <div class="sidebar-section-body">
                            <div class="form-check mb-2">
                                <input type="radio" class="form-check-input" name="status" value="" id="status-all" onclick="this.form.submit(); onLoading('show', '.content')" {{ is_null($status) ? 'checked' : '' }}>
                                <label class="form-check-label" for="status-all">Semua</label>
                            </div>
                            <div class="form-check mb-2">
                                <input type="radio" class="form-check-input" name="status" value="already-occupied" id="status-already-occupied" onclick="this.form.submit(); onLoading('show', '.content')" {{ $status == 'already-occupied' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status-already-occupied">Sudah Ditempati</label>
                            </div>
                            <div class="form-check mb-2">
                                <input type="radio" class="form-check-input" name="status" value="empty" id="status-empty" onclick="this.form.submit(); onLoading('show', '.content')" {{ $status == 'empty' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status-empty">Kosong</label>
                            </div>
                        </div>
                    </div>
                    <div class="border-top mb-2">
                        <ul class="nav nav-sidebar mt-3">
                            <li class="nav-item pt-0">
                                <a href="javascript:void(0);" class="nav-link no-click bg-transparent">
                                    Total Data <span class="fw-normal text-muted align-self-center ms-auto">{{ number_format($bed->total()) }}</span>
                                </a>
                            </li>
                            <li class="nav-item pt-0">
                                <a href="javascript:void(0);" class="nav-link no-click bg-transparent">
                                    Total Yang Ditampilkan <span class="fw-normal text-muted align-self-center ms-auto">{{ number_format($bed->count()) }}</span>
                                </a>
                            </li>
                            <li class="nav-item pt-0">
                                <a href="javascript:void(0);" class="nav-link no-click bg-transparent">
                                    Total Halaman <span class="fw-normal text-muted align-self-center ms-auto">{{ number_format($bed->lastPage()) }}</span>
                                </a>
                            </li>
                            <li class="nav-item pt-0">
                                <a href="javascript:void(0);" class="nav-link no-click bg-transparent">
                                    Per Halaman <span class="fw-normal text-muted align-self-center ms-auto">{{ number_format($bed->perPage()) }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="sidebar-section">
                        <a href="{{ url('dashboard/room') }}" class="btn btn-danger col-12 text-center rounded-top-0" onclick="onLoading('show', '.content')">Reset Semua Filter</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
