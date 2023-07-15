<?php
namespace App\Http\Controllers;
use Stripe\StripeClient;
use Stripe\Checkout\Session;
use App\Models\User;
use App\Models\Order;
use App\Models\Receipt;
use App\Models\OrderPaid; 

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
    \Stripe\Stripe::setApiKey(config('stripe.sk'));
    $brand = $request->get('brand');
    $price = $request->get('price');
    $total_price = $request->get('total_price');

    // Get the currently logged-in user
    $user = auth()->user();

    $session = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [
            [
                'price_data' => [
                    'currency' => 'kes',
                    'unit_amount' => (int) ($total_price * 100),
                    'product_data' => [
                        'name' => $brand,
                    ],
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

    // Assign the user_id from the currently logged-in user
    $orderPaid->user_id = $user->id;

    $orderPaid->save();

    return redirect()->away($session->url);
}

    

   

}
