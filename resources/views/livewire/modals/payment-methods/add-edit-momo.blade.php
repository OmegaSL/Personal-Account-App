<!-- Add New MOMO Details Modal ================================== -->
<div wire:ignore.self id="add-edit-momo-details" class="modal fade" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title font-weight-400">
					{{ $this->momo_update_mode == true ? 'Edit ' : 'Add ' }} a Mobile Money
				</h5>
				<button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span
						aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body p-4">
				@if ($this->momo_update_mode == true)
					<form wire:submit.prevent='updateMobileMoneyDetails'>
					@else
						<form wire:submit.prevent='addMobileMoneyDetails'>
				@endif
				<div class="form-group">
					<label for="momo_provider">Mobile Money Provider</label>
					<select id="momo_provider" class="custom-select" required wire:model.lazy='momo_provider'>
						<option value="">Select Card Type</option>
						<option value="MTN">MTN</option>
						<option value="Vodafone">Vodafone</option>
						<option value="AirtelTigo">AirtelTigo</option>
					</select>

					@error('momo_provider')
						<span class="text-danger">{{ $message }}</span>
					@enderror
				</div>
				<div class="form-group">
					<label for="account_number">Account Number</label>
					<input type="text" class="form-control" id="account_number" required wire:model.defer='account_number'
						placeholder="Card Number">

					@error('account_number')
						<span class="text-danger">{{ $message }}</span>
					@enderror
				</div>
				<div class="form-group">
					<label for="account_name">Account Name</label>
					<input type="text" class="form-control" wire:model.defer="account_name" id="account_name" required
						value="" placeholder="Card Holder Name">

					@error('account_name')
						<span class="text-danger">{{ $message }}</span>
					@enderror
				</div>
				<button class="btn btn-primary btn-block" type="submit">
					{{ $this->momo_update_mode == true ? 'Update ' : 'Add ' }} Mobile Money
				</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Credit or Debit Cards End -->
