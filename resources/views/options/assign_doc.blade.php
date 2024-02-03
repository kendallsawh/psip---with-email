@extends('layouts.app-master')

@section('content')
@auth
    <div class="bg-light p-5 rounded">
        
        <h1>Add a Department or Division</h1>
        <p class="lead">Only authenticated users can access this section.</p>
        
    </div>

    <div class="bg-light p-4 rounded">
        

        <div class="container mt-4">

            <form method="POST" action="{{ route('assign.store') }}" enctype="multipart/form-data">
                @csrf
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
                    <label for="psip" class="form-label">Vote Number - PSIP Name</label>
                    
                    <select id="psip" name="psip" class="form-control dropdown">
                        <!-- Options will be dynamically populated based on selected division -->
                    </select>    

                    @if ($errors->has('psip'))
                        <span class="text-danger text-left">{{ $errors->first('psip') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="activity" class="form-label">Activity</label>
                    
                    <select id="activity" name="activity" class="form-control dropdown">
                        <!-- Options will be dynamically populated based on selected psip -->
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
                <a href="{{ route('home.index') }}" class="btn btn-default">Cancel</a>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
    var getPsipsUrl = "{{ route('get.psips', ['division' => ':id']) }}";
    var getActivitiesUrl = "{{ route('get.activities', ['psip' => ':id']) }}";
    $(document).ready(function() {
        $('#division').change(function() {
            var divisionId = $(this).val();
            var url = getPsipsUrl.replace(':id', divisionId);
            $.get(url, function(data) {
                $('#psip').empty();
                $('#psip').append('<option disabled="" selected=""></option>');
                $.each(data, function(index, psip) {
                    $('#psip').append('<option value="' + psip.id + '">' + psip.code + ' - '+psip.psip_name + '</option>');
                });
            });
        });

        $('#psip').change(function() {
            var psipId = $(this).val();
            var url = getActivitiesUrl.replace(':id', psipId);
            $.get(url, function(data) {
                $('#activity').empty();
                $('#activity').append('<option disabled="" selected=""></option>');
                $.each(data, function(index, activity) {
                    $('#activity').append('<option value="' + activity.id + '">' + activity.activity_name + '</option>');
                });
            });
        });
    });
</script>


    @endsection