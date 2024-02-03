<!-- Modal -->
<div class="modal fade" id="currExpModal" tabindex="-1" aria-labelledby="currExpModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="currExpModalLabel">Edit</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<!-- Your Form Here -->
				<form class="" method="POST" action="{{ route('psip.updatecurrexp', $psip->id) }}" enctype="multipart/form-data">
					@csrf
					<div class="mb-3">
						<label for="current_expenditure" class="form-label">Edit Current Expenditure</label>
						<input type="number" class="form-control" id="current_expenditure" name="current_expenditure">
					</div>
					<button type="submit" class="btn btn-primary">Edit</button>
					<button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
				</form>
			</div>
		</div>
	</div>
</div>
