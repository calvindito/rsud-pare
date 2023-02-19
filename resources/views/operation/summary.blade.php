<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Operasi - <span class="fw-normal">Ringkasan</span>
            </h5>
        </div>
    </div>
</div>
<div class="content pt-0">
    <div class="card">
        <div class="card-header d-sm-flex align-items-sm-center py-sm-0">
            <h6 class="py-sm-3 mb-sm-0">Ringkasan Singkat Data Operasi</h6>
            <div class="ms-sm-auto my-sm-auto">
                <form>
                    @csrf
                    <div class="input-group">
                        <span class="input-group-text"><i class="ph-calendar"></i></span>
                        <select class="form-select wmin-100" name="year" id="year" onchange="onLoading('show', '.content'); this.form.submit()">
                            @for($i = date('Y'); $i >= 2018; $i--)
                                <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>Tahun {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="d-lg-flex">
                <ul class="nav nav-tabs nav-tabs-vertical nav-tabs-vertical-start wmin-lg-200 me-lg-3 mb-3 mb-lg-0">
                    <li class="nav-item">
                        <a href="#vertical-left-tab1" class="nav-link active" data-bs-toggle="tab">
                            Berdasarkan UPF
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#vertical-left-tab2" class="nav-link" data-bs-toggle="tab">
                            Berdasarkan Anestesi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#vertical-left-tab3" class="nav-link" data-bs-toggle="tab">
                            Berdasarkan Dokter Operasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#vertical-left-tab4" class="nav-link" data-bs-toggle="tab">
                            Berdasarkan Unit
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#vertical-left-tab5" class="nav-link" data-bs-toggle="tab">
                            Berdasarkan Status
                        </a>
                    </li>
                </ul>
                <div class="tab-content flex-lg-fill">
                    <div class="tab-pane fade show active" id="vertical-left-tab1">
                        <div class="table-fix-header">
                            <table class="table table-bordered table-hover table-xs">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Nama</th>
                                        <th>Total Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($functionalService as $key => $fs)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $fs->name }}</td>
                                            <td>{{ number_format($fs->operation_count) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="vertical-left-tab2">
                        <div class="table-fix-header">
                            <table class="table table-bordered table-hover table-xs">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Total Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($operatingRoomAnesthetist as $key => $ora)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $ora->code }}</td>
                                            <td>{{ $ora->name }}</td>
                                            <td>{{ number_format($ora->operation_count) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="vertical-left-tab3">
                        <div class="table-fix-header">
                            <table class="table table-bordered table-hover table-xs">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Nama</th>
                                        <th>Total Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($doctor as $key => $d)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $d->name }}</td>
                                            <td>{{ number_format($d->operation_count) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="vertical-left-tab4">
                        <div class="table-fix-header">
                            <table class="table table-bordered table-hover table-xs">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Nama</th>
                                        <th>Jenis</th>
                                        <th>Total Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($unit as $key => $u)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $u->name }}</td>
                                            <td>{{ $u->type_format_result }}</td>
                                            <td>{{ number_format($u->operation_count) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="vertical-left-tab5">
                        <div class="table-fix-header">
                            <table class="table table-bordered table-hover table-xs">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Status</th>
                                        <th>Total Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($status as $key => $s)
                                        <tr>
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td>{{ $s->name }}</td>
                                            <td>{{ number_format($s->total) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        fullWidthAllDevice();
    });
</script>
