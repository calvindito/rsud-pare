<body>
	<div class="navbar bg-primary navbar-expand-xl navbar-static shadow navbar-dark">
		<div class="container-fluid">
			<div class="d-flex d-xl-none me-2">
				<button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
					<i class="ph-list"></i>
				</button>
			</div>
			<div class="navbar-brand flex-1">
				<a href="{{ url('dashboard/general') }}" class="d-inline-flex align-items-center fw-bold text-white">
                    <i class="ph-leaf me-2"></i>
                    SIMRS KAB KEDIRI
				</a>
			</div>
			<ul class="nav gap-1 flex-xl-1 justify-content-end order-0 order-xl-1">
                <li class="nav-item">
					<a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="offcanvas" data-bs-target=".panel-notification">
						<i class="ph-bell"></i>
						<span class="badge bg-yellow text-black position-absolute top-0 end-0 translate-middle-top zindex-1 rounded-pill mt-1 me-1">0</span>
					</a>
				</li>
				<li class="nav-item ms-lg-2">
					<a href="#" class="navbar-nav-link align-items-center rounded-pill p-1" data-bs-toggle="offcanvas" data-bs-target=".panel-account">
                        <img src="{{ asset('template/assets/images/demo/users/face11.jpg') }}" class="w-32px h-32px rounded-pill">
						<span class="d-none d-md-inline-block mx-md-2">Victoria</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
