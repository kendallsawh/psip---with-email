@extends('layouts.app-master')

@section('content')
@auth
    <div class="bg-light p-5 rounded">
        
        <h1>Add a Department or Division</h1>
        <p class="lead">Only authenticated users can access this section.</p>
        
    </div>

    <div class="bg-light p-4 rounded">
        

        <div class="container mt-4">

            <form method="POST" action="{{ route('activities.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="psip" class="form-label">Vote Number - PSIP Name</label>
                    
                    <select id="psip" name="psip" class="form-control dropdown">
                        <option disabled="" selected=""></option>
                        @foreach($psips as $psip)
                        <option value="{{$psip->id}}" {{old('psip')==$psip->id ? 'selected' : '' }}>{{$psip->code}} - {{$psip->psip_name}}</option>
                        @endforeach
                    </select>    

                    @if ($errors->has('psip'))
                        <span class="text-danger text-left">{{ $errors->first('psip') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="activity" class="form-label">Activity Name</label>
                    <input value="{{ old('activity') }}" 
                        type="text" 
                        class="form-control" 
                        name="activity" 
                        required>

                    @if ($errors->has('activity'))
                        <span class="text-danger text-left">{{ $errors->first('activity') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="allocation" class="form-label">Allocation</label>
                    <input value="{{ old('allocation') }}" 
                        type="number" 
                        class="form-control" 
                        name="allocation" 
                        required>

                    @if ($errors->has('allocation'))
                        <span class="text-danger text-left">{{ $errors->first('allocation') }}</span>
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
<script type="text/javascript">

    
</script>

    @endsection