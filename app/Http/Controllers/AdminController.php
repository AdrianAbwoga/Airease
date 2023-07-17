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

class AdminController extends Controller
{
    public function AdminDashboard(){
        return view('admin.index');

    }//end method

    

    public function AdminLogout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }//end method

    public function AdminLogin(){

        return view('admin.admin_login');

    }//End Method

    public function AdminProfile(){

       $id = Auth::user()->id;
       $profileData = User::find($id);
       return view('admin.admin_profile_view',compact('profileData'));
    }//end method

    public function AdminProfileStore(Request $request){
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
        'message' => 'Admin Profile Updated Successfully',
        'alert-type' => 'success'  
       );
       return redirect()->back()->with($notification);

    }//end method
    
    public function AdminViewUser(){
        $users = User::all();
        return view('admin.admin_viewuser',compact('users'));


    }//end method
    public function AdminViewCar(){
        $cars = Car::all();
        return view('admin.admin_viewcar',compact('cars'));


    }//end method
    public function AdminViewHotel(){
        $hotels = Hotel::all();
        return view('admin.admin_viewhotel',compact('hotels'));


    }//end method
    public function AdminEditHotel($id){

        $data = Hotel::find($id);

        
        return view('admin.admin_edithotel',compact('data'));


     }//end method
     public function AdminHotelStore(Request $request, $id){
       
        $data = Hotel::find($id);
        $data->hotel_name = $request->hotel_name;
        $data->price = $request->price;
        $data->location = $request->location;
        $data->country = $request->country;
        $data->company = $request->company;
        $data->region = $request->region;
        $data->save();
        $notification = array(
         'message' => 'Hotel Information Updated Successfully',
         'alert-type' => 'success'  
        );
        
       
        return redirect()->back()->with($notification);
 
     }//end method

    public function AdminEditCar($id){

        $data = Car::find($id);

        
        return view('admin.admin_editcar',compact('data'));


     }//end method
     public function AdminCarStore(Request $request, $id){
       
        $data = Car::find($id);
        $data->brand = $request->brand;
        $data->price = $request->price;
        $data->body = $request->body;
        $data->year = $request->year;
        $data->model = $request->model;
        $data->save();
        $notification = array(
         'message' => 'Car Information Updated Successfully',
         'alert-type' => 'success'  
        );
        
       
        return redirect()->back()->with($notification);
 
     }//end method
     public function destroyCar($id)
    {
    Car::destroy($id);

    $notification = [
        'message' => 'Car Information Deleted Successfully',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);
    }

    public function destroyHotel($id)
    {
    Hotel::destroy($id);

    $notification = [
        'message' => 'Hotel Information Deleted Successfully',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);
    }

    public function AdminViewFlight(){
        $flights = Flight::all();
        return view('admin.admin_viewflight',compact('flights'));


    }//end method

    public function AdminViewOrder(){
        $ordersPaid = OrderPaid::all();
        return view('admin.admin_vieworders',compact('ordersPaid'));


    }//end method
 
 

    public function AdminChangePassword(){
        $id = Auth::user()->id;
       $profileData = User::find($id);

        return view('admin.admin_change_password',compact('profileData'));

    }
    
    public function AdminUpdatePassword(Request $request){

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
    public function AdminEditUser($id){

        $data = User::find($id);

        
        return view('admin.admin_edituser',compact('data'));


     }//end method
    public function AdminUserStore(Request $request, $id){
       
       $data = User::find($id);
       $data->username = $request->username;
       $data->name = $request->name;
       $data->email = $request->email;
       $data->phone = $request->phone;
       $data->address = $request->address;
       $data->save();
       $notification = array(
        'message' => 'User Profile Updated Successfully',
        'alert-type' => 'success'  
       );
       
      
       return redirect()->back()->with($notification);

    }//end method
    public function destroy($id)
    {
    User::destroy($id);

    $notification = [
        'message' => 'User Deleted Successfully',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);
    }
    
    
}


