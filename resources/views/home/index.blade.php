@extends('layouts.app-master')
@section('css')
<style type="text/css">
    .stacked-badge, .btn-stacked {
      display: block;
      width: 100%; /* Makes it take full available width */
      margin-bottom: 5px; /* Adds a little margin for separation */
      text-align: center; /* Centers the text */
  }


</style>
@endsection
@section('content')
@auth

<div class="container">
    <div class="card">
        <div class="card-body">
            <h1 class="card-title">Division Listing</h1>
            
            <p class="lead">For financial {{$financial_year}}</p>
            <hr>
            <div class="row justify-content-end">
                <div class="col-lg-3">
                    <span class="badge rounded-pill bg-primary stacked-badge"><a href="#" class="text-light" style="text-decoration: none">Consolidated Fund(CF)</a></span>
                    <span class="badge rounded-pill bg-success stacked-badge"><a href="#" class="text-light" style="text-decoration: none">Infrastructure Development Fund(IDF)</a></span>
                    <span class="badge rounded-pill bg-info stacked-badge"><a href="{{ route('psip.prev_yrs') }}" class="text-light" style="text-decoration: none">View previous years</a></span>
                    <!-- <a href="{{ route('psip.prev_yrs') }}" class="btn btn-primary btn-sm btn-rounded btn-stacked rounded-pill">View previous years</a> -->

                </div>
            </div>

            <br>

            <table class="table  table-hover">
                <thead>
                    <tr>

                     <th>Division Name</th>
                     <th>PSIP</th>
                     @role('admin')
                     <th width="10%" colspan="3">Status</th>
                     @endrole
                     @role('planning|ict|contributor')
                     <th width="3%" colspan="3">Status</th>
                     @endrole
                 </tr>
             </thead>
             <tbody>
                @foreach ($divisions as $key => $division)
                <!-- {{ $division->psipNames->count() == 0 ? 'table-warning' : '' }} use this to highlight rows -->
                <tr class="">


                    <td class="fw-normal">{{ $division->division_name }} -  

                    </td>
                    <td>
                        @forelse($division->psipNames as $psip)
                        <ul class="d-flex justify-content-between align-items-start">
                            <a href="{{ route('psip.show', $psip->id) }}" style="text-decoration: none">{{$psip->psip_name}} - <strong>{{$psip->code}}</strong>                                
                            </a> 
                            <span class="badge rounded-pill bg-{{$psip->group->subitem->item->fundType->id==1?'success':'primary'}}">Type: {{$psip->group->subitem->item->fundType->slug}}</span>
                            <!-- <span>{{$psip->group->subitem->item->fundType->fund_type}}</span> -->
                        </ul>
                        @empty
                        <ul>No Projects</ul>
                        
                        @endforelse
                        
                    </td>
                    
                    <td>
                        @forelse($division->psipNames as $psip)
                        

                        <ul class="d-flex">
                            @role('planning|admin')
                            <span class="badge rounded-pill bg-warning"><a href="{{ route('dataentry.create',$psip->id) }}" class="text-light" style="text-decoration: none">Data Entry</a></span>
                            @endrole
                           <span class="badge rounded-pill bg-{{$psip->status_id==3?'danger':'success'}}">{{$psip->status->status}}</span> 
                        </ul>
                        
                        @empty
                        @endforelse
                    </td>
                    <!-- <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('psipupload.edit', $division->id) }}">Edit PSIP</a>
                    </td> -->

                </tr>
                @endforeach
            </tbody>
            
        </table>

        <div class="d-flex">
            {!! $divisions->links() !!}
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
<script type="text/javascript">


</script>

@endsection