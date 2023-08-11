<div>

	<div class="container h-100">
		<!-- SignUp Form
								============================================= -->
		<div class="row no-gutters h-100">
			<div class="col-11 col-sm-9 col-md-7 col-lg-5 col-xl-4 m-auto">
				<div class="logo mb-4 text-center">
					<a href="/" title="{{ config('app.name') }}">
						<img src="{{ asset('assets/images/logo.png') }}" alt="{{ config('app.name') }}"></a>
				</div>
				<form wire:submit.prevent='register'>
					<div class="vertical-input-group">
						<div class="input-group">
							<input type="text" class="form-control" wire:model.defer='first_name' required placeholder="Your First Name">
						</div>
						<div class="input-group">
							<input type="text" class="form-control" wire:model.defer='last_name' required placeholder="Your Last Name">
						</div>
						<div class="input-group">
							<input type="text" class="form-control" wire:model.defer='name' required placeholder="Your Username">
						</div>
						<br>
						<div class="input-group">
							<input type="email" class="form-control" wire:model.defer='email' required placeholder="Your Email">
						</div>
						<div class="input-group">
							<input type="number" min="0" class="form-control" wire:model.defer='phone' required
								placeholder="Your Phone">
						</div>
						<div class="input-group">
							<input type="date" class="form-control" wire:model.defer='birth_date' required placeholder="Your Birth Date"
								title="Enter your date of birth">
						</div>
						<br>
						<div class="input-group">
							<input type="password" class="form-control" wire:model.defer='password' required placeholder="Password">
						</div>
						<div class="input-group">
							<input type="password" class="form-control" wire:model.defer='password_confirmation' required
								placeholder="Password Confirmation">
						</div>
					</div>

					<button class="btn btn-primary btn-block shadow-none my-4" type="submit">Sign Up</button>
				</form>
				<p class="text-3 text-center text-muted">Already have an account?
					<a class="btn-link" href="{{ route('login') }}">Log In</a>
				</p>
			</div>
			<div class="col-12 fixed-bottom">
				<p class="text-center text-1 text-muted mb-1">
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
		</div>
		<!-- SignUp Form End -->
	</div>

</div>
