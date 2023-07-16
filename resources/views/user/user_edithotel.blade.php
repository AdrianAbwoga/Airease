@extends('user.user_dashboard')
@section('user') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<div class="page-content">

    
<h6 class="card-title">Confirm order</h6>


<form method="POST" action="{{ route('user.store.order',['id' => $data->id]) }}" class="forms-sample" enctype="multipart/form-data">
    @csrf    
    <div class="mb-3">
        <label for="exampleInputUsername1" class="form-label">Hotel name</label>
        <input type="text" name="hotel_name" class="form-control" id="hotel_name" autocomplete="off" value="{{ $data->hotel_name }}" readonly>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Price per day</label>
        <input type="text" name="price" class="form-control" id="price" autocomplete="off" value="{{ $data->price }}" readonly>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Country</label>
        <input type="text" name="country" class="form-control" id="country" autocomplete="off" value="{{ $data->country }}" readonly>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Location</label>
        <input type="text" name="location" class="form-control" id="location" autocomplete="off" value="{{ $data->location }}" readonly>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Region</label>
        <input type="text" name="region" class="form-control" id="region" autocomplete="off" value="{{ $data->region }}" readonly>
    </div>

    <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Arrival Date</label>
    <input type="date" name="arrival_date" class="form-control" id="arrival_date" required>
</div>

<div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Company</label>
    <input type="text" name="company" class="form-control" id="company" autocomplete="off" value="{{ $data->company }}" readonly>
</div>

<div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">order type</label>
        <input type="text" name="order_type" class="form-control" id="order_type" autocomplete="off" value="{{ $data->order_type }}" readonly>
    </div>



    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Days of stay</label>
        <input type="number" name="days_of_stay" class="form-control" id="days_of_stay" autocomplete="off"  required>
    </div>

    <button type="submit" class="btn btn-primary me-2">Confirm Order</button>
    
</form>


</div> 
@endsection
