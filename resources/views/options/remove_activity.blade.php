<!-- Modal -->
<div class="modal fade" id="activityRemoveModal" tabindex="-1" aria-labelledby="activityRemoveModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="activityRemoveModalLabel">Assign Form</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<!-- Your Form Here -->
				<form class="" method="POST" action="{{ route('activities.removeactivity') }}" enctype="multipart/form-data">
					@csrf
					<h6><strong>You are about to remove this activity. Please take a moment to review the implications of this action.</strong></h6>
					<input type="text" name="remove_activity" id="remove_activity" value="" style="display: none;">
					
					<button type="submit" class="btn btn-danger">Continue to Remove Activity</button>
					<button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Close">Go back where its safe</button>
				</form>
			</div>
		</div>
	</div>
</div>