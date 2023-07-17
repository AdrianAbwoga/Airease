<!-- flight-search.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Flight Search</title>
</head>
<body>
    <h1>Flight Search</h1>

    <form method="POST" action="{{ route('user.flights.search') }}">
        @csrf

        <div class="mb-3">
            <label for="departure">Departure:</label>
            <input type="text" id="departure" name="departure" placeholder="Departure Airport Code" required>
        </div>

        <div class="mb-3">
            <label for="arrival">Arrival:</label>
            <input type="text" id="arrival" name="arrival" placeholder="Arrival Airport Code" required>
        </div>

        <div>
        <button type="submit" class="btn btn-primary me-2">Search Flights</button>
        </div>
    </form>

    @isset($flightData)
        <h2>Search Results</h2>
        <table>
            <thead>
                <tr>
                    <th>Flight Number</th>
                    <th>Airline</th>
                    <th>Departure</th>
                    <th>Arrival</th>
                    <th>Status</th>
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
                        <td>
                            <form method="POST" action="{{ route('user.store.order') }}">
                                @csrf
                                <input type="hidden" name="flight_number" value="{{ $flight['flight']['iata'] }}">
                                <input type="hidden" name="airline" value="{{ $flight['airline']['name'] }}">
                                <input type="hidden" name="departure" value="{{ $flight['departure']['airport'] }}">
                                <input type="hidden" name="arrival" value="{{ $flight['arrival']['airport'] }}">
                                <button type="submit">Order</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endisset
</body>
</html>
