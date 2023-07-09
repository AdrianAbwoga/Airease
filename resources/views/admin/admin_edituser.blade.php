@extends('admin.admin_dashboard')
@section('admin') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<div class="page-content">

    
<h6 class="card-title">UPDATE User Profile</h6>


<form method ="POST" action="{{ route('admin.user.store',['id' => $data->id]) }}"class="forms-sample" enctype="multipart/form-data">
@csrf    
<div class="mb-3">
        <label for="exampleInputUsername1" class="form-label">Username</label>
        <input type="text" name="username" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{ $data->username }}">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Name</label>
        <input type="text" name="name" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{ $data->name }}">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{ $data->email }}">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{ $data->phone }}">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Address</label>
        <input type="text" name="address" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{ $data->address }}">
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