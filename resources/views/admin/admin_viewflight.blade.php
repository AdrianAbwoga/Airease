@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div class="page-content">

<style>
    .centered-title {
        text-align: center;
    }
</style>

    <h6 class="card-title centered-title">Flight Information</h6>
    <table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Departure location</th>
            <th>Destination</th>
            <th>Number of users</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach($flights as $flight)
        
        <tr>
            <td>{{ $flight->id }}</td>
            <td>{{ $flight->Depature_location }}</td>
            <td>{{ $flight->destination }}</td>
            <td>{{ $flight->number_of_users }}</td>
            
            
        </tr>
       
        @endforeach
    </tbody>
</table>


			</div>
@endsection