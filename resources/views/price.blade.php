@extends('layouts.main')

@section('content')
    <div class="card p-5">
        <h2 class="text-center">Flight Payment</h2>
        
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <h4>Flight Details</h4>
                    <p><strong>Airline:</strong> {{ $airline }}</p>
                    <p><strong>Departure:</strong> {{ $departure }}</p>
                    <p><strong>Destination:</strong> {{ $destination }}</p>
                    <p><strong>Travel Class:</strong> {{ $travelClass }}</p>
                    <p><strong>Price (EUR):</strong> {{ $price }}</p>
                </div>
            </div>
        </div>

        <div class="container mt-5">
            <h4>Select Payment Method</h4>
            
            <!-- M-PESA Payment Form -->
            <form action="" method="POST">
                @csrf
                <input type="hidden" name="airline" value="{{ $airline }}">
                <input type="hidden" name="departure" value="{{ $departure }}">
                <input type="hidden" name="destination" value="{{ $destination }}">
                <input type="hidden" name="travelClass" value="{{ $travelClass }}">
                <input type="hidden" name="price" value="{{ $price }}">
                
                <button type="submit" class="btn btn-primary">Pay with M-PESA</button>
            </form>
            
            <!-- PayPal Payment Form -->
            <form action="" method="POST">
                @csrf
                <input type="hidden" name="airline" value="{{ $airline }}">
                <input type="hidden" name="departure" value="{{ $departure }}">
                <input type="hidden" name="destination" value="{{ $destination }}">
                <input type="hidden" name="travelClass" value="{{ $travelClass }}">
                <input type="hidden" name="price" value="{{ $price }}">
                
                <button type="submit" class="btn btn-primary">Pay with PayPal</button>
            </form>
            
            <!-- Bank Transfer Payment Form -->
            <form action="" method="POST">
                @csrf
                <input type="hidden" name="airline" value="{{ $airline }}">
                <input type="hidden" name="departure" value="{{ $departure }}">
                <input type="hidden" name="destination" value="{{ $destination }}">
                <input type="hidden" name="travelClass" value="{{ $travelClass }}">
                <input type="hidden" name="price" value="{{ $price }}">
                
                <button type="submit" class="btn btn-primary">Pay with Bank Transfer</button>
            </form>
        </div>
    </div>
@endsection