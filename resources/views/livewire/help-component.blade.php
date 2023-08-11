@section('title', 'Help')

<div>

	<!-- Page Header
		============================================= -->
	<section class="hero-wrap section">
		<div class="hero-mask opacity-9 bg-primary"></div>
		<div class="hero-bg" style="background-image:url('./images/bg/image-2.jpg');"></div>
		<div class="hero-content">
			<div class="container">
				<div class="row align-items-center text-center">
					<div class="col-12">
						<h1 class="text-11 text-white mb-3">How can we help you?</h1>
					</div>
					{{-- <div class="col-md-10 col-lg-8 col-xl-6 mx-auto">
						<div class="input-group">
							<input class="form-control shadow-none border-0" type="search" id="search-input"
								placeholder="Search for answer..." value="">
							<div class="input-group-append"> <span class="input-group-text bg-white border-0 p-0">
									<button class="btn text-muted px-3 border-0" type="button"><i class="fa fa-search"></i></button>
								</span> </div>
						</div>
					</div> --}}
				</div>
			</div>
		</div>
	</section>
	<!-- Page Header end -->

	<!-- Content
		============================================= -->
	<div id="content">

		<!-- Main Topics
				============================================= -->
		<section class="section py-3 my-3 py-sm-5 my-sm-5">
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-lg-3 mb-4 mb-lg-0">
						<div class="bg-light shadow-sm rounded p-4 text-center"> <span class="d-block text-17 text-primary mt-2 mb-3"><i
									class="fas fa-user-circle"></i></span>
							<h3 class="text-body text-4">My Account</h3>
							<p class="mb-0">
								<a class="text-muted btn-link" href="{{ route('home') }}">
									Go to Dashboard
									<span class="text-1 ml-1">
										<i class="fas fa-chevron-right"></i>
									</span>
								</a>
							</p>
						</div>
					</div>
					<div class="col-sm-6 col-lg-3 mb-4 mb-lg-0">
						<div class="bg-light shadow-sm rounded p-4 text-center">
							<span class="d-block text-17 text-primary mt-2 mb-3">
								<i class="fas fa-money-check-alt"></i>
							</span>
							<h3 class="text-body text-4">Payment</h3>
							<p class="mb-0">
								<a class="text-muted btn-link" href="{{ route('deposit') }}">
									Make Payment
									<span class="text-1 ml-1">
										<i class="fas fa-chevron-right"></i>
									</span>
								</a>
							</p>
						</div>
					</div>
					<div class="col-sm-6 col-lg-3 mb-4 mb-sm-0">
						<div class="bg-light shadow-sm rounded p-4 text-center">
							<span class="d-block text-17 text-primary mt-2 mb-3">
								<i class="fas fa-shield-alt"></i>
							</span>
							<h3 class="text-body text-4">Security</h3>
							<p class="mb-0">
								<a class="text-muted btn-link" href="{{ route('profile') }}">
									Learn More
									<span class="text-1 ml-1">
										<i class="fas fa-chevron-right"></i>
									</span>
								</a>
							</p>
						</div>
					</div>
					<div class="col-sm-6 col-lg-3">
						<div class="bg-light shadow-sm rounded p-4 text-center"> <span class="d-block text-17 text-primary mt-2 mb-3"><i
									class="fas fa-credit-card"></i></span>
							<h3 class="text-body text-4">Payment Methods</h3>
							<p class="mb-0">
								<a class="text-muted btn-link" href="{{ route('profile-account') }}">
									Add Payment Methods
									<span class="text-1 ml-1">
										<i class="fas fa-chevron-right"></i>
									</span>
								</a>
							</p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Main Topics end -->

		<!-- Popular Topics
				============================================= -->
		<section class="section bg-white">
			<div class="container">
				<h2 class="text-9 text-center">Popular Topics</h2>
				<p class="text-4 text-center mb-5">Lisque persius interesset his et, in quot quidam persequeris.</p>
				<div class="row">
					<div class="col-md-10 mx-auto">
						<div class="row">
							<div class="col-md-6">
								<div class="accordion accordion-alternate" id="popularTopics">
									@php
										$faqs_count = $faqs->count() / 2;
									@endphp
									@foreach ($faqs->take($faqs_count) as $faq)
										<div class="card">
											<div class="card-header" id="faq{{ $faq->id }}">
												<h5 class="mb-0">
													<a href="#" class="collapsed" data-toggle="collapse" data-target="#collapse{{ $faq->id }}"
														aria-expanded="false" aria-controls="collapse{{ $faq->id }}">
														{{ $faq->question }}
													</a>
												</h5>
											</div>
											<div id="collapse{{ $faq->id }}" class="collapse" aria-labelledby="faq{{ $faq->id }}"
												data-parent="#popularTopics">
												<div class="card-body">
													{{ $faq->answer }}
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>

							<div class="col-md-6">
								<div class="accordion accordion-alternate" id="popularTopics2">
									@foreach ($faqs->skip($faqs_count)->take($faqs_count) as $faq)
										<div class="card">
											<div class="card-header" id="faq{{ $faq->id }}">
												<h5 class="mb-0">
													<a href="#" class="collapsed" data-toggle="collapse" data-target="#collapse{{ $faq->id }}"
														aria-expanded="false" aria-controls="collapse{{ $faq->id }}">
														{{ $faq->question }}
													</a>
												</h5>
											</div>
											<div id="collapse{{ $faq->id }}" class="collapse" aria-labelledby="faq{{ $faq->id }}"
												data-parent="#popularTopics">
												<div class="card-body">
													{{ $faq->answer }}
												</div>
											</div>
										</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
				{{-- @dd($this->perPage, \App\Models\Faq::all()->count()) --}}
				@if ($this->perPage < $all_faq->count())
					<div class="text-center mt-4">
						<a href="#!" wire:click='loadMore' class="btn-link text-4">
							See more topics
							<i class="fas fa-chevron-right text-2 ml-2"></i>
						</a>
					</div>
				@endif
			</div>
		</section>
		<!-- Popular Topics end -->

		<!-- Can't find ============================================= -->
		<section class="section py-4 my-4 py-sm-5 my-sm-5">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<div class="bg-white shadow-sm rounded pl-4 pl-sm-0 pr-4 py-4">
							<div class="row no-gutters">
								<div class="col-12 col-sm-auto text-13 text-light d-flex align-items-center justify-content-center"> <span
										class="px-4 ml-3 mr-2 mb-4 mb-sm-0"><i class="far fa-envelope"></i></span> </div>
								<div class="col text-center text-sm-left">
									<div class="">
										<h5 class="text-3 text-body">Can't find what you're looking for?</h5>
										<p class="text-muted mb-0">We want to answer all of your queries. Get in touch and we'll get back to you as
											soon as we can.
											<a class="btn-link" href="{{ route('contact-us') }}">Contact us<span class="text-1 ml-1">
													<i class="fas fa-chevron-right"></i>
												</span>
											</a>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6 mt-4 mt-lg-0">
						<div class="bg-white shadow-sm rounded pl-4 pl-sm-0 pr-4 py-4">
							<div class="row no-gutters">
								<div class="col-12 col-sm-auto text-13 text-light d-flex align-items-center justify-content-center"> <span
										class="px-4 ml-3 mr-2 mb-4 mb-sm-0"><i class="far fa-comment-alt"></i></span> </div>
								<div class="col text-center text-sm-left">
									<div class="">
										<h5 class="text-3 text-body">Technical questions</h5>
										<p class="text-muted mb-0">Have some technical questions? Hit us up on live chat or whatever.
											<a class="btn-link" href="{{ route('contact-us') }}">Click here<span class="text-1 ml-1">
													<i class="fas fa-chevron-right"></i>
												</span>
											</a>
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Can't find end -->

	</div>
	<!-- Content end -->

</div>
