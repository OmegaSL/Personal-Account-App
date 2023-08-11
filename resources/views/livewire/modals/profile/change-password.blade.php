<!-- Edit Details Modal ================================== -->
<div wire:ignore.self id="change-password" class="modal fade " role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title font-weight-400">Change Password</h5>
				<button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-4">
				<form wire:submit.prevent='updatePassword'>
					<div class="form-group">
						<label for="current_password">Confirm Current Password</label>
						<input type="text" class="form-control" wire:model.defer="current_password" id="current_password" required
							placeholder="Enter Current Password">

						@error('current_password')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="new_password">New Password</label>
						<input type="text" class="form-control" wire:model.defer="new_password" id="new_password" required
							placeholder="Enter New Password">

						@error('new_password')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group">
						<label for="confirm_password">Confirm New Password</label>
						<input type="text" class="form-control" wire:model.defer="confirm_password" id="confirm_password" required
							placeholder="Enter Confirm New Password">

						@error('confirm_password')
							<span class="text-danger">{{ $message }}</span>
						@enderror
					</div>

					<button class="btn btn-primary btn-block mt-4" type="submit">Update Password</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Security End -->
