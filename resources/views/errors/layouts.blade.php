
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>@yield('title')</title>
    <link href="{{ asset('assets/icon.png') }}" rel="shortcut icon">
	<link href="{{ asset('template/assets/fonts/inter/inter.css') }}" rel="stylesheet">
	<link href="{{ asset('template/assets/icons/phosphor/styles.min.css') }}" rel="stylesheet">
	<link href="{{ asset('template/assets/css/ltr/all.min.css') }}" id="stylesheet" rel="stylesheet">
	<script src="{{ asset('template/assets/demo/demo_configurator.js') }}"></script>
	<script src="{{ asset('template/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('template/assets/js/app.js') }}"></script>
</head>
<body>
	<div class="page-content">
		<div class="content-wrapper">
			<div class="content-inner">
				<div class="content d-flex justify-content-center align-items-center">
					<div class="flex-fill">
						<div class="text-center mb-4">
							<img src="{{ asset('template/assets/images/error_bg.svg') }}" class="img-fluid mb-3" height="230" alt="">
							<h1 class="display-3 fw-semibold lh-1 mb-3">@yield('code')</h1>
							<h4 class="w-md-25 mx-md-auto">@yield('message')</h4>
						</div>
						<div class="text-center">
							<a href="{{ url('/') }}" class="btn btn-primary">
                                <i class="ph-arrow-left me-2"></i>
								Kembali
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
