@extends('layouts.app-master')

@section('content')
@auth
    <div class="bg-light p-5 rounded">
        
        <h1>Update PSIPs to current Financial Year</h1>
        <p class="lead">Only authenticated users can access this section.</p>
        
    </div>

    <div class="bg-light p-4 rounded">
        

        <div class="container mt-4">

            <form method="POST" action="{{ route('update.psip.financials.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Update</th>
                                    <th class="text-center">PSIP Name</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($psips as $psip)
                                <tr>
                                    <td>
                                        <input type="checkbox" 
                                        name="psip[{{ $psip->id }}]"
                                        value="{{ $psip->id }}"
                                        class=''
                                        onclick="showObjective({{ $psip['id'] }})">
                                    </td>
                                    <td>{{ $psip->psip_name }} - <b>{{ $psip->code }}</b>
                                        <p id="op_obj[{{ $psip->id }}]" style="display:none;"><b>Please update objectives as necessary</b></p>
                                        <textarea class="form-control" name="objective[{{ $psip->id }}]" id="objective[{{ $psip->id }}]" style="display:none" rows="4">
                                            {{ $psip->psipDetails->first()->details }}
                                        </textarea>
                                        
                                        @foreach($psip->activities as $activity)
                                        <div class="form-check" id="formcheck[{{ $psip->id }}]" style="display:none">
                                            <input type="checkbox" 
                                            name="activity[{{ $activity->id }}]"
                                            value="{{ $activity->id }}"
                                            class='form-check-input' style="display:none"
                                            id="activity[{{ $psip->id }}]">
                                            <label class="form-check-label" for="activity[{{ $psip->id }}]" style="display:none" id="label[{{ $psip->id }}]">
                                                {{ $activity->activity_name }}
                                            </label>
                                        </div>

                                        @endforeach
                                        
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


                <button type="submit" class="btn btn-primary">Update</button>
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
function showObjective(id) {
    //alert(id);
    $('#objective\\[' + id + '\\]').show();
    $('#op_obj\\[' + id + '\\]').show();
    $('#activity\\[' + id + '\\]').show();
    $('#label\\[' + id + '\\]').show();
    $('#formcheck\\[' + id + '\\]').show();
}

    
</script>

    @endsection