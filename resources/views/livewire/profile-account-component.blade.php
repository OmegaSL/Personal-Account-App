@section('title', 'Profile Account')

<div>

	<!-- Secondary Menu ============================================= -->
	<div wire:ignore class="bg-primary">
		<div class="container d-flex justify-content-center">
			<ul class="nav secondary-nav">
				<li class="nav-item">
					<a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
						Account
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{ request()->routeIs('profile-account') ? 'active' : '' }}"
						href="{{ route('profile-account') }}">
						Cards & Bank Accounts
					</a>
				</li>
				{{-- <li class="nav-item">
					<a class="nav-link" href="profile-notifications.html">
						Notifications
					</a>
				</li> --}}
			</ul>
		</div>
	</div>
	<!-- Secondary Menu end -->

	<!-- Content ============================================= -->
	<div id="content" class="py-4">
		<div class="container">
			<div class="row">

				@include('shared.sidebar')

				<!-- Middle Panel ============================================= -->
				<div class="col-lg-9">

					{{-- <!-- Credit or Debit Cards ============================================= -->
					<div class="bg-light shadow-sm rounded p-4 mb-4">
						<h3 class="text-5 font-weight-400 mb-4">
							Credit or Debit Cards
							<span class="text-muted text-4"> (for withdrawal) </span>
						</h3>
						<div class="row">
							@foreach ($card_payment_methods as $cardPaymentMethod)
								<div class="col-12 col-sm-6 col-lg-4">
									<div
										class="account-card {{ $cardPaymentMethod->card_type == 'visa' ? 'account-card-primary' : '' }} text-white rounded p-3 mb-4 mb-lg-0">
										<p class="text-4">
											@php
												// separate the card number into 4 digits each
												$cardNumber = str_split($cardPaymentMethod->card_number, 4);

												// replace the first 12 digits with X
												$cardNumber[0] = 'XXXX';
												$cardNumber[1] = 'XXXX';
												$cardNumber[2] = 'XXXX';

												// join the array back into a string
												$cardNumber = implode('-', $cardNumber);

												echo $cardNumber;
											@endphp
										</p>
										<p class="d-flex align-items-center"> <span
												class="account-card-expire text-uppercase d-inline-block opacity-6 mr-2">
												Valid<br> thru<br>
											</span>
											<span class="text-4 opacity-9">
												{{ $cardPaymentMethod->card_expiry }}
											</span>
										</p>
										<p class="d-flex align-items-center m-0">
											<span class="text-uppercase font-weight-500">
												{{ $cardPaymentMethod->card_holder }}
											</span>
											<img class="ml-auto" style="width: 48px;"
												src="{{ $cardPaymentMethod->card_type == 'visa' ? asset('assets/images/payment/visa.png') : asset('assets/images/payment/mastercard.png') }}"
												alt="visa" title="">
										</p>

										<div class="account-card-overlay rounded">
											<a href="#" wire:click="editCardDetails({{ $cardPaymentMethod->id }})" data-target="#edit-card-details"
												data-toggle="modal" class="text-light btn-link mx-2">
												<span class="mr-1">
													<i class="fas fa-edit"></i>
												</span>
												Edit
											</a>
											<a href="#!" class="text-light btn-link mx-2"
												onclick="confirm('Are you sure you want to delete this payment method?') || event.stopImmediatePropagation()"
												wire:click='deletePaymentMethod({{ $cardPaymentMethod->id }})'>
												<span class="mr-1">
													<i class="fas fa-minus-circle"></i>
												</span>
												Delete
											</a>
										</div>
									</div>
								</div>
							@endforeach

							<div class="col-12 col-sm-6 col-lg-4">
								<a href="" data-target="#add-new-card-details" wire:click="resetFields" data-toggle="modal"
									class="account-card-new d-flex align-items-center rounded h-100 p-3 mb-4 mb-lg-0">
									<p class="w-100 text-center line-height-4 m-0">
										<span class="text-3">
											<i class="fas fa-plus-circle"></i>
										</span>
										<span class="d-block text-body text-3">
											Add New Card
										</span>
									</p>
								</a>
							</div>
						</div>
					</div>

					@include('livewire.modals.payment-methods.edit-card')
					@include('livewire.modals.payment-methods.add-card') --}}

					<!-- Mobile Money ============================================= -->
					<div class="bg-light shadow-sm rounded p-4 mb-4">
						<h3 class="text-5 font-weight-400 mb-4">
							Mobile Money
							<span class="text-muted text-4"> (for deposit and withdrawal) </span>
						</h3>
						<div class="row">
							@foreach ($mobile_money_payment_methods as $momoPaymentMethod)
								<div class="col-12 col-sm-6 col-lg-4">
									<div
										class="account-card {{ $momoPaymentMethod->momo_provider == 'MTN' ? 'account-card-warning' : 'account-card-danger' }} text-white rounded p-3 mb-4 mb-lg-0">
										<p class="text-4">
											@php
												// separate the card number into 4 digits each
												$momoNumber = str_split($momoPaymentMethod->account_number, 4);
												
												// replace the first 12 digits with X
												$momoNumber[0] = 'XXXX';
												$momoNumber[1] = 'XXXX';
												
												// join the array back into a string
												$momoNumber = implode('-', $momoNumber);
												
												echo $momoNumber;
											@endphp
										</p>
										<p class="d-flex align-items-center"> <span
												class="account-card-expire text-uppercase d-inline-block opacity-6 mr-2">
												Provider<br>
											</span>
											<span class="text-4 opacity-9">
												{{ $momoPaymentMethod->momo_provider }}
											</span>
											{{-- <span
												class="bg-light text-0 text-body font-weight-500 rounded-pill d-inline-block px-2 line-height-4 opacity-8 ml-auto">
												Primary
											</span> --}}
										</p>
										<p class="d-flex align-items-center m-0">
											<span class="text-uppercase font-weight-500">
												{{ $momoPaymentMethod->account_name }}
											</span>
											<img class="ml-auto" style="width: 48px;" src="{{ asset('assets/images/payment/mobile-money.svg') }}"
												alt="visa" title="">
										</p>

										<div class="account-card-overlay rounded">
											<a href="#" wire:click="editMobileMoneyDetails({{ $momoPaymentMethod->id }})"
												data-target="#add-edit-momo-details" data-toggle="modal" class="text-light btn-link mx-2">
												<span class="mr-1">
													<i class="fas fa-edit"></i>
												</span>
												Edit
											</a>
											<a href="#!" class="text-light btn-link mx-2"
												onclick="confirm('Are you sure you want to delete this payment method?') || event.stopImmediatePropagation()"
												wire:click='deletePaymentMethod({{ $momoPaymentMethod->id }})'>
												<span class="mr-1">
													<i class="fas fa-minus-circle"></i>
												</span>
												Delete
											</a>
										</div>
									</div>
								</div>
							@endforeach

							<div class="col-12 col-sm-6 col-lg-4">
								<a href="" data-target="#add-edit-momo-details" wire:click="resetFields" data-toggle="modal"
									class="account-card-new d-flex align-items-center rounded h-100 p-3 mb-4 mb-lg-0">
									<p class="w-100 text-center line-height-4 m-0">
										<span class="text-3">
											<i class="fas fa-plus-circle"></i>
										</span>
										<span class="d-block text-body text-3">
											Add New Mobile Money
										</span>
									</p>
								</a>
							</div>
						</div>
					</div>

					@include('livewire.modals.payment-methods.add-edit-momo')


					<!-- Bank Accounts ============================================= -->
					<div class="bg-light shadow-sm rounded p-4 mb-4">
						<h3 class="text-5 font-weight-400 mb-4">
							Bank Accounts
							<span class="text-muted text-4">(for deposit and withdrawal)</span>
						</h3>
						<div class="row">

							@foreach ($bank_payment_methods as $bankPaymentMethod)
								<div class="col-12 col-sm-6">
									<div class="account-card account-card-primary text-white rounded mb-4 mb-lg-0">
										<div class="row no-gutters">
											<div class="col-3 d-flex justify-content-center p-3">
												<div class="my-auto text-center text-13">
													<i class="fas fa-university"></i>
													{{-- <p
														class="bg-light text-0 text-body font-weight-500 rounded-pill d-inline-block px-2 line-height-4 opacity-8 mb-0">
														Primary
                                                    </p> --}}
												</div>
											</div>
											<div class="col-9 border-left">
												<div class="py-4 my-2 pl-4">
													<p class="text-4 font-weight-500 mb-1">{{ $bankPaymentMethod->account_name }}</p>
													<p class="text-4 opacity-9 mb-1">
														@php
															// separate the card number into 4 digits each
															$backAccountNumber = str_split($bankPaymentMethod->account_number, 4);
															
															// replace the first 12 digits with X
															$backAccountNumber[0] = 'XXXX';
															$backAccountNumber[1] = 'XXXX';
															$backAccountNumber[2] = 'XXXX';
															
															// join the array back into a string
															$backAccountNumber = implode('-', $backAccountNumber);
															
															echo $backAccountNumber;
														@endphp
													</p>
													<p class="m-0">
														@if ($bankPaymentMethod->status)
															Approved
															<span class="text-3">
																<i class="fas fa-check-circle"></i>
															</span>
														@else
															Pending
															<span class="text-3">
																<i class="fas fa-redo"></i>
															</span>
														@endif
													</p>
												</div>
											</div>
										</div>
										<div class="account-card-overlay rounded">
											<a href="#" data-target="#bank-account-details" data-toggle="modal"
												wire:click="editBankAccountDetails({{ $bankPaymentMethod->id }})" class="text-light btn-link mx-2"><span
													class="mr-1">
													<i class="fas fa-share"></i>
												</span>
												More Details
											</a>
											<a href="#!" class="text-light btn-link mx-2"
												onclick="confirm('Are you sure you want to delete this payment method?') || event.stopImmediatePropagation()"
												wire:click='deletePaymentMethod({{ $bankPaymentMethod->id }})'>
												<span class="mr-1">
													<i class="fas fa-minus-circle"></i>
												</span>
												Delete
											</a>
										</div>
									</div>
								</div>
							@endforeach

							<div class="col-12 col-sm-6">
								<a href="" data-target="#add-new-bank-account" data-toggle="modal"
									class="account-card-new d-flex align-items-center rounded h-100 p-3 mb-4 mb-lg-0">
									<p class="w-100 text-center line-height-4 m-0">
										<span class="text-3">
											<i class="fas fa-plus-circle"></i>
										</span>
										<span class="d-block text-body text-3">
											Add New Bank Account
										</span>
									</p>
								</a>
							</div>
						</div>
					</div>
					@include('livewire.modals.payment-methods.view-bank')
					@include('livewire.modals.payment-methods.add-bank')

				</div>
				<!-- Middle Panel End -->
			</div>
		</div>
	</div>
	<!-- Content end -->

</div>
