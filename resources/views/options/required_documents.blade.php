<!-- Modal -->
<div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="documentModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="documentModalLabel">List of <u>applicable</u> documents to upload for each activity</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<table class="table  table-hover" id="tabledoc">
					<thead>
						<tr>

							<th>Document Name</th>
							<th>Uploaded</th>
						</tr>
					</thead>
					<tbody>
						@foreach($doctypes as $key => $doc)
						<tr class="">
							<td class="fw-normal">  
								{{$key+1}}. {{$doc->doc_type_name}}
							</td>
							<td>
							</td>
						</tr>
						@endforeach
					</tbody>

				</table>
			</div>
		</div>
	</div>
</div>
