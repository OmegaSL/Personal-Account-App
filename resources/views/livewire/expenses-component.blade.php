@section('title', 'Expenses')

<div>

	<!-- Content ============================================= -->
	<div id="content" class="py-4">
		<div class="container">
			<div class="row">

				@include('shared.sidebar')

				<!-- Middle Panel ============================================= -->
				<div class="col-lg-9">

					<h2 class="font-weight-400 mb-3">Expenses</h2>

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
										<a href="#!" class="btn-link" wire:click.prevent='resetFields'>
											Reset Filters
											<i class="fas fa-sliders-h text-3 ml-1"></i>
										</a>
									</div>
									{{-- <!-- Statements Link ========================= -->
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
									</div> --}}

									<!-- All Filters Link ========================= -->
									<div class="col-auto d-flex align-items-center mr-auto form-group" data-toggle="collapse">
										<a class="btn-link" data-toggle="collapse" href="#allFilters" aria-expanded="false"
											aria-controls="allFilters">
											Add Category
											<i class="fas fa-plus text-3 ml-1"></i>
										</a>
									</div>
									<!-- All Filters collapse ================================ -->
									<div class="col-12 collapse mb-3" id="allFilters" wire:ignore.self>
										<div class="form-group">
											<input type="text" id="allTransactions" wire:model.defer='category_name' class="form-control"
												placeholder="Expense Category Name">

											@error('category_name')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
										<div class="custom-control custom-radio custom-control-inline">
											<button class="btn btn-sm btn-primary" wire:click.prevent='storeCategory'>Add New</button>
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
						<div class="d-flex justify-content-between mb-3">
							<h3 class="text-5 font-weight-400 d-flex align-items-center px-4 mb-3">
								All Transactions
							</h3>
							<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addExpenseModal">
								Add Expense
							</button>
						</div>

						<!-- Expenses List =============================== -->
						<div class="transaction-list table-responsive">
							<table class="table table-light">
								<thead class="thead-light">
									<tr>
										<th>#</th>
										<th>Expense Category</th>
										<th>Title</th>
										<th>Amount</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@forelse ($expenses as $expense)
										<tr>
											<td>{{ $loop->iteration }}</td>
											<td>{{ $expense->expenseCategory?->name }}</td>
											<td>{{ $expense->title }}</td>
											<td>{{ $expense->amount }}</td>
											<td>{{ $expense->status ? 'Active' : 'Inactive' }}</td>
											<td>
												<button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editExpenseModal"
													wire:click="editExpense({{ $expense->id }})">
													<i class="fas fa-edit"></i>
												</button>
												<button class="btn btn-sm btn-danger" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
													wire:click="deleteExpense({{ $expense->id }})">
													<i class="fas fa-trash"></i>
												</button>
											</td>
										</tr>
									@empty
										<tr>
											<td colspan="5" class="text-center">No Records Found!</td>
										</tr>
									@endforelse
								</tbody>
							</table>
						</div>
						<!-- Expenses List End -->

						@include('livewire.modals.expenses.add-expenses')
						@include('livewire.modals.expenses.edit-expenses')

						<!-- Pagination ============================================= -->
						<ul class="pagination justify-content-center mt-4 mb-0">
							{{ $expenses->links() }}
						</ul>
						<!-- Paginations end -->

					</div>
					<!-- All Expenses End -->
				</div>
				<!-- Middle End -->
			</div>
		</div>
	</div>
	<!-- Content end -->

</div>
