<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\frontend\SABEnquiry;
use App\Models\frontend\SABPost;
use App\Models\frontend\BusinessPost;
use App\Models\frontend\SABReview;
use App\Models\frontend\BusinessReview;
use App\Models\frontend\BusinessEnquiry;
use App\Models\frontend\ConsumerEnquiry;
use App\Models\frontend\ConsumerPost;
use App\Models\frontend\EcosansarUsers;
use App\Models\frontend\ConsumerReview;
use App\Models\frontend\UserActivityLog;
use RealRashid\SweetAlert\Facades\Alert;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class EnquiryController extends Controller
{

    public function consumer_save(Request $req){
        
        $req->validate([
            'name' => 'required',
           // 'email' => 'required',
            'mobile' => 'required',
            'message' => 'required'
        ]);
        
        $details = ConsumerPost::where('id',$req->id)->first();

        $enquiry = new ConsumerEnquiry();
        $enquiry->user_id = $details->user_id;
        $enquiry->post_id = $req->id;
        $enquiry->name = $req->name;
        $enquiry->email = $req->email;
        $enquiry->mobile = $req->mobile;
        $enquiry->message = $req->message;
        $enquiry->save();

        
        
         $users = EcosansarUsers::where('id',$details->user_id)->first();
        
        // echo "<pre>";
        // print_r($post);die;
        
        if($req->email){
            
             $data = [
            'post_name' => $details->name,
            'name' =>  $req->name,
            'email' => $req->email,
            'mobile' => $details->mobile,
            'post_email' =>$details->email,
            ];
            
             $data["email"] = $req->email;
            // $data["title"] = "IIV India Registered Valuers Foundation | Payment Success | Thank you";
            $data["title"] =  "Connection Details for Your Interest";
            // Mail::to(Auth::user()->email)->send(new Payment_done_mail($data));
            Mail::send('frontend.mail.userthankuemail', $data, function($message)use($data){
                $message->to($data["email"], $data["email"])
                        ->subject($data["title"]);
            });
        }
        
        $data = [
            'name' => $req->name,
            'post_email' => $req->email,
            'mobile' => $req->mobile,
            //'post_email' => $req->email,
            'msg' => $req->message,
        ];
        
            // print_r($data);die;
        $data["email"] = $details->email;
        // $data["title"] = "IIV India Registered Valuers Foundation | Payment Success | Thank you";
        $data["title"] =  "Enquiry from ".$req->name;
        // Mail::to(Auth::user()->email)->send(new Payment_done_mail($data));
        Mail::send('frontend.mail.consumermail', $data, function($message)use($data){
            $message->to($data["email"], $data["email"])
                    ->subject($data["title"]);
        });
        
        $data["email"] = "userfortesting456@gmail.com";
        // $data["title"] = "IIV India Registered Valuers Foundation | Payment Success | Thank you";
        $data["title"] =  "Enquiry from ".$req->name. " for ".$details->name;
        // Mail::to(Auth::user()->email)->send(new Payment_done_mail($data));

        Mail::send('frontend.mail.adminconsumermail', $data, function($message)use($data){
            $message->to($data["email"], $data["email"])
                    ->subject($data["title"]);
        });
        
          $contact = $req->mobile;
    // // Check if the user exists in the ecosansar_users table
    //     $user = DB::table('ecosansar_users')
    //     ->where('mobile', $contact)->first();
    //     // Generate a 6-digit random OTP
    //     $otp = mt_rand(100000, 999999);
    
        $templateId = '6697c3ecd6fc051035577b52'; // Ensure this is a valid string from MSG91
        $apiKey = config('services.msg91.authkey'); // Fetch authkey from config
        
        // Prepare the data for the cURL request
        $data = json_encode([
            'template_id' => $templateId,
            'short_url' => '0',
            'realTimeResponse' => '1',
            'recipients' => [
                [
                    'mobiles' => '91' . $contact,
                    'var1' => $details->name,
                    'var2' => $details->mobile,
                ]
            ]
        ]);
    
        // Initialize cURL
        $curl = curl_init();
    
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://control.msg91.com/api/v5/flow",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authkey: $apiKey",
                "content-type: application/json"
            ],
        ]);
    
        // Execute the cURL request and handle the response
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
    
        // if ($err){
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => "cURL Error #: $err",
        //     ], 500);
        // }else{
        //     return response()->json([
        //         'status' => 'success',
        //         'message' => $response,
        //     ]);
        // }
        
        //   // user activity start
        // $userid = session()->get('user_id');
        // if ($userid){
        //     $userActivity = new UserActivityLog();
        //     $userActivity->user_id = $userid;
        //     $userActivity->activity = 'Corporate post add';
        //     $userActivity->url = request()->fullUrl();   // Get the full URL of the request
        //     $userActivity->ip_address = request()->ip();
        //     $userActivity->save();
        // }
        // // user activity end
        
        // Alert::success('success','Enquiry Added Successfully');
        // return redirect()->back();
         Session::flash('success', 'Enquiry Sent Successfully');
       return redirect()->back();
    }
    
     public function Consumerconnectreportlist(){
      
        
        // $result111 = ConsumerEnquiry::join('ecosansar_users','ecosansar_users.id','consumer_enquiries.user_id')
        //  ->join('consumer_enquiries', 'consumer_enquiries.post_id', 'consumer_posts.id')
        // // ->join('resources', 'resources.id', 'business_resource_posts.resource_type')
        // ->select('consumer_enquiries.*','ecosansar_users.name as username','consumer_posts.name as postname')
        // ->get();
        
        $result = ConsumerEnquiry::join('ecosansar_users', 'ecosansar_users.id', 'consumer_enquiries.user_id')
        ->join('consumer_posts', 'consumer_enquiries.post_id', 'consumer_posts.id')
        // ->join('resources', 'resources.id', 'business_resource_posts.resource_type')
        ->select('consumer_enquiries.*', 'ecosansar_users.name as username', 'consumer_posts.name as postname')
        ->get();

        
      $data=compact('result');
    
    return view('admin/usertype/Consumerconnectreportlist')->with($data);
  }
  
  public function shortConsumerconnectReportList(Request $request) {
    // Ensure that startdate and enddate are provided, otherwise use default values
    $request->validate([
        'start_date' => 'required',
        'end_date' => 'required',
       ]);
    
    $startDate = $request->start_date;
   $endDate = $request->end_date;
    
        
         $result = ConsumerEnquiry::join('ecosansar_users', 'ecosansar_users.id', 'consumer_enquiries.user_id')
        ->join('consumer_posts', 'consumer_enquiries.post_id', 'consumer_posts.id')
        // ->join('resources', 'resources.id', 'business_resource_posts.resource_type')
        ->select('consumer_enquiries.*', 'ecosansar_users.name as username', 'consumer_posts.name as postname')
        ->whereBetween('consumer_enquiries.created_at', [$startDate, $endDate])
        ->get();
        
        
        // echo"<pre>";
        // print_r($result);
        // die;

    // Pass the result to the view
    $data = compact('result');
    
    return view('admin.usertype.Consumerconnectreportlist')->with($data);
}
  
   public function sabconnectreportlist(){
        
        $result = SABEnquiry::join('ecosansar_users', 'ecosansar_users.id', 's_a_b_enquiries.user_id')
        ->join('s_a_b_posts', 's_a_b_enquiries.post_id', 's_a_b_posts.id')
        // ->join('resources', 'resources.id', 'business_resource_posts.resource_type')
        ->select('s_a_b_enquiries.*', 'ecosansar_users.name as username', 's_a_b_posts.name as postname')
        ->get();

      $data=compact('result');
    
    return view('admin/usertype/sabconnectreportlist')->with($data);
  }
  
  public function shortsabconnectReportList(Request $request) {
      
       $request->validate([
        'start_date' => 'required',
        'end_date' => 'required',
       ]);
    
      $startDate = $request->start_date;
      $endDate = $request->end_date;
    
         $result = SABEnquiry::join('ecosansar_users', 'ecosansar_users.id', 's_a_b_enquiries.user_id')
        ->join('s_a_b_posts', 's_a_b_enquiries.post_id', 's_a_b_posts.id')
        // ->join('resources', 'resources.id', 'business_resource_posts.resource_type')
        ->select('s_a_b_enquiries.*', 'ecosansar_users.name as username', 's_a_b_posts.name as postname')
        ->whereBetween('s_a_b_enquiries.created_at', [$startDate, $endDate])
        ->get();

    // Pass the result to the view
    $data = compact('result');
    
    return view('admin.usertype.sabconnectreportlist')->with($data);
}
  
   public function Businessconnectreportlist(){
        
        $result = BusinessEnquiry::join('ecosansar_users', 'ecosansar_users.id', 'business_enquiries.user_id')
        ->join('business_posts', 'business_enquiries.post_id', 'business_posts.id')
        // ->join('resources', 'resources.id', 'business_resource_posts.resource_type'),'business_posts.name as postname'
        ->select('business_enquiries.*', 'ecosansar_users.name as username')
        ->get();
        
        //  echo"<pre>";
        // print_r($result);
        //  die;

      $data=compact('result');
    
    return view('admin/usertype/Businessconnectreportlist')->with($data);
  }
  
   public function shortBusinessconnectReportList(Request $request) {
       
        $request->validate([
        'start_date' => 'required',
        'end_date' => 'required',
       ]);
    
      $startDate = $request->start_date;
      $endDate = $request->end_date;
    
         $result = BusinessEnquiry::join('ecosansar_users', 'ecosansar_users.id', 'business_enquiries.user_id')
        ->join('business_posts', 'business_enquiries.post_id', 'business_posts.id')
        // ->join('resources', 'resources.id', 'business_resource_posts.resource_type'),'business_posts.name as postname'
        ->select('business_enquiries.*', 'ecosansar_users.name as username')
        ->whereBetween('business_enquiries.created_at', [$startDate, $endDate])
        ->get();

    // Pass the result to the view
    $data = compact('result');
    
    return view('admin.usertype.Businessconnectreportlist')->with($data);
}
  
  
    
    public function sab_save(Request $req){
        $req->validate([
            'name' => 'required',
            //'email' => 'required',
            'mobile' => 'required',
            'message' => 'required'
        ]);
 
        // echo "<pre>";
        // print_r($req->all());die;
        
        $details = SABPost::where('id',$req->id)->first();

        $enquiry = new SABEnquiry();
        $enquiry->user_id = $details->user_id;
        $enquiry->post_id = $req->id;
        $enquiry->login_id = $req->loginid;
        $enquiry->name = $req->name;
        $enquiry->email = $req->email;
        $enquiry->mobile = $req->mobile;
        $enquiry->message = $req->message;
        $enquiry->type = 'firsttime';
       // $enquiry->save();

        $post = SABPost::where('id',$req->id)->first();
        // echo "<pre>";
        // print_r($post);die;
        
        
          $contact = $req->mobile;
    // // Check if the user exists in the ecosansar_users table
    //     $user = DB::table('ecosansar_users')
    //     ->where('mobile', $contact)->first();
    //     // Generate a 6-digit random OTP
    //     $otp = mt_rand(100000, 999999);
    
        $templateId = '6697c3ecd6fc051035577b52'; // Ensure this is a valid string from MSG91
        $apiKey = config('services.msg91.authkey'); // Fetch authkey from config
        
        // Prepare the data for the cURL request
        $data = json_encode([
            'template_id' => $templateId,
            'short_url' => '0',
            'realTimeResponse' => '1',
            'recipients' => [
                [
                    'mobiles' => '91' . $contact,
                    'var1' => $details->name,
                    'var2' => $details->mobile,
                ]
            ]
        ]);
    
        // Initialize cURL
        $curl = curl_init();
    
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://control.msg91.com/api/v5/flow",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authkey: $apiKey",
                "content-type: application/json"
            ],
        ]);
    
        // Execute the cURL request and handle the response
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
    
        // if ($err){
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => "cURL Error #: $err",
        //     ], 500);
        // }else{
        //     return response()->json([
        //         'status' => 'success',
        //         'message' => $response,
        //     ]);
        // }
        
        // Alert::success('success','Enquiry Added Successfully');
        // return redirect()->back();
         Session::flash('success', 'Enquiry Sent Successfully');
       return redirect()->back();
    }
    
    public function business_save(Request $req){
        
        //  echo "<pre>";
        //   print_r($req->all());die;
        
        $req->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'message' => 'required'
        ]);
       //echo $req->email;die;
        $details = BusinessPost::where('id',$req->id)->first();
        $enquiry = new BusinessEnquiry();
        $enquiry->user_id = $details->user_id;
        $enquiry->post_id = $req->id;
        $enquiry->name = $req->name;
        $enquiry->email = $req->email;
        $enquiry->mobile = $req->mobile;
        $enquiry->message = $req->message;
        $enquiry->save();

        // echo "<pre>";
        // print_r($post);die;
        
        $users = EcosansarUsers::where('id',$details->user_id)->first();

        if($req->email){
            
             $data = [
            'post_name' => $users->name,
            'name' => $req->name,
            'email' => $req->email,
            'mobile' => $users->mobile,
            'post_email' =>$details->email,
            ];
            
             $data["email"] = $req->email;
            // $data["title"] = "IIV India Registered Valuers Foundation | Payment Success | Thank you";
            $data["title"] =  "Connection Details for Your Interest";  
            // Mail::to(Auth::user()->email)->send(new Payment_done_mail($data));
            Mail::send('frontend.mail.userthankuemail', $data, function($message)use($data){
                $message->to($data["email"], $data["email"])
                        ->subject($data["title"]);
            });
        }
        
        $data = [
            'name' => $req->name,
            'post_email' => $req->email,
            'mobile' => $req->mobile,
            'msg' => $req->message,
        ];
        
            // print_r($data);die;
        $data["email"] = $details->email;
        // $data["title"] = "IIV India Registered Valuers Foundation | Payment Success | Thank you";
        $data["title"] =  "Enquiry from ".$req->name;
        // Mail::to(Auth::user()->email)->send(new Payment_done_mail($data));
        Mail::send('frontend.mail.businessmail', $data, function($message)use($data){
            $message->to($data["email"], $data["email"])
                    ->subject($data["title"]);
        });
        
        
        
        $data["email"] = "userfortesting456@gmail.com";
        // $data["title"] = "IIV India Registered Valuers Foundation | Payment Success | Thank you";
        $data["title"] =  "Enquiry from ".$req->name. " for ".$details->name;
        // Mail::to(Auth::user()->email)->send(new Payment_done_mail($data));
        Mail::send('frontend.mail.adminconsumermail', $data, function($message)use($data){
            $message->to($data["email"], $data["email"])
                    ->subject($data["title"]);
        });
        
        
           $contact = $req->mobile;
    // // Check if the user exists in the ecosansar_users table
    //     $user = DB::table('ecosansar_users')
    //     ->where('mobile', $contact)->first();
    //     // Generate a 6-digit random OTP
    //     $otp = mt_rand(100000, 999999);
    
        $templateId = '6697c3ecd6fc051035577b52'; // Ensure this is a valid string from MSG91
        $apiKey = config('services.msg91.authkey'); // Fetch authkey from config
        
        // Prepare the data for the cURL request
        $data = json_encode([
            'template_id' => $templateId,
            'short_url' => '0',
            'realTimeResponse' => '1',
            'recipients' => [
                [
                    'mobiles' => '91' . $contact,
                    'var1' => $users->name,
                    'var2' => $users->mobile,
                ]
            ]
        ]);
    
        // Initialize cURL
        $curl = curl_init();
    
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://control.msg91.com/api/v5/flow",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authkey: $apiKey",
                "content-type: application/json"
            ],
        ]);
    
        // Execute the cURL request and handle the response
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
    
        // if ($err){
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => "cURL Error #: $err",
        //     ], 500);
        // }else{
        //     return response()->json([
        //         'status' => 'success',
        //         'message' => $response,
        //     ]);
        // }
        
        
         Session::flash('success', 'Enquiry Sent Successfully');
       return redirect()->back();
        // Alert::success('success','Enquiry Added Successfully');
        // return redirect()->back();
    }
    
    public function sabreviewsave(Request $req){
        $req->validate([
            'title' => 'required',
            'message' => 'required',
            'rating' => 'required',
        ]);
        $details = SABPost::where('id',$req->post_id)->first();
        $enquiry = new SABReview();

        $enquiry->user_id = $details->user_id;
        $enquiry->post_id = $req->post_id;
        $enquiry->title = $req->title;
        $enquiry->message = $req->message;
        $enquiry->rating = $req->rating;

        $enquiry->save();
        Alert::success('success','Review Added Successfully');
        return redirect()->back();
    }
    
    public function consumerreviewsave(Request $req){
        $req->validate([
            'title' => 'required',
            'message' => 'required',
            'rating' => 'required',
        ]);
        $details = ConsumerPost::where('id',$req->post_id)->first();
        $enquiry = new ConsumerReview();

        $enquiry->user_id = $details->user_id;
        $enquiry->post_id = $req->post_id;
        $enquiry->title = $req->title;
        $enquiry->message = $req->message;
        $enquiry->rating = $req->rating;
        $enquiry->save();
        Alert::success('success','Review Added Successfully');
        return redirect()->back();
    }
    
    public function businessreviewsave(Request $req){
        $req->validate([
            'title' => 'required',
            'message' => 'required',
            'rating' => 'required',
        ]);
        $details = BusinessPost::where('id',$req->post_id)->first();
        $enquiry = new BusinessReview();

        $enquiry->user_id = $details->user_id;
        $enquiry->post_id = $req->post_id;
        $enquiry->title = $req->title;
        $enquiry->message = $req->message;
        $enquiry->rating = $req->rating;

        $enquiry->save();
        Alert::success('success','Review Added Successfully');
        return redirect()->back();
    }

}
