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
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#formModal">Assign/Request a document to be uploaded</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#cancelPsipModal">Surpress this PSIP</a></li>
                                    <li><a class="dropdown-item" href="{{ route('update.all.psip') }}">update all psip(dont touch right now)</a></li>
                                </ul>
                            </div>
                            @endrole  
                            @role('ict|contributor')
                            <div class="btn-group">
                                <button type="button" class="btn btn-light btn-lg dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#screeningBriefModal">Add Screening Brief</a></li>
                                </ul>
                            </div>

                            @endrole
                        </h2>
                        <p><h5 class="text-center">(Status - {{App\Models\Status::find($psip->status_id)->status}})</h5></p>

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
            <div class="tab-pane fade show active" id="pill1" role="tabpanel" aria-labelledby="pill1-tab">
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-12">
                            @if($psip->psipDetailForCurrentYear)
                            <div class="d-flex align-items-center">
                                <h4>Fiscal {{$psip->psipDetailForCurrentYear->financial_year}}</h4>
                            </div>
                            <hr>
                                @if((auth()->user()->divisions_id == $psip->division_id) || (auth()->user()->id==2) || (auth()->user()->divisions_id == 15))
                                    <div class="d-flex align-items-center mt-2">
                                        <span><strong>Current Expenditure</strong><i>{{$psip->psipDetailForCurrentYear? ' as of ' . $psip->psipDetailForCurrentYear->psipFinancialsThisYear()->current_expenditure_dt : ''}}</i>:</span>
                                        <span class="ms-2">{{$psip->psipDetailForCurrentYear? '$' . $psip->psipDetailForCurrentYear->psipFinancialsThisYear()->current_expenditure : '0.00'}}</span>
                                        @role('admin|planning')
                                        <div class="">
                                            <div class="btn-group">
                                                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">

                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#currExpModal">Edit Current Expenditure</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        @endrole
                                    </div>
                                    <div class="d-flex align-items-center">
                                            <span><strong>Approved Allocation</strong>:</span>
                                            <span class="ms-2">{{ $psip->psipDetailForCurrentYear ? '$' . number_format($psip->psipDetailForCurrentYear->psipFinancialsThisYear()->approved_estimates, 2) : '$0.00' }}</span>
                                            @role('admin|planning')
                                            <div class="">
                                                <div class="btn-group">
                                                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">

                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#appEstModal">Edit Approved Estimate</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @endrole
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                            <span><strong>Revised Allocation</strong>:</span>
                                            <span class="ms-2">{{$psip->psipDetailForCurrentYear? '$'.number_format($psip->psipDetailForCurrentYear->psipFinancialsThisYear()->revised_estimates,2) : '0.00'}}</span>
                                            @role('admin|planning')
                                            <div class="">
                                                <div class="btn-group">
                                                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">

                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#revEstModal">Edit Revised Estimate</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @endrole
                                    </div>
                                    <div class="d-flex align-items-center mt-2">
                                        <span><strong>Actual expenditure {{$psip->psipDetailForCurrentYear->financial_year}}</strong>:</span>
                                        <span class="ms-2">{{$psip->psipDetailForCurrentYear? '$'.number_format($psip->psipDetailForCurrentYear->psipFinancialsThisYear()->actual_expenditure,2) : '0.00'}}</span>
                                    </div>
                                    <hr>
                                    <div class="">
                                        <canvas id="PolarArea" height="400" width="400"></canvas>
                                    </div>
                            
                                @else
                                    <p>Sorry you cannot view this data.</p>
                                @endif
                            @else
                            <h5>No Data Found</h5>
                            @endif
                        </div>
                    </div>
                </div>

                
            </div>
            <div class="tab-pane fade" id="pill2" role="tabpanel" aria-labelledby="pill2-tab">
                <div class="container">
                    <div class="card">
                        <div class="card-body">
                            <div class="container mt-4">
                                <div class="row">
                                        <div class="col-md-12">
                                            <div class="lead">
                                            <p class="text-decoration-underline">
                                                <strong>Details for {{$psip->psipDetailForCurrentYear? $psip->psipDetailForCurrentYear->financial_year : $financial_year}}</strong>
                                            </p>
                                        </div>                    
                                    </div>                
                                </div>       
                                <div class="row">
                                    <div class="col-md-12">                    
                                        <p>                        
                                            {{$psip->psipDetailForCurrentYear?$psip->psipDetailForCurrentYear->details:'No details found'}}
                                        </p>                   

                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                <!-- document data -->
                                    <div class="col-md-12" id="left-column">
                                        @if($psip->psipDetailForCurrentYear)
                                            <div class="lead">
                                                <p class="text-decoration-underline">
                                                    <strong>{{$psip->psipDetailForCurrentYear?$psip->psipDetailForCurrentYear->financial_year:$financial_year}} programme activities for {{$psip->code}}</strong>
                                                    <span class="badge rounded-pill bg-success stacked-badge"><a href="#" class="text-light" style="text-decoration: none" data-bs-toggle="modal" data-bs-target="#documentModal">!</a></span>
                                                </p>
                                                
                                            </div>
                                         

                                        <div class="accordion" id="accordionExample">
                                            @foreach($activities as $key => $b)

                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading{{$key}}">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}" onclick="fetchDocTypeDivisions({{$b['id']}})">
                                                        Project {{$b->activity_name}}
                                                    </button>
                                                </h2>
                                                <div id="collapse{{$key}}" class="accordion-collapse collapse" aria-labelledby="heading{{$key}}" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <!-- remember divisions is incorrectly spelt in the database -->
                                                        @if((auth()->user()->divisions_id == $psip->division_id) || auth()->user()->divisions_id == 15 ||auth()->user()->id==2)
                                                        <a href="{{ route('psipupload.create', $b->id) }}" class="btn btn-primary btn-sm">Attach a document to this  PSIP Activity</a>
                                                        @if((auth()->user()->divisions_id == 15 ||auth()->user()->id==2))
                                                        <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#activitySurpressModal" onclick="setSurpesssActivityId({{$b['id']}})">
                                                        Surpress this activity
                                                        </button>
                                                        <button class="btn btn-danger btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#activityRemoveModal" onclick="setRemoveActivityId({{$b['id']}})">
                                                        Remove this activity
                                                        </button>
                                                        @endif
                                                        <div class="list-group">
                                                            @foreach($b->documents as $c)<!-- c == psipdoc -->
                                                            <li class="list-group-item list-group-item-action  d-flex justify-content-between align-items-start">
                                                                <div class="ms-2 me-auto">

                                                                  <a href="{{$c->filepath? asset('storage/'.$c->filepath):'#'}}"  target="_blank" style="text-decoration: none; color: black;">                                                
                                                                {{$c->docType->doc_type_name}} - {{$c->doc_title? $c->doc_title:''}}
                                                                
                                                            </a>
                                                              </div>
                                                              <span class="badge bg-primary rounded-pill"><a href="#" data-bs-toggle="modal" data-bs-target="#updateDocumentModal" onclick="setUpdateDocId({{$c['id']}},{{$b['id']}})" style="text-decoration: none; color: whitesmoke;">Update Document</a></span>
                                                            </li>
                                                            
                                                            <!-- ADD SCREENING BRIEF CODE HERE -->

                                                            @endforeach
                                                        </div>
                                                        @else
                                                            <p>Sorry you cannot view this data.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            @endforeach
                                        </div>
                                        @else
                                        <div class="row">
                                            <div class="col-md-12">                    
                                                <p>                        
                                                    No details found
                                                </p>                   

                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div><hr>
                            </div>                           
                        </div>            
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pill3" role="tabpanel" aria-labelledby="pill3-tab">
                <!-- Projections -->
                <div class="container">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="text-decoration-underline">Projections</h4>
                                    @if((auth()->user()->divisions_id == $psip->division_id) || auth()->user()->divisions_id == 15 ||auth()->user()->id==2)
                                        @if ($psip->psipDetailForCurrentYear)
                                        <p>
                                            <strong>Projections made in {{$psip->psipDetailForCurrentYear->financial_year}} for successive years</strong>
                                            <br>
                                            @foreach($psip->psipDetailForCurrentYear->psipDraftEstimate as $projection)

                                            Expected spending for {{$projection->draft_est_year}}: ${{number_format($projection->draft_est,2)}}
                                            <br>
                                            Details of projects: {{$projection->details}}
                                            <hr>
                                            @endforeach
                                        </p>


                                        @else
                                        <p>No data</p>
                                        @endif
                                    @else
                                    <p>Sorry you cannot view this data.</p>
                                    @endif
                                    

                                </div>
                            </div>
                            @if((auth()->user()->divisions_id == $psip->division_id) || auth()->user()->id==2) || auth()->user()->divisions_id == 15)
                            <canvas id="Projections" width="800" height="400"></canvas>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pill4" role="tabpanel" aria-labelledby="pill4-tab">
                <!-- previous data -->
                <div class="container">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Information on prior years</h4>
                                    @if((auth()->user()->divisions_id == $psip->division_id) || auth()->user()->divisions_id == 15 ||auth()->user()->id==2)
                                    @forelse ($psip->psipDetailsExceptCurrentYear as $detail)
                                    <p>
                                        <strong>Details for {{$detail->financial_year}}</strong>
                                        <br>
                                        {{$detail->details}}
                                    </p>
                                    <p><strong>Approved Estimate</strong><br>{{$detail->approved_estimate}}</p>
                                    <hr>
                                    @empty
                                    <p>No prior data</p>
                                    @endforelse
                                    @else
                                    <p>Sorry you cannot view this data.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        </div>
        
    </div>
    @if((auth()->user()->divisions_id == $psip->division_id) || (auth()->user()->id==2 ||auth()->user()->id==1) || auth()->user()->divisions_id == 15)
    @include('options.assign_doc2')
    @include('options.approved_estimate')
    @include('options.revised_estimate')
    @include('options.current_expenditure')
    @include('options.required_documents')
    @include('options.cancel_activity')
    @include('options.remove_activity')
    @include('options.cancel_psip')
    @include('options.update_doc')
    @include('options.screening_brief')
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
      labels: ["Actual Expenditure(prev year)","Approved Allocation(MOP&F)","Revised Allocation"],
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
      }
    };

    var polarAreaChart = new Chart(psipDetail, {
      type: 'polarArea',
      data: birdsData,
      options: chartOptions
    });

</script>


    @endsection
