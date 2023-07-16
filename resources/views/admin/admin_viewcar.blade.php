@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div class="page-content">

<style>
    .centered-title {
        text-align: center;
    }
</style>

<h6 class="card-title centered-title">CARS INFORMATION</h6>

<!-- Search Bar -->
<div class="mb-3">
    <label for="search-brand" class="form-label">Search by Brand:</label>
    <input type="text" class="form-control" id="search-brand" placeholder="Enter Brand">
</div>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Brand</th>
            <th>Price</th>
            <th>Body</th>
            <th>Year</th>
            <th>Model</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cars as $car)
        
        <tr>
            <td>{{ $car->id }}</td>
            <td>{{ $car->brand }}</td>
            <td>{{ $car->price }}</td>
            <td>{{ $car->body }}</td>
            <td>{{ $car->year }}</td>
            <td>{{ $car->model }}</td>
            <td>
                <a href="{{ route('admin.edit.car', ['id' => $car->id]) }}" type="button" class="btn btn- success">Edit</a>
                <form method="POST" action="{{ route('admin.car.destroy', ['id' => $car->id]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn- danger">Delete</button>
                </form>
            </td>
        </tr>
        
        @endforeach
    </tbody>
</table>

</div>

<script>
    $(document).ready(function() {
        $('#search-brand').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('tbody tr').filter(function() {
                $(this).toggle($(this).children('td:nth-child(2)').text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>

@endsection
