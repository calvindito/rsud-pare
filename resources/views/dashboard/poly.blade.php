<div class="content">
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0 text-center text-uppercase fw-normal">Daftar Antrian Poli</h6>
        </div>
        <div class="card-body">
            <table class="table">
                @foreach($unit as $u)
                    {{-- @php $currentLongLine = Simrs::currentLongLine($u->id); @endphp
                    <tr>
                        <td>{{ $u->name }}</td>
                        <td>Pasien : <b>{{ isset($currentLongLine->patient) ? $currentLongLine->patient->name : '-' }}</b></td>
                        <td>Antrian Ke : <b>{{ $currentLongLine->active }}</b></td>
                    </tr> --}}
                    @foreach($u->outpatientPoly as $key => $op)
                        <tr>
                            <td>{{ $u->name }}</td>
                            <td>Pasien : <b>{{ $op->outpatient->patient->name }}</b></td>
                            <td>Antrian Ke : <b>{{ $key + 1 }}</b></td>
                        </tr>
                    @endforeach
                @endforeach
            </table>
        </div>
    </div>
</div>
