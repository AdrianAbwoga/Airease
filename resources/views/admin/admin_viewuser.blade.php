@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div class="page-content">

<style>
    .centered-title {
        text-align: center;
    }
</style>

<h6 class="card-title centered-title">USERS INFORMATION</h6>

<!-- Search Bar -->
<div class="mb-3">
    <label for="search-id" class="form-label">Search by ID:</label>
    <input type="text" class="form-control" id="search-id" placeholder="Enter ID">
</div>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Date joined</th>
            <th>Action</th>
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
            <td>
                <a href="{{ route('admin.edit.user', ['id' => $user->id]) }}" type="button" class="btn btn- success">Edit</a>
                <form method="POST" action="{{ route('admin.user.destroy', ['id' => $user->id]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn- danger">Delete</button>
                </form>
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>

</div>

<script>
    $(document).ready(function() {
        $('#search-id').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('tbody tr').filter(function() {
                $(this).toggle($(this).children('td:first').text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>

@endsection
