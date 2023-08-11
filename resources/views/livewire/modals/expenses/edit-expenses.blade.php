<!-- Edit Expenses Details Modal ======================================== -->
<div wire:ignore.self id="editExpenseModal" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static"
	data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title font-weight-400">Edit expense</h5>
				<button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"
					wire:click='resetFields'>
					<span aria-hidden="true">
						&times;
					</span>
				</button>
			</div>
			<div class="modal-body p-4">
				<form wire:submit.prevent='updateExpense'>
					<div class="form-group">
						<label for="expense_category">Expense category</label>
						<select class="custom-select" id="expense_category" name="expense_category" wire:model.defer='expense_category'>
							<option value=""> --- Please Select --- </option>
							@forelse ($categories as $category)
								<option value="{{ $category->id }}">{{ $category->name }}</option>
							@empty
								<option value="">No category found</option>
							@endforelse
						</select>

						@error('expense_category')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>

					<div class="form-group">
						<label for="title">Expense Title</label>
						<input type="text" class="form-control" id="title" required wire:model.defer='title'
							placeholder="Expense Title">

						@error('title')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>

					<div class="form-group">
						<label for="amount">Expense Amount</label>
						<input type="number" min="0" class="form-control" id="title" required wire:model.defer='amount'
							placeholder="Expense Amount">

						@error('amount')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>

					<div class="form-group">
						<label for="description">Expense Description</label>
						<textarea class="form-control" wire:model.defer='description' cols="5" rows="3"></textarea>

						@error('description')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>

					<button class="btn btn-primary btn-block" type="submit">
						Save Changes
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Expenses End -->
