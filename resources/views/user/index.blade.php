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
                          <h4 class="text-center mt-3 mb-4">Flights</h4>
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award text-primary icon-xxl d-block mx-auto my-3"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                          <h1 class="text-center">$40</h1>
                          <p class="text-muted text-center mb-4 fw-light">per month</p>
                          <h5 class="text-primary text-center mb-4">Up to 25 units</h5>
                          <table class="mx-auto">
                            <tbody><tr>
                              <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check icon-md text-primary me-2"><polyline points="20 6 9 17 4 12"></polyline></svg></td>
                              <td><p>Accounting dashboard</p></td>
                            </tr>
                            <tr>
                              <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check icon-md text-primary me-2"><polyline points="20 6 9 17 4 12"></polyline></svg></td>
                              <td><p>Invoicing</p></td>
                            </tr>
                            <tr>
                              <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check icon-md text-primary me-2"><polyline points="20 6 9 17 4 12"></polyline></svg></td>
                              <td><p>Online payments</p></td>
                            </tr>
                            <tr>
                              <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x icon-md text-danger me-2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></td>
                              <td><p class="text-muted">Branded website</p></td>
                            </tr>
                            <tr>
                              <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x icon-md text-danger me-2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></td>
                              <td><p class="text-muted">Dedicated account manager</p></td>
                            </tr>
                            <tr>
                              <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x icon-md text-danger me-2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></td>
                              <td><p class="text-muted">Premium apps</p></td>
                            </tr>
                          </tbody></table>
                          <div class="d-grid">
                            
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 stretch-card grid-margin grid-margin-md-0">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="text-center mt-3 mb-4">Business</h4>
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-gift text-success icon-xxl d-block mx-auto my-3"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>
                          <h1 class="text-center">$70</h1>
                          <p class="text-muted text-center mb-4 fw-light">per month</p>
                          <h5 class="text-success text-center mb-4">Up to 75 units</h5>
                          <table class="mx-auto">
                            <tbody><tr>
                              <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check icon-md text-primary me-2"><polyline points="20 6 9 17 4 12"></polyline></svg></td>
                              <td><p>Accounting dashboard</p></td>
                            </tr>
                            <tr>
                              <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check icon-md text-primary me-2"><polyline points="20 6 9 17 4 12"></polyline></svg></td>
                              <td><p>Invoicing</p></td>
                            </tr>
                            <tr>
                              <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check icon-md text-primary me-2"><polyline points="20 6 9 17 4 12"></polyline></svg></td>
                              <td><p>Online payments</p></td>
                            </tr>
                            <tr>
                              <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check icon-md text-primary me-2"><polyline points="20 6 9 17 4 12"></polyline></svg></td>
                              <td><p>Branded website</p></td>
                            </tr>
                            <tr>
                              <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check icon-md text-primary me-2"><polyline points="20 6 9 17 4 12"></polyline></svg></td>
                              <td><p>Dedicated account manager</p></td>
                            </tr>
                            <tr>
                              <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x icon-md text-danger me-2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></td>
                              <td><p class="text-muted">Premium apps</p></td>
                            </tr>
                          </tbody></table>
                          <div class="d-grid">
                            
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 stretch-card">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="text-center mt-3 mb-4">Professional</h4>
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase text-primary icon-xxl d-block mx-auto my-3"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                          <h1 class="text-center">$250</h1>
                          <p class="text-muted text-center mb-4 fw-light">per month</p>
                          <h5 class="text-primary text-center mb-4">Up to 300 units</h5>
                          <table class="mx-auto">
                            <tbody><tr>
                              <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check icon-md text-primary me-2"><polyline points="20 6 9 17 4 12"></polyline></svg></td>
                              <td><p>Accounting dashboard</p></td>
                            </tr>
                            <tr>
                              <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check icon-md text-primary me-2"><polyline points="20 6 9 17 4 12"></polyline></svg></td>
                              <td><p>Invoicing</p></td>
                            </tr>
                            <tr>
                              <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check icon-md text-primary me-2"><polyline points="20 6 9 17 4 12"></polyline></svg></td>
                              <td><p>Online payments</p></td>
                            </tr>
                            <tr>
                              <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check icon-md text-primary me-2"><polyline points="20 6 9 17 4 12"></polyline></svg></td>
                              <td><p>Branded website</p></td>
                            </tr>
                            <tr>
                              <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check icon-md text-primary me-2"><polyline points="20 6 9 17 4 12"></polyline></svg></td>
                              <td><p>Dedicated account manager</p></td>
                            </tr>
                            <tr>
                              <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check icon-md text-primary me-2"><polyline points="20 6 9 17 4 12"></polyline></svg></td>
                              <td><p>Premium apps</p></td>
                            </tr>
                          </tbody></table>
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