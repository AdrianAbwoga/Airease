@extends('admin.admin_dashboard')
@section('admin') 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<div class="page-content">

    <h6 class="card-title">USERS INFORMATION</h6>
    <table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Date joined</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        @if($user->role === 'user')
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at }}</td>
            
        </tr>
        @endif
        @endforeach
    </tbody>
</table>


			</div>
            

@endsection