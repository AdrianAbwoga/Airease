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
                            <th>description</th>
                            <th class="text-end">Unit cost</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-end">
                            <td class="text-start">1</td>
                            <td class="text-start">{{ $orderPaid->brand }}</td>
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
        
        <!-- Add the print button -->
        <div class="text-center mt-5">
            <button id="printButton" type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer btn-icon-prepend">
                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                    <rect x="6" y="14" width="12" height="8"></rect>
                </svg>
                Print
            </button>
        </div>

    </div>
    @endif
    @endforeach
</div>

<script>
    document.getElementById("printButton").addEventListener("click", function() {
        window.print();
    });
</script>
@endsection
