<div class="content">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <form method="POST">
                @method('PATCH')
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Ganti Password</h5>
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
                            <label class="col-lg-4 col-form-label">Password Saat Ini <span class="text-danger fw-bold">*</span></label>
                            <div class="col-lg-8">
                                <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Masukan password saat ini">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Password Baru <span class="text-danger fw-bold">*</span></label>
                            <div class="col-lg-8">
                                <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Masukan password baru">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Konfirmasi Password <span class="text-danger fw-bold">*</span></label>
                            <div class="col-lg-8">
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Masukan konfirmasi password">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group mb-0">
                            <div class="text-end">
                                <button type="submit" class="btn btn-warning">
                                    <i class="ph-floppy-disk me-1"></i>
                                    Simpan Perubahan Password
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
