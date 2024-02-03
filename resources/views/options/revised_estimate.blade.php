<!-- Modal -->
<div class="modal fade" id="revEstModal" tabindex="-1" aria-labelledby="revEstModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="revEstModalLabel">Edit</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<!-- Your Form Here -->
				
				<form class="" method="POST" action="{{ route('psip.updaterevisedest', $psip->id) }}" enctype="multipart/form-data">
					@csrf
					<div class="mb-3">
						<label for="revised_estimates" class="form-label">Edit Revised Estimate</label>
						<input type="number" class="form-control" id="revised_estimates" name="revised_estimates">
					</div>
					<button type="submit" class="btn btn-primary">Edit</button>
					<button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
				</form>
			</div>
		</div>
	</div>
</div>
