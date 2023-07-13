@extends('admin.admin_dashboard')
@section('admin') 

<div class="page-content">

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
          <div>
            <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
          </div>
          <div class="d-flex align-items-center flex-wrap text-nowrap">
            <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
              <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i data-feather="calendar" class="text-primary"></i></span>
              <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date" data-input>
            </div>
            
            
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Users</h6>
                      
                    </div>
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2">

                        <?php
                        $connection = mysqli_connect("localhost","root","","airease");
                        $query = "SELECT id FROM users WHERE role ='user' ORDER BY id";
                        $query_run = mysqli_query($connection, $query);

                        $row = mysqli_num_rows($query_run);
                        echo ''.$row.'';
                        ?>

                        </h3>
                        <div class="d-flex align-items-baseline">
                          
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">Flights</h6>
                      
                    </div>
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2">
                          
                        
                        
                        <?php
                        $connection = mysqli_connect("localhost","root","","airease");
                        $query = "SELECT id FROM flights";
                        $query_run = mysqli_query($connection, $query);

                        $row = mysqli_num_rows($query_run);
                        echo ''.$row.'';
                        ?></h3>
                        
                      </div>
                     
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                      <h6 class="card-title mb-0">still deciding</h6>
                      
                    </div>
                    <div class="row">
                      <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2"><!--code for retrieving number of tickets sold--></h3>
                        
                      </div>
                      
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> <!-- row -->

      

        <div class="row">
          <div class="col-lg-7 col-xl-12 grid-margin stretch-card">
            
            </div>
          </div>
       
        </div> <!-- row -->



			</div>

@endsection