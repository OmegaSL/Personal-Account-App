@section('title', 'About Us')

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/owl.carousel/assets/owl.carousel.min.css') }}" />
@endsection

<div>

	<!-- Page Header ============================================= -->
	<section class="page-header page-header-text-light py-0 mb-0">
		<section class="hero-wrap section">
			<div class="hero-mask opacity-7 bg-dark"></div>
			<div class="hero-bg hero-bg-scroll" style="background-image:url('{{ asset('assets/images/bg/image-2.jpg') }}');"></div>
			<div class="hero-content">
				<div class="container">
					<div class="row">
						<div class="col-12 text-center">
							<h1 class="text-11 font-weight-500 text-white mb-4">About
								{{ $setting ? $setting->site_name : config('app.name') }}</h1>
							<p class="text-5 text-white line-height-4 mb-4">
								Our mission is to help you save money and time and gain peace of mind with our easy-to-use,
								innovative personal finance management tools.
							</p>
							<a href="{{ route('about-us') }}" class="btn btn-primary m-2">Open a Free Account</a>
							<a class="btn btn-outline-light video-btn m-2" href="#"
								data-src="https://www.youtube.com/embed/7e90gBu4pas" data-toggle="modal" data-target="#videoModal">
								<span class="mr-2">
									<i class="fas fa-play-circle"></i>
								</span>
								See How it Works
							</a>
						</div>
					</div>
				</div>
			</div>
		</section>
	</section>
	<!-- Page Header end -->

	<!-- Content ============================================= -->
	<div id="content">

		<!-- Who we are ============================================= -->
		<section class="section">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 d-flex">
						<div class="my-auto px-0 px-lg-5 mx-2">
							<h2 class="text-9">Who we are</h2>
							<p class="text-4">
								{{ $setting->about_us != null ? $setting->about_us : 'My Personal Account Management App' }}
							</p>
						</div>
					</div>
					<div class="col-lg-6 my-auto text-center">
						<img class="img-fluid shadow-lg rounded-lg" src="{{ asset('assets/images/who-we-are.jpg') }}" alt="">
					</div>
				</div>
			</div>
		</section>
		<!-- Who we are end -->

		<!-- Our Values ============================================= -->
		<section class="section bg-white">
			<div class="container">
				<div class="row no-gutters">
					<div class="col-lg-6 order-2 order-lg-1">
						<div class="row">
							<div class="col-6 col-lg-7 ml-auto mb-lg-n5">
								<img class="img-fluid rounded-lg shadow-lg" src="{{ asset('assets/images/our-values-vision.jpg') }}"
									alt="banner">
							</div>
							<div class="col-6 col-lg-8 mt-lg-n5">
								<img class="img-fluid rounded-lg shadow-lg" src="{{ asset('assets/images/our-values-mission.jpg') }}"
									alt="banner">
							</div>
						</div>
					</div>
					<div class="col-lg-6 d-flex order-1 order-lg-2">
						<div class="my-auto px-0 px-lg-5">
							<h2 class="text-9 mb-4">Our Values</h2>
							<h4 class="text-4 font-weight-500">Our Mission</h4>
							<p class="tex-3">
								{{ $setting->mission != null ? $setting->mission : 'My Personal Account Management App' }}
							</p>
							<h4 class="text-4 font-weight-500 mb-2">Our Vision</h4>
							<p class="tex-3">
								{{ $setting->vision != null ? $setting->vision : 'My Personal Account Management App' }}
							</p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Our Values end -->
	</div>

	<!-- Video Modal
============================================= -->
	<div class="modal fade" id="videoModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			<div class="modal-content bg-transparent border-0">
				<button type="button" class="close text-white opacity-10 ml-auto mr-n3 font-weight-400" data-dismiss="modal"
					aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<div class="modal-body p-0">
					<div class="embed-responsive embed-responsive-16by9">
						<iframe class="embed-responsive-item" id="video" allow="autoplay"></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Video Modal end -->

</div>

@section('scripts')
	<script src="{{ asset('assets/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
@endsection
