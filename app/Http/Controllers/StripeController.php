<?php

namespace App\Http\Controllers;

use Stripe\StripeClient;
use Stripe\Checkout\Session;
use App\Models\User;
use App\Models\Order;
use App\Models\Receipt;
use App\Models\OrderPaid; 
use App\Models\Hotel;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function UserReceipt()
    {
        $users = User::all();
        $orders = Order::all();
        return view('user.user_receipt')
            ->with('users', $users)
            ->with('orders', $orders);
    }

    public function session(Request $request)
    {
        \Stripe\Stripe::setApiKey('sk_test_51NU1ulJobbXtcIizziGUBgCkSX5TjaTt3pt5d0ioqK9JOedxIIF051XMEDzgwbNDz2cVIcdRC3Ti0ZqFJ7NHa023005o2v2rTd');
        
        $brand = $request->get('brand');
        $hotel_name = $request->get('hotel_name');
        $price = $request->get('price');
        $total_price = $request->get('total_price');
        $order_type = $request->get('order_type');
        $airline = $request->get('airline');

        // Get the currently logged-in user
        $user = auth()->user();

        // Determine the date based on the order type
        $end_date = null;
        if ($order_type === 'car') {
            // Car order
            $end_date = $request->get('drop_off_date');
        } elseif ($order_type === 'hotel') {
            // Hotel order
            $end_date = $request->get('checkout_date');
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'kes',
                        'product_data' => [
                            'name' => $brand,
                        ],
                        'unit_amount' => (int) ($total_price * 100),
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('user.paid'),
            'cancel_url' => route('user.user_receipt'),
        ]);

        // Store the information in the orders_paid table
        $orderPaid = new OrderPaid();
        $orderPaid->brand = $brand;
        $orderPaid->price = $price;
        $orderPaid->total_price = $total_price;
        $orderPaid->order_type = $order_type;
        $orderPaid->hotel_name = $hotel_name;
        $orderPaid->end_date = $end_date;
        $orderPaid->airline = $airline;

        // Assign the user_id from the currently logged-in user
        $orderPaid->user_id = $user->id;

        $orderPaid->save();

        Order::where('user_id', $user->id)->delete();

        return redirect()->away($session->url);
    }
}
