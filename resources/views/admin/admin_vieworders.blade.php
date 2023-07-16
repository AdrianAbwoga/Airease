@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div class="page-content">
    <style>
        .centered-title {
            text-align: center;
        }
    </style>

    <h6 class="card-title centered-title">PAID ORDERS INFORMATION</h6>
    
    <div class="filter">
        <label for="order-type">Filter by Order Type:</label>
        <select id="order-type" name="order-type">
            <option value="">All</option>
            <option value="car">Car</option>
            <option value="hotel">Hotel</option>
            <option value="flight">Flight</option>
        </select>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>UserID</th>
                <th>Brand</th>
                <th>Price</th>
                <th>Order Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ordersPaid as $orderPaid)
            <tr class="order-row">
                <td>{{ $orderPaid->id }}</td>
                <td>{{ $orderPaid->user_id }}</td>
                <td>{{ $orderPaid->brand }}</td>
                <td>{{ $orderPaid->price }}</td>
                <td>{{ $orderPaid->order_type }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    // Filter the orders based on the selected order type
    $('#order-type').on('change', function() {
        var selectedOrderType = $(this).val();
        
        $('.order-row').each(function() {
            var orderType = $(this).find('td:nth-child(5)').text();
            
            if (selectedOrderType === '' || orderType.toLowerCase() === selectedOrderType.toLowerCase()) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>
@endsection
