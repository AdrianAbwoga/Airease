@extends('admin.admin_dashboard')
@section('admin') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<div class="page-content">

    
<h6 class="card-title">UPDATE Car Information</h6>


<form method ="POST" action="{{ route('admin.hotel.store',['id' => $data->id]) }}"class="forms-sample" enctype="multipart/form-data">
@csrf    
<div class="mb-3">
        <label for="exampleInputhotel_name1" class="form-label">Hotel name</label>
        <input type="text" name="hotel_name" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{ $data->hotel_name }}">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Price</label>
        <input type="text" name="price" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{ $data->price }}">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">location</label>
        <input type="text" name="location" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{ $data->location }}">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">company</label>
        <input type="text" name="company" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{ $data->company }}">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">region</label>
        <input type="text" name="region" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{ $data->region }}">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">country</label>
        <input type="text" name="country" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{ $data->country }}">
    </div>


    <button type="submit" class="btn btn-primary me-2">Save Changes</button>
    
</form>


</div> 
            </div>
          </div>
          <!-- middle wrapper end -->
          <!-- right wrapper start -->
         
          <!-- right wrapper end -->
        </div>

			</div>
           

@endsection