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
                                                    <strong>{{$psip->psipDetailForCurrentYear?$psip->psipDetailForCurrentYear->financial_year:$financial_year}} Project Activities for {{$psip->code}}</strong>
                                                    <span class="badge rounded-pill bg-secondary stacked-badge"><a href="#" class="text-light" style="text-decoration: none" data-bs-toggle="modal" data-bs-target="#documentModal">!</a></span>

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
                                                                <div class="ms-2 me-auto" style="width: 100%;">
                                                                    <a href="{{$c->filepath? asset('storage/'.$c->filepath):'#'}}"  target="_blank" style="display: block; text-decoration: none; color: black; width: 90%;">                                                
                                                                        {{$c->docType->doc_type_name}}{{$c->doc_title? ' - '.$c->doc_title:''}}
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