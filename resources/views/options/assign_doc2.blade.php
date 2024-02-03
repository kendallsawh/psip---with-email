<!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="formModalLabel">Assign Form</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<!-- Your Form Here -->
				<form method="POST" action="{{ route('assign.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="d-none">
						<input type="text" name="psip" value="{{$psip->id}}">
					</div>
					
					<div class="mb-3">
						<label for="division" class="form-label">Division/Department Name</label>
						<select id="division" name="division" class="form-control dropdown">
							<option disabled="" selected=""></option>
							@foreach($divisions as $division)
							<option value="{{$division->id}}" {{old('division')==$division->id ? 'selected' : '' }}>{{$division->division_name}}</option>
							@endforeach
						</select>  
						@if ($errors->has('division'))
						<span class="text-danger text-left">{{ $errors->first('division') }}</span>
						@endif
					</div>
					<div class="mb-3">
						<label for="activity" class="form-label">Activity</label>

						<select id="activity" name="activity" class="form-control dropdown">
							<option disabled="" selected=""></option>
							@foreach($activities as $activity)
							<option value="{{$activity->id}}" {{old('activity')==$activity->id ? 'selected' : '' }}>{{$activity->activity_name}}</option>
							@endforeach
						</select>    
						@if ($errors->has('activity'))
						<span class="text-danger text-left">{{ $errors->first('activity') }}</span>
						@endif
					</div>
					<div class="mb-3">
						<label for="doctype" class="form-label">Document Type</label>

						<select id="doctype" name="doctype" class="form-control dropdown">
							<option disabled="" selected=""></option>
							@foreach($doctypes as $doctype)
							<option value="{{$doctype->id}}" {{old('doctype')==$doctype->id ? 'selected' : '' }}>{{$doctype->code}} - {{$doctype->doc_type_name}}</option>
							@endforeach
						</select>    
						@if ($errors->has('doctype'))
						<span class="text-danger text-left">{{ $errors->first('doctype') }}</span>
						@endif
					</div>
					<button type="submit" class="btn btn-primary">Add</button>
					<button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
				</form>
			</div>
		</div>
	</div>
</div>
