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
                                            <div class="dropdown">
                                                <button class="btn btn-light" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                                    &#8230;<!-- horizontal ellipsis HTML entity  -->
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
                                                <div class="dropdown">
                                                    <button class="btn btn-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                        &#8230;<!-- horizontal ellipsis HTML entity  -->
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
                                                <div class="dropdown">
                                                    <button class="btn btn-light" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                                        &#8230;<!-- horizontal ellipsis HTML entity  -->
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