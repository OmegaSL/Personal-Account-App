@section('title', 'Transactions')

<div>

	<!-- Content ============================================= -->
	<div id="content" class="py-4">
		<div class="container">
			<div class="row">

				@include('shared.sidebar')

				<!-- Middle Panel ============================================= -->
				<div class="col-lg-9">

					<h2 class="font-weight-400 mb-3">Transactions</h2>

					<!-- Filter ============================================= -->
					<div class="row">
						<div class="col mb-2">
							<form id="filterTransactions" method="post">
								<div class="form-row">
									<!-- Date Range ========================= -->
									<div class="col-sm-3 col-md-3 form-group">
										<label for="date-range">Date From</label>
										<input type="date" class="form-control" placeholder="Date Range From" wire:model="dateFrom">
									</div>
									<div class="col-sm-3 col-md-3 form-group">
										<label for="date-range">Date To</label>
										<input type="date" class="form-control" placeholder="Date Range To" wire:model="dateTo">
									</div>
									<!-- All Filters Link ========================= -->
									<div class="col-auto d-flex align-items-center mr-auto form-group" data-toggle="collapse">
										<a class="btn-link" data-toggle="collapse" href="#allFilters" aria-expanded="false"
											aria-controls="allFilters">
											All Filters
											<i class="fas fa-sliders-h text-3 ml-1"></i>
										</a>
									</div>
									<!-- Statements Link ========================= -->
									<div class="col-auto d-flex align-items-center ml-auto form-group">
										<div class="dropdown">
											<a class="text-muted btn-link" href="#" role="button" id="statements" data-toggle="dropdown"
												aria-haspopup="true" aria-expanded="false">
												<i class="fas fa-file-download text-3 mr-1"></i>
												Statements
											</a>
											<div class="dropdown-menu dropdown-menu-right" aria-labelledby="statements">
												<a class="dropdown-item" href="#">CSV</a>
												<a class="dropdown-item" href="#">PDF</a>
											</div>
										</div>
									</div>

									<!-- All Filters collapse ================================ -->
									<div class="col-12 collapse mb-3" id="allFilters" wire:ignore.self>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="allTransactions" name="allFilters" class="custom-control-input" checked>
											<label class="custom-control-label" for="allTransactions">All Transactions</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="paymentsSend" name="allFilters" class="custom-control-input" value="pending"
												wire:model='filterBy'>
											<label class="custom-control-label" for="paymentsSend">Payments Pending</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="paymentsReceived" name="allFilters" class="custom-control-input" value="completed"
												wire:model='filterBy'>
											<label class="custom-control-label" for="paymentsReceived">Payments Completed</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="refunds" name="allFilters" class="custom-control-input" value="cancelled"
												wire:model='filterBy'>
											<label class="custom-control-label" for="refunds">Failed/Cancelled</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="withdrawal" name="allFilters" class="custom-control-input" value="withdrawal"
												wire:model='filterBy'>
											<label class="custom-control-label" for="withdrawal">Withdrawal</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="deposit" name="allFilters" class="custom-control-input" value="deposit"
												wire:model='filterBy'>
											<label class="custom-control-label" for="deposit">Deposit</label>
										</div>
									</div>
									<!-- All Filters collapse End -->
								</div>
							</form>
						</div>
					</div>
					<!-- Filter End -->

					<!-- All Transactions ============================================= -->
					<div class="bg-light shadow-sm rounded py-4 mb-4">
						<h3 class="text-5 font-weight-400 d-flex align-items-center px-4 mb-3">All Transactions</h3>
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
							@forelse ($transactions as $transaction)
								<div class="transaction-item px-4 py-3" data-toggle="modal" data-target="#transaction-detail"
									wire:click='show_transaction_details({{ $transaction->id }})'>
									<div class="row align-items-center flex-row">
										<div class="col-2 col-sm-1 text-center">
											<span class="d-block text-4 font-weight-300">{{ $transaction->created_at->format('d') }}</span>
											<span
												class="d-block text-1 font-weight-300 text-uppercase">{{ $transaction->created_at->format('M') }}</span>
										</div>
										<div class="col col-sm-7">
											<span
												class="d-block text-4">{{ str_replace('_', ' ', Str::title($transaction->payment_method?->account_type)) ?? 'N/A or Deleted' }}</span>
											<span class="text-muted">
												@if ($transaction->payment_method)
													{{ $transaction->type }} to
													{{ str_replace('_', ' ', Str::title($transaction->payment_method?->account_type)) ?? 'N/A or Deleted' }}
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

						<!-- Pagination ============================================= -->
						<ul class="pagination justify-content-center mt-4 mb-0">
							{{ $transactions->links() }}
						</ul>
						<!-- Paginations end -->

					</div>
					<!-- All Transactions End -->
				</div>
				<!-- Middle End -->
			</div>
		</div>
	</div>
	<!-- Content end -->

</div>
