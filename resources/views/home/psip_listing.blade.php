@extends('layouts.app-master')

@section('content')
@auth
    <div class="bg-light p-5 rounded">
        
        <h1>PSIP Activities for {{$division}}</h1>
        <p class="lead">For fiscal 2023</p>
        <p class="lead">Only authenticated users can access this section.</p>
        
    </div>
    <div class="bg-light p-5 rounded">       
        
        
        <table class="table table-bordered">
          <tr>
             <th width="1%">PSIP Code</th>
             <th>PSIP Name/Desctription</th>
             <th width="3%" colspan="3">Action</th>
             <th>Tags</th>
          </tr>
            @foreach ($psips as $key => $psip)
            <tr>
                <td>{{ $psip->code }}</td>
                <td>{{ $psip->psip_name }} - {{ $psip->description }}</td>
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('psip.show', $psip->id) }}">Show</a>
                </td>
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('psipupload.edit', $psip->id) }}">Edit</a>
                </td>
                
            </tr>
            @endforeach
        </table>

        <div class="d-flex">
            {!! $psips->links() !!}
        </div>
        
    </div>

    
    <div class="bg-light p-5 rounded">        
         
             
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