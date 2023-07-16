@extends('user.user_dashboard')
@section('user')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // Add click event listener to the Price column header
        $('th[data-column="price"]').on('click', function() {
            var table = $(this).closest('table');
            var rows = table.find('tbody > tr').toArray();

            // Toggle sorting order based on the current state
            var ascending = $(this).hasClass('asc');
            $(this).toggleClass('asc', !ascending).toggleClass('desc', ascending);

            // Sort the rows based on the price value
            rows.sort(function(a, b) {
                var aValue = parseFloat($(a).find('td[data-column="price"]').text());
                var bValue = parseFloat($(b).find('td[data-column="price"]').text());

                if (ascending) {
                    return aValue - bValue;
                } else {
                    return bValue - aValue;
                }
            });

            // Reorder the table rows based on the sorted array
            table.find('tbody').empty().append(rows);
        });

        // Add search functionality
        $('#searchInput').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            var table = $('#hotelTable');
            var rows = table.find('tbody > tr');

            rows.each(function() {
                var brand = $(this).find('td[data-column="country"]').text().toLowerCase();
                if (brand.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>

<div class="page-content">
    <style>
        .centered-title {
            text-align: center;
        }
    </style>

    <h6 class="card-title centered-title">Hotel Information</h6>

    <!-- Add search bar -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by country">
    </div>

    <table class="table" id="hotelTable">
        <thead>
            <tr>
                <th>ID</th>
                <th data-column="country">Country</th>
                <th data-column="price" class="asc">Price</th>
                <th>Hotel name</th>
                <th>region</th>
                <th>location</th>
                
        </thead>
        <tbody>
            @foreach($hotels as $hotel)
                <tr>
                    <td>{{ $hotel->id }}</td>
                    <td data-column="country">{{ $hotel->country }}</td>
                    <td data-column="price">{{ $hotel->price }}</td>
                    <td>{{ $hotel->hotel_name }}</td>
                    <td>{{ $hotel->region }}</td>
                    <td>{{ $hotel->location }}</td>
                    <td>
                        <a href="{{ route('user.edit.hotel', ['id' => $hotel->id]) }}" type="button" class="btn btn-success">Order</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
