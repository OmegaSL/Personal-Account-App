<!-- Footer
		============================================= -->
<footer id="footer">
	<div class="container">
		<div class="row">
			<div class="col-lg d-lg-flex align-items-center">
				<ul class="nav justify-content-center justify-content-lg-start text-3">
					<li class="nav-item"> <a class="nav-link active" href="{{ route('about-us') }}">About Us</a></li>
					<li class="nav-item"> <a class="nav-link" href="{{ route('contact-us') }}">Support</a></li>
					<li class="nav-item"> <a class="nav-link" href="{{ route('help') }}">Help</a></li>
					<li class="nav-item"> <a class="nav-link" href="{{ route('contact-us') }}">Fees</a></li>
				</ul>
			</div>
			<div class="col-lg d-lg-flex justify-content-lg-end mt-3 mt-lg-0">
				<ul class="social-icons justify-content-center">
					<li class="social-icons-facebook">
						<a data-toggle="tooltip"
							href="{{ $setting->facebook_url != null ? $setting->facebook_url : 'http://www.facebook.com/' }}" target="_blank"
							title="Facebook">
							<i class="fab fa-facebook-f"></i>
						</a>
					</li>
					<li class="social-icons-twitter">
						<a data-toggle="tooltip"
							href="{{ $setting->twitter_url != null ? $setting->twitter_url : 'http://www.twitter.com/' }}" target="_blank"
							title="Twitter">
							<i class="fab fa-twitter"></i>
						</a>
					</li>
					<li class="social-icons-linkedin">
						<a data-toggle="tooltip"
							href="{{ $setting->linkedin_url != null ? $setting->linkedin_url : 'http://www.linkedin.com/' }}" target="_blank"
							title="Google">
							<i class="fab fa-linkedin"></i>
						</a>
					</li>
					<li class="social-icons-youtube">
						<a data-toggle="tooltip"
							href="{{ $setting->youtube_url != null ? $setting->youtube_url : 'http://www.youtube.com/' }}" target="_blank"
							title="Youtube">
							<i class="fab fa-youtube"></i>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="footer-copyright pt-3 pt-lg-2 mt-2">
			<div class="row">
				<div class="col-lg">
					<p class="text-center text-lg-left mb-2 mb-lg-0">
						Copyright &copy;
						@php
							$currentYear = date('Y');
							$startingYear = 2023;
							if ($currentYear > $startingYear) {
							    echo $startingYear . ' - ' . $currentYear;
							} else {
							    echo $startingYear;
							}
						@endphp
						<a href="#">
							{{ $setting ? $setting->site_name : config('app.name') }}
						</a>. All Rights Reserved.
					</p>
				</div>
				<div class="col-lg d-lg-flex align-items-center justify-content-lg-end">
					<ul class="nav justify-content-center">
						<li class="nav-item"> <a class="nav-link active" href="#">Security</a></li>
						<li class="nav-item"> <a class="nav-link" href="#">Terms</a></li>
						<li class="nav-item"> <a class="nav-link" href="#">Privacy</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- Footer end -->
