<body>
	<div class="navbar bg-primary navbar-expand-xl navbar-static shadow navbar-dark">
		<div class="container-fluid">
			<div class="d-flex d-xl-none me-2">
				<button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
					<i class="ph-list"></i>
				</button>
			</div>
			<div class="navbar-brand flex-1">
				<a href="{{ url('dashboard/general') }}" class="d-inline-flex align-items-center">
					<img src="{{ asset('assets/logo.png') }}">
                    {{-- <span class="ms-2 fw-bold text-muted">RSUD KABUPATEN KEDIRI</span> --}}
				</a>
			</div>
			<ul class="nav gap-1 flex-xl-1 justify-content-end order-0 order-xl-1">
				<li class="nav-item nav-item-dropdown-xl dropdown">
					<a href="#" class="navbar-nav-link align-items-center rounded-pill p-1" data-bs-toggle="dropdown">
                        <img src="{{ asset('template/assets/images/demo/users/face11.jpg') }}" class="w-32px h-32px rounded-pill">
						<span class="d-none d-md-inline-block mx-md-2">Victoria</span>
					</a>
					<div class="dropdown-menu dropdown-menu-end">
						<a href="#" class="dropdown-item">
							<i class="ph-user-circle me-2"></i>
							My profile
						</a>
						<a href="#" class="dropdown-item">
							<i class="ph-currency-circle-dollar me-2"></i>
							My subscription
						</a>
						<a href="#" class="dropdown-item">
							<i class="ph-shopping-cart me-2"></i>
							My orders
						</a>
						<a href="#" class="dropdown-item">
							<i class="ph-envelope-open me-2"></i>
							My inbox
							<span class="badge bg-primary rounded-pill ms-auto">26</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<i class="ph-gear me-2"></i>
							Account settings
						</a>
						<a href="#" class="dropdown-item">
							<i class="ph-sign-out me-2"></i>
							Logout
						</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
