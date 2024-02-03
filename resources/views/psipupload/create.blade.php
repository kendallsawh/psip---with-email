@extends('layouts.app-master')

@section('content')
@auth
    <div class="bg-light p-5 rounded">
        
        <h1>{{$activity->activity_name}}</h1>
        <p class="lead">Only authenticated users can access this section.</p>
        
    </div>

    <div class="bg-light p-4 rounded">
        <h2>Attach Document</h2>
        <div class="lead">
            Attach a document to an existing Activity. <b>**You can provide further details about the document in the description box**.</b>
        </div>

        <div class="container mt-4">

            <form method="POST" action="{{ route('psipupload.store', $activity->id) }}" enctype="multipart/form-data">
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

                <div class="mb-3">
                    <label for="doc_type" class="form-label">Document Type</label>
                    
                    <select id="doc_type" name="doc_type" class="form-control dropdown">
                        <option disabled="" selected=""></option>
                        @foreach($doc_types as $doc_type)
                        <option value="{{$doc_type->id}}" {{old('doc_type')==$doc_type->id ? 'selected' : '' }}>{{$doc_type->code}} - {{$doc_type->doc_type_name}}</option>
                        @endforeach
                    </select>    

                    @if ($errors->has('doc_type'))
                        <span class="text-danger text-left">{{ $errors->first('doc_type') }}</span>
                    @endif
                </div>
                
                <div class="mb-3">
                    <label for="file_upload" class="form-label">Document Upload</label>
                    <input class="form-control" 
                        name="file_upload" 
                        type="file" 
                        placeholder="Document Type" required>

                    @if ($errors->has('file_upload'))
                        <span class="text-danger text-left">{{ $errors->first('file_upload') }}</span>
                    @endif
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
                

                <button type="submit" class="btn btn-primary">Upload Document</button>
                <a href="{{ route('posts.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
    
    <div class="bg-light p-5 rounded">        
        
            
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
<script type="text/javascript">

    
</script>

    @endsection