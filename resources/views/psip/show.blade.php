@extends('layouts.app-master')
@section('css')
<style type="text/css">
    .custom-nav-pills .nav-link {
    background-color: lightgray;
    color: #606070;  /* Choose the text color you prefer */
}

.custom-nav-pills .nav-link.active {
    background-color: #007bff;  /* Bootstrap's default active color; change as needed */
    color: #ffffff;  /* White text for active pill */
}


</style>
@endsection
@section('content')
@auth
    
    <div class="p-5 rounded">
        
    </div>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="text-center">Activities/ Documents for PSIP: {{$title}}
                            @role('admin|planning')
                            <div class="btn-group">
                                <button type="button" class="btn btn-light btn-lg dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('psip.edit', $psip->id) }}">Edit PSIP</a></li>
                                    <li><a class="dropdown-item" href="{{ route('psip.projection', $psip->id) }}">Add projections for another year</a></li>
                                    <!-- Modal Trigger Here -->
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#screeningBriefModal">Add Screening Brief</a></li>
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#psNoteModal">Add PS Note</a></li>
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#formModal">Assign/Request a document to be uploaded</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#cancelPsipModal">Surpress this PSIP</a></li>
                                    <!-- the below code shoul not be removed, this is the link to update all psip to the new financial year -->
                                    <!-- <li><a class="dropdown-item" href="{{ route('update.all.psip') }}">update all psip(dont touch right now)</a></li> -->
                                </ul>
                            </div>
                            @endrole  
                            @role('ict|contributor')
                            <div class="btn-group">
                                <button type="button" class="btn btn-light btn-lg dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#psNoteModal">Add Screening Brief</a></li>
                                </ul>
                            </div>

                            @endrole
                        </h2>
                        <p><h5 class="text-center">(Status - {{App\Models\Status::find($psip->status_id)->status}})
                            @if($psip->status_id==1) 
                                <i class="bi bi-check-lg text-success"></i>
                                
                            @else
                                <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                            @endif
                            </h5>
                        </p>

                    </div>
                </div>


            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="card">
           <!-- Pills navigation -->
        <ul class="nav nav-pills nav-justified mb-3 custom-nav-pills" id="myTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pill1-tab" data-bs-toggle="pill" href="#pill1" role="tab" aria-controls="pill1" aria-selected="true">Financial Summary</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pill2-tab" data-bs-toggle="pill" href="#pill2" role="tab" aria-controls="pill2" aria-selected="false">Activities</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pill3-tab" data-bs-toggle="pill" href="#pill3" role="tab" aria-controls="pill3" aria-selected="false">Projections</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pill4-tab" data-bs-toggle="pill" href="#pill4" role="tab" aria-controls="pill4" aria-selected="false">Prior Years</a>
            </li>
        </ul>

        <!-- Pills content -->
        <div class="tab-content" id="myTabsContent">
            @include('psip.pills.pill_1')<!-- Fininacial Pill -->
            @include('psip.pills.pill_2')<!-- Activities Pill -->
            @include('psip.pills.pill_3')<!-- Projections Pill -->
            @include('psip.pills.pill_4')<!-- Prior Years Pill -->
        </div>
        </div>
        
    </div>
    
    <!-- if user division == psip division or if admin user or planning user or if user is in planning -->
    @if((auth()->user()->divisions_id == $psip->division_id) || (auth()->user()->id==2 ||auth()->user()->id==1) || auth()->user()->divisions_id == 15)
    @include('options.assign_doc2')
    @include('options.edit_psip_detail')
    @include('options.approved_estimate')
    @include('options.revised_estimate')
    @include('options.current_expenditure')
    @include('options.required_documents')
    @include('options.cancel_activity')
    @include('options.remove_activity')
    @include('options.cancel_psip')
    @include('options.update_doc')
    @include('options.screening_brief')
    @include('options.add_ps_note')
    @endif
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
    var getUrl = "{{ route('activities.filltable') }}";
    function fetchDocTypeDivisions(activity_id) {
        $.ajax({
            type: 'POST',
            url: getUrl,
            data: { activity_id: activity_id, _token: '{{ csrf_token() }}' },
            success: function(response) {
                $('#tabledoc tbody').empty(); // Clear existing rows

                if (response.status === 'not_found') {
                    $('#tabledoc tbody').append('<tr><td colspan="2">No records found.</td></tr>');
                } else if (response.status === 'found') {
                    response.data.forEach(function(row) {
                        $('#tabledoc tbody').append(
                            '<tr>' +                                
                                '<td>' + row.doc_type_name + '</td>' +
                                '<td><span class="badge rounded-pill ' + (row.uploaded === 'Yes' ? 'bg-success' : 'bg-danger') + ' stacked-badge">' + row.uploaded + '</span></td>' +

                            '</tr>'
                        );
                    });
                }
            }
        });
    }

    function setUpdateDocId(doc_id,activity_id){
        //alert(doc_id)
        $('#update_doc_id').val(doc_id);
        $('#update_activity_doc_id').val(activity_id);
    }
    function setSurpesssActivityId(activity_id){
        //alert(activity_id)
        
        $('#surpress_activity').val(activity_id);
    }
    function setRemoveActivityId(activity_id){
        //alert(activity_id)
        
        $('#remove_activity').val(activity_id);
    }

    
