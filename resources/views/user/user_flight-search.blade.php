@extends('user.user_dashboard')

@section('user')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div class="page-content">
    <style>
        .centered-title {
            text-align: center;
        }
    </style>
<body>
<h6 class="card-title centered-title">Search Flight Information</h6>

    <form method="POST" action="{{ route('user.flights.search') }}">
        @csrf

        <div class="mb-3">
            <label for="departure" class="form-label">Departure:</label>
            <input type="text" id="departure" name="departure" class="form-control" placeholder="Departure Airport Code" required>
        </div>

        <div class="mb-3">
            <label for="arrival" class="form-label">Arrival:</label>
            <input type="text" id="arrival" name="arrival" class="form-control" placeholder="Arrival Airport Code" required>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary me-2">Search Flight</button>
        </div>
    </form>

    @isset($flightData)
        <h2>Search Results</h2>
        <div class="table-responsive">
            <table class="table" id="flightTable">
                <thead>
                    <tr>
                        <th>Flight Number</th>
                        <th>Airline</th>
                        <th>Departure</th>
                        <th>Arrival</th>
                        <th>Status</th>
                        <th class="price">Price</th> <!-- Add the "price" class to trigger sorting -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($flightData as $flight)
                    <tr>
                        <td>{{ $flight['flight']['iata'] }}</td>
                        <td>{{ $flight['airline']['name'] }}</td>
                        <td>{{ $flight['departure']['airport'] }}</td>
                        <td>{{ $flight['arrival']['airport'] }}</td>
                        <td>{{ $flight['flight_status'] }}</td>
                        <td>Ksh{{ $price = rand(50000, 250000) }}</td>
                        <td>
                            <form method="POST" action="{{ route('user.store.flight') }}">
                                @csrf
                                <input type="hidden" name="flight_number" value="{{ $flight['flight']['iata'] }}">
                                <input type="hidden" name="airline" value="{{ $flight['airline']['name'] }}">
                                <input type="hidden" name="departure" value="{{ $flight['departure']['airport'] }}">
                                <input type="hidden" name="arrival" value="{{ $flight['arrival']['airport'] }}">
                                <input type="hidden" name="price" value="{{ $price }}">
                                <button type="submit">Order</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endisset
</div>

<script>
    $(document).ready(function() {
        $('#flightTable th.price').on('click', function() {
            var table = $(this).closest('table');
            var rows = table.find('tbody tr').toArray().sort(comparer($(this).index()));

            this.asc = !this.asc;

            if (!this.asc) {
                rows = rows.reverse();
            }

            for (var i = 0; i < rows.length; i++) {
                table.append(rows[i]);
            }
        });

        function comparer(index) {
            return function(a, b) {
                var valA = getCellValue(a, index);
                var valB = getCellValue(b, index);
                return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB);
            };
        }

        function getCellValue(row, index) {
            return $(row).children('td').eq(index).text().replace(/\D/g, '');
        }
    });
</script>

@endsection
