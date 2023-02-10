<div class="page-header page-header-light border rounded mb-3">
    <div class="page-header-content d-flex">
        <div class="page-title">
            <h5 class="mb-0">
                Pendataan - Rawat Inap - <span class="fw-normal">E-Resep</span>
            </h5>
        </div>
        <div class="my-auto ms-auto">
            <a href="{{ url('collection/inpatient') }}" class="btn btn-flat-primary">Kembali ke Daftar</a>
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
                        <th class="align-middle">No RM</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $patient->id }}</td>
                        <th class="align-middle">Jenis Kelamin</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $patient->gender_format_result }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Nama</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $patient->name }}</td>
                        <th class="align-middle">Alamat</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $patient->address }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Tanggal Masuk</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $inpatient->date_of_entry }}</td>
                        <th class="align-middle">Kamar</th>
                        <td class="align-middle" width="1%">:</td>
                        <td class="align-middle">{{ $inpatient->roomType->name . ' | ' . $inpatient->roomType->classType->name }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <form action="" method="POST">
        @csrf
        <div class="card">
            @if($inpatient->status == 1)
                <div class="card-header">
                    <h6 class="hstack gap-2 mb-0">Pilih Obat</h6>
                </div>
            @endif
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @elseif(session('success'))
                    <div class="alert bg-success text-white fade show text-center">
                        {{ session('success') }}
                    </div>
                @elseif(session('error'))
                    <div class="alert bg-danger text-white fade show text-center">
                        {{ session('error') }}
                    </div>
                @endif
                @if($inpatient->status == 1)
                    <select class="form-control listbox" name="recipe[]" id="recipe" multiple>
                        @foreach($medicine as $m)
                            <option value="{{ $m->id }}" {{ $recipe->firstWhere('medicine_id', $m->id) ? 'selected' : '' }}>{{ $m->name }}</option>
                        @endforeach
                    </select>
                @else
                    <table class="table table-bordered table-hover table-xs">
                        <thead>
                            <tr>
                                <th class="text-center" nowrap>No</th>
                                <th nowrap>Obat</th>
                                <th nowrap>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($recipe->count() > 0)
                                @foreach($recipe as $key => $r)
                                    <tr>
                                        <td class="text-center align-middle">{{ $key + 1 }}</td>
                                        <td class="align-middle">{{ $r->medicine->name }}</td>
                                        <td class="align-middle">1</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center" colspan="3">Tidak ada obat yang dipilih</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                @endif
            </div>
            @if($inpatient->status == 1)
                <div class="card-footer">
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary" onclick="onLoading('show', '.content')">
                            <i class="ph-paper-plane-tilt me-2"></i>
                            Submit
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    $(function() {
        sidebarMini();

        listBox('#recipe', {
            showAddButton: false,
            showAddAllButton: false,
            showRemoveButton: false,
            showRemoveAllButton: false
        });

        $('.dual-listbox__search').attr('placeholder', 'Cari nama obat ...');
        $('.dual-listbox__container .dual-listbox__title').eq(0).html('Obat Yang Tersedia');
        $('.dual-listbox__container .dual-listbox__title').eq(1).html('Obat Yang Dipilih');
    });
</script>
