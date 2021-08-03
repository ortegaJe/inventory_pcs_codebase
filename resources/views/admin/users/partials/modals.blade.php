<!-- Pop In Modal -->
<form action="{{ route('admin.inventory.technicians.update-password', $users->id) }}" method="POST">
	@csrf
	@method('PATCH')
	<div class="modal fade" id="modal-popin" tabindex="-1" role="dialog" aria-labelledby="modal-popin" aria-hidden="true">
		<div class="modal-dialog modal-dialog-popin" role="document">
			<div class="modal-content">
				<div class="block block-themed block-transparent mb-0">
					<div class="block-header bg-primary-dark">
						<h3 class="block-title">Update Password</h3>
						<div class="block-options">
							<button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
								<i class="si si-close"></i>
							</button>
						</div>
					</div>
					<div class="block-content">
						<div class="form-group row">
							<div class="col-12">
								<div class="form-material input-group floating">
									<input type="password" class="form-control" id="password" name="password">
									<label for="password">Password</label>
									<div class="input-group-append">
										<span class="input-group-text">
											<i class="fa fa-asterisk"></i>
										</span>
									</div>
								</div>
								@if($errors->has('password'))
								<small class="text-danger is-invalid">{{ $errors->first('password') }}</small>
								@endif
							</div>
						</div>
						<div class="form-group row">
							<div class="col-12 mb-4">
								<div class="form-material input-group floating">
									<input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
									<label for="password_confirmation">Confirm Password</label>
									<div class="input-group-append">
										<span class="input-group-text">
											<i class="fa fa-asterisk"></i>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-alt-success">
						<i class="fa fa-check"></i> Update
					</button>
				</div>
			</div>
		</div>
	</div>
</form>
<!-- END Pop In Modal -->