</script>

<script>
$(document).ready(function(){
    // Delegated event handling for dynamically added elements
    $(document).on('change', '.docGroupDropdown', function() {
        //console.log("Dropdown changed");
        var selectedValue = $(this).val();
        var selectedText = $(this).find("option:selected").text();
        var $accordionItem = $(this).closest('.accordion-item'); // Find the closest accordion-item

        if(selectedValue) {
            // Hide the selected option
            $(this).find("option[value='" + selectedValue + "']").addClass('d-none');

            var filterSpan = $('<span class="filter-span badge rounded-pill bg-secondary"  id="filter-' + selectedValue + '">' + selectedText + ' <button class="remove-filter btn btn-secondary  btn-sm" data-filter="' + selectedValue + '"><i class="bi bi-x-circle"></i></button></span> ');
            $accordionItem.find('.activeFilters').append(filterSpan);
            
            // Reset dropdown
            $(this).val('');

            applyFilters($accordionItem);
        }
    });

    $(document).on('click', '.remove-filter', function() {
        //console.log("Filter removed");
        var filterValue = $(this).data('filter');
        var $accordionItem = $(this).closest('.accordion-item');
        $accordionItem.find("#filter-" + filterValue).remove();
        $accordionItem.find(".docGroupDropdown option[value='" + filterValue + "']").removeClass('d-none').show(); // Unhide the option

        applyFilters($accordionItem);
    });

    function applyFilters($accordionItem) {
        var selectedFilters = $accordionItem.find('.remove-filter').map(function() {
                                return Number($(this).data('filter')); // Convert each to number
                                }).get();
        //console.log("Selected Filters: ", selectedFilters);
        $accordionItem.find('.list-group-item').each(function() {
            var docGroupId = Number($(this).data('doc-group-id'));
            //console.log("Doc Group ID: ", docGroupId, " - Should Hide: ", !selectedFilters.includes(docGroupId));
            //console.log("Comparing DocGroupID:", docGroupId, "with SelectedFilters:", selectedFilters);
            if(selectedFilters.length === 0 || selectedFilters.includes(docGroupId)) {
                //console.log("Showing:", $(this).text().trim());
                $(this).css('display', 'flex'); // Show the item
                
            } else {
                $(this).removeClass('d-flex');
                $(this).css('display', 'none');
 // Hide the item
                //console.log("Hiding:", $(this).text().trim());
            }
        });
    }
});
</script>






<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

<script src="
https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js
"></script>

<script>
    
    // Decode and extract data
    const rawData = JSON.parse({!! json_encode($draft_estimates) !!});
    const labels = rawData.map(item => item.draft_est_year);
    const data = rawData.map(item => parseFloat(item.draft_est));
    const ctx = document.getElementById('Projections');

    new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Projection in $TTD',
            data: data,
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
</script>

<script>
    
    // Decode and extract data

    const psipDetail = document.getElementById('PolarArea');
    const approved = JSON.parse({!! json_encode($approved_estimates) !!});
    const actual = JSON.parse({!! json_encode($actual_expenditure) !!});
    const revised = JSON.parse({!! json_encode($revised_estimates) !!});
    
    Chart.defaults.font.family = "Lato";
    Chart.defaults.font.size = 22;
    Chart.defaults.color = "black";

    var birdsData = {
      labels: ["Actual Expenditure","Approved Allocation(MOP&F)","Revised Allocation"],
      datasets: [{
        data: [actual, approved, revised],
        backgroundColor: [
          "rgba(255, 0, 0, 0.5)",
          "rgba(100, 255, 0, 0.5)",
          "rgba(0, 100, 255, 0.5)"
        ]
      }]
    };

    var chartOptions = {
      plugins: {
        title: {
          display: true,
          align: "start",
          text: "Polar Radial Chart"
        },
        legend: {
          align: "start"
        }

      },
      responsive: false, // Prevents resizing to the parent container
        maintainAspectRatio: false // Maintains the aspect ratio; set to false if aspect ratio is not a concern
    };

    var polarAreaChart = new Chart(psipDetail, {
      type: 'polarArea',
      data: birdsData,
      options: chartOptions
      
    });

</script>


    @endsection
