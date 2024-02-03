<!-- Modal -->
<div class="modal fade" id="appEstModal" tabindex="-1" aria-labelledby="appEstModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="appEstModalLabel">Edit</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<!-- Your Form Here -->
				<form class="" method="POST" action="{{ route('psip.updatedapproveest', $psip->id) }}" enctype="multipart/form-data">
					@csrf
					<div class="mb-3">
						<label for="approved_estimates" class="form-label">Edit Approved Estimates</label>
						<input type="number" class="form-control" id="approved_estimates" name="approved_estimates">
					</div>
					<button type="submit" class="btn btn-primary">Edit</button>
					<button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
				</form>
			</div>
		</div>
	</div>
</div>
