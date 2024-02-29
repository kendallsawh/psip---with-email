<!-- Modal -->
<div class="modal fade" id="screeningBriefModal" tabindex="-1" aria-labelledby="screeningBriefModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="screeningBriefModalLabel">Add Screening Brief Document</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<!-- Your Form Here -->
				<form class="" method="POST" action="{{ route('psipupload.addscreeningbrief', $psip->id) }}" enctype="multipart/form-data">
					@csrf
					<div class="mb-3">
						<label for="title" class="form-label">Document Title</label>
						<input value="{{ old('title') }}" 
						type="text" 
						class="form-control" 
						name="title" 
						placeholder="Title" required>

						@if ($errors->has('title'))
						<span class="text-danger text-left">{{ $errors->first('title') }}</span>
						@endif
					</div>
					<div class="mb-3"><label for="file_upload" class="form-label">Document Upload</label>
                    <input class="form-control" 
                        name="file_upload" 
                        type="file" 
                        placeholder="Document Type" required>
                    </div>
                    <div class="mb-3">
                    	<label for="description" class="form-label">Description</label>
                    	<textarea value="{{ old('description') }}" 
                    	type="text" 
                    	class="form-control" 
                    	name="description" 
                    	placeholder="Description" required></textarea>

                    	@if ($errors->has('description'))
                    	<span class="text-danger text-left">{{ $errors->first('description') }}</span>
                    	@endif
                    </div>
                    <div class="mb-3"><label for="screening_date" class="form-label">Document Date</label>
                    <input class="form-control" 
                        name="screening_date" 
                        type="date" 
                        placeholder="Document Date">
                    </div>	
						
					
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
				</form>
			</div>
		</div>
	</div>
</div>
