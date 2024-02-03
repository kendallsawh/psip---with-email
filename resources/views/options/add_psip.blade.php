@extends('layouts.app-master')

@section('content')
@auth
    <div class="bg-light p-5 rounded">
        
        <h1>Add a Department or Division</h1>
        <p class="lead">Only authenticated users can access this section.</p>
        
    </div>

    <div class="bg-light p-4 rounded">
        

        <div class="container mt-4">

            <form method="POST" action="{{ route('psip.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="psip_code" class="form-label">PSIP Code</label>
                    <input value="{{ old('psip_code') }}" 
                        type="text" 
                        class="form-control" 
                        name="psip_code" 
                        required>

                    @if ($errors->has('psip_code'))
                        <span class="text-danger text-left">{{ $errors->first('psip_code') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="psip_name" class="form-label">PSIP Name</label>
                    <input value="{{ old('psip_name') }}" 
                        type="text" 
                        class="form-control" 
                        name="psip_name" 
                        required>

                    @if ($errors->has('psip_name'))
                        <span class="text-danger text-left">{{ $errors->first('psip_name') }}</span>
                    @endif
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
                    <label for="allocation" class="form-label">Allocation for the current financial year</label>
                    <input value="{{ old('allocation') }}" 
                        type="number" 
                        class="form-control" 
                        name="allocation"
                        placeholder="Numbers only. Decimals allowed" 
                        required>

                    @if ($errors->has('allocation'))
                        <span class="text-danger text-left">{{ $errors->first('allocation') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start/Approval Date</label>
                    <input value="{{ old('start_date') }}" 
                        type="text" 
                        class="form-control" 
                        name="start_date" 
                        required>
                        <p><strong>Note: This input only captures the date the vote was approved. The system will record the active date as the <u>current financial year</u>.</strong></p>

                    @if ($errors->has('start_date'))
                        <span class="text-danger text-left">{{ $errors->first('start_date') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea value="{{ old('description') }}" 
                        type="text" 
                        class="form-control" 
                        name="description" 
                        placeholder="Drag lower right hand corner to expand." required></textarea>

                    @if ($errors->has('description'))
                        <span class="text-danger text-left">{{ $errors->first('description') }}</span>
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