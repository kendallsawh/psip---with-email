@extends('layouts.app-master')
@section('css')
    <style>
        .draggable {
            cursor: grab;
        }
        .dropzone {
            min-height: 50px;
            border: 2px dashed #cccccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
        }
        .drag-enter {
            background-color: #f0f0f0;
        }
    </style>
@endsection
@section('content')
@auth
<meta name="csrf-token" content="{{ csrf_token() }}">

<div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
  <!-- Position it at the end of the page -->
  <div style="position: absolute; top: 0; right: 0;">

    <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <strong class="me-auto">Notification</strong>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        Your action was successful!
      </div>
    </div>

  </div>
</div>


<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Documents (Drag from here)</h4>
                    <div id="documents" class="list-group">
                        <!-- Example Document Items -->
                        @foreach($documents as $key=>$document)
                        @if(is_null($document->doc_group_id))
                        <div class="list-group-item draggable" draggable="true" data-id="{{$document->id}}">{{$document->docType->doc_type_name}}{{$document->doc_title? ' - '.$document->doc_title:''}}</div>
                        @endif
                        @endforeach

                    </div>
                </div>
                <div class="col-md-6">
                    <h4>Document Folders/Groups (Drop here)</h4>
                    <!-- Example DocGroup Items -->
                    @foreach($doc_groups as $key=>$doc_group)
                    <div class="dropzone" data-group-id="{{$doc_group->id}}">
                        <h5>{{$doc_group->group_name}}</h5>
                        @foreach($documents as $key=>$document)
                        @if($document->doc_group_id == $doc_group->id)
                        <div class="list-group-item draggable" draggable="true" data-id="{{$document->id}}">{{$document->docType->doc_type_name}}{{$document->doc_title? ' - '.$document->doc_title:''}}</div>
                        @endif
                        @endforeach
                    </div>
                    @endforeach
                    <!-- <div class="dropzone" data-group-id="1">
                        <h5>Agricultural Planning</h5>
                        
                    </div>
                    <div class="dropzone" data-group-id="2">
                        <h5>Procurement</h5>
                    </div>
                    <div class="dropzone" data-group-id="3">
                        <h5>Group 3</h5>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endauth
@guest
<div class="bg-light p-5 rounded">

    <h1>Homepage</h1>
    <p class="lead">Please login to view the restricted data.</p>

</div>
@endguest
@endsection
@section("scripts")
<!-- Include jQuery -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script>
$(document).ready(function() {
    let draggedItem = null;

    $('.draggable').on('dragstart', function(e) {
        draggedItem = $(this); // Store the dragged item
        setTimeout(function() {
            draggedItem.addClass('d-none'); // Temporarily hide the item being dragged
        }, 0);
    });

    $('.draggable').on('dragend', function() {
        // Ensure the d-none class is removed when dragging ends, in case the drop doesn't trigger
        if (draggedItem) {
            draggedItem.removeClass('d-none');
        }
        draggedItem = null;
    });

    $('.dropzone').on('dragover', function(e) {
        e.preventDefault(); // Prevent default to allow drop
        $(this).addClass('drag-enter');
    });

    $('.dropzone').on('dragleave', function(e) {
        $(this).removeClass('drag-enter');
    });

    $('.dropzone').on('drop', function(e) {
        e.preventDefault();
        // Ensure the item retains its 'list-group-item' class and any other necessary classes
        $(this).append(draggedItem.removeClass('d-none').addClass('list-group-item'));
        $(this).removeClass('drag-enter');
        // Capture the data-id of the dragged item and the data-group-id of the target drop zone
        let documentId = draggedItem.attr('data-id');
        let groupId = $(this).attr('data-group-id');

        // AJAX call to the Laravel controller
        var getUrl = "{{ route('psipupload.organizesave') }}";
        $.ajax({
            url: getUrl, // Update this URL to your actual Laravel route
            type: 'POST',
            data: {
                documentId: documentId,
                groupId: groupId,
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
            },
            success: function(response) {
                // Handle success
                console.log('Item moved successfully', response);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error('Error moving item', xhr, status, error);
            }
        });
        var toastElement = new bootstrap.Toast(document.getElementById('successToast'));
        toastElement.show();
        draggedItem = null;
    });
});

</script>
@endsection