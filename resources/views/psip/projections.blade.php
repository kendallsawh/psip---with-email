@extends('layouts.app-master')

@section('content')
@auth
    
    <div class="bg-light p-4 rounded">
        <h2>Edit PSIP</h2>
        <div class="lead">            
        </div>
        <div class="container mt-4">
            <form method="POST" action="{{ route('psip.store_projection', $psip->id) }}" enctype="multipart/form-data">
                @csrf
                
                <!-- PSIP Names Section -->
                <h6>PSIP Name</h6>
                <div class="form-group">
                    <label for="psip_name">PSIP Name</label>
                    <input type="text" class="form-control" id="psip_name" name="psip_name" value="{{ $psip->psip_name }}" readonly/>
                </div>
                <br>
                <!-- PSIP Details Section for Current Financial Year -->
                <div class="financial-section mb-4">
	                <h6>PSIP Details for Current Financial Year</h6>
	                <div class="form-group">
	                    <label for="details">Details</label>
	                    <textarea class="form-control" id="details" name="details" rows="4"></textarea>
	                </div>
	                
					<div class="form-group">
	                        <label for="draft_est">Draft Estimates</label>
	                        <input type="number" step="0.01" class="form-control" id="draft_est" name="draft_est" value="" required/>
	                    </div> 
					<div class="form-group">
						<label for="draft_est_year">Draft Estimate Year</label>
						<input type="number" min="2025" max="2099" step="1" class="form-control" id="draft_est_year" name="draft_est_year" required />
					</div>
				</div>
				


                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
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

