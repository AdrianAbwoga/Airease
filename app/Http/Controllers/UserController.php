<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Car;
use App\Models\Order;
use App\Models\OrderPaid;
use App\Models\Receipt;
use App\Models\Hotel;
use GuzzleHttp\Client;


class UserController extends Controller
{
    public function UserDashboard(){
        return view('user.index');

    }//end method

    public function UserFlightsSearch(){
        return view('user.user_flight-search');

    }//end method

    

    public function UserLogout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }//end method


    public function UserProfile(){

       $id = Auth::user()->id;
       $profileData = User::find($id);
       return view('user.user_profile_view',compact('profileData'));
    }//end method

    public function UserProfileStore(Request $request){
        $id = Auth::user()->id;
       $data = User::find($id);
       $data->username = $request->username;
       $data->name = $request->name;
       $data->email = $request->email;
       $data->phone = $request->phone;
       $data->address = $request->address;
       
       if($request->file('photo')){
        $file = $request->file('photo');
        @unlink(public_path('upload/admin_images/'.$data->photo));
        $filename = date('YmdHi').$file->getClientOriginalName(); 
        $file->move(public_path('upload/admin_images'),$filename);
        $data['photo'] = $filename;
       }
       $data->save();
       $notification = array(
        'message' => 'User Profile Updated Successfully',
        'alert-type' => 'success'  
       );
       return redirect()->back()->with($notification);

    }//end method
    
    public function UserChangePassword(){
        $id = Auth::user()->id;
       $profileData = User::find($id);

        return view('user.user_change_password',compact('profileData'));

    }
    
    public function UserUpdatePassword(Request $request){

        //validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        //match the old password

        if (!Hash::check($request->old_password, auth::user()->password)){

            $notification = array(
                'message' => 'Old password Does Not Match',
                'alert-type' => 'error'  
               );
               return back()->with($notification);
        
        }

        //Update The New Password

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = array(
            'message' => 'Password Changed Successfully',
            'alert-type' => 'success'  
           );

           return back()->with($notification);
    

    }
    public function UserViewCar(){
        $cars = Car::all();
        return view('user.user_viewcar',compact('cars'));
   
    }

    public function UserEditCar($id){

        $data = Car::find($id);

        
        return view('user.user_editcar',compact('data'));


     }//end method
     
     public function UserViewHotel(){
        $hotels = Hotel::all();
        return view('user.user_viewhotel',compact('hotels'));
    
    }
    
    public function UserEditHotel($id){
    
        $data = Hotel::find($id);
    
        
        return view('user.user_edithotel',compact('data'));
    
    
     }//end method
     public function UserStoreFlight(Request $request)
{
    $flightNumber = $request->input('flight_number');
    $airline = $request->input('airline');
    $departure = $request->input('departure');
    $arrival = $request->input('arrival');
    $price = $request->input('price');
    
    $user_id = Auth::id();

    // Create a new order instance
    $order = new Order();
    $order->flight_number = $flightNumber;
    $order->airline = $airline;
    $order->departure = $departure;
    $order->arrival = $arrival;
    $order->price = $price;

    $order->user_id = $user_id;

    // Save the order to the database
    $order->save();

    // Redirect or return a response as needed
    return redirect()->route('user.user_receipt')->with('success', 'Order placed successfully.');
}
     public function UserStoreOrder(Request $request)
     {
        $validatedData = $request->validate([
            'order_type' => 'required|in:car,hotel',
            'brand' => 'required_if:order_type,car',
            'price' => 'required_if:order_type,car',
            'body' => 'required_if:order_type,car',
            'year' => 'required_if:order_type,car',
            'model' => 'required_if:order_type,car',
            'num_of_days' => 'required_if:order_type,car|integer|min:1',
            'pickup_date' => 'required_if:order_type,car|date',
            'hotel_name' => 'required_if:order_type,hotel',
            'location' => 'required_if:order_type,hotel',
            'country' => 'required_if:order_type,hotel',
            'region' => 'required_if:order_type,hotel',
            'company' => 'required_if:order_type,hotel',
            'days_of_stay' => 'required_if:order_type,hotel|integer|min:1',
            'arrival_date' => 'required_if:order_type,hotel|date',
        ]);
     
         // Get the currently authenticated user
         $user = Auth::user();
     
         // Check the order type
         if ($validatedData['order_type'] === 'car') {
             // Car Rental Order
             $order = $this->processCarOrder($validatedData, $user);
         } elseif ($validatedData['order_type'] === 'hotel') {
             // Hotel Order
             $order = $this->processHotelOrder($validatedData, $user);
         } else {
             // Invalid order type
             return redirect()->route('user.user_receipt')->with('error', 'Invalid order type.');
         }
     
         // Save the order to the database
         $order->save();
     
         // Redirect or perform any other necessary actions
         return redirect()->route('user.user_receipt')->with('success', 'Order placed successfully.');
     }
     
     private function processCarOrder(array $validatedData, User $user): Order
     {
         // Create a new car rental order instance
         $order = new Order();
         $order->brand = $validatedData['brand'];
         $order->price = $validatedData['price'];
         $order->body = $validatedData['body'];
         $order->year = $validatedData['year'];
         $order->model = $validatedData['model'];
         $order->num_of_days = $validatedData['num_of_days'];
         $order->pickup_date = $validatedData['pickup_date'];
         $order->order_type = $validatedData['order_type'];
     
         // Associate the user with the order
         $order->user()->associate($user);
     
         return $order;
     }
     
     private function processHotelOrder(array $validatedData, User $user): Order
     {
         // Create a new hotel order instance
         $order = new Order();
         $order->hotel_name = $validatedData['hotel_name'];
         $order->price = $validatedData['price'];
         $order->location = $validatedData['location'];
         $order->country = $validatedData['country'];
         $order->region = $validatedData['region'];
         $order->company = $validatedData['company'];
         $order->days_of_stay = $validatedData['days_of_stay'];
         $order->arrival_date = $validatedData['arrival_date'];
         $order->order_type = $validatedData['order_type'];
     
     
         // Associate the user with the order
         $order->user()->associate($user);
     
         return $order;
     }
    



     public function UserReceipt(){
        $users = User::all();
        $orders = Order::all();
        return view('user.user_receipt')
        ->with('users', $users)
        ->with('orders', $orders)
        ->with('order', $order);

    }//end method
    public function UserViewReceipt()
    {
        $user = Auth::user(); // Retrieve the currently logged-in user
        
        $orders = $user->orders;

        
        return view('user.user_receipt', compact('user', 'orders'));
    }
    
    public function destroy($order_id)
    {
    Order::destroy($order_id);

    $notification = [
        'message' => 'Removed Order Successfully',
        'alert-type' => 'info'
    ];

    return redirect()->back()->with($notification);
    }
    public function UserPaid()
{
    $users = User::all();
    $ordersPaid = OrderPaid::all();
        
        return view('user.user_paid')
        ->with('users', $users)
        ->with('ordersPaid', $ordersPaid);

    }//end method
    public function searchFlights(Request $request)
    {
        $accessKey = '1c69867d3f54c5cf05a2f79404d5ecea';
        $departure = $request->input('departure');
        $arrival = $request->input('arrival');

        $client = new Client();
        $response = $client->request('GET', 'http://api.aviationstack.com/v1/flights', [
            'query' => [
                'access_key' => $accessKey,
                'dep_iata' => $departure,
                'arr_iata' => $arrival,
            ],
        ]);

        $flightData = json_decode($response->getBody(), true);

        // Process the flight data and return the view with flight data
        return view('user.user_flight-search')->with('flightData', $flightData['data']);
    }
    public function showFlightSearchForm()
{
    return view('user.user_flight-search');
}


}

    

    






