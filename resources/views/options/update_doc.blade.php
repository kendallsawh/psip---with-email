<!-- Modal -->
<div class="modal fade" id="updateDocumentModal" tabindex="-1" aria-labelledby="updateDocumentModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="updateDocumentModalLabel">Update Document</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<!-- Your Form Here -->
				<form class="" method="POST" action="{{ route('psipdocument.update') }}" enctype="multipart/form-data">
					@csrf
					<input type="text" name="update_doc_id" id="update_doc_id" value="" style="display: none;">
					<input type="text" name="update_activity_doc_id" id="update_activity_doc_id" value="" style="display: none;">
					<div class="mb-3"><label for="file_upload" class="form-label">Document Upload</label>
                    <input class="form-control" 
                        name="file_upload" 
                        type="file" 
                        placeholder="Document Type" required>
                    </div>	
						
					
					<button type="submit" class="btn btn-primary">Update</button>
					<button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
				</form>
			</div>
		</div>
	</div>
</div>
