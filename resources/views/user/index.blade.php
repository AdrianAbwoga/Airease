@extends('user.user_dashboard')
@section('user') 

<div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
          <div>
          <h4 class="mb-3 mb-md-0">Welcome to Airease, {{ auth()->user()->name }}</h4>
          </div>
          <div class="d-flex align-items-center flex-wrap text-nowrap">
            <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
              <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i data-feather="calendar" class="text-primary"></i></span>
              <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date" data-input>
            </div>
            
            
          </div>
        </div>
        <div class="row">
					<div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <h3 class="text-center mb-3 mt-4">Amazing things to choose from </h3>
                <p class="text-muted text-center mb-4 pb-2">Choose from car rentals to airplane tickets and where to rest your head.</p>
                <div class="container">  
                  <div class="row">
                    <div class="col-md-4 stretch-card grid-margin grid-margin-md-0">
                      <div class="card">
                        <div class="card-body">
                        <a href="">
                          <h4 class="text-center mt-3 mb-4">Flights</h4>
                        </a>

                          
                          
                          <div class="d-grid">
                            
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 stretch-card grid-margin grid-margin-md-0">
                      <div class="card">
                        <div class="card-body">
                        <a href="{{  route('user.view.car')  }}">
                          <h4 class="text-center mt-3 mb-4">Cars</h4>
                        </a>
                          
                          
                          <div class="d-grid">
                            
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 stretch-card">
                      <div class="card">
                        <div class="card-body">
                        <a href="{{  route('user.view.hotel')  }}">
                          <h4 class="text-center mt-3 mb-4">Hotels</h4>
                        </a>
                          
                          
                          <div class="d-grid">
                            
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
					</div>
				</div>


      

        <div class="row">
          <div class="col-lg-7 col-xl-12 grid-margin stretch-card">
            
            
            </div>
          </div>
       
        



			</div>

@endsection