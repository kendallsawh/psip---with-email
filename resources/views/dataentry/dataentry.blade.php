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
            <form method="POST" action="{{ route('dataentry.store', $psip->id) }}" enctype="multipart/form-data">
                @csrf
                <!-- <div class="mb-3">
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
                    <label for="group" class="form-label">Division/Department Name</label>
                    
                    <select id="group" name="group" class="form-control dropdown">
                        <option disabled="" selected=""></option>
                        @foreach($groups as $group)
                        <option value="{{$group->id}}" {{old('group')==$group->id ? 'selected' : '' }}>{{$group->group_name}}</option>
                        @endforeach
                    </select>    

                    @if ($errors->has('group'))
                        <span class="text-danger text-left">{{ $errors->first('group') }}</span>
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
                </div> -->
                <!-- PSIP Names Section -->
                <!-- PSIP Details Section for Current Financial Year -->

				<div class="form-group">
					<label for="financial_year">Financial Year</label>
					<input type="number" min="2024" max="2099" step="1" class="form-control" id="financial_year" name="financial_year"  value="2024" />
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
                
                <!-- ... other fields for psip_details based on current financial year ... -->

                <!-- PSIP Financials Section (Dynamic) -->
                <h6>PSIP Financials</h6> 
                <!-- current allocation -->
                <div class="mb-3">
                    <label for="current_allocation" class="form-label">Current allocation for the current financial year</label>
                    <input value="{{ old('current_allocation') }}" 
                        type="number" 
                        class="form-control" 
                        name="current_allocation"
                        placeholder="Numbers only. Decimals allowed" 
                        required>

                    @if ($errors->has('current_allocation'))
                        <span class="text-danger text-left">{{ $errors->first('current_allocation') }}</span>
                    @endif
                </div>  
                <!-- approved allocation -->
                <div class="mb-3">
                    <label for="approved_allocation" class="form-label">Approved allocation for the current financial year</label>
                    <input value="{{ old('approved_allocation') }}" 
                        type="number" 
                        class="form-control" 
                        name="approved_allocation"
                        placeholder="Numbers only. Decimals allowed" 
                        required>

                    @if ($errors->has('approved_allocation'))
                        <span class="text-danger text-left">{{ $errors->first('approved_allocation') }}</span>
                    @endif
                </div>  
                <!-- revised allocation -->  
                <div class="mb-3">
                    <label for="revised_allocation" class="form-label">Revised estimates for the current financial year</label>
                    <input value="{{ old('revised_allocation') }}" 
                        type="number" 
                        class="form-control" 
                        name="revised_allocation"
                        placeholder="Numbers only. Decimals allowed" 
                        required>

                    @if ($errors->has('revised_allocation'))
                        <span class="text-danger text-left">{{ $errors->first('revised_allocation') }}</span>
                    @endif
                </div>
                <!-- actual expenditure --> 
                <div class="mb-3">
                    <label for="actual_expenditure" class="form-label">Actual expenditure for the current financial year</label>
                    <input value="{{ old('actual_expenditure') }}" 
                        type="number" 
                        class="form-control" 
                        name="actual_expenditure"
                        placeholder="Numbers only. Decimals allowed" 
                        required>

                    @if ($errors->has('actual_expenditure'))
                        <span class="text-danger text-left">{{ $errors->first('actual_expenditure') }}</span>
                    @endif
                </div>        
                <!-- <div class="financial-section mb-4">           
                    <div class="form-group mt-2">
                        <label for="revised_estimates">Draft Estimates</label>
                        <input type="number" step="0.01" class="form-control" id="revised_estimates" name="revised_estimates[]" value="">
                    </div>                     
                </div> -->

                <!-- Activities Section (Dynamic) -->
                <h6>Activities</h6>
                <div id="activitiesContainer">
                	<div class="activity-section mb-3">
                		<!-- Activity Fields Here -->
                		<button type="button" onclick="addActivity()">Add Activity</button>
                		<button type="button" onclick="removeActivity()">Remove Activity</button>
                		<!-- ... -->
                		<!-- <button type="button" onclick="addParticular(this)">Add Particular</button>
                		<button type="button" onclick="removeParticular(this)">Remove Particular</button> -->
                		<!-- Particulars will go here -->
                		<div class="particularsContainer">
                			<!-- Particular fields will be dynamically added here -->
                		</div>
                	</div>
                </div>

                <!-- ... -->


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
// Function to add a new activity section
let activityIndex = 0; // Keep track of the number of activity sections

// Function to add a new activity section
function addActivity() {
    const activityContainer = document.getElementById("activitiesContainer");

    // Create new activity section
    const newActivitySection = document.createElement("div");
    newActivitySection.className = "activity-section mb-3";

    // Populate the new activity section with form fields
    newActivitySection.innerHTML = `
        <div class="form-group">
            <label for="activity_name">Activity Name</label>
            <input type="text" class="form-control" name="activity_name[${activityIndex}]" value="">
        </div>
        <button type="button" onclick="addParticular(this, ${activityIndex})">Add Particular</button>
        <button type="button" onclick="removeParticular(this)">Remove Particular</button>
    `;

    // Create a container to hold the particular sections
    const particularsContainer = document.createElement("div");
    particularsContainer.className = "particularsContainer";

    // Append the particulars container to the new activity section
    newActivitySection.appendChild(particularsContainer);

    // Append new activity section to the container
    activityContainer.appendChild(newActivitySection);

    // Increment the activity index
    activityIndex++;
}


// Function to remove the last activity section
function removeActivity() {
    const activityContainer = document.getElementById("activitiesContainer");
    const activitySections = activityContainer.getElementsByClassName("activity-section");

    if (activitySections.length > 1) {
        // Remove the last activity section
        activitySections[activitySections.length - 1].remove();

        // Decrement the activity index
        activityIndex--;
        
        // Re-index remaining activities and particulars
        for (let i = 0; i < activitySections.length; i++) {
            const activitySection = activitySections[i];
            const activityInput = activitySection.querySelector('input[name^="activity_name"]');
            activityInput.name = `activity_name[${i}]`;

            const particularInputs = activitySection.querySelectorAll('input[name^="particulars["], input[name^="particulars_cost["]');
            particularInputs.forEach(input => {
                input.name = input.name.replace(/\[\d+\]/, `[${i}]`);
            });
        }
    }
}

/// Function to add a new particular section
function addParticular(buttonElement, activityIndex) {
    const activitySection = buttonElement.closest('.activity-section');
    const particularsContainer = activitySection.getElementsByClassName('particularsContainer')[0];

    // Create new particular section
    const newParticularSection = document.createElement("div");
    newParticularSection.className = "particular-section";

    // Populate with form fields
    newParticularSection.innerHTML = `
        <div class="form-group">
            <label for="particulars">Particulars</label>
            <input type="text" class="form-control" name="particulars[${activityIndex}][]" value="">
        </div>
        <div class="form-group">
            <label for="particulars_cost">Particulars Cost</label>
            <input type="number" step="0.01" class="form-control" name="particulars_cost[${activityIndex}][]" value="">
        </div>
    `;

    // Append to the particulars container
    particularsContainer.appendChild(newParticularSection);
}

// Function to remove the last particular section
function removeParticular(buttonElement) {
    const activitySection = buttonElement.closest('.activity-section');
    const particularsContainer = activitySection.getElementsByClassName('particularsContainer')[0];
    const particularSections = particularsContainer.getElementsByClassName('particular-section');

    if (particularSections.length > 0) {
        particularSections[particularSections.length - 1].remove();
    }
}

    
</script>

@endsection

