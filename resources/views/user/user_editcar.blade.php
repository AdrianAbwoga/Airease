@extends('user.user_dashboard')
@section('user') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<div class="page-content">

    
<h6 class="card-title">Confirm order</h6>


<form method="POST" action="{{ route('user.store.order',['id' => $data->id]) }}" class="forms-sample" enctype="multipart/form-data">
    @csrf    
    <div class="mb-3">
        <label for="exampleInputUsername1" class="form-label">Brand</label>
        <input type="text" name="brand" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{ $data->brand }}" readonly>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Price per day</label>
        <input type="text" name="price" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{ $data->price }}" readonly>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Body</label>
        <input type="email" name="body" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{ $data->body }}" readonly>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Year</label>
        <input type="text" name="year" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{ $data->year }}" readonly>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Model</label>
        <input type="text" name="model" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{ $data->model }}" readonly>
    </div>

    <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Pickup Date</label>
    <input type="date" name="pickup_date" class="form-control" id="exampleInputUsername1" required>
</div>


    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Number of Days</label>
        <input type="number" name="num_of_days" class="form-control" id="exampleInputUsername1" autocomplete="off" required>
    </div>

    <button type="submit" class="btn btn-primary me-2">Confirm Order</button>
    
</form>


</div> 
@endsection
