@extends('admin.admin_dashboard')
@section('admin') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<div class="page-content">

    
<h6 class="card-title">UPDATE Car Information</h6>


<form method ="POST" action="{{ route('admin.car.store',['id' => $data->id]) }}"class="forms-sample" enctype="multipart/form-data">
@csrf    
<div class="mb-3">
        <label for="exampleInputBrand1" class="form-label">Brand</label>
        <input type="text" name="brand" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{ $data->brand }}">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Price</label>
        <input type="text" name="price" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{ $data->price }}">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Body</label>
        <input type="text" name="body" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{ $data->body }}">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Year</label>
        <input type="text" name="year" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{ $data->year }}">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Model</label>
        <input type="text" name="model" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{ $data->model }}">
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