
<div class="content">
    <div class="accordion" id="accordion_collapsed">
        <div class="card">
            <div class="card-body py-0">
                <div class="accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapsed_item1">
                            Pendaftaran Pasien Umum
                        </button>
                    </h2>
                    <div id="collapsed_item1" class="accordion-collapse collapse" data-bs-parent="#accordion_collapsed">
                        <div class="accordion-body">
                            <div class="d-lg-flex justify-content-lg-between">
                                <ul class="nav nav-pills nav-pills-outline nav-pills-toolbar flex-column wmin-lg-250 me-lg-3 mb-3 mb-lg-0">
                                    <li class="nav-item">
                                        <a href="#pill-1-1" class="nav-link active" data-bs-toggle="tab">Data Pasien</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pill-1-2" class="nav-link" data-bs-toggle="tab">Data Pribadi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pill-1-3" class="nav-link" data-bs-toggle="tab">Alamat</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pill-1-4" class="nav-link" data-bs-toggle="tab">Poli Tujuan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pill-1-5" class="nav-link" data-bs-toggle="tab">Riwayat Kunjungan Poli</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pill-1-6" class="nav-link" data-bs-toggle="tab">Riwayat Kunjungan Rawat Inap</a>
                                    </li>
                                </ul>
                                <div class="tab-content flex-1">
                                    <div class="tab-pane fade show active" id="pill-1-1">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Nomor RM</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="{{ rand(0000000, 9999999) }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Nomor Identitas</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="{{ rand(0000000000000000, 9999999999999999) }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Nomor Peserta</label>
                                                    <div class="col-lg-9">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control">
                                                            <button class="btn btn-primary" type="button">
                                                                <i class="ph-magnifying-glass me-2"></i>
                                                                Cari Nomor
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Nama</label>
                                                    <div class="col-lg-9">
                                                        <div class="input-group">
                                                            <select class="form-select w-auto flex-grow-0">
                                                                <option selected>Tuan</option>
                                                                <option>Nyonya</option>
                                                            </select>
                                                            <input type="text" class="form-control" value="{{ $faker->name }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Jenis Kelamin</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Laki - Laki</option>
                                                            <option>Perempuan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Tanggal Lahir</label>
                                                    <div class="col-lg-9">
                                                        <input type="date" class="form-control" value="{{ $faker->date('Y-m-d') }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Agama</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Islam</option>
                                                            <option>Kristen</option>
                                                            <option>Katolik</option>
                                                            <option>Hindu</option>
                                                            <option>Budha</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pill-1-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Tempat Lahir</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="{{ $faker->city }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Golongan Darah</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>A</option>
                                                            <option>B</option>
                                                            <option>AB</option>
                                                            <option>O</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Status Perkawinan</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Lajang</option>
                                                            <option>Menikah</option>
                                                            <option>Cerai Hidup</option>
                                                            <option>Cerai Mati</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Pekerjaan</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="{{ $faker->jobTitle }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Suku</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="Jawa">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Telepon</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="{{ $faker->phoneNumber }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Nama Ayah</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="{{ $faker->name }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Nama Suami / Istri</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="{{ $faker->name }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pill-1-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Provinsi</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Jawa Timur</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Kota</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Surabaya</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Kecamatan</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Sawahan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Desa</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Pakis</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">RT</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="00{{ rand(1, 9) }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">RW</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="00{{ rand(1, 9) }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Jalan / Dusun</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="{{ $faker->streetAddress }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pill-1-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Golongan</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Umum</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Tanggal Periksa</label>
                                                    <div class="col-lg-9">
                                                        <input type="date" class="form-control" value="{{ $faker->date('Y-m-d') }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Jam Daftar</label>
                                                    <div class="col-lg-9">
                                                        <input type="time" class="form-control" value="{{ $faker->time('H:i') }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Kehadiran</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Datang Sendiri</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="line"></div>
                                                <div class="alert alert-light border-trans">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control">
                                                        <button class="btn btn-light" type="button">
                                                            <i class="ph-plus me-2"></i>
                                                            Tambah Poli
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <label class="col-lg-2 col-form-label">Poli 1</label>
                                                    <div class="col-lg-10">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" value="Anak">
                                                            <button class="btn btn-danger" type="button">
                                                                <i class="ph-trash me-2"></i>
                                                                Hapus
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <label class="col-lg-2 col-form-label">Poli 2</label>
                                                    <div class="col-lg-10">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" value="Penyakit Dalam">
                                                            <button class="btn btn-danger" type="button">
                                                                <i class="ph-trash me-2"></i>
                                                                Hapus
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <label class="col-lg-2 col-form-label">Poli 3</label>
                                                    <div class="col-lg-10">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" value="Jantung">
                                                            <button class="btn btn-danger" type="button">
                                                                <i class="ph-trash me-2"></i>
                                                                Hapus
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <label class="col-lg-2 col-form-label">Poli 4</label>
                                                    <div class="col-lg-10">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" value="Saraf">
                                                            <button class="btn btn-danger" type="button">
                                                                <i class="ph-trash me-2"></i>
                                                                Hapus
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="line"></div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Keterangan</label>
                                                    <div class="col-lg-9">
                                                        <textarea class="form-control">{{ $faker->sentence(10, true) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pill-1-5">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" nowrap>No</th>
                                                            <th nowrap>Tanggal MRS</th>
                                                            <th nowrap>Jam MRS</th>
                                                            <th nowrap>Golongan</th>
                                                            <th nowrap>Kehadiran</th>
                                                            <th nowrap>Poli Tujuan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <tr>
                                                                <td class="text-center align-middle">{{ $i }}</td>
                                                                <td class="align-middle">{{ $faker->date('d/m/Y') }}</td>
                                                                <td class="align-middle">{{ $faker->time('H:i') }}</td>
                                                                <td class="align-middle">Umum</td>
                                                                <td class="align-middle">Datang Sendiri</td>
                                                                <td class="align-middle">Jantung</td>
                                                            </tr>
                                                        @endfor
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pill-1-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" nowrap>No</th>
                                                            <th nowrap>Tanggal MRS</th>
                                                            <th nowrap>Jam MRS</th>
                                                            <th nowrap>Golongan</th>
                                                            <th nowrap>Kamar</th>
                                                            <th nowrap>DPJP</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <tr>
                                                                <td class="text-center align-middle">{{ $i }}</td>
                                                                <td class="align-middle">{{ $faker->date('d/m/Y') }}</td>
                                                                <td class="align-middle">{{ $faker->time('H:i') }}</td>
                                                                <td class="align-middle">Umum</td>
                                                                <td class="align-middle">IGD</td>
                                                                <td class="align-middle">dr. Ellen Trio Sukma Dewi</td>
                                                            </tr>
                                                        @endfor
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="line"></div>
                            <div class="text-end">
                                <button type="button" class="btn btn-success">
                                    <i class="ph-check-circle me-2"></i>
                                    Daftarkan Pasien Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-0">
                <div class="accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapsed_item2">
                            Pendaftaran IGD
                        </button>
                    </h2>
                    <div id="collapsed_item2" class="accordion-collapse collapse" data-bs-parent="#accordion_collapsed">
                        <div class="accordion-body">
                            <div class="d-lg-flex justify-content-lg-between">
                                <ul class="nav nav-pills nav-pills-outline nav-pills-toolbar flex-column wmin-lg-250 me-lg-3 mb-3 mb-lg-0">
                                    <li class="nav-item">
                                        <a href="#pill-2-1" class="nav-link active" data-bs-toggle="tab">Data Pasien</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pill-2-2" class="nav-link" data-bs-toggle="tab">Alamat</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pill-2-3" class="nav-link" data-bs-toggle="tab">IGD</a>
                                    </li>
                                </ul>
                                <div class="tab-content flex-1">
                                    <div class="tab-pane fade show active" id="pill-2-1">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Nomor RM</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="{{ rand(0000000, 9999999) }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Nomor Identitas</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="{{ rand(0000000000000000, 9999999999999999) }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Nomor Peserta</label>
                                                    <div class="col-lg-9">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control">
                                                            <button class="btn btn-primary" type="button">
                                                                <i class="ph-magnifying-glass me-2"></i>
                                                                Cari Nomor
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Nama</label>
                                                    <div class="col-lg-9">
                                                        <div class="input-group">
                                                            <select class="form-select w-auto flex-grow-0">
                                                                <option selected>Tuan</option>
                                                                <option>Nyonya</option>
                                                            </select>
                                                            <input type="text" class="form-control" value="{{ $faker->name }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Jenis Kelamin</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Laki - Laki</option>
                                                            <option>Perempuan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Tanggal Lahir</label>
                                                    <div class="col-lg-9">
                                                        <input type="date" class="form-control" value="{{ $faker->date('Y-m-d') }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Agama</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Islam</option>
                                                            <option>Kristen</option>
                                                            <option>Katolik</option>
                                                            <option>Hindu</option>
                                                            <option>Budha</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pill-2-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Provinsi</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Jawa Timur</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Kota</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Surabaya</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Kecamatan</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Sawahan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Desa</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Pakis</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">RT</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="00{{ rand(1, 9) }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">RW</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="00{{ rand(1, 9) }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Jalan / Dusun</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="{{ $faker->streetAddress }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pill-2-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Jenis Pasien</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option>-- Pilih --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Tanggal Masuk</label>
                                                    <div class="col-lg-9">
                                                        <input type="date" class="form-control" value="{{ $faker->date('Y-m-d') }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Jam Masuk</label>
                                                    <div class="col-lg-9">
                                                        <input type="time" class="form-control" value="{{ $faker->time('H:i') }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Kehadiran</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Datang Sendiri</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">UPF</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Bedah Mulut</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">DPJP</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="drg. Joko Widiastomo, Sp. BM.">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="line"></div>
                            <div class="text-end">
                                <button type="button" class="btn btn-success">
                                    <i class="ph-check-circle me-2"></i>
                                    Daftarkan Pasien Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-0">
                <div class="accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapsed_item3">
                            Pendaftaran Rawat Inap
                        </button>
                    </h2>
                    <div id="collapsed_item3" class="accordion-collapse collapse" data-bs-parent="#accordion_collapsed">
                        <div class="accordion-body">
                            <div class="d-lg-flex justify-content-lg-between">
                                <ul class="nav nav-pills nav-pills-outline nav-pills-toolbar flex-column wmin-lg-250 me-lg-3 mb-3 mb-lg-0">
                                    <li class="nav-item">
                                        <a href="#pill-3-1" class="nav-link active" data-bs-toggle="tab">Data Pasien</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pill-3-2" class="nav-link" data-bs-toggle="tab">Riwayat Kunjungan Poli</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pill-3-3" class="nav-link" data-bs-toggle="tab">Riwayat Kunjungan Rawat Inap</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pill-3-4" class="nav-link" data-bs-toggle="tab">Kamar Tujuan</a>
                                    </li>
                                </ul>
                                <div class="tab-content flex-1">
                                    <div class="tab-pane fade show active" id="pill-3-1">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Nomor RM</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="{{ rand(0000000, 9999999) }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Nomor Identitas</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="{{ rand(0000000000000000, 9999999999999999) }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Nomor Peserta</label>
                                                    <div class="col-lg-9">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control">
                                                            <button class="btn btn-primary" type="button">
                                                                <i class="ph-magnifying-glass me-2"></i>
                                                                Cari Nomor
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Nama</label>
                                                    <div class="col-lg-9">
                                                        <div class="input-group">
                                                            <select class="form-select w-auto flex-grow-0">
                                                                <option selected>Tuan</option>
                                                                <option>Nyonya</option>
                                                            </select>
                                                            <input type="text" class="form-control" value="{{ $faker->name }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Jenis Kelamin</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Laki - Laki</option>
                                                            <option>Perempuan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Tanggal Lahir</label>
                                                    <div class="col-lg-9">
                                                        <input type="date" class="form-control" value="{{ $faker->date('Y-m-d') }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Agama</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Islam</option>
                                                            <option>Kristen</option>
                                                            <option>Katolik</option>
                                                            <option>Hindu</option>
                                                            <option>Budha</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pill-3-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" nowrap>No</th>
                                                            <th nowrap>Tanggal MRS</th>
                                                            <th nowrap>Jam MRS</th>
                                                            <th nowrap>Golongan</th>
                                                            <th nowrap>Kehadiran</th>
                                                            <th nowrap>Poli Tujuan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <tr>
                                                                <td class="text-center align-middle">{{ $i }}</td>
                                                                <td class="align-middle">{{ $faker->date('d/m/Y') }}</td>
                                                                <td class="align-middle">{{ $faker->time('H:i') }}</td>
                                                                <td class="align-middle">Umum</td>
                                                                <td class="align-middle">Datang Sendiri</td>
                                                                <td class="align-middle">Jantung</td>
                                                            </tr>
                                                        @endfor
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pill-3-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" nowrap>No</th>
                                                            <th nowrap>Tanggal MRS</th>
                                                            <th nowrap>Jam MRS</th>
                                                            <th nowrap>Golongan</th>
                                                            <th nowrap>Kamar</th>
                                                            <th nowrap>DPJP</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <tr>
                                                                <td class="text-center align-middle">{{ $i }}</td>
                                                                <td class="align-middle">{{ $faker->date('d/m/Y') }}</td>
                                                                <td class="align-middle">{{ $faker->time('H:i') }}</td>
                                                                <td class="align-middle">Umum</td>
                                                                <td class="align-middle">IGD</td>
                                                                <td class="align-middle">dr. Ellen Trio Sukma Dewi</td>
                                                            </tr>
                                                        @endfor
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pill-3-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Tanggal Masuk</label>
                                                    <div class="col-lg-9">
                                                        <input type="date" class="form-control" value="{{ $faker->date('Y-m-d') }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Jam Masuk</label>
                                                    <div class="col-lg-9">
                                                        <input type="time" class="form-control" value="{{ $faker->time('H:i') }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Jenis Pasien</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Umum</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Kamar</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">UPF</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option>-- Pilih --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="line"></div>
                            <div class="text-end">
                                <button type="button" class="btn btn-success">
                                    <i class="ph-check-circle me-2"></i>
                                    Daftarkan Pasien Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-0">
                <div class="accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapsed_item4">
                            Data Rawat Inap
                        </button>
                    </h2>
                    <div id="collapsed_item4" class="accordion-collapse collapse" data-bs-parent="#accordion_collapsed">
                        <div class="accordion-body">
                            <div class="d-lg-flex justify-content-lg-between">
                                <ul class="nav nav-pills nav-pills-outline nav-pills-toolbar flex-column wmin-lg-250 me-lg-3 mb-3 mb-lg-0">
                                    <li class="nav-item">
                                        <a href="#pill-4-1" class="nav-link active" data-bs-toggle="tab">Data Pasien</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pill-4-2" class="nav-link" data-bs-toggle="tab">Pelayanan Medik</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pill-4-3" class="nav-link" data-bs-toggle="tab">Tindakan Medik Operasi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pill-4-4" class="nav-link" data-bs-toggle="tab">Tindakan Medik Non Operasi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pill-4-5" class="nav-link" data-bs-toggle="tab">Penunjang</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pill-4-5" class="nav-link" data-bs-toggle="tab">Obat & Alat Kesehatan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pill-4-6" class="nav-link" data-bs-toggle="tab">Lain - Lain</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pill-4-7" class="nav-link" data-bs-toggle="tab">Total Keseluruhan</a>
                                    </li>
                                </ul>
                                <div class="tab-content flex-1">
                                    <div class="tab-pane fade show active" id="pill-4-1">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td class="align-middle fw-bold">Nama Pasien</td>
                                                            <td class="align-middle" width="1%" class="text-center">:</td>
                                                            <td class="align-middle">{{ $faker->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle fw-bold">No Registrasi</td>
                                                            <td class="align-middle" width="1%" class="text-center">:</td>
                                                            <td class="align-middle">{{ rand(000000, 999999) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle fw-bold">Tanggal Masuk</td>
                                                            <td class="align-middle" width="1%" class="text-center">:</td>
                                                            <td class="align-middle">{{ $faker->date('d/m/Y') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle fw-bold">Tanggal Keluar</td>
                                                            <td class="align-middle" width="1%" class="text-center">:</td>
                                                            <td class="align-middle">{{ $faker->date('d/m/Y') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle fw-bold">Perawatan</td>
                                                            <td class="align-middle" width="1%" class="text-center">:</td>
                                                            <td class="align-middle">Bersalin</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle fw-bold">Kelas</td>
                                                            <td class="align-middle" width="1%" class="text-center">:</td>
                                                            <td class="align-middle">III</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle fw-bold">Lama Perawatan</td>
                                                            <td class="align-middle" width="1%" class="text-center">:</td>
                                                            <td class="align-middle">2 Hari</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle fw-bold">Alamat</td>
                                                            <td class="align-middle" width="1%" class="text-center">:</td>
                                                            <td class="align-middle">Kunjang Kunjang</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle fw-bold">Dokter</td>
                                                            <td class="align-middle" width="1%" class="text-center">:</td>
                                                            <td class="align-middle">dr. Hamidah Tri Handajani, Sp</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="align-middle fw-bold">Status</td>
                                                            <td class="align-middle" width="1%" class="text-center">:</td>
                                                            <td class="align-middle">
                                                                <span class="badge bg-success">
                                                                    <i class="ph-check-circle"></i>
                                                                    Pasien Pulang
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pill-4-2">
                                        <h1 class="text-center fw-bold text-muted mt-5">Coming Soon ...</h1>
                                    </div>
                                    <div class="tab-pane fade" id="pill-4-3">
                                        <h1 class="text-center fw-bold text-muted mt-5">Coming Soon ...</h1>
                                    </div>
                                    <div class="tab-pane fade" id="pill-4-4">
                                        <h1 class="text-center fw-bold text-muted mt-5">Coming Soon ...</h1>
                                    </div>
                                    <div class="tab-pane fade" id="pill-4-5">
                                        <h1 class="text-center fw-bold text-muted mt-5">Coming Soon ...</h1>
                                    </div>
                                    <div class="tab-pane fade" id="pill-4-6">
                                        <h1 class="text-center fw-bold text-muted mt-5">Coming Soon ...</h1>
                                    </div>
                                    <div class="tab-pane fade" id="pill-4-7">
                                        <h1 class="text-center fw-bold text-muted mt-5">Coming Soon ...</h1>
                                    </div>
                                    <div class="tab-pane fade" id="pill-4-8">
                                        <h1 class="text-center fw-bold text-muted mt-5">Coming Soon ...</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-0">
                <div class="accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapsed_item5">
                            Rincian Biaya
                        </button>
                    </h2>
                    <div id="collapsed_item5" class="accordion-collapse collapse" data-bs-parent="#accordion_collapsed">
                        <div class="accordion-body">
                            <h1 class="text-center fw-bold text-muted mb-0">Coming Soon ...</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-0">
                <div class="accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapsed_item6">
                            Data Kamar Operasi
                        </button>
                    </h2>
                    <div id="collapsed_item6" class="accordion-collapse collapse" data-bs-parent="#accordion_collapsed">
                        <div class="accordion-body">
                            <div class="d-lg-flex justify-content-lg-between">
                                <ul class="nav nav-pills nav-pills-outline nav-pills-toolbar flex-column wmin-lg-250 me-lg-3 mb-3 mb-lg-0">
                                    <li class="nav-item">
                                        <a href="#pill-6-1" class="nav-link active" data-bs-toggle="tab">Data Pasien</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pill-6-2" class="nav-link" data-bs-toggle="tab">Alamat</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pill-6-3" class="nav-link" data-bs-toggle="tab">OK</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pill-6-4" class="nav-link" data-bs-toggle="tab">Tindakan OK</a>
                                    </li>
                                </ul>
                                <div class="tab-content flex-1">
                                    <div class="tab-pane fade show active" id="pill-6-1">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Nomor RM</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="{{ rand(0000000, 9999999) }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Nomor Identitas</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="{{ rand(0000000000000000, 9999999999999999) }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Nomor Peserta</label>
                                                    <div class="col-lg-9">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control">
                                                            <button class="btn btn-primary" type="button">
                                                                <i class="ph-magnifying-glass me-2"></i>
                                                                Cari Nomor
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Nama</label>
                                                    <div class="col-lg-9">
                                                        <div class="input-group">
                                                            <select class="form-select w-auto flex-grow-0">
                                                                <option selected>Tuan</option>
                                                                <option>Nyonya</option>
                                                            </select>
                                                            <input type="text" class="form-control" value="{{ $faker->name }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Jenis Kelamin</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Laki - Laki</option>
                                                            <option>Perempuan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Tanggal Lahir</label>
                                                    <div class="col-lg-9">
                                                        <input type="date" class="form-control" value="{{ $faker->date('Y-m-d') }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Agama</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Islam</option>
                                                            <option>Kristen</option>
                                                            <option>Katolik</option>
                                                            <option>Hindu</option>
                                                            <option>Budha</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pill-6-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Provinsi</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Jawa Timur</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Kota</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Surabaya</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Kecamatan</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Sawahan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Desa</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Pakis</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">RT</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="00{{ rand(1, 9) }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">RW</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="00{{ rand(1, 9) }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Jalan / Dusun</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control" value="{{ $faker->streetAddress }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pill-6-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Unit</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Kamar Bersalin</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Tanggal Operasi</label>
                                                    <div class="col-lg-9">
                                                        <input type="date" class="form-control" value="{{ $faker->date('Y-m-d') }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Diagnosa</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Jenis Operasi</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option>-- Pilih --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Cito Elektif</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option>-- Pilih --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">UPF</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option selected>Bedah Mulut</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pill-6-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Jenis Anastesi</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option>-- Pilih --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Dokter Anastesi</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Asisten Dokter</label>
                                                    <div class="col-lg-9">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-lg-3 col-form-label">Spesimen</label>
                                                    <div class="col-lg-9">
                                                        <select class="form-select">
                                                            <option>Ya</option>
                                                            <option>Tidak</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="line"></div>
                            <div class="text-end">
                                <button type="button" class="btn btn-primary">
                                    <i class="ph-check-circle me-2"></i>
                                    Daftarkan Pasien Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-0">
                <div class="accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapsed_item7">
                            Laporan
                        </button>
                    </h2>
                    <div id="collapsed_item7" class="accordion-collapse collapse" data-bs-parent="#accordion_collapsed">
                        <div class="accordion-body">
                            <div class="card">
                                <div class="card-header">
                                    <span class="fw-semibold">Filter</span>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <label class="col-lg-2 col-form-label">Tanggal</label>
                                        <div class="col-lg-10">
                                            <div class="input-group">
                                                <input type="date" class="form-control">
                                                <span class="input-group-text">s/d</span>
                                                <input type="date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-lg-2 col-form-label">Jenis PX</label>
                                        <div class="col-lg-10">
                                            <select class="form-select">
                                                <option>-- Pilih --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <label class="col-lg-2 col-form-label">Unit / Poli</label>
                                        <div class="col-lg-10">
                                            <select class="form-select">
                                                <option>-- Pilih --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-end">
                                        <button type="button" class="btn btn-success">
                                            <i class="ph-microsoft-excel-logo me-2"></i>
                                            Export Excel
                                        </button>
                                        <button type="button" class="btn btn-primary">
                                            <i class="ph-magnifying-glass me-2"></i>
                                            Cari
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="bg-light">
                                                <th class="text-center" nowrap>No</th>
                                                <th nowrap>Tanggal Periksa</th>
                                                <th nowrap>No RM</th>
                                                <th nowrap>Nama PX</th>
                                                <th nowrap>Golongan PX</th>
                                                <th nowrap>Unit / Poli</th>
                                                <th nowrap>Dokter</th>
                                                <th nowrap>Status Rujukan</th>
                                                <th nowrap>Tindakan</th>
                                                <th nowrap>AKHP</th>
                                                <th nowrap>JRS</th>
                                                <th nowrap>JAPSEL</th>
                                                <th nowrap>Tarif</th>
                                            </thead>
                                            <tbody>
                                                @for($i = 1; $i <= 10; $i++)
                                                    <tr>
                                                        <td class="text-center align-middle">{{ $i }}</td>
                                                        <td class="align-middle">{{ $faker->date('d/m/Y') }}</td>
                                                        <td class="align-middle">{{ rand(000000, 999999) }}</td>
                                                        <td class="align-middle">{{ $faker->name }}</td>
                                                        <td class="align-middle">Umum</td>
                                                        <td class="align-middle">Paru</td>
                                                        <td class="align-middle" nowrap>dr. Yoyok Prasetijo, Sp.P.</td>
                                                        <td class="align-middle">Sembuh</td>
                                                        <td class="align-middle">Konsultasi</td>
                                                        <td class="text-end align-middle">0</td>
                                                        <td class="text-end align-middle">0</td>
                                                        <td class="text-end align-middle">0</td>
                                                        <td class="text-end align-middle">22.500</td>
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
