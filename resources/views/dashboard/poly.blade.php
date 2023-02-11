<div class="content">
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0 text-center text-uppercase fw-normal">Daftar Antrian Poli</h6>
        </div>
        <div class="card-body">
            <table class="table">
                @foreach($unit as $u)
                    @php $longLine = Simrs::todayLongLinePoly($u->id); @endphp
                    <tr>
                        <td>{{ $u->name }}</td>
                        <td>
                            Total Antrian : <a href="javascript:void(0);" class="fw-bold" data-bs-toggle="modal" data-bs-target="#modal-{{ $u->id }}">{{ $longLine->total }}</a>
                            <div id="modal-{{ $u->id }}" class="modal fade" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title">Antrian {{ $u->name }}</h6>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Pasien</th>
                                                        <th>Status</th>
                                                        <th>Antrian Ke</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($longLine->total > 0)
                                                        @foreach($longLine->data as $key => $d)
                                                            <tr>
                                                                <td>{{ $d->outpatient->patient->name }}</td>
                                                                <td>{{ $d->status() }}</td>
                                                                <td>{{ $key + 1 }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="3" class="text-center">Tidak ada antrian</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
