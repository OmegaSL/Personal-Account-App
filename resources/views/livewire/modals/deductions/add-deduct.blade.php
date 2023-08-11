<!-- Add New Bank Account Details Modal ======================================== -->
<div wire:ignore.self id="addDeductionModal" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static"
	data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title font-weight-400">Add deduction</h5>
				<button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"
					wire:click='resetInputFields'>
					<span aria-hidden="true">
						&times;
					</span>
				</button>
			</div>
			<div class="modal-body p-4">
				<form wire:submit.prevent='addDeduction'>
					<div class="form-group">
						<label for="deduction_name">Deduction Name</label>
						<input type="text" class="form-control" id="deduction_name" required wire:model.defer='deduction_name'
							placeholder="Deduction Name">

						@error('deduction_name')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="deduction_frequency">Deduction Frequency</label>
						<select class="custom-select" id="deduction_frequency" name="deduction_frequency"
							wire:model.defer='deduction_frequency'>
							<option value=""> --- Please Select --- </option>
							<option value="daily">Daily</option>
							<option value="weekly">Weekly</option>
							<option value="monthly">Monthly</option>
							<option value="yearly">Yearly</option>
						</select>
					</div>
					<div class="form-group">
						<label for="deduction_period">Deduction Period</label>
						<input type="number" class="form-control" min="0" id="deduction_period" required
							wire:model.defer='deduction_period' placeholder="Bank Deduction Period">

						@error('deduction_period')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="deduction_amount">Deduction Amount</label>
						<input type="number" class="form-control" min="0" wire:model.defer="deduction_amount"
							id="deduction_amount" required placeholder="Bank Deduction Amount">

						@error('deduction_amount')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="deduction_start_date">Deduction Start Date</label>
						<input type="date" class="form-control" min="{{ date('Y-m-d') }}" wire:model.defer="deduction_start_date"
							id="deduction_start_date" required placeholder="Bank Deduction Start Date">

						@error('deduction_start_date')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="deduction_end_date">Deduction End Date</label>
						<input type="date" class="form-control" min="0" wire:model.defer="deduction_end_date"
							id="deduction_end_date" required placeholder="Bank Deduction End Date">

						@error('deduction_end_date')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="deduction_status">Deduction Status</label>
						<select class="custom-select" id="deduction_status" name="deduction_status" wire:model.defer='deduction_status'>
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select>

						@error('deduction_status')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="deduction_description">Deduction Description</label>
						<textarea class="form-control" wire:model.defer="deduction_description" cols="30" rows="10"
						 placeholder="Deduction Description"></textarea>

						@error('deduction_description')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<p>
							Note: <br>
							Once you add a deduction, it will be automatically be deducted from your basic balance.
							This action cannot be undone.
						</p>
					</div>

					<button class="btn btn-primary btn-block" type="submit">
						Add Deduction
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Bank Accounts End -->
