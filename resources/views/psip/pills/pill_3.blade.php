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
                            @if((auth()->user()->divisions_id == $psip->division_id) || auth()->user()->id==2 || auth()->user()->divisions_id == 15)
                            <canvas id="Projections" width="800" height="400"></canvas>
                            @endif
                        </div>
                    </div>
                </div>
            </div>