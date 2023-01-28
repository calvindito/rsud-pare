                <div class="navbar navbar-sm navbar-footer border-top">
                    <div class="container-fluid">
                        <span>
                            Hak Cipta {{ date('Y') }} &copy; RSUD Kabupaten Kediri
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="panel_right" class="offcanvas offcanvas-end panel-account" tabindex="-1">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title fw-semibold">Akun Anda</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="text-center px-3 mb-3">
                <a href="#" class="d-inline-block mb-3">
                    <img src="{{ asset('template/assets/images/demo/users/face11.jpg') }}" class="rounded-pill" width="100" height="100">
                </a>
                <h6 class="mb-0">Victoria Davidson</h6>
                <div>Head of UX</div>
            </div>
            <div class="bg-light text-muted py-2 px-3">Navigasi</div>
            <div class="list-group list-group-borderless py-2">
                <a href="{{ url('auth/profile') }}" class="list-group-item list-group-item-action">
                    <i class="ph-user-list me-3"></i>
                    Profil
                </a>
                <a href="{{ url('auth/change-password') }}" class="list-group-item list-group-item-action">
                    <i class="ph-lock me-3"></i>
                    Ganti Password
                </a>
                <a href="{{ url('auth/logout') }}" class="list-group-item list-group-item-action">
                    <i class="ph-power me-3"></i>
                    Keluar
                </a>
            </div>
        </div>
    </div>
</body>
</html>
