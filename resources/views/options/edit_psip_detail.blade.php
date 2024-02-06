<!-- Modal -->
<div class="modal fade" id="psipDetailModal" tabindex="-1" aria-labelledby="psipDetailModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="psipDetailModalLabel">Update PSIP Details for {{$psip->code}}</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<!-- Your Form Here -->
				<form class="" method="POST" action="{{ route('psip.editpsipdetails', $psip->id) }}" enctype="multipart/form-data">
					@csrf
					<div class="mb-3">
                    <label for="psip_detail" class="form-label">PSIP Detail</label>
                    
                    <textarea class="form-control" name="psip_detail" id="psip_detail" rows="4">{{ $psip->psipDetailForCurrentYear->details }}</textarea>

                    @if ($errors->has('psip_detail'))
                        <span class="text-danger text-left">{{ $errors->first('psip_detail') }}</span>
                    @endif
                </div>					
					
					<button type="submit" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
				</form>
			</div>
		</div>
	</div>
</div>
