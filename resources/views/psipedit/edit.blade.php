@extends('layouts.app-master')

@section('content')
@auth
    <!-- <div class="bg-light p-5 rounded">
        
        <h1></h1>
        <p class="lead">Only authenticated users can access this section.</p>
        
    </div>
 -->
    <div class="bg-light p-4 rounded">
        <h2>Edit PSIP</h2>
        <div class="lead">
            
        </div>

        <div class="container mt-4">

            <form method="POST" action="{{ route('psip.update', $psip->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- PSIP Names Section -->
                <h6>PSIP Name Details</h6>
                <div class="form-group">
                    <label for="psip_name">PSIP Name</label>
                    <input type="text" class="form-control" id="psip_name" name="psip_name" value="{{ $psip->psip_name }}">
                </div>

                <!-- PSIP Details Section for Current Financial Year -->
                <h6>PSIP Details for Current Financial Year</h6>
                <div class="form-group">
                    <label for="details">Details</label>
                    <textarea class="form-control" id="details" name="details" rows="4">{{ $psip->psipDetailForCurrentYear ? $psip->psipDetailForCurrentYear->details : '' }}
                    </textarea>
                </div>

                
                <!-- ... other fields for psip_details based on current financial year ... -->

                <!-- PSIP Financials Section (Dynamic) -->
                <h6>PSIP Financials</h6>
                @foreach ($psip->psipDetailForCurrentYear->psipFinancials as $financial)
                <div class="financial-section mb-4">
                    <div class="form-group">
                        <label for="actual_expenditure">Actual Expenditure</label>
                        <input type="number" step="0.01" class="form-control" id="actual_expenditure" name="actual_expenditure[]" value="{{ $financial->actual_expenditure }}">
                    </div>
                    
                    <div class="form-group mt-2">
                        <label for="approved_estimates">Approved Estimates</label>
                        <input type="number" step="0.01" class="form-control" id="approved_estimates" name="approved_estimates[]" value="{{ $financial->approved_estimates }}">
                    </div>
                    
                    <div class="form-group mt-2">
                        <label for="revised_estimates">Revised Estimates</label>
                        <input type="number" step="0.01" class="form-control" id="revised_estimates" name="revised_estimates[]" value="{{ $financial->revised_estimates }}">
                    </div>
                    
                    <small class="form-text text-muted">
                        These values are based on the financial year: {{ $financial->financial_year }}
                    </small>
                </div>
                @endforeach


                <!-- Activities Section (Dynamic) -->
                <h6>Activities</h6>
                @if($psip->activities->count())
                @foreach ($psip->activities as $activity)
                <div class="activity-section mb-3">
                    <div class="form-group">
                        <label for="activity_name">Activity Name</label>
                        <input type="text" class="form-control" id="activity_name" name="activity_name[]" value="{{ $activity->activity_name }}">
                    </div>
                    
                    @if($activity->activityParticulars->count())
                    @foreach($activity->activityParticulars as $particular)
                    <div class="particular-section" style="margin-left: 20px;">
                        <div class="form-group">
                            <label for="particulars">Particulars</label>
                            <input type="text" class="form-control" id="particulars" name="particulars[]" value="{{ $particular->particulars }}">
                        </div>
                        <div class="form-group">
                            <label for="particulars_cost">Particulars Cost</label>
                            <input type="number" step="0.01" class="form-control" id="particulars_cost" name="particulars_cost[]" value="{{ $particular->particulars_cost }}">
                        </div>
                    </div>
                    @endforeach
                    @else
                    <small class="text-muted">No particulars for this activity.</small>
                    @endif
                </div>
                @endforeach
                @else
                <small class="text-muted">No activities available.</small>
                @endif


                


                <button type="submit" class="btn btn-primary">Save Changes</button>
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

