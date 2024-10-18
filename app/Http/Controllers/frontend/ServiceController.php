<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\frontend\ServiceEnquiry;

class ServiceController extends Controller
{
    public function service_enquiry_save(Request $req){
        
        // $req->validate([
        //     'name' => 'required',
        //   // 'email' => 'required',
        //     'mobile' => 'required',
        //     'message' => 'required'
        // ]);
        
        $details = Service::where('id',$req->id)->first();

        $enquiry = new ServiceEnquiry();
        
        $enquiry->name = $req->name;
        $enquiry->address = $req->address;
        $enquiry->mobile = $req->mobile;
        $enquiry->message = $req->message;
         $enquiry->type_of_service = $req->type_of_service;
        $enquiry->save();
         
         Session::flash('success', 'Enquiry Sent Successfully');
       return redirect()->back();
    }
    
}
