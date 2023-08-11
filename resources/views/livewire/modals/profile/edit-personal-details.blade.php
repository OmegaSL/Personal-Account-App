<!-- Edit Details Modal ================================== -->
<div wire:ignore.self id="edit-personal-details" class="modal fade " role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title font-weight-400">Personal Details</h5>
				<button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-4">
				<form wire:submit.prevent='updateProfile'>
					<div class="row">
						<div class="col-12">
							@if ($avatar_url)
								Photo Preview: <br>
								<img class="rounded-circle" width="80" src="{{ $avatar_url->temporaryUrl() }}">
								<br>
							@elseif ($this->user->avatar_url)
								Photo Preview: <br>
								<img class="rounded-circle" width="80" src="{{ asset('storage/' . $this->user->avatar_url) }}">
								<br>
							@endif
							<div class="form-group">
								<label for="avatar_url">Profile Picture</label>
								<input type="file" class="form-control" wire:model='avatar_url' id="avatar_url" required
									placeholder="First Name">

								@error('avatar_url')
									<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-12 col-sm-6">
							<div class="form-group">
								<label for="first_name">First Name</label>
								<input type="text" class="form-control" wire:model.defer='first_name' id="first_name" required
									placeholder="First Name">

								@error('first_name')
									<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-12 col-sm-6">
							<div class="form-group">
								<label for="last_name">Last Name</label>
								<input type="text" class="form-control" wire:model.defer='last_name' id="last_name" required
									placeholder="Full Name">

								@error('last_name')
									<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label for="birth_date">Date of Birth</label>
								<div class="position-relative">
									<input id="birth_date" wire:model.defer='birth_date' type="date" class="form-control" required
										placeholder="Date of Birth">

									@error('birth_date')
										<span class="text-danger">{{ $message }}</span>
									@enderror
								</div>
							</div>
						</div>
						<div class="col-12">
							<h3 class="text-5 font-weight-400 mt-3">Address</h3>
							<hr>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label for="address">Address</label>
								<input type="text" class="form-control" wire:model.defer="address" id="address" required
									placeholder="Address 1">

								@error('address')
									<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-12 col-sm-6">
							<div class="form-group">
								<label for="city">City</label>
								<input id="city" wire:model.defer='city' type="text" class="form-control" required placeholder="City">

								@error('city')
									<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-12 col-sm-6">
							<div class="form-group">
								<label for="state">State/Region</label>
								<input id="state" wire:model.defer='state' type="text" class="form-control" placeholder="State">

								@error('state')
									<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-12 col-sm-6">
							<div class="form-group">
								<label for="postal_code">Zip Code</label>
								<input id="postal_code" wire:model.defer='postal_code' type="text" class="form-control"
									placeholder="ZIP Code. eg. 00233">

								@error('postal_code')
									<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
						</div>
						<div class="col-12 col-sm-6">
							<div class="form-group">
								<label for="country">Country</label>
								<select class="custom-select" id="country" name="country" wire:model.defer='country'>
									<option value=""> --- Please Select --- </option>
									@foreach ($this->world_countries as $key => $value)
										<option value="{{ $value['alpha2'] }}" {{ $value['alpha2'] == $this->country ? 'selected' : '' }}>
											{{ $value['name'] }}
										</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<button class="btn btn-primary btn-block mt-2" type="submit" wire:loading.remove>Save Changes</button>
					<button class="btn btn-primary btn-block mt-2" type="button" disabled wire:loading>
						<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
						<span class="sr-only">Loading...</span>
						Loading...
					</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Personal Details End -->
