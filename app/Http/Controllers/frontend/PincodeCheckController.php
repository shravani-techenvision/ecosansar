<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Pincode;
use App\Models\frontend\PincodeCheckSave;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;

class PincodeCheckController extends Controller
{
   public function checkPincode(Request $request)
    {
        // Validate the pincode
        $request->validate([
            'pincode' => 'required|digits:6', // Adjust this rule according to your requirements
        ]);

        $pincode = $request->input('pincode');

        // Check if the pincode exists in the database
        $exists = Pincode::where('pincode', $pincode)->exists();

        if ($exists) {
            // If it exists, return a message
            return response()->json(['success' => true, 'message' => 'Yay! We’re Available in Your Area! ']);
        } else {
            // If it does not exist, redirect to a new page
            return redirect('/service-not-available'); // Adjust this to your actual route
        }
    }
    public function servicenotavailable(){
        return view('frontend/servicenotavail');
    }
     public function checkPincodeSave(Request $req){
        $req->validate([
            'name' => 'required',
            'phone_no' => 'required',
            'pincode' => 'required',
            'address' => 'required',
        ]);
        $pincode = new PincodeCheckSave();
        $pincode->name = $req->name;
        $pincode->email = $req->email;
        $pincode->phone_no = $req->phone_no;
        $pincode->pincode = $req->pincode;
         $pincode->address = $req->address;
          $pincode->message = $req->message;
        $pincode->save();
        Session::flash('success', 'Enquiry Sent Successfully');
       return redirect()->back();
    }
}
