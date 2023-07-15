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
            var table = $('#carTable');
            var rows = table.find('tbody > tr');

            rows.each(function() {
                var brand = $(this).find('td[data-column="brand"]').text().toLowerCase();
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

    <h6 class="card-title centered-title">Car Information</h6>

    <!-- Add search bar -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by Brand">
    </div>

    <table class="table" id="carTable">
        <thead>
            <tr>
                <th>ID</th>
                <th data-column="brand">Brand</th>
                <th data-column="price" class="asc">Price</th>
                <th>Body</th>
                <th>Year</th>
                <th>Model</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cars as $car)
                <tr>
                    <td>{{ $car->id }}</td>
                    <td data-column="brand">{{ $car->brand }}</td>
                    <td data-column="price">{{ $car->price }}</td>
                    <td>{{ $car->body }}</td>
                    <td>{{ $car->year }}</td>
                    <td>{{ $car->model }}</td>
                    <td>
                        <a href="{{ route('user.edit.car', ['id' => $car->id]) }}" type="button" class="btn btn-success">Order</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
