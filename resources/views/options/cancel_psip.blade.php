<!-- Modal -->
<div class="modal fade" id="cancelPsipModal" tabindex="-1" aria-labelledby="cancelPsipModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="cancelPsipModalLabel">Surpress PSIP</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<!-- Your Form Here -->
				<form class="" method="POST" action="{{ route('psip.cancelpsip', $psip->id) }}" enctype="multipart/form-data">
					@csrf
					<h6><strong>You are about to set this psip to the status of Cancelled/Surpress. Please take a moment to review the implications of this action.</strong></h6>
					
					
					<button type="submit" class="btn btn-danger">Continue to Surpress Request</button>
					<button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Close">Go back where its safe</button>
				</form>
			</div>
		</div>
	</div>
</div>
