<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
	<link
		href="{{ $setting->site_favicon != null ? asset('storage/' . $setting->site_favicon) : asset('assets/images/favicon.png') }}"
		rel="icon" />

	<title>{{ $setting ? $setting->site_name : config('app.name') }} - @yield('title', 'Personal Account') </title>

	<meta name="description"
		content="{{ $setting->about_us != null ? $setting->about_us : 'My Personal Account Management App' }}">
	<meta name="author" content="OmegaSL Programming">

	<!-- Web Fonts ============================================= -->
	<link rel='stylesheet'
		href='https://fonts.googleapis.com/css?family=Rubik:300,300i,400,400i,500,500i,700,700i,900,900i' type='text/css'>

	<!-- Stylesheet ============================================= -->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/font-awesome/css/all.min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/owl.carousel/assets/owl.carousel.min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/stylesheet.css') }}" />

	@yield('styles')

	@livewireStyles
</head>

<body>
	<!-- Preloader -->
	<div id="preloader">
		<div data-loader="dual-ring"></div>
	</div>
	<!-- Preloader End -->

	<div id="main-wrapper">
		@include('shared.header')
		@yield('content')
		@include('shared.footer')
	</div>


	<!-- Back to Top ============================================= -->
	<a id="back-to-top" data-toggle="tooltip" title="Back to Top" href="javascript:void(0)">
		<i class="fa fa-chevron-up"></i>
	</a>

	<!-- Script -->
	<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('assets/js/theme.js') }}"></script>

	@yield('scripts')

	@livewireScripts
</body>

</html>
