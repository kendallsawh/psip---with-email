@extends('layouts.app-master')

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
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#formModal">Assign/Request a document to be uploaded</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('update.all.psip') }}">update all psip(dont touch right now)</a></li>
                                </ul>
                            </div>

                            @endrole  
                        </h2>

                    </div>
                </div>
                
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading">
                            <button class="accordion-button lead" type="button" data-bs-toggle="collapse" data-bs-target="#collapse" aria-expanded="true" aria-controls="collapse">
                                Show Fiscal {{
                                    $psip->psipDetailForCurrentYear
                                    ? ($psip->psipDetailForCurrentYear->financial_year - 1) . '/' . $psip->psipDetailForCurrentYear->financial_year
                                    : '(no data found)'
                                }} Data
                            </button>

                        </h2>
                        <div id="collapse" class="accordion-collapse collapse" aria-labelledby="heading" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                
                                <div class="d-flex align-items-center">
                                    <span><strong>Approved Allocation</strong></span>
                                    <span class="ms-2">{{$psip->psipDetailForCurrentYear? $psip->psipDetailForCurrentYear->psipFinancialsThisYear()->approved_estimates : '0.00'}}</span>
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
                                    <span><strong>Revised Allocation</strong></span>
                                    <span class="ms-2">{{$psip->psipDetailForCurrentYear? $psip->psipDetailForCurrentYear->psipFinancialsThisYear()->revised_estimates : '0.00'}}</span>
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
                                <hr>
                                <div class="d-flex align-items-center mt-2">
                                    <canvas id="PolarArea" height="100" width="100"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                  
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
                </div>
            </div>
        </div>
    </div>
    <br>
    
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- document data -->
                    <div class="col-md-11" id="left-column">
                        <div class="lead">
                            <p class="text-decoration-underline">
                               <strong>{{$psip->psipDetailForCurrentYear?$psip->psipDetailForCurrentYear->financial_year:$financial_year}} project activities for {{$psip->code}}</strong>
                           </p>
                       </div>
                        <h5></h5>

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
                                        @if((auth()->user()->divisions_id == $psip->division_id) || (auth()->user()->id==2))
                                        <a href="{{ route('psipupload.create', $b->id) }}" class="btn btn-primary btn-sm">Attach a document to this  PSIP</a>
                                        <div class="list-group">
                                            @foreach($b->documents as $c)

                                            <a href="{{$c->filepath? asset('storage/'.$c->filepath):'#'}}" class="list-group-item list-group-item-action" target="_blank">                                                
                                                {{$c->docType->doc_type_name}}
                                            </a>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            @endforeach
                        </div>
                    </div>
                    <!-- document responsibilities table -->
                    <div class="col-md-1" id="right-column" style="opacity: 0;transform: translateX(100%);transition: opacity 0.5s ease, transform 0.5s ease;">
                        <p>Checklist of required documents and who is responsible for uploading</p>

                        <table class="table table-hover " id="tabledoc">
                            <thead>
                                <tr>             
                                    <th>Division Responsible</th>
                                    <th>Document Required</th>
                                </tr>
                            </thead>                        
                            <tbody>                            
                                <tr>
                                    <td></td>
                                    <td></td>  
                                </tr>                        
                            </tbody>                        
                        </table>

                    </div>
                </div><hr>
            </div>            
        </div>
    </div>
    
    <br>
    <!-- Projections -->
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-decoration-underline">Projections</h4>
                        @if ($psip->psipDetailForCurrentYear)
                        <p>
                            <strong>Projections made in {{$psip->psipDetailForCurrentYear->financial_year}} for successive years</strong>
                            <br>
                            @foreach($psip->psipDetailForCurrentYear->psipDraftEstimate as $projection)
                            
                            Expected spending for {{$projection->draft_est_year}}: ${{$projection->draft_est}}
                            <br>
                            Details of projects: {{$projection->details}}
                            <hr>
                            @endforeach
                        </p>


                        @else
                        <p>No prior data</p>
                        @endif

                    </div>
                </div>
                <canvas id="Projections" width="800" height="400"></canvas>
            </div>
        </div>
    </div>
    
    <br>
    <!-- previous data -->
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                <div class="col-md-12">
                    <h4>Information on prior years</h4>
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
                    
                </div>
            </div>
            </div>
        </div>
    </div>
    

    <!-- blank container template -->
    <br>
    <div class="container">
        <div class="card">
            <div class="card-body">
                
            </div>
        </div>
    </div>
    @include('options.assign_doc2')
    @include('options.approved_estimate')
    @include('options.revised_estimate')
    
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
                                '<td>' + row.division_name + '</td>' +
                                '<td>' + row.doc_type_name + '</td>' +
                            '</tr>'
                        );
                    });
                }
            }
        });

        const leftColumn = document.getElementById("left-column");
        const rightColumn = document.getElementById("right-column");

        // Adjust column widths
        leftColumn.classList.remove("col-md-11");
        leftColumn.classList.add("col-md-8");

        rightColumn.classList.remove("col-md-1");
        rightColumn.classList.add("col-md-4");

        // Show right column
        rightColumn.style.opacity = "1";
        rightColumn.style.transform = "translateX(0)";
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
    const approved = JSON.parse({!! json_encode($psip->psipDetailForCurrentYear->psipFinancialsThisYear()->approved_estimates) !!});
    const actual = JSON.parse({!! json_encode($psip->psipDetailForCurrentYear->psipFinancialsThisYear()->actual_expenditure) !!});
    const revised = JSON.parse({!! json_encode($psip->psipDetailForCurrentYear->psipFinancialsThisYear()->revised_estimates) !!});
    
    Chart.defaults.font.family = "Lato";
    Chart.defaults.font.size = 22;
    Chart.defaults.color = "black";

    var birdsData = {
      labels: ["Actual Expenditure(prev year)","Approved Allocation’(MOP&F)","Revised Allocation’"],
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