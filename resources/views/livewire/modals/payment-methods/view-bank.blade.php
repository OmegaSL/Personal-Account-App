<!-- Edit Bank Account Details Modal ======================================== -->
<div wire:ignore.self id="bank-account-details" class="modal fade" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered transaction-details" role="document">
		<div class="modal-content">
			<div class="modal-body">
				@if ($this->payment_method_id)
					<div class="row no-gutters">
						<div class="col-sm-5 d-flex justify-content-center bg-primary rounded-left py-4">
							<div class="my-auto text-center">
								<div class="text-17 text-white mb-3"><i class="fas fa-university"></i></div>
								<h3 class="text-6 text-white my-3">{{ $this->account_name }}</h3>
								<div class="text-4 text-white my-4">
									@php
										// separate the card number into 4 digits each
										$backAccountNumber = str_split($this->account_number, 4);
										
										// replace the first 12 digits with X
										$backAccountNumber[0] = 'XXXX';
										
										// join the array back into a string
										$backAccountNumber = implode('-', $backAccountNumber);
									@endphp
									{{ Str::limit($backAccountNumber, 9, '') }} | GHS
								</div>
								<p class="bg-light text-0 text-body font-weight-500 rounded-pill d-inline-block px-2 line-height-4 mb-0">
									Primary</p>
							</div>
						</div>
						<div class="col-sm-7">
							<h5 class="text-5 font-weight-400 m-3">Bank Account Details
								<button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true" wire:click='resetFields'>&times;</span> </button>
							</h5>
							<hr>
							<div class="px-3">
								<ul class="list-unstyled">
									<li class="font-weight-500">Account Type:</li>
									<li class="text-muted">{{ $this->account_type }}</li>
								</ul>
								<ul class="list-unstyled">
									<li class="font-weight-500">Account Name:</li>
									<li class="text-muted">{{ $this->account_name }}</li>
								</ul>
								<ul class="list-unstyled">
									<li class="font-weight-500">Account Number:</li>
									<li class="text-muted">
										@php
											// separate the card number into 4 digits each
											$backAccountNumber = str_split($this->account_number, 4);
											
											// replace the first 12 digits with X
											$backAccountNumber[0] = 'XXXX';
											$backAccountNumber[1] = 'XXXX';
											$backAccountNumber[2] = 'XXXX';
											
											// join the array back into a string
											$backAccountNumber = implode('-', $backAccountNumber);
											
											echo $backAccountNumber;
										@endphp
									</li>
								</ul>
								<ul class="list-unstyled">
									<li class="font-weight-500">Bank Country:</li>
									<li class="text-muted">
										@php
											foreach ($this->world_countries as $key => $value) {
											    if ($value['alpha2'] == $this->bank_country) {
											        $this->bank_country = $value['name'];
											    }
											}
										@endphp
										{{ $this->bank_country ?? 'Not Provided' }}
									</li>
								</ul>
								<ul class="list-unstyled">
									<li class="font-weight-500">Status:</li>
									<li class="text-muted">
										@if ($this->status)
											Approved
											<span class="text-success text-3">
												<i class="fas fa-check-circle"></i>
											</span>
										@else
											Pending
											<span class="text-info text-3">
												<i class="fas fa-redo"></i>
											</span>
										@endif
									</li>
								</ul>
								<p>
									<a href="#!" class="btn btn-sm btn-outline-danger btn-block shadow-none"
										onclick="confirm('Are you sure you want to delete this payment method?') || event.stopImmediatePropagation()"
										wire:click='deletePaymentMethod({{ $this->payment_method_id }})'>
										<span class="mr-1">
											<i class="fas fa-minus-circle"></i>
										</span>
										Delete Account
									</a>
								</p>
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
