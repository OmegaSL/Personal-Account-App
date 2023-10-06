<!-- Header
		============================================= -->
<header id="header">
	<div class="container">
		<div class="header-row">
			<div class="header-column justify-content-start">
				<!-- Logo ============================= -->
				<div class="logo">
					<a class="d-flex" href="{{ url('/') }}"
						title="{{ $setting ? $setting->site_name : config('app.name') }} - Personal Account">
						<img style="max-height: 50px;"
							src="{{ $setting->site_logo != null ? asset('storage/' . $setting->site_logo) : asset('assets/images/logo.png') }}"
							alt="{{ $setting ? $setting->site_name : config('app.name') }}" />
					</a>
				</div>
				<!-- Logo end -->
				<!-- Collapse Button ============================== -->
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header-nav">
					<span></span> <span></span> <span></span>
				</button>
				<!-- Collapse Button end -->

				<!-- Primary Navigation ============================== -->
				<nav class="primary-menu navbar navbar-expand-lg">
					<div id="header-nav" class="collapse navbar-collapse">
						<ul class="navbar-nav mr-auto">
							<li class="{{ request()->routeIs('home') ? 'active' : '' }}">
								<a href="{{ route('home') }}">
									Dashboard
								</a>
							</li>
							<li class="{{ request()->routeIs('transactions') ? 'active' : '' }}">
								<a href="{{ route('transactions') }}">
									Transactions
								</a>
							</li>
							<li class="{{ request()->routeIs('deposit') ? 'active' : '' }}">
								<a href="{{ route('deposit') }}">
									Deposit/Withdrawal
								</a>
							</li>
							<li class="{{ request()->routeIs('user.expenses') ? 'active' : '' }}">
								<a href="{{ route('user.expenses') }}">
									Expenses
								</a>
							</li>
							<li class="{{ request()->routeIs('saving-deduction') ? 'active' : '' }}">
								<a href="{{ route('saving-deduction') }}">
									Deductions
								</a>
							</li>
						</ul>
					</div>
				</nav>
				<!-- Primary Navigation end -->
			</div>
			<div class="header-column justify-content-end">
				@auth
					<!-- Login & Signup Link ============================== -->
					<nav class="login-signup navbar navbar-expand">
						<ul class="navbar-nav">
							<li class="{{ request()->routeIs('profile') ? 'active' : '' }}">
								<a href="{{ route('profile') }}">
									Settings
								</a>
							</li>
							<li class="align-items-center h-auto ml-sm-3">
								<a class="btn btn-outline-primary shadow-none d-none d-sm-block" href="{{ route('logout') }}">
									Sign out
								</a>
							</li>
						</ul>
					</nav>
					<!-- Login & Signup Link end -->
				@else
					<!-- Login & Signup Link ============================== -->
					<nav class="login-signup navbar navbar-expand">
						<ul class="navbar-nav">
							<li><a href="{{ route('login') }}">Login</a> </li>
							<li class="align-items-center h-auto ml-sm-3">
								<a class="btn btn-primary d-none d-sm-block" href="{{ route('register') }}">
									Sign Up
								</a>
							</li>
						</ul>
					</nav>
					<!-- Login & Signup Link end -->
				@endauth
			</div>
		</div>
	</div>
</header>
<!-- Header End -->
