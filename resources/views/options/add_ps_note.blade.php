<!-- Modal -->
<div class="modal fade" id="psNoteModal" tabindex="-1" aria-labelledby="psNoteModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="screeningBriefModalLabel">Add PS Note</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<!-- Your Form Here -->
				<form class="" method="POST" action="{{ route('psipupload.addpsnote', $psip->id) }}" enctype="multipart/form-data">
					@csrf
					<div class="mb-3"><label for="file_upload" class="form-label">Document Upload</label>
                    <input class="form-control" 
                        name="file_upload" 
                        type="file" 
                        placeholder="Document Type" required>
                    </div>
                    <!-- <div class="mb-3"><label for="screening_date" class="form-label">Document Date</label>
                    <input class="form-control" 
                        name="screening_date" 
                        type="text" 
                        placeholder="Document Date">
                    </div>	 -->
						
					
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
				</form>
			</div>
		</div>
	</div>
</div>
