<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
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
        'message' => 'Admin Profile Updated Successfully',
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


