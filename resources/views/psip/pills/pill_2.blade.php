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
                                            <!-- <div class="lead">
                                                <p class="text-decoration-underline">
                                                    <strong>{{$psip->psipDetailForCurrentYear?$psip->psipDetailForCurrentYear->financial_year:$financial_year}} Project Activities for {{$psip->code}}</strong>
                                                    <span class="badge rounded-pill bg-secondary stacked-badge"><a href="#" class="text-light" style="text-decoration: none" data-bs-toggle="modal" data-bs-target="#documentModal">!</a></span>
                                                    <div class="dropdown">
                                                                <button class="btn btn-outline-secondary" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    &#8230;
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#updateDocumentModal" class="dropdown-item">Update Document</a>
                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#updateDocumentModal" class="dropdown-item">Add Photos</a>
                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#updateDocumentModal" class="dropdown-item">View Photos</a>
                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#updateDocumentModal" class="dropdown-item">Reorder Activities</a>
                                                                        
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                </p>                                                
                                            </div>     -->   
                                            <div class="lead">
                                                <p class="text-decoration-underline d-inline-block mb-0">
                                                    <strong>{{$psip->psipDetailForCurrentYear?$psip->psipDetailForCurrentYear->financial_year:$financial_year}} Project Activities for {{$psip->code}}</strong>
                                                </p>
                                                <div class="dropdown d-inline-block">
                                                    <button class="btn btn-outline-secondary btn-sm" type="button" id="dropdownMenuButton8" data-bs-toggle="dropdown" aria-expanded="false">
                                                       Options &#8230;<!-- horizontal ellipsis HTML entity -->
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#documentModal" class="dropdown-item">View Uploaded Documents</a></li>
                                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#screeningBriefModal">Add Screening Brief</a></li>
                                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#screeningBriefModal">Add PS Note</a></li>  
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#updateDocumentModal"  class="dropdown-item">Reorder Activities</a>                                         
                                                    </ul>
                                                </div>
                                            </div>
                                 
                                        <br>
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
                                                        <div class="d-flex align-items-center">
                                                            <a href="{{ route('psipupload.create', $b->id) }}" class="btn btn-primary btn-sm me-2">Attach a document to this PSIP Activity</a>
                                                            <div class="dropdown">
                                                                <button class="btn btn-outline-secondary" type="button" id="dropdownMenuButton9" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    &#8230;<!-- horizontal ellipsis HTML entity -->
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#updateDocumentModal" class="dropdown-item">Add Photos To This Activity</a>
                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#updateDocumentModal" class="dropdown-item">View Photos For This Activity</a>
                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#updateDocumentModal" class="dropdown-item">View Completion Status Of This Activity</a>
                                                                        @if((auth()->user()->divisions_id == 15 || auth()->user()->id == 2))
                                                                        <div class="dropdown-divider"></div>
                                                                        <button class="btn btn-danger btn-sm dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#activitySurpressModal" onclick="setSurpesssActivityId({{$b['id']}})">
                                                                            Surpress this activity
                                                                            <span class="badge rounded-pill bg-danger stacked-badge">!</span>
                                                                        </button>
                                                                        <button class="btn btn-danger btn-sm dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#activityRemoveModal" onclick="setRemoveActivityId({{$b['id']}})">
                                                                            Remove this activity
                                                                            <span class="badge rounded-pill bg-danger stacked-badge">!</span>
                                                                        </button>
                                                                        @endif
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <div class="list-group">
                                                            @foreach($b->documents as $c)<!-- c == psipdoc -->
                                                            <li class="list-group-item list-group-item-action  d-flex justify-content-between align-items-start">
                                                                <div class="ms-2 me-auto" style="width: 100%;">
                                                                    <a href="{{$c->filepath? asset('storage/'.$c->filepath):'#'}}"  target="_blank" style="display: block; text-decoration: none; color: black; width: 90%;">                                                
                                                                        {{$c->docType->doc_type_name}}{{$c->doc_title? ' - '.$c->doc_title:''}}
                                                                    </a>
                                                              </div>
                                                              <!-- <span class="badge bg-primary rounded-pill"><a href="#" data-bs-toggle="modal" data-bs-target="#updateDocumentModal" onclick="setUpdateDocId({{$c['id']}},{{$b['id']}})" style="text-decoration: none; color: whitesmoke;">Update Document</a></span> -->
                                                              <div class="dropdown">
                                                                <button class="btn btn-outline-secondary" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    &#8230;<!-- horizontal ellipsis HTML entity  -->
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#updateDocumentModal" onclick="setUpdateDocId({{$c['id']}},{{$b['id']}})" class="dropdown-item">Update Document</a>
                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#updateDocumentModal" onclick="setUpdateDocId({{$c['id']}},{{$b['id']}})" class="dropdown-item">Document Details</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
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