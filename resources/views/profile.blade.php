<div class="content">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Profil</h5>
                    </div>
                    <div class="card-body border-top">
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
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3">Kode Pegawai</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="code" id="code" value="{{ $user->employee->code }}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3">Nama <span class="text-danger fw-bold">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Masukan nama" value="{{ old('name', $user->employee->name) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3">Kota</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="city" id="city" placeholder="Masukan kota" value="{{ old('city', $user->employee->city) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3">Kode Pos</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="postal_code" id="postal_code" placeholder="Masukan kode pos" value="{{ old('postal_code', $user->employee->postal_code) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3">No Telp</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Masukan no telp" value="{{ old('phone', $user->employee->phone) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3">No HP</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="cellphone" id="cellphone" placeholder="Masukan no hp" value="{{ old('cellphone', $user->employee->cellphone) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3">Email</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="email" id="email" placeholder="Masukan email" value="{{ old('email', $user->employee->email) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3">Username <span class="text-danger fw-bold">*</span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="username" id="username" placeholder="Masukan username" value="{{ old('username', $user->username) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3">Alamat</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="address" id="address" style="resize:none;" placeholder="Masukan alamat" value="{{ old('address', $user->employee->address) }}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group mb-0">
                            <div class="text-end">
                                <button type="submit" class="btn btn-warning" onclick="onLoading('show', '.content')">
                                    <i class="ph-floppy-disk me-1"></i>
                                    Simpan Perubahan Profil
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
