@extends('user.user_dashboard')
@section('user') 

<div class="page-content">
<div class="row">
					<div class="col-md-12 stretch-card">
						<div class="card">
							<div class="card-body">
								<h6 class="card-title">Search Flights</h6>
									<form>
										<div class="row">
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">From</label>
													<input type="text" class="form-control" placeholder="From" name="from" required>
												</div>
											</div><!-- Col -->
											<div class="col-sm-6">
												<div class="mb-3">
													<label class="form-label">To</label>
													<input type="text" class="form-control" placeholder="To" name ="to" required>
												</div>
											</div><!-- Col -->
										</div><!-- Row -->
										<div class="row">
											<div class="col-sm-4">
												<div class="mb-3">
													<label class="form-label">City</label>
													<input type="date" class="form-control" placeholder="Departure Date" name="date" required>
												</div>
											</div><!-- Col -->
											<div class="col-sm-4">
												<div class="mb-3">
													<label class="form-label">Passengers</label>
													<input type="number" class="form-control" placeholder="Passengers" name="passengers" required>
												</div>
											</div><!-- Col -->
											
										</div><!-- Row -->
										</form>
                                        @if(isset($flights) && count($flights) > 0)
            <h2 class="text-center mt-5">{{ count($flights) }} Results</h2>
            <div class="row">
                @foreach($flights as $flight)
                    <div class="col-12">
                        <div class="flight-container p-4 border rounded mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Flight {{ $flight->id }}</h5>
                                <a href="{{ url('/api/price', ['flight' => json_encode($flight)]) }}" class="btn btn-primary">View</a>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <p class="mb-1">Airline: {{ $flight->itineraries[0]->segments[0]->carrierCode }}</p>
                                    <p class="mb-1">Departure: {{ $flight->itineraries[0]->segments[0]->departure->iataCode }}</p>
                                    <p class="mb-1">Destination: {{ $flight->itineraries[0]->segments[0]->arrival->iataCode }}</p>
                                    <p class="mb-1">Travel Class: {{ $flight->travelerPricings[0]->fareDetailsBySegment[0]->cabin }}</p>
                                    <p class="mb-1">Price (EUR): {{ $flight->price->total }}</p>
                                </div>
                                <div class="col-9">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif



			</div>

@endsection