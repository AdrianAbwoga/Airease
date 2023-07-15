@extends('user.user_dashboard')
@section('user')
<div class="page-content">
    @foreach($orders as $order)
    <div class="card-body">
        <div class="container-fluid d-flex justify-content-between">
            <div class="col-lg-3 ps-0">
                <a href="#" class="noble-ui-logo logo-light d-block mt-3">Air<span>Ease</span></a>                 
                <p class="mt-1 mb-1"><b>AirEase FlyBetter</b></p>
                <p>+254772046768<br> Strathmore University St,<br>Nairobi, Madaraka.</p>
                <h5 class="mt-5 mb-2 text-muted">Invoice to :</h5>
                <p>{{ $order->user->name }},<br> {{ $order->user->address }},<br> {{ $order->user->email }}.</p>
            </div>
            <div class="col-lg-3 pe-0">
                <h4 class="fw-bolder text-uppercase text-end mt-4 mb-2">Invoice</h4>
                <h6 class="text-end mb-5 pb-4">#UserID {{ $order->order_id }}</h6>
                <p class="text-end mb-1">Balance Due</p>
                <h4 class="text-end fw-normal">Ksh{{ $order->total_price }}</h4>
                <h6 class="mb-0 mt-3 text-end fw-normal mb-2"><span class="text-muted">Ordered Date :</span> {{ $order->created_at }}</h6>
                <h6 class="mb-0 mt-3 text-end fw-normal mb-2"><span class="text-muted">Pickup Date :</span> {{ $order->pickup_date }}</h6>
                <h6 class="mb-0 mt-3 text-end fw-normal mb-2"><span class="text-muted">Return Date :</span> {{ $order->drop_off_date }}</h6>
            </div>
        </div>
        <div class="container-fluid mt-5 d-flex justify-content-center w-100">
            <div class="table-responsive w-100">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Brand</th>
                            <th class="text-end">Number of days</th>
                            <th class="text-end">Unit cost</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-end">
                            <td class="text-start">1</td>
                            <td class="text-start">{{ $order->brand }}</td>
                            <td>{{ $order->num_of_days }}</td>
                            <td>Ksh{{ $order->price }}</td>
                            <td>Ksh{{ $order->total_price }}</td>
                        </tr>
                        <!-- Add more rows if needed -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="container-fluid mt-5 w-100">
            <div class="row">
                <div class="col-md-6 ms-auto">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr class="bg-dark">
                                    <td class="text-bold-800">Total price</td>
                                    <td class="text-bold-800 text-end">Ksh {{ $order->total_price }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-start">
        <form action="{{ route('session', ['order' => $order->order_id]) }}" method="POST">
        @csrf
        <input type="hidden" name="brand" value="{{ $order->brand }}">
        <input type="hidden" name="num_of_days" value="{{ $order->num_of_days }}">
        <input type="hidden" name="price" value="{{ $order->price }}">
        <input type="hidden" name="total_price" value="{{ $order->total_price }}">
        <button class="btn btn-success" type="submit" id="checkout-live-button">Pay</button>
    </form>
    <form method="POST" action="{{ route('user.order.destroy', ['order_id' => $order->order_id]) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
</div>


    </div>
    @endforeach
</div>
@endsection
