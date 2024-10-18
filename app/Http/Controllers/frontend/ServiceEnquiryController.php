<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\frontend\ServiceEnquiry;
use Illuminate\Support\Facades\Session;
use Mail;

class ServiceEnquiryController extends Controller
{
    public function service_enquiry_save(Request $req){
        
        $req->validate([
            'name' => 'required',
          'address' => 'required',
            'mobile' => 'required',
            'type_of_service' => 'required',
            'message' => 'required'
        ]);

        $enquiry = new ServiceEnquiry();
        
        $enquiry->name = $req->name;
        $enquiry->address = $req->address;
        $enquiry->mobile = $req->mobile;
        $enquiry->message = $req->message;
         $enquiry->type_of_service = $req->type_of_service;
        $enquiry->save();
        
         $data = [
            'name' => $req->name,
            'address' => $req->address,
            'mobile' => $req->mobile,
            'msg' => $req->message,
            'type_of_service' => $req->type_of_service,
        ];
        
         $data["email"] = "userfortesting456@gmail.com";
        // $data["title"] = "IIV India Registered Valuers Foundation | Payment Success | Thank you";
        $data["title"] =  "Enquiry from ".$req->name;

        Mail::send('frontend.mail.adminserviceenquiry', $data, function($message)use($data){
            $message->to($data["email"], $data["email"])
                    ->subject($data["title"]);
        });
         
         Session::flash('success', 'Enquiry Sent Successfully');
       return redirect()->back();
    }
    
}
