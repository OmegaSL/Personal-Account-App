@section('title', 'Saving Deductions')

<div>

	<!-- Content ============================================= -->
	<div id="content" class="py-4">
		<div class="container">
			<div class="row">

				@include('shared.sidebar')

				<!-- Middle Panel ============================================= -->
				<div class="col-lg-9">

					<h2 class="font-weight-400 mb-3">Deduction</h2>

					<!-- Filter ============================================= -->
					<div class="row">
						<div class="col mb-2">
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
								<!-- Reset Link ========================= -->
								<div class="col-auto d-flex align-items-center mr-auto form-group">
									<a class="btn-link" href="#allFilters" wire:click.prevent='resetFilter'>
										Reset Filter
										<i class="fas fa-recycle text-3 ml-1"></i>
									</a>
								</div>

								<!-- Search Field ========================= -->
								<div class="col-auto d-flex align-items-center ml-auto form-group">
									<button class="btn btn-primary btn-block" data-toggle="modal" data-target="#addDeductionModal">
										Add Deduction
									</button>
								</div>

							</div>
						</div>
					</div>
					<!-- Filter End -->

					<!-- All Deductions ============================================= -->
					<div class="bg-light shadow-sm rounded py-4 mb-4">
						<h3 class="text-5 font-weight-400 d-flex align-items-center px-4 mb-3">All Deductions</h3>

						<!-- Deduction List =============================== -->
						<div class="transaction-list table-responsive">
							<table class="table table-light">
								<thead class="thead-light">
									<tr>
										<th>#</th>
										<th>Name</th>
										<th>Frequency</th>
										<th>Period</th>
										<th>Amount</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@forelse ($deductions as $deduction)
										<tr>
											<td>{{ $loop->iteration }}</td>
											<td>{{ $deduction->name }}</td>
											<td>{{ $deduction->frequency }}</td>
											<td>
												{{ $deduction->period }}
												{{ str_replace('ly', '', $deduction->frequency) }}'s
											</td>
											<td>{{ $setting->currency }}{{ $deduction->amount }}</td>
											<td>
												@if ($deduction->status)
													<span class="text-success">Active</span>
												@else
													<span class="text-danger">Inactive</span>
												@endif
											</td>
											<td>
												<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#viewDeductionModal"
													wire:click="viewDeduction({{ $deduction->id }})">
													<i class="fas fa-eye"></i>
												</button>
												@if ($deduction->end_date < now() && $deduction->receive_status == 0)
													<button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editDeductionModal"
														wire:click="editDeduction({{ $deduction->id }})">
														<i class="fas fa-edit"></i>
													</button>
													<button class="btn btn-sm btn-dark" wire:click="receiveDeduction({{ $deduction->id }})">
														<i class="fas fa-money-bill"></i>
													</button>
												@endif
												{{-- <button class="btn btn-sm btn-danger" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
													wire:click="deleteDeduction({{ $deduction->id }})">
													<i class="fas fa-trash"></i>
												</button> --}}
											</td>
										</tr>
									@empty
										<tr>
											<td colspan="6" class="text-center">No deductions found</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>
						<!-- Deduction List End -->

						<!-- Pagination ============================================= -->
						<ul class="pagination justify-content-center mt-4 mb-0">
							{{ $deductions->links() }}
						</ul>
						<!-- Paginations end -->

					</div>
					<!-- All Deductions End -->

					@include('livewire.modals.deductions.add-deduct')
					@include('livewire.modals.deductions.edit-deduct')
					@include('livewire.modals.deductions.view-deduct-histories')

				</div>
				<!-- Middle End -->
			</div>
		</div>
	</div>
	<!-- Content end -->

</div>

@section('scripts')
	<script>
		window.addEventListener('deductionUpdate', event => {
			$('#editDeductionModal').modal('hide');
		})

		window.addEventListener('deductionStore', event => {
			$('#addDeductionModal').modal('hide');
		})
	</script>
@endsection
