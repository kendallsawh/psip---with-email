<div class="tab-pane fade" id="pill2" role="tabpanel" aria-labelledby="pill2-tab">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="lead">
                                <p class="text-decoration-underline d-inline-block mb-0">
                                    <strong>Details for {{$psip->psipDetailForCurrentYear? $psip->psipDetailForCurrentYear->financial_year : $financial_year}}</strong>
                                </p>
                                @if((auth()->user()->divisions_id == $psip->division_id) || (auth()->user()->id==2 ||auth()->user()->id==1) || auth()->user()->divisions_id == 15)
                                <div class="dropdown d-inline-block">
                                    <button class="btn btn-light btn-sm" type="button" id="dropdownMenuButton8" data-bs-toggle="dropdown" aria-expanded="false">
                                      <i class="bi bi-three-dots" style="font-size: 1.2rem;color: cornflowerblue;"></i>
                                  </button>
                                  <ul class="dropdown-menu">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#psipDetailModal" class="dropdown-item">Edit Details</a>

                                </ul>
                            </div>
                            @endif
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
                            <p class="text-decoration-underline d-inline-block mb-0">
                                <strong>{{$psip->psipDetailForCurrentYear?$psip->psipDetailForCurrentYear->financial_year:$financial_year}} Project Activities for {{$psip->code}}</strong>
                            </p>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-light btn-sm" type="button" id="dropdownMenuButton8" data-bs-toggle="dropdown" aria-expanded="false">
                                 <i class="bi bi-three-dots" style="font-size: 1.3rem;color: cornflowerblue;"></i>
                             </button>
                             <ul class="dropdown-menu">                                
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#psNoteModal">Add PS Note</a>  
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#screeningBriefModal">Add Screening Brief</a>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#achievementReportModal">Add Achievment Report</a>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#"  class="dropdown-item">Add New Activity</a>
                                <a href="{{ route('activities.edit', $psip->id) }}" class="dropdown-item">Edit Activity Details</a>                                         
                            </ul>
                        </div>
                    </div>

                    <br>
                    <div class="accordion" id="accordionMainDoc">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading_main">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_main" aria-expanded="true" aria-controls="collapse_main">
                                    Main Project Documents - PS Note, Screening Brief, Achievement Reports.
                                </button>
                            </h2>
                            <div id="collapse_main" class="accordion-collapse collapse" aria-labelledby="heading_main" data-bs-parent="#accordionMainDoc">
                                <div class="accordion-body">
                                    <div class="list-group">
                                        @foreach($psip->screeningBriefs as $key=>$screeningbrief)
                                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-start"  >
                                                <div class="ms-2 me-auto" style="width: 100%;">
                                                    <a href="{{$screeningbrief->filepath? asset('storage/'.$screeningbrief->filepath):'#'}}"  target="_blank" style="display: block; text-decoration: none; color: black; width: 90%;">                                                
                                                        Screening Brief{{$screeningbrief->file_name? ' - '.$screeningbrief->file_name:''}}{{$screeningbrief->created_at? ' - Upload Date:'.$screeningbrief->created_at:''}}
                                                    </a>
                                                </div>
                                        </li>
                                        @endforeach
                                        @foreach($psip->psNotes as $key=>$psnote)
                                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-start"  >
                                                <div class="ms-2 me-auto" style="width: 100%;">
                                                    <a href="{{$psnote->filepath? asset('storage/'.$psnote->filepath):'#'}}"  target="_blank" style="display: block; text-decoration: none; color: black; width: 90%;">                                                
                                                        PS Note{{$psnote->file_name? ' - '.$psnote->file_name:''}}{{$psnote->created_at? ' - Upload Date:'.$psnote->created_at:''}}
                                                    </a>
                                                </div>
                                        </li>
                                        @endforeach
                                        @foreach($psip->achievementReports as $key=>$a_report)
                                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-start"  >
                                                <div class="ms-2 me-auto" style="width: 100%;">
                                                    <a href="{{$a_report->filepath? asset('storage/'.$a_report->filepath):'#'}}"  target="_blank" style="display: block; text-decoration: none; color: black; width: 90%;">                                                
                                                        PS Note{{$a_report->file_name? ' - '.$a_report->file_name:''}}{{$a_report->created_at? ' - Upload Date:'.$a_report->created_at:''}}
                                                    </a>
                                                </div>
                                        </li>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="accordion" id="accordionExample">
                        @foreach($activities as $key => $b)

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{$key}}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}" onclick="fetchDocTypeDivisions({{$b['id']}})">
                                   {{$b->activity_name}}
                               </button>

                            </h2>
                            <div id="collapse{{$key}}" class="accordion-collapse collapse" aria-labelledby="heading{{$key}}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <!-- remember divisions is incorrectly spelt in the database -->
                                    @if((auth()->user()->divisions_id == $psip->division_id) || auth()->user()->divisions_id == 15 ||auth()->user()->id==2)
                                    <div class="d-flex justify-content-between align-items-start">
                                        <a href="{{ route('psipupload.create', $b->id) }}" class="btn btn-primary btn-sm me-2"><i class="bi bi-upload"></i> Upload Document</a>
                                        <div class="d-flex justify-content-between align-items-start">
                                            <select id="docGroupDropdown" class="form-select form-select-sm me-2 docGroupDropdown">
                                                <option value="">Folder Select</option>
                                                @foreach($docGroups as $docGroup)
                                                <option value="{{$docGroup->id}}">{{$docGroup->group_name}}</option>
                                                @endforeach
                                            </select>
                                            <div id="activeFilters" class="activeFilters"></div>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-light" type="button" id="dropdownMenuButton9" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical" style="font-size: 1.4rem; color: cornflowerblue;"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#documentModal" class="dropdown-item"> Document Checklist</a>
                                                <a href="{{ route('psipupload.organize', $b->id) }}" class="dropdown-item" target="_blank">Organize Documents</a>
                                                <!-- <a href="#" data-bs-toggle="modal" data-bs-target="#" class="dropdown-item">Add Photos To This Activity</a> -->
                                                <a href="{{ route('activityphoto.upload', $b->id) }}" class="dropdown-item" target="_blank">View/Upload Photos For This Activity</a>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#" class="dropdown-item">View Completion Status Of This Activity</a>
                                                @if((auth()->user()->divisions_id == 15 || auth()->user()->id == 2))
                                                <div class="dropdown-divider"></div>
                                                <button class="btn btn-danger btn-sm dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#activitySurpressModal" onclick="setSurpesssActivityId({{$b['id']}})">
                                                    Surpress this activity
                                                    <i class="bi bi-exclamation-circle-fill text-danger"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#activityRemoveModal" onclick="setRemoveActivityId({{$b['id']}})">
                                                    Remove this activity
                                                    <i class="bi bi-exclamation-circle-fill text-danger"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#" >
                                                    Set activity as completed
                                                    <i class="bi bi-check-circle-fill text-success"></i>
                                                </button>
                                                @endif

                                            </ul>
                                        </div>
                                    </div>

                                    <div class="list-group">
                                        @foreach($b->documents as $c)<!-- c == psipdoc -->
                                        <!-- <li class="list-group-item list-group-item-action  d-flex justify-content-between align-items-start"> -->
                                        <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-start" data-doc-group-id="{{$c->doc_group_id}}" >
                                            <div class="ms-2 me-auto" style="width: 100%;">
                                                <a href="{{$c->filepath? asset('storage/'.$c->filepath):'#'}}"  target="_blank" style="display: block; text-decoration: none; color: black; width: 90%;">                                                
                                                    {{$c->docType->doc_type_name}}{{$c->doc_title? ' - '.$c->doc_title:''}}
                                                </a>
                                            </div>

                                            <div class="dropdown">
                                                <button class="btn btn-light" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical" style="font-size: 1.1rem; color: cornflowerblue;"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#documentDetailsModal{{$c->id}}" class="dropdown-item">View Document Details</a>
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#updateDocumentModal" onclick="setUpdateDocId({{$c['id']}},{{$b['id']}})" class="dropdown-item">Update Document(Replace Current)</a>
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#" class="dropdown-item">Edit Document Details</a>

                                                    </li>
                                                </ul>
                                            </div>
                                        </li>

                                        <!-- document details modal -->
                                       
                                        @include('options.doc_details')
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