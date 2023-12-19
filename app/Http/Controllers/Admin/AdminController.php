<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{

    public function dashboard(){
        return view('admin.dashboard');
    }


    public function updateVendorDetails (){
        return 'hola';
    }

    public function updateAdminDetails (Request $request){
        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first();
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $rules = [
                'admin_name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
                'admin_mobile' => ['required', 'numeric', 'digits:9'],
                'admin_image' => ['image'],
            ];
            $customMessages = [
                'admin_name.required' => 'Name is required',
                'admin_name.regex' => 'Valid Name is required',
                'admin_mobile.required' => 'Mobile is required',
                'admin_mobile.numeric' => 'Valid Mobile is required',
                'admin_mobile.digits' => 'Maximum 9 digits are allowed',
                'admin_image.image' => 'Valid Image is required',
            ];

            $this->validate($request, $rules, $customMessages);

            //Upload Image
            if($request->hasFile('admin_image')){
                $image_tmp = $request->file('admin_image');

                if($image_tmp->isValid()){

                    //Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image Name
                    $imageName = rand(111,99999).'.'.$extension;
                    $imagePath = 'admin/images/photos/';
                  //Upload the Image
                    if((!empty( $adminDetails->image )) && file_exists(public_path('admin/images/photos/'.$adminDetails->image)))
                    {

                       $oldimagepath = public_path('admin/images/photos/'.$adminDetails->image);

                       unlink($oldimagepath);
                    }

                    $image_tmp->move(public_path($imagePath), $imageName);

                    //Update Admin Details with image

                }
            }else if(!empty($data['current_admin_image'])){
                $imageName = $data['current_admin_image'];
            }else{
                $imageName = "";

            }

            //Update Admin Details witaout image
            Admin::where('email',Auth::guard('admin')->user()->email)->update(['name'=>$data['admin_name'],'mobile'=>$data['admin_mobile'], 'image'=>$imageName]);
            return redirect()->back()->with('success_message','Admin Details Updated Successfully');
        }

        return view('admin.settings.update_admin_details',compact('adminDetails'));
    }

    public function updateAdminPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            //Check if current password is correct
            if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
                //Check if new and confirm password is matching
                if ($data['confirm_password'] == $data['new_password']) {
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_password'])]);
                    return redirect()->back()->with('success_message', 'Password has been updated successfully');
                } else {
                    return redirect()->back()->with('error_message', 'New Password and Confirm Password is not matching');
                }
            } else {
                return redirect()->back()->with('error_message', 'Your current password is incorrect');
            }
        }
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();

        return view('admin.settings.update_admin_password', compact('adminDetails'));
    }

    public function checkAdminPassword (Request $request){
        $data = $request->all();
       // echo "<pre>"; print_r($data); die;
        $adminDetails =Admin::where('email',Auth::guard('admin')->user()->email)->first();
        $current_password = $data['current_password'];
        if(Hash::check($current_password,$adminDetails->password)){
            return "true";
        }else{
            return "false";
        }


    }

    public function login (Request $request){

        if($request->isMethod('post')){

            $data = $request->all();
             //echo "<pre>"; print_r($data); die;

             $rules = [
                'email' => ['required', 'email', 'max:255'],
                'password' => ['required'],
            ];
            $customMessages = [
                'email.required' => 'Email is required',
                'email.email' => 'Valid Email is required',
                'password.required' => 'Password is required',
            ];

            $this->validate($request, $rules, $customMessages);

            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password'],'status'=>1])){
                return redirect('admin/dashboard');
            }else{
                return redirect()->back()->with('error_message','Invalid Username or Password');
            }
        }
        return view('admin.login');
    }

    public function logout (Request $request){

        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('admin.login'));
    }
}
