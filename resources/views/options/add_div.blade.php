@extends('layouts.app-master')

@section('content')
@auth
    <div class="bg-light p-5 rounded">
        
        <h1>Add a Department or Division</h1>
        <p class="lead">Only authenticated users can access this section.</p>
        
    </div>

    <div class="bg-light p-4 rounded">
        

        <div class="container mt-4">

            <form method="POST" action="{{ route('division.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="division" class="form-label">Division/Department Name</label>
                    <input value="{{ old('division') }}" 
                        type="text" 
                        class="form-control" 
                        name="division" 
                        required>

                    @if ($errors->has('division'))
                        <span class="text-danger text-left">{{ $errors->first('division') }}</span>
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