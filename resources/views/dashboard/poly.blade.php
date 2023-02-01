<div class="content">
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0 text-center text-uppercase fw-normal">Daftar Antrian Poli</h6>
        </div>
        <div class="card-body">
            <table class="table">
                @foreach($unit as $u)
                    <tr>
                        <td>{{ $u->name }}</td>
                        <td>
                            Total Antrian : <a href="javascript:void(0);" class="fw-bold" data-bs-toggle="modal" data-bs-target="#modal-{{ $u->id }}">{{ $u->outpatientPoly->count() }}</a>
                            <div id="modal-{{ $u->id }}" class="modal fade" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title">{{ $u->name }}</h6>
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
                                                    @if($u->outpatientPoly->count() > 0)
                                                        @foreach($u->outpatientPoly as $key => $op)
                                                            <tr>
                                                                <td>{{ $op->outpatient->patient->name }}</td>
                                                                <td>{{ $op->status() }}</td>
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
                    {{-- @foreach($u->outpatientPoly as $key => $op)
                        <tr>
                            <td>{{ $u->name }}</td>
                            <td>Pasien : <b>{{ $op->outpatient->patient->name }}</b></td>
                            <td>Antrian Ke : <b>{{ $key + 1 }}</b></td>
                        </tr>
                    @endforeach --}}
                @endforeach
            </table>
        </div>
    </div>
</div>
