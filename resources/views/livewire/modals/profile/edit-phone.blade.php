<!-- Edit Details Modal ================================== -->
<div wire:ignore.self id="edit-phone" class="modal fade " role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title font-weight-400">Phone</h5>
				<button type="button" class="close font-weight-400" data-dismiss="modal" aria-label="Close"> <span
						aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body p-4">
				<form wire:submit.prevent='editPhone'>
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label for="phone">Mobile <span class="text-muted font-weight-500">(Primary)</span></label>
								<input type="text" class="form-control" wire:model.defer="phone" id="phone" required
									placeholder="Mobile Number">

								@error('phone')
									<span class="text-danger">{{ $message }}</span>
								@enderror
							</div>
						</div>
					</div>

					<button class="btn btn-primary btn-block" type="submit">Save Changes</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Phone End -->
