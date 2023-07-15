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

class UserController extends Controller
{
    public function UserDashboard(){
        return view('user.index');

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

public function UserStoreOrder(Request $request)
{
    $validatedData = $request->validate([
        'brand' => 'required',
        'price' => 'required',
        'body' => 'required',
        'year' => 'required',
        'model' => 'required',
        'num_of_days' => 'required|integer|min:1',
        'pickup_date' => 'required|date',
    ]);

    // Create a new order instance
    $order = new Order();
    $order->brand = $validatedData['brand'];
    $order->price = $validatedData['price'];
    $order->body = $validatedData['body'];
    $order->year = $validatedData['year'];
    $order->model = $validatedData['model'];
    $order->num_of_days = $validatedData['num_of_days'];
    $order->pickup_date = $validatedData['pickup_date'];
    

    // Get the currently authenticated user
    $user = Auth::user();

    // Associate the user with the order
    $order->user()->associate($user);

    // Save the order to the database
    $order->save();

    // Redirect or perform any other necessary actions
    return redirect()->route('user.user_receipt')->with('success', 'Order placed successfully.');
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


}

    

    






