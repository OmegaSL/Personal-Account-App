@section('title', 'Home')

<div>

	<!-- Content ============================================= -->
	<div id="content" class="py-4">
		<div class="container">
			<div class="row">
				@include('shared.sidebar')

				<!-- Middle Panel ============================================= -->
				<div class="col-lg-9">

					<!-- Profile Completeness =============================== -->
					<div class="bg-light shadow-sm rounded p-4 mb-4">
						<h3 class="text-5 font-weight-400 d-flex align-items-center mb-3">
							Profile Completeness
							{{-- <span class="bg-light-4 text-success rounded px-2 py-1 font-weight-400 text-2 ml-2">50%</span> --}}
						</h3>
						<div class="row profile-completeness">
							<div class="col-sm-6 col-md-3 mb-4 mb-md-0">
								<div class="border rounded p-3 text-center">
									<span class="d-block text-10 text-light mt-2 mb-3">
										<i class="fas fa-mobile-alt"></i>
									</span>
									@if ($this->user->phone)
										<span class="text-5 d-block text-success mt-4 mb-3">
											<i class="fas fa-check-circle"></i>
										</span>
										<p class="mb-0">Mobile Added</p>
									@else
										<span class="text-5 d-block text-light mt-4 mb-3">
											<i class="far fa-circle "></i>
										</span>
										<p class="mb-0">
											<a class="btn-link stretched-link" href="{{ route('profile') }}">Add Mobile</a>
										</p>
									@endif
								</div>
							</div>
							<div class="col-sm-6 col-md-3 mb-4 mb-md-0">
								<div class="border rounded p-3 text-center">
									<span class="d-block text-10 text-light mt-2 mb-3">
										<i class="fas fa-envelope"></i>
									</span>
									@if ($this->user->email)
										<span class="text-5 d-block text-success mt-4 mb-3">
											<i class="fas fa-check-circle"></i>
										</span>
										<p class="mb-0">Email Added</p>
									@else
										<span class="text-5 d-block text-light mt-4 mb-3">
											<i class="far fa-circle "></i>
										</span>
										<p class="mb-0">
											<a class="btn-link stretched-link" href="{{ route('profile') }}">Add Email</a>
										</p>
									@endif
								</div>
							</div>
							<div class="col-sm-6 col-md-3 mb-4 mb-sm-0">
								<div class="border rounded p-3 text-center">
									<span class="d-block text-10 text-light mt-2 mb-3">
										<i class="fas fa-credit-card"></i>
									</span>
									@if ($this->user->paymentMethods->count() > 0)
										<span class="text-5 d-block text-success mt-4 mb-3">
											<i class="fas fa-check-circle"></i>
										</span>
										<p class="mb-0">Card Added</p>
									@else
										<span class="text-5 d-block text-light mt-4 mb-3">
											<i class="far fa-circle "></i>
										</span>
										<p class="mb-0">
											<a class="btn-link stretched-link" href="{{ route('profile-account') }}">Add Card</a>
										</p>
									@endif
								</div>
							</div>
							<div class="col-sm-6 col-md-3">
								<div class="border rounded p-3 text-center">
									<span class="d-block text-10 text-light mt-2 mb-3">
										<i class="fas fa-university"></i>
									</span>
									@if ($this->user->paymentMethods->count() > 0)
										<span class="text-5 d-block text-success mt-4 mb-3">
											<i class="fas fa-check-circle"></i>
										</span>
										<p class="mb-0">Bank Account Added</p>
									@else
										<span class="text-5 d-block text-light mt-4 mb-3">
											<i class="far fa-circle "></i>
										</span>
										<p class="mb-0">
											<a class="btn-link stretched-link" href="{{ route('profile-account') }}">Add Bank Account</a>
										</p>
									@endif
								</div>
							</div>
						</div>
					</div>
					<!-- Profile Completeness End -->

					<!-- Recent Activity =============================== -->
					<div class="bg-light shadow-sm rounded py-4 mb-4">
						<h3 class="text-5 font-weight-400 d-flex align-items-center px-4 mb-3">Recent Activity</h3>

						<!-- Title =============================== -->
						<div class="transaction-title py-2 px-4">
							<div class="row">
								<div class="col-2 col-sm-1 text-center"><span class="">Date</span></div>
								<div class="col col-sm-7">Description</div>
								<div class="col-auto col-sm-2 d-none d-sm-block text-center">Status</div>
								<div class="col-3 col-sm-2 text-right">Amount</div>
							</div>
						</div>
						<!-- Title End -->

						<!-- Transaction List =============================== -->
						<div class="transaction-list">
							@forelse ($recent_transactions as $transaction)
								<div class="transaction-item px-4 py-3" data-toggle="modal" data-target="#transaction-detail"
									wire:click='show_transaction_details({{ $transaction->id }})'>
									<div class="row align-items-center flex-row">
										<div class="col-2 col-sm-1 text-center">
											<span class="d-block text-4 font-weight-300">{{ $transaction->created_at->format('d') }}</span>
											<span
												class="d-block text-1 font-weight-300 text-uppercase">{{ $transaction->created_at->format('M') }}</span>
										</div>
										<div class="col col-sm-7">
											<span class="d-block text-4">
												{{ $transaction->payment_method != null ? str_replace('_', ' ', $transaction->payment_method?->account_type) : 'N/A or Deleted' }}
											</span>
											<span class="text-muted">
												@if ($transaction->payment_method)
													{{ $transaction->type }} to
													{{ $transaction->payment_method != null ? str_replace('_', ' ', $transaction->payment_method?->account_type) : 'N/A or Deleted' }}
													Account
												@else
													N/A or Deleted
												@endif
											</span>
										</div>
										<div class="col-auto col-sm-2 d-none d-sm-block text-center text-3">
											@if ($transaction->status == 'completed')
												<span class="text-success" data-toggle="tooltip" data-original-title="Completed">
													<i class="fas fa-check-circle"></i>
												</span>
											@elseif ($transaction->status == 'failed' || $transaction->status == 'cancelled')
												<span class="text-danger" data-toggle="tooltip" data-original-title="Failed">
													<i class="fas fa-times-circle"></i>
												</span>
											@elseif ($transaction->status == 'pending')
												<span class="text-warning" data-toggle="tooltip" data-original-title="Pending">
													<i class="fas fa-ellipsis-h"></i>
												</span>
											@endif
										</div>
										<div class="col-3 col-sm-2 text-right text-4"> <span class="text-nowrap">
												@php
													$total = $transaction->amount + $transaction->amount * $transaction->fee;
												@endphp
												{{ $setting->currency != null ? $setting->currency : '₵' }}{{ $total }}
											</span>
											<span class="text-2 text-uppercase">(GHS)</span>
										</div>
									</div>
								</div>
							@empty
								<div class="transaction-item px-4 py-3">
									<div class="row align-items-center flex-row">
										<div class="col-12 col-sm-12 text-center">
											<span class="d-block text-4 font-weight-300">No recent transactions</span>
										</div>
									</div>
								</div>
							@endforelse
						</div>
						<!-- Transaction List End -->

						@include('livewire.modals.transactions.transaction-details')

						<!-- View all Link =============================== -->
						<div class="text-center mt-4">
							<a href="{{ route('transactions') }}" class="btn-link text-3">
								View all
								<i class="fas fa-chevron-right text-2 ml-2"></i>
							</a>
						</div>
						<!-- View all Link End -->

					</div>
					<!-- Recent Activity End -->
				</div>
				<!-- Middle Panel End -->
			</div>
		</div>
	</div>
	<!-- Content end -->

</div>
