@extends('admin.admin_dashboard')

@section('admin')
<div class="page-content">
  <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
    <h4 class="mb-3 mb-md-0">Welcome to Dashboard, {{ auth()->user()->name }}</h4>

    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
      <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
        <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle>
          <i data-feather="calendar" class="text-primary"></i>
        </span>
        <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date" data-input>
      </div>
    </div>
  </div>

  <div class="row">
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
                $connection = mysqli_connect("localhost", "root", "", "airease");
                $query = "SELECT id FROM users WHERE role ='user' ORDER BY id";
                $query_run = mysqli_query($connection, $query);

                $usersno = mysqli_num_rows($query_run);
                echo '' . $usersno . '';
                ?>
              </h3>
              <div class="d-flex align-items-baseline"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-baseline">
            <h6 class="card-title mb-0">Available Hotels</h6>
          </div>
          <div class="row">
            <div class="col-6 col-md-12 col-xl-5">
              <h3 class="mb-2">
                <?php
                $connection = mysqli_connect("localhost", "root", "", "airease");
                $query = "SELECT id FROM hotels";
                $query_run = mysqli_query($connection, $query);

                $hotelsno = mysqli_num_rows($query_run);
                echo '' . $hotelsno . '';
                ?>
              </h3>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-baseline">
            <h6 class="card-title mb-0">Available cars</h6>
          </div>
          <div class="row">
            <div class="col-6 col-md-12 col-xl-5">
              <h3 class="mb-2">
                <?php
                $connection = mysqli_connect("localhost", "root", "", "airease");
                $query = "SELECT id FROM cars";
                $query_run = mysqli_query($connection, $query);

                $carsno = mysqli_num_rows($query_run);
                echo '' . $carsno . '';
                
                ?>
              </h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> <!-- row -->

  <div class="card">
    <div class="card-body">
      <h6 class="card-title">General chart</h6>
      <div id="apexPie" style="min-height: 301.7px;"></div>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <h6 class="card-title">Orders Chart</h6>
      <div id="apexPie2" style="min-height: 301.7px;"></div>
    </div>
  </div>
</div>

<!-- Include the ApexCharts library -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
<?php
                $connection = mysqli_connect("localhost", "root", "", "airease");
                $query = "SELECT id FROM orders_paid";
                $query_run = mysqli_query($connection, $query);

                $ordersno = mysqli_num_rows($query_run);
                
                
                ?>

<!-- Initialize the chart -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const options = {
      series: [<?php echo $usersno; ?>, <?php echo $hotelsno; ?>, <?php echo $carsno; ?>,<?php echo $ordersno; ?>],
      chart: {
        type: "pie",
        height: 350,
      },
      labels: ["Users", "Hotels", "Available Cars","Orders paid"],
      colors: ["#6571FF", "#FDBC06", "#FF3366", "#66D1D1"],
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: "bottom"
          }
        }
      }]
    };

    const chart = new ApexCharts(document.querySelector("#apexPie"), options);
    chart.render();
  });
</script>
<!-- Include the ApexCharts library -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
<?php
$connection = mysqli_connect("localhost", "root", "", "airease");

// Count for hotel orders
$query_hotel = "SELECT id FROM orders_paid WHERE order_type = 'hotel'";
$query_run_hotel = mysqli_query($connection, $query_hotel);
$hotelno = mysqli_num_rows($query_run_hotel);

// Count for car orders
$query_car = "SELECT id FROM orders_paid WHERE order_type = 'car'";
$query_run_car = mysqli_query($connection, $query_car);
$carno = mysqli_num_rows($query_run_car);

// Count for flight orders
$query_flight = "SELECT id FROM orders_paid WHERE order_type = 'flight'";
$query_run_flight = mysqli_query($connection, $query_flight);
$flightno = mysqli_num_rows($query_run_flight);
?>



<!-- Initialize the chart -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const options = {
      series: [<?php echo $hotelno; ?>, <?php echo $carno; ?>, <?php echo $flightno; ?>],
      chart: {
        type: "pie",
        height: 350,
      },
      labels: ["Hotels", "Cars", "Flights"],
      colors: ["#6571FF", "#FDBC06", "#FF3366"],
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: "bottom"
          }
        }
      }]
    };

    const chart = new ApexCharts(document.querySelector("#apexPie2"), options);
    chart.render();
  });
</script>


@endsection
