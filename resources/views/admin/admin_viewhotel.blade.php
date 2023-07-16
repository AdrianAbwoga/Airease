@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div class="page-content">

<style>
    .centered-title {
        text-align: center;
    }
</style>

<h6 class="card-title centered-title">HOTEL INFORMATION</h6>

<!-- Search Bar -->
<div class="mb-3">
    <label for="search-hotel_name" class="form-label">Search by Hotel Name:</label>
    <input type="text" class="form-control" id="search-hotel_name" placeholder="Enter Hotel name">
</div>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Hotel name</th>
            <th>Price</th>
            <th>country</th>
            <th>location</th>
            <th>region</th>
            <th>company</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($hotels as $hotel)
        
        <tr>
            <td>{{ $hotel->id }}</td>
            <td>{{ $hotel->hotel_name }}</td>
            <td>{{ $hotel->price }}</td>
            <td>{{ $hotel->country }}</td>
            <td>{{ $hotel->location }}</td>
            <td>{{ $hotel->region }}</td>
            <td>{{ $hotel->company }}</td>
            
            <td>
                <a href="{{ route('admin.edit.hotel', ['id' => $hotel->id]) }}" type="button" class="btn btn- success">Edit</a>
                <form method="POST" action="{{ route('admin.hotel.destroy', ['id' => $hotel->id]) }}">
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
        $('#search-hotel_name').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('tbody tr').filter(function() {
                $(this).toggle($(this).children('td:nth-child(2)').text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>

@endsection
