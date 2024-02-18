@extends('layouts.app-master')

@section('content')
@auth
    
    <div class="bg-light p-4 rounded">
        <h2>Edit PSIP</h2>
        <div class="lead">
            
        </div>

        <div class="container mt-4">

            <form method="POST" action="{{ route('activities.update', $psip->id) }}" enctype="multipart/form-data">
                @csrf
               
                <!-- PSIP Names Section -->
                <h6>PSIP Name</h6>
                <p>{{ $psip->psip_name.' - '.$psip->code }}</p>
                

                <!-- PSIP Details Section for Current Financial Year -->
                <h6>PSIP Details for Current Financial Year</h6>
                @if($psip->psipDetailForCurrentYear)
                    <p>{{$psip->psipDetailForCurrentYear->details}}</p>
                @else
                <p>No Details Found.</p>
                @endif
                

                <!-- Activities Section -->
                <h6>Activities</h6>
                <p><strong>Note: Only edit the activity if there is a minor changes to its details. If the activty is required to be removed or otherwise, please notify the Agricultural Planning Unit. </strong></p>
                <div class="activities-container">
                @if($psip->activities->count())
                @foreach ($psip->activities as $index => $activity)
                    
                    <div class="activity-section mb-3" name="activity-id" data-activity-id="{{ $activity->id }}">
                        <div class="form-group">
                            <label for="activity_name">Activity Name  </label>&nbsp;&nbsp; 
                            <button type="button" class="btn btn-light btn-sm move-up"><i class="bi bi-arrow-up-square">Up</i></button>
                            <button type="button" class="btn btn-light btn-sm move-down"><i class="bi bi-arrow-down-square">Down</i></button>
                            <input type="text" class="form-control" id="activity_name" name="activity_name[{{ $activity->id }}]" value="{{ $activity->activity_name }}">
                            <input type="hidden" name="activity_order[{{ $activity->id }}]" value="{{ $activity->activity_order }}">
                            <input type="hidden" name="activity_id[{{ $activity->id }}]" id="activity_id" value="{{ $activity->id }}">
                        </div>
                        
                        @if($activity->activityParticulars->count())
                        @foreach($activity->activityParticulars as $particular)
                        <div class="particular-section" style="margin-left: 20px;">
                            <div class="form-group">
                                <label for="particulars">Particulars</label>
                                <input type="text" class="form-control" id="particulars" name="particulars[][{{ $activity->id }}]" value="{{ $particular->particulars }}">
                            </div>
                            <div class="form-group">
                                <label for="particulars_cost">Particulars Cost</label>
                                <input type="number" step="0.01" class="form-control" id="particulars_cost" name="particulars_cost[][{{ $activity->id }}]" value="{{ $particular->particulars_cost }}">
                            </div>
                        </div>
                        @endforeach
                        @else
                        <small class="text-muted">No particulars for this activity.</small>
                        @endif
                    </div>
                
                @endforeach
                @else
                <small class="text-muted">No activities found.</small>
                @endif
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const activitiesContainer = document.querySelector('.activities-container'); // Ensure this selector matches your actual container

    document.addEventListener('click', function (e) {
        if (e.target.closest('.move-up')) {
            const currentActivity = e.target.closest('.activity-section');
            const firstActivity = activitiesContainer.firstElementChild;
            if (currentActivity !== firstActivity) {
                activitiesContainer.insertBefore(currentActivity, currentActivity.previousElementSibling);
                updateActivityOrders();
            }
        } else if (e.target.closest('.move-down')) {
            const currentActivity = e.target.closest('.activity-section');
            const nextActivity = currentActivity.nextElementSibling;
            // Check if there is a next activity to move down into its place
            if (nextActivity) {
                activitiesContainer.insertBefore(nextActivity, currentActivity);
                updateActivityOrders();
            }
        }
    });
});

function updateActivityOrders() {
    document.querySelectorAll('.activity-section').forEach((element, index) => {
        const activityId = element.getAttribute('data-activity-id');
        const inputField = document.querySelector('input[name="activity_order[' + activityId + ']"]');
        if (inputField) {
            inputField.value = index + 1; // Update the order based on the current position
        }
    });
}



</script>




@endsection

