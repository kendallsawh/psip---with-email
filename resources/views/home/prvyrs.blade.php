@extends('layouts.app-master')

@section('content')
@auth
<div class="bg-light p-5 rounded">

    <h1>PSIP Database</h1>
    <p class="lead">Only authenticated users can access this section.</p>

</div>
<div class="bg-light p-5 rounded">       

 <div class="row">

        
        <div class="col-lg-4 offset-md-4">
            <div class="card " >
                <div class="card-content " >
                    <div class="card-header text-center">
                        Please select a year
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="" class="btn btn-primary btn-lg col-sm-12">2021</a></li>
                        <li class="list-group-item"><a href="" class="btn btn-primary btn-lg col-sm-12">2022</a></li>
                        <li class="list-group-item"><a href="" class="btn btn-primary btn-lg col-sm-12">2023</a></li>
                    </ul>
                </div>
                
            </div>
        </div>
        
</div>


    
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