@extends('admin.admin_dashboard')

@section('admin')
<div class="page-content">
  <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
      <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
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
      <h6 class="card-title">Pie chart</h6>
      <div id="apexPie" style="min-height: 301.7px;"></div>
    </div>
  </div>
</div>

<!-- Include the ApexCharts library -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>

<!-- Initialize the chart -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const options = {
      series: [<?php echo $usersno; ?>, <?php echo $hotelsno; ?>, <?php echo $carsno; ?>],
      chart: {
        type: "pie",
        height: 350,
      },
      labels: ["Users", "Hotels", "Available Cars"],
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
@endsection
