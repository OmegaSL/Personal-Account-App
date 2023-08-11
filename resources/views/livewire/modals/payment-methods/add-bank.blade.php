<!-- Add New Bank Account Details Modal ======================================== -->
<div wire:ignore.self id="add-new-bank-account" class="modal fade" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title font-weight-400">Add bank account</h5>
				<button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span
						aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body p-4">
				<form wire:submit.prevent='addBankAccountDetails'>
					<div class="form-group">
						<label for="bank_country">Bank Country</label>
						<select class="custom-select" id="bank_country" name="bank_country" wire:model.defer='bank_country'>
							<option value=""> --- Please Select --- </option>
							@foreach ($this->world_countries as $key => $value)
								<option value="{{ $value['alpha2'] }}" {{ $value['alpha2'] == $this->bank_country ? 'selected' : '' }}>
									{{ $value['name'] }}
								</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="bank_name">Bank Name</label>
						<input type="text" class="form-control" id="bank_name" required wire:model.defer='bank_name'
							placeholder="Bank Name">

						@error('bank_name')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="account_number">Account Number</label>
						<input type="text" class="form-control" id="account_number" required wire:model.defer='account_number'
							placeholder="Bank Account Number">

						@error('account_number')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="account_name">Account Name</label>
						<input type="text" class="form-control" wire:model.defer="account_name" id="account_name" required
							value="" placeholder="Bank Account Name">

						@error('account_name')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<button class="btn btn-primary btn-block" type="submit">
						Add Bank Account
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Bank Accounts End -->
