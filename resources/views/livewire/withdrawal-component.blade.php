@section('title', 'Withdrawal')

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

	<!-- Content
		============================================= -->
	<div id="content" class="py-4">
		<div class="container">
			<h2 class="font-weight-400 text-center mt-3 mb-4">Withdraw Money</h2>
			<div class="row">
				<div class="col-md-8 col-lg-6 col-xl-5 mx-auto">
					<!-- Withdraw Money Form
								============================================= -->
					<div class="bg-light shadow-sm rounded p-3 p-sm-4 mb-4">
						<div class="text-center bg-primary p-4 rounded mb-4">
							<h3 class="text-10 text-white font-weight-400">
								@php
									// get user basic balance if basic_balance is selected or saving balance if saving_balance is selected
									$balance = $this->balance_type;
									$balance = auth()->user()->$balance;
								@endphp
								{{ $setting->currency }}
								{{ number_format($balance, 2) }}
							</h3>
							<p class="text-white">Available Balance</p>
							<select class="custom-select" wire:model='balance_type'>
								<option value="basic_balance">Basic Balance</option>
								<option value="saving_balance">Saving Balance</option>
							</select>
						</div>
						<form wire:submit.prevent='withdrawal'>
							<div class="form-group">
								<label for="paymentMethod">Withdraw to</label>
								<select id="cardType" class="custom-select" required wire:model.lazy='payment_method'>
									<option value="">Select Payment Method</option>
									@forelse ($payment_methods as $payment_method)
										<option value="{{ $payment_method->id }}">
											{{ str_replace('_', ' ', Str::title($payment_method->account_type)) }} -
											{{ $payment_method->account_name }}
											{{ $payment_method->momo_provider != null ? '(' . $payment_method->momo_provider . ')' : '' }}
										</option>
									@empty
										<option value="">No Payment Method</option>
									@endforelse
								</select>

								@error('payment_method')
									<p class="text-danger">{{ $message }}</p>
								@enderror
							</div>
							<div class="form-group">
								<label for="youSend">Amount</label>
								<div class="input-group">
									<div class="input-group-prepend"> <span class="input-group-text">₵</span> </div>
									<input type="text" class="form-control" id="amount" wire:model.debounce.550ms="amount"
										placeholder="Enter Amount to deposit">
								</div>

								@error('amount')
									<p class="text-danger">{{ $message }}</p>
								@enderror
							</div>

							@php
								$method = \App\Models\PaymentMethod::where('id', $this->payment_method)->first();
								$this->bank_name = $method?->bank_name ?? $method?->momo_provider;
							@endphp

							@if (isset($method))
								<p class="text-4 text-center alert alert-info">You are Withdraw money <br>
									to<br>
									<span class="font-weight-500">
										{{ $method?->bank_name ?? $method?->momo_provider }} - {{ $method?->account_number }}
									</span>
								</p>
							@endif

							<p class="mb-2 mt-4">Amount to Withdraw <span class="text-3 float-right">{{ (int) $this->amount }} GHS</span>
							</p>
							<p class="text-muted">
								Transactions fees
								<span class="float-right d-flex align-items-center">
									{{ $setting->transaction_fee }} GHS
								</span>
							</p>
							<hr>

							<p class="font-weight-500">
								Total
								<span class="text-3 float-right">
									{{ ($setting->transaction_fee / 100) * (int) $this->amount + (int) $this->amount }}
									GHS
								</span>
							</p>

							<button class="btn btn-primary btn-block">Continue</button>
						</form>
						<!-- Withdraw Money Confirm end -->

					</div>
					<!-- Withdraw Money Form end -->

				</div>

			</div>
		</div>
	</div>
	<!-- Content end -->

</div>
