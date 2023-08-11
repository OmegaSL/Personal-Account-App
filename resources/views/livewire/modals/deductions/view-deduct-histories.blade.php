<!-- View Deduction Details Modal ======================================== -->
<div wire:ignore.self id="viewDeductionModal" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static"
	data-keyboard="false">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			@if ($this->deduction_histories)
				<div class="modal-header">
					<h5 class="modal-title font-weight-400">
						View Deduction History,
						{{ $this->view_deduction->start_date->format('d M, Y') }} -
						{{ $this->view_deduction->end_date->format('d M, Y') }}
					</h5>
					<button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"
						wire:click='resetInputFields'>
						<span aria-hidden="true">
							&times;
						</span>
					</button>
				</div>
				<div class="modal-body p-4">
					<!-- Deduction List =============================== -->
					<div class="transaction-list table-responsive">
						<table class="table table-light">
							<thead class="thead-light">
								<tr>
									<th>#</th>
									<th>Amount</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
								@forelse ($this->deduction_histories as $deduction)
									<tr>
										<td>{{ $loop->iteration }}</td>
										<td>{{ $setting->currency }}{{ $deduction->amount }}</td>
										<td>
											{{ $deduction->created_at->format('d M, Y') }}
										</td>
									</tr>
								@empty
									<tr>
										<td colspan="3" class="text-center">No deduction histories found</td>
									</tr>
								@endforelse
							</tbody>
						</table>

					</div>
					<!-- Deduction List End -->
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
<!-- Bank Accounts End -->
