<!-- Transaction Item Details Modal =========================================== -->
<div wire:ignore.self id="transaction-detail" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static"
	data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered transaction-details" role="document">
		<div class="modal-content">
			<div class="modal-body">
				@if ($this->transaction_details)
					<div class="row no-gutters">
						<div class="col-sm-5 d-flex justify-content-center bg-primary rounded-left py-4">
							<div class="my-auto text-center">
								<div class="text-17 text-white my-3"><i class="fas fa-building"></i></div>
								<h3 class="text-4 text-white font-weight-400 my-3">
									{{ $this->transaction_details->payment_method?->account_name }}
								</h3>
								<div class="text-8 font-weight-500 text-white my-4">
									@php
										$total = $this->transaction_details->amount + $this->transaction_details->amount * $this->transaction_details->fee;
									@endphp
									{{ $setting->currency != null ? $setting->currency : '₵' }}
									{{ $total }}
								</div>
								<p class="text-white">
									{{ $this->transaction_details->created_at->format('d F Y') }}
								</p>
							</div>
						</div>
						<div class="col-sm-7">
							<h5 class="text-5 font-weight-400 m-3">Transaction Details
								<button type="button" class="close font-weight-400" wire:click='resetFields' data-dismiss="modal"
									aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</h5>
							<hr>
							<div class="px-3">
								<ul class="list-unstyled">
									<li class="mb-2">
										Payment Amount
										<span class="float-right text-3">
											{{ $setting->currency != null ? $setting->currency : '₵' }}{{ $this->transaction_details->amount }}
										</span>
									</li>
									<li class="mb-2">
										Fee
										<span class="float-right text-3">
											-
											{{ $setting->currency != null ? $setting->currency : '₵' }}{{ $this->transaction_details->amount * $this->transaction_details->fee }}
										</span>
									</li>
								</ul>
								<hr class="mb-2">
								<p class="d-flex align-items-center font-weight-500 mb-4">Total Amount <span class="text-3 ml-auto">
										{{ $setting->currency != null ? $setting->currency : '₵' }}{{ $total }}
									</span>
								</p>
								<ul class="list-unstyled">
									<li class="font-weight-500">Paid By:</li>
									<li class="text-muted">
										{{ $this->transaction_details->payment_method?->account_name ?? 'N/A or Deleted' }}
									</li>
								</ul>
								<ul class="list-unstyled">
									<li class="font-weight-500">Transaction ID:</li>
									<li class="text-muted">
										{{ $this->transaction_details->reference }}
									</li>
								</ul>
								<ul class="list-unstyled">
									<li class="font-weight-500">Description:</li>
									<li class="text-muted">
										{{ $this->transaction_details->type }} to
										{{ str_replace('_', ' ', $this->transaction_details->payment_method?->account_type) }}
										on {{ $this->transaction_details->created_at->format('d F Y') }}
									</li>
								</ul>
								<ul class="list-unstyled">
									<li class="font-weight-500">Status:</li>
									<li class="text-muted">
										{{ Str::title($this->transaction_details->status) }}
									</li>
								</ul>
							</div>
						</div>
					</div>
				@else
					{{-- Create a Spinner in center --}}
					<div id="preloader">
						<div data-loader="dual-ring"></div>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
<!-- Transaction Item Details Modal End -->
