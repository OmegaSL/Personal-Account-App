<!-- Add New Card Details Modal ================================== -->
<div wire:ignore.self id="edit-card-details" class="modal fade" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title font-weight-400">Edit Card</h5>
				<button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span
						aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body p-4">
				<form wire:submit.prevent='updateCardDetails'>
					<div class="form-group">
						<label for="card_type">Card Type</label>
						<select id="card_type" class="custom-select" required wire:model.lazy='card_type'>
							<option value="">Select Card Type</option>
							<option value="visa">Visa</option>
							<option value="mastercard">MasterCard</option>
						</select>

						@error('card_type')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="card_number">Card Number</label>
						<input type="text" class="form-control" id="card_number" required wire:model.defer='card_number'
							placeholder="Card Number">

						@error('card_number')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="card_expiry">Expiry Date</label>
								<input id="card_expiry" type="text" maxlength="5" class="form-control" wire:model.defer='card_expiry'
									required placeholder="MM/YY">

								@error('card_expiry')
									<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="card_cvv">
									CVV <span class="text-info ml-1" data-toggle="tooltip"
										data-original-title="For Visa/Mastercard, the three-digit CVV number is printed on the signature panel on the back of the card immediately after the card's account number. For American Express, the four-digit CVV number is printed on the front of the card above the card account number.">
										<i class="fas fa-question-circle"></i>
									</span>
								</label>
								<input id="card_cvv" type="password" maxlength="3" class="form-control" wire:model.defer="card_cvv" required
									placeholder="CVV (3 digits)">

								@error('card_cvv')
									<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="card_holder">Card Holder Name</label>
						<input type="text" class="form-control" wire:model.defer="card_holder" id="card_holder" required value=""
							placeholder="Card Holder Name">

						@error('card_holder')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<button class="btn btn-primary btn-block" type="submit">Update Card</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Credit or Debit Cards End -->
