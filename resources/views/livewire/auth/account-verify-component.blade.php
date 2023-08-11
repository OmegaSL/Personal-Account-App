<div>

	<style>
		/* disable arrow down and up on number input */
		input[type=number]::-webkit-inner-spin-button,
		input[type=number]::-webkit-outer-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}
	</style>

	<div class="container h-100">
		<!-- SignUp Form ============================================= -->
		<div class="row no-gutters h-100">
			<div class="col-11 col-sm-9 col-md-7 col-lg-5 col-xl-4 m-auto">
				<div class="logo mb-4 text-center">
					<a href="/" title="{{ config('app.name') }}">
						<img src="{{ asset('assets/images/logo.png') }}" alt="{{ config('app.name') }}"></a>
				</div>
				<form wire:submit.prevent='verify' enctype="multipart/form-data">
					<div class="vertical-input-group">
						<div class="input-group">
							<input type="email" class="form-control" wire:model.defer='email' disabled readonly required
								placeholder="Your Email">
						</div>
						<br>
						<div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
							<input type="number" min="0" wire:model.defer='otp_code_input_1' maxlength="1"
								style="width: 40px; height: 40px; font-size: 24px; text-align: center;" autofocus>
							<input type="number" min="0" wire:model.defer='otp_code_input_2' maxlength="1"
								style="width: 40px; height: 40px; font-size: 24px; text-align: center;">
							<input type="number" min="0" wire:model.defer='otp_code_input_3' maxlength="1"
								style="width: 40px; height: 40px; font-size: 24px; text-align: center;">
							<input type="number" min="0" wire:model.defer='otp_code_input_4' maxlength="1"
								style="width: 40px; height: 40px; font-size: 24px; text-align: center;">
							<input type="number" min="0" wire:model.defer='otp_code_input_5' maxlength="1"
								style="width: 40px; height: 40px; font-size: 24px; text-align: center;">
							<input type="number" min="0" wire:model.defer='otp_code_input_6' maxlength="1"
								style="width: 40px; height: 40px; font-size: 24px; text-align: center;">
						</div>
					</div>

					<button class="btn btn-primary btn-block shadow-none my-4" type="submit">Submit</button>
				</form>

				<div wire:poll.visible>
					@if (now()->diffInSeconds(auth()->user()->updated_at) > 60)
						<p class="text-3 text-center text-muted">
							Didn't receive the code?
							<a class="btn-link" href="#!" wire:loading.remove wire:click.prevent='resendOTPCode'>Resend OTP Code</a>
							<a class="btn-link" href="#!" wire:loading wire:target='resendOTPCode' style="pointer-events: none; cursor: default;">
								Resending OTP Code...
							</a>
						</p>
					@else
						<p class="text-3 text-center text-muted">
							Please check your email for the code or wait for 60 seconds to resend the code.
							@php
								$remainingTime = 60 - now()->diffInSeconds(auth()->user()->updated_at);

								if ($remainingTime < 0) {
								    $remainingTime = 0;
								}

								echo $remainingTime;
							@endphp
						</p>
					@endif
				</div>

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

@section('scripts')
	{{-- prevent number from containing more one letter and move the focus to the next input when input has been filled --}}
	<script>
		$(document).ready(function() {
			$('input[type="number"]').keyup(function() {
				if (this.value.length == this.maxLength) {
					$(this).next('input').focus();
				}

				// prevent number from containing more one letter
				if (this.value.length > this.maxLength) {
					this.value = this.value.slice(0, this.maxLength);
				}

				// make input focus when user press backspace
				if (this.value.length == 0) {
					$(this).prev('input').focus();
				}

				// erase all the value to the right when user press backspace
				if (this.value.length == 0) {
					$(this).next('input').val('');
				}

				// erase the value if cursor is in front of the input
				if (this.value.length == 0) {
					$(this).prev('input').val('');
				}
			});
		});
	</script>
@endsection
