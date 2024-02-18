<!-- document details modals -->
                                        <div class="modal fade" id="documentDetailsModal{{$c->id}}" tabindex="-1" aria-labelledby="documentDetailsModalLabel{{$c->id}}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="documentDetailsModalLabel{{$c->id}}">Document Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                       
                                                            <h5>Document type</h5>
                                                            <p>{{$c->docType->doc_type_name}}</p>
                                                            <h5>Document Title/Name</h5>
                                                            <p id="docName">{{$c->doc_title? $c->doc_title:'No title submitted'}}</p>
                                                            <h5>Document Details/Description</h5>
                                                            <p id="docDetails">{{$c->docType->description? $c->docType->description:'No details submitted'}}</p>
                                                            <h5>Upload Date</h5>
                                                            <p id="docCreatedAt">{{$c->created_at? $c->created_at:'No data'}}</p>
                                                            <h5>Additional Information</h5>
                                                            <p id="docPreviousDoc">{{$c->previous_doc_id? 'This document replaced a previous document.':'No data.'}}</p>
                                                            <p id="docUplodedBy">Uploaded by: {{$c->createdBy->name}}</p>
                                                            <hr>
                                                            <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>