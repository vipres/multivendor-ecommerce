<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
   public function dashboard(){
        return view('admin.dashboard');
    }

    public function updateAdminPassword (){
        //echo "<pre>"; print_r(Auth::guard('admin')->user()->email); die;
            $adminDetails =Admin::where('email',Auth::guard('admin')->user()->email)->first();

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
