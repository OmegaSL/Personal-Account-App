@section('title', 'Contact Us')

<div>

	<!-- Page Header ============================================= -->
	<section class="page-header page-header-text-light bg-dark-3 py-5">
		<div class="container">
			<div class="row text-center">
				<div class="col-12">
					<ul class="breadcrumb mb-0">
						<li><a href="/">Home</a></li>
						<li class="active">Contact Us</li>
					</ul>
				</div>
				<div class="col-12">
					<h1>Contact Us</h1>
				</div>
			</div>
		</div>
	</section>
	<!-- Page Header End -->

	<!-- Content
		============================================= -->
	<div id="content">
		<div class="container">
			<div class="row">

				<div class="col-md-4 mb-4">
					<div class="bg-white shadow-md rounded h-100 p-3">
						<div class="featured-box text-center">
							<div class="featured-box-icon text-primary mt-4"> <i class="fas fa-map-marker-alt"></i></div>
							<h3>{{ $setting ? $setting->site_name : config('app.name') }}.</h3>
							<p>
								{{ $setting->site_address ? $setting->site_address : 'Koforidua, Ghana' }}<br>
								{{ $setting->site_address ? $setting->site_address : 'Koforidua, Ghana' }}
							</p>
						</div>
					</div>
				</div>

				<div class="col-md-4 mb-4">
					<div class="bg-white shadow-md rounded h-100 p-3">
						<div class="featured-box text-center">
							<div class="featured-box-icon text-primary mt-4"> <i class="fas fa-phone"></i> </div>
							<h3>Telephone</h3>
							<p class="mb-0">{{ $setting->site_phone ? $setting->site_phone : '233248429877' }}</p>
							<p>{{ $setting->site_phone2 ? $setting->site_phone2 : '233207908922' }}</p>
						</div>
					</div>
				</div>

				<div class="col-md-4 mb-4">
					<div class="bg-white shadow-md rounded h-100 p-3">
						<div class="featured-box text-center">
							<div class="featured-box-icon text-primary mt-4"> <i class="fas fa-envelope"></i> </div>
							<h3>Business Inquiries</h3>
							<p>{{ $setting ? $setting->site_email : '233207908922' }}</p>
						</div>
					</div>
				</div>


				<div class="col-12 mb-4">
					<div class="text-center py-5 px-2">
						<h2 class="text-8">Get in touch</h2>
						<p class="lead">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
						<div class="d-flex flex-column">
							<ul class="social-icons social-icons-lg social-icons-colored justify-content-center">
								<li class="social-icons-facebook"><a data-toggle="tooltip"
										href="{{ $setting->facebook_url ? $setting->facebook_url : 'http://www.facebook.com/' }}" target="_blank"
										title="" data-original-title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
								<li class="social-icons-twitter"><a data-toggle="tooltip"
										href="{{ $setting->twitter_url ? $setting->twitter_url : 'http://www.twitter.com/' }}" target="_blank"
										title="" data-original-title="Twitter"><i class="fab fa-twitter"></i></a></li>
								<li class="social-icons-google"><a data-toggle="tooltip" href="http://www.google.com/" target="_blank"
										title="" data-original-title="Google"><i class="fab fa-google"></i></a></li>
								<li class="social-icons-linkedin"><a data-toggle="tooltip"
										href="{{ $setting->linkedin_url ? $setting->linkedin_url : 'http://www.linkedin.com/' }}" target="_blank"
										title="" data-original-title="Linkedin"><i class="fab fa-linkedin-in"></i></a></li>
								<li class="social-icons-youtube"><a data-toggle="tooltip"
										href="{{ $setting->youtube_url ? $setting->youtube_url : 'http://www.youtube.com/' }}" target="_blank"
										title="" data-original-title="Youtube"><i class="fab fa-youtube"></i></a></li>
								<li class="social-icons-instagram"><a data-toggle="tooltip"
										href="{{ $setting->instagram_url ? $setting->instagram_url : 'http://www.instagram.com/' }}" target="_blank"
										title="" data-original-title="Instagram"><i class="fab fa-instagram"></i></a></li>
							</ul>
						</div>
					</div>
				</div>

			</div>
		</div>


		<section class="hero-wrap section shadow-md">
			<div class="hero-mask opacity-9 bg-primary"></div>
			<div class="hero-bg" style="background-image:url('images/bg/image-2.jpg');"></div>
			<div class="hero-content">
				<div class="container text-center">
					<h2 class="text-9 text-white">Awesome Customer Support</h2>
					<p class="text-4 text-white mb-4">
						Have you any query? Don't worry. We have great people ready to help you whenever you need it.
					</p>
					<a href="{{ route('about-us') }}" class="btn btn-light">Find out more</a>
				</div>
			</div>
		</section>
		<!-- Content end -->

	</div>
