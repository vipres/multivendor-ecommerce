<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;
use App\Models\Admin;
use App\Models\VendorsBusinessDetail;
use App\Models\VendorsBankDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{

    public function dashboard(){

        return view('admin.dashboard');
    }

    public function updateVendorDetails (Request $request, $slug){

        $vendorDetails = Vendor::where('vendors.email', Auth::guard('admin')->user()->email)
        ->join('admins', 'admins.email', '=', 'vendors.email')
        ->select('vendors.*', 'admins.image')
        ->first();
        //dd($vendorDetails);

        if($slug=="personal"){
            if($request->isMethod('post')){
                $data = $request->all();
                //echo "<pre>"; print_r($data); die;

                $rules = [
                    'vendor_name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
                    'vendor_city' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
                    'vendor_mobile' => ['required', 'numeric', 'digits:9'],
                    'vendor_image' => ['image'],
                ];
                $customMessages = [
                    'vendor_name.required' => 'Name is required',
                    'vendor_name.regex' => 'Valid Name is required',
                    'vendor_city.required' => 'City is required',
                    'vendor_city.regex' => 'Valid City name is required',
                    'vendor_mobile.required' => 'Mobile is required',
                    'vendor_mobile.numeric' => 'Valid Mobile is required',
                    'vendor_mobile.digits' => 'Maximum 9 digits are allowed',
                    'vendor_image.image' => 'Valid Image is required',
                ];

                $this->validate($request, $rules, $customMessages);

                //Upload Image
                if($request->hasFile('vendor_image')){
                    $image_tmp = $request->file('vendor_image');

                    if($image_tmp->isValid()){

                        //Get Image Extension
                        $extension = $image_tmp->getClientOriginalExtension();
                        //Generate New Image Name
                        $imageName = rand(111,99999).'.'.$extension;
                        $imagePath = 'admin/images/photos/';
                      //Upload the Image
                        if((!empty( $vendorDetails->image )) && file_exists(public_path('admin/images/photos/'.$vendorDetails->image)))
                        {

                           $oldimagepath = public_path('admin/images/photos/'.$vendorDetails->image);

                           unlink($oldimagepath);
                        }

                        $image_tmp->move(public_path($imagePath), $imageName);

                        //Update Vendor Details with image

                    }
                }else if(!empty($data['current_vendor_image'])){
                    $imageName = $data['current_vendor_image'];
                }else{
                    $imageName = "";

                }

                //Update in Admin Table
                Admin::where('email',Auth::guard('admin')->user()->email)->update(['name'=>$data['vendor_name'],'mobile'=>$data['vendor_mobile'], 'image'=>$imageName]);
                //Update in Vendor Table
                Vendor::where('email',Auth::guard('admin')->user()->email)->update(
                    ['name'=>$data['vendor_name'],
                    'address'=>$data['vendor_address'],
                    'city'=>$data['vendor_city'],
                    'state'=>$data['vendor_state'],
                    'country'=>$data['vendor_country'],
                    'pincode'=>$data['vendor_pincode'],
                    'mobile'=>$data['vendor_mobile'],


                ]);



                return redirect()->back()->with('success_message','Vendor Details Updated Successfully');
            }

        }elseif($slug=="business"){
            $vendorDetails = VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->first();

            if($request->isMethod('post')){
                $data = $request->all();
                //echo "<pre>"; print_r($data); die;

                $rules = [
                    'shop_name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
                    'shop_city' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
                    'shop_mobile' => ['required', 'numeric', 'digits:9'],
                    'shop_image' => ['image'],
                    'shop_address' => ['required', 'max:255'],
                    'shop_state' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
                    'shop_country' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
                    'shop_pincode' => ['required', 'numeric'],
                    'address_proof' => ['required'],
                    'address_proof_image'=>['image'],
                    'business_license_number'=>['required'],
                    'gst_number' => ['required'],
                    'pan_number' => ['required'],

                ];
                $customMessages = [
                    'shop_name.required' => 'Name is required',
                    'shop_name.regex' => 'Valid Name is required',
                    'shop_city.required' => 'City is required',
                    'shop_city.regex' => 'Valid City name is required',
                    'shop_mobile.required' => 'Mobile is required',
                    'shop_mobile.numeric' => 'Valid Mobile is required',
                    'shop_mobile.digits' => 'Maximum 9 digits are allowed',
                    'shop_image.image' => 'Valid Image is required',
                    'shop_address.required' => 'Address is required',
                    'shop_address.max' => 'Valid Address is required',
                    'shop_state.required' => 'State is required',
                    'shop_state.regex' => 'Valid State name is required',
                    'shop_state.max' => 'Valid State name is required',
                    'shop_country.required' => 'Country is required',
                    'shop_country.regex' => 'Valid Country name is required',
                    'shop_country.max' => 'Valid Country name is required',
                    'shop_pincode.required' => 'Pincode is required',
                    'shop_pincode.numeric' => 'Valid Pincode is required',
                    'shop_pincode.digits' => 'Maximum 6 digits are allowed',
                    'address_proof.required' => 'Address Proof is required',
                    'address_proof_image.image' => 'Valid Address Proof is required',
                    'business_license_number.required' => 'Business License Number is required',
                    'gst_number.required' => 'GST Number is required',
                    'pan_number.required' => 'PAN Number is required',
                ];

                $this->validate($request, $rules, $customMessages);

                //Upload Image
                if($request->hasFile('address_proof_image')){
                    $image_tmp = $request->file('address_proof_image');

                    if($image_tmp->isValid()){

                        //Get Image Extension
                        $extension = $image_tmp->getClientOriginalExtension();
                        //Generate New Image Name
                        $imageName = rand(111,99999).'.'.$extension;
                        $imagePath = 'admin/images/proofs/';
                      //Upload the Image
                        if((!empty( $vendorDetails->address_proof_image )) && file_exists(public_path('admin/images/proofs/'.$vendorDetails->address_proof_image)))
                        {

                           $oldimagepath = public_path('admin/images/proofs/'.$vendorDetails->address_proof_image);

                           unlink($oldimagepath);
                        }

                        $image_tmp->move(public_path($imagePath), $imageName);

                        //Update Vendor Details with image

                    }
                }else if(!empty($data['current_address_proof_image'])){
                    $imageName = $data['current_address_proof_image'];
                }else{
                    $imageName = "";

                }


                //Update in Vendor Bussiness Details Table
                VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update(
                    [
                    'shop_name'=>$data['shop_name'],
                    'shop_address'=>$data['shop_address'],
                    'shop_city'=>$data['shop_city'],
                    'shop_state'=>$data['shop_state'],
                    'shop_country'=>$data['shop_country'],
                    'shop_pincode'=>$data['shop_pincode'],
                    'shop_mobile'=>$data['shop_mobile'],
                    'shop_website'=>$data['shop_website'],
                    'address_proof'=>$data['address_proof'],
                    'address_proof_image'=>$imageName,
                    'business_license_number'=>$data['business_license_number'],
                    'gst_number'=>$data['gst_number'],
                    'pan_number'=>$data['pan_number'],

                ]);



                return redirect()->back()->with('success_message','Vendor Businnes Details Updated Successfully');
            }

        }elseif($slug=="bank"){

            $vendorDetails = VendorsBankDetail::where('vendors_bank_details.vendor_id', Auth::guard('admin')->user()->vendor_id)
            ->join('admins', 'admins.vendor_id', '=', 'vendors_bank_details.vendor_id')
            ->select('vendors_bank_details.*', 'admins.email')
            ->first();
            //dd($vendorDetails);
            if($request->isMethod('post')){
                $data = $request->all();
                //echo "<pre>"; print_r($data); die;

                $rules = [
                    'account_holder_name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
                    'bank_name' => ['required', 'regex:/^[\pL\s\-]+$/u', 'max:255'],
                    'account_number' => ['required', 'numeric'],
                    'bank_ifsc_code' => ['required'],
                ];
                $customMessages = [
                    'account_holder_name.required' => 'Name is required',
                    'account_holder_name.regex' => 'Valid Name is required',
                    'bank_name.required' => 'City is required',
                    'bank_name.regex' => 'Valid City name is required',
                    'account_number.required' => 'Mobile is required',
                    'account_number.numeric' => 'Valid ccc is required',
                    'bank_ifsc_code.required' => 'Valid Ifsc code is required',
                ];

                $this->validate($request, $rules, $customMessages);

                //Update in Vendor Bank Details Table
                VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update(
                    [
                    'account_holder_name'=>$data['account_holder_name'],
                    'bank_name'=>$data['bank_name'],
                    'account_number'=>$data['account_number'],
                    'bank_ifsc_code'=>$data['bank_ifsc_code'],
                ]);

                return redirect()->back()->with('success_message','Vendor Bank Details Updated Successfully');


            }
        }
        return view('admin.settings.update_vendor_details')->with(compact('slug', 'vendorDetails'));

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

    public function admins ( $type=null){

        $admins = Admin::query();
        if(!empty($type)){
            $admins = $admins->where('type',$type);
            $title = ucfirst($type).'s';
        }else{
            $title = "All Admins/Sub Admins/Vendors";
        }
        $admins =$admins->get();
        //dd($admins);
        return view('admin.admins.admins')->with(compact('admins', 'title'));
    }

    public function viewVendorDetails ($id){
        $vendorDetails = Admin::with('vendorPersonal', 'vendorBussiness', 'vendorBank')->where('id', $id)->first();
        //$vendorDetails = json_decode(json_encode($vendorDetails), true);
        //dd($vendorDetails);
        return view('admin.admins.view_vendor_details', compact('vendorDetails'));
    }

    public function updateAdminStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>";print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Admin::where('id', $data['admin_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'admin_id' => $data['admin_id'] ]);
        };
    }

    public function logout (Request $request){

        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('admin.login'));
    }


}
