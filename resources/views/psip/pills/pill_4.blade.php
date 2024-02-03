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