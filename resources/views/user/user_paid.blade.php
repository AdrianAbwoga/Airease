@extends('user.user_dashboard')
@section('user')
<div class="page-content">
    @foreach($ordersPaid as $orderPaid)
    @if($orderPaid->user_id == auth()->user()->id)
    <div class="card-body">
        <div class="container-fluid d-flex justify-content-between">
            <div class="col-lg-3 ps-0">
                <a href="#" class="noble-ui-logo logo-light d-block mt-3">Air<span>Ease</span></a>                 
                <p class="mt-1 mb-1"><b>AirEase FlyBetter</b></p>
                <p>+254772046768<br> Strathmore University St,<br>Nairobi, Madaraka.</p>
                <h5 class="mt-5 mb-2 text-muted">Receipt to :</h5>
                <p>{{ $orderPaid->user->name }},<br> {{ $orderPaid->user->address }},<br> {{ $orderPaid->user->email }}.</p>
            </div>
            <div class="col-lg-3 pe-0">
                <h4 class="fw-bolder text-uppercase text-end mt-4 mb-2">PAID RECEIPT</h4>
                <h6 class="text-end mb-5 pb-4">#UserID {{ $orderPaid->user_id }}</h6>
                <p class="text-end mb-1">AMOUNT PAID</p>
                <h4 class="text-end fw-normal">Ksh{{ $orderPaid->total_price }}</h4>
                <h6 class="mb-0 mt-3 text-end fw-normal mb-2"><span class="text-muted">Ordered Date :</span> {{ $orderPaid->created_at }}</h6>
                
                
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
                            <td class="text-start">{{ $orderPaid->brand }}</td>
                            <td>{{ $orderPaid->num_of_days }}</td>
                            <td>Ksh{{ $orderPaid->price }}</td>
                            <td>Ksh{{ $orderPaid->total_price }}</td>
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
                                    <td class="text-bold-800 text-end">Ksh {{ $orderPaid->total_price }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        

    </div>
    @endif
    @endforeach
</div>
@endsection
