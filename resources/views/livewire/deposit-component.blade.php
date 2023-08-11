@section('title', 'Deposit')

<div>

	<!-- Secondary menu ============================================= -->
	<div wire:ignore class="bg-white">
		<div class="container d-flex justify-content-center">
			<ul class="nav secondary-nav alternate">
				<li class="nav-item">
					<a class="nav-link {{ request()->routeIs('deposit') ? 'active' : '' }}" href="{{ route('deposit') }}">
						Deposit
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{ request()->routeIs('withdrawal') ? 'active' : '' }}" href="{{ route('withdrawal') }}">
						Withdraw
					</a>
				</li>
			</ul>
		</div>
	</div>
	<!-- Secondary menu end -->

	<!-- Content ============================================= -->
	<div id="content" class="py-4">
		<div class="container">
			<h2 class="font-weight-400 text-center mt-3 mb-4">Deposit Money</h2>
			<div class="row">
				<div class="col-md-8 col-lg-6 col-xl-5 mx-auto">
					<div class="bg-light shadow-sm rounded p-3 p-sm-4 mb-4">

						<!-- Deposit Money Form ============================================= -->
						<form wire:submit.prevent='deposit'>
							<div class="form-group">
								<label for="paymentMethod">Payment Method</label>
								<select id="cardType" class="custom-select" required wire:model.lazy='payment_method'>
									<option value="">Select Payment Method</option>
									@forelse ($payment_methods as $payment_method)
										<option value="{{ $payment_method->id }}">
											{{ str_replace('_', ' ', Str::title($payment_method->account_type)) }} -
											{{ $payment_method->account_name ?? $payment_method->card_holder }}
										</option>
									@empty
										<option value="">No Payment Method</option>
									@endforelse
								</select>

								@error('payment_method')
									<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label for="bank_name">Bank</label>
								<input type="text" class="form-control" required wire:model.debounce.550ms="bank_name" id="bank_name"
									placeholder="Enter Bank Name">

								@error('bank_name')
									<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
							<div class="form-group">
								<label for="youSend">Amount</label>
								<div class="input-group">
									<div class="input-group-prepend"> <span class="input-group-text">₵</span> </div>
									<input type="text" class="form-control" id="amount" wire:model.debounce.550ms="amount"
										placeholder="Enter Amount to deposit">
									<div class="input-group-append">
										<span class="input-group-text p-0">
											<select id="youSendCurrency" disabled class="form-control bg-transparent">
												<option value="₵">GHS</option>
											</select>
										</span>
									</div>
								</div>

								@error('amount')
									<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>

							@php
								$method = \App\Models\PaymentMethod::where('id', $this->payment_method)->first();
								$this->bank_name = $method?->bank_name ?? $method?->momo_provider;
							@endphp

							@if (isset($method))
								<div class="alert alert-info rounded shadow-sm py-3 px-4 px-sm-2 mb-4">
									<div class="row">
										<p class="col-sm-5 opacity-7 text-sm-right mb-0 mb-sm-3">Account Name:</p>
										<p class="col-sm-7">{{ $method?->account_name }}</p>
									</div>
									<div class="row">
										<p class="col-sm-5 opacity-7 text-sm-right mb-0 mb-sm-3">Account Number:</p>
										<p class="col-sm-7">{{ $method?->account_number ?? $method?->card_number }}</p>
									</div>
									<div class="row">
										<p class="col-sm-5 opacity-7 text-sm-right mb-0">Bank Name:</p>
										<p class="col-sm-7 mb-0">{{ $method?->bank_name ?? $method?->momo_provider }}</p>
									</div>
								</div>
							@endif

							<h3 class="text-5 font-weight-400 mb-3">Details</h3>
							<p class="mb-1">Deposit Amount <span class="text-3 float-right">{{ (int) $this->amount }} GHS</span></p>
							<p class="mb-1">Fees <span class="text-3 float-right">{{ $setting->transaction_fee }} GHS</span></p>
							<hr>
							<p class="font-weight-500">
								Total
								<span class="text-3 float-right">
									{{ ($setting->transaction_fee / 100) * (int) $this->amount + (int) $this->amount }}
									GHS
								</span>
							</p>

							<hr>
							<p class="font-weight-500">
								You'll deposit <span class="text-3 float-right">
									{{ ($setting->transaction_fee / 100) * (int) $this->amount + (int) $this->amount }} GHS
								</span>
							</p>
							<button class="btn btn-primary btn-block">Continue</button>
						</form>
						<!-- Deposit Money Form end -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Content end -->


</div>
