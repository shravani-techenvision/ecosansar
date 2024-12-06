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
use App\Models\frontend\ChangeReview;
use App\Models\frontend\ConsumerAskReview;
use App\Services\PHPMailerService;
use Illuminate\Support\Facades\View;

class EnquiryController extends Controller
{
    protected $mailerService;
	public function __construct(PHPMailerService $mailerService)
	{
    	$this->mailerService = $mailerService;
	}
    public function consumer_save(Request $req){

        $req->validate([
            'name' => 'required',
           // 'email' => 'required',
            'mobile' => 'required',
            'message' => 'required'
        ]);
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $details = ConsumerPost::where('id',$req->id)->first();

        $enquiry = new ConsumerEnquiry();
        $enquiry->user_id = $details->user_id;
        $enquiry->login_user_id = $user_id;
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
           // Render the email body using the Blade view
           $body = view('frontend.mail.userthankuemail', $data)->render();
           // Call your mailer service to send the email
           $this->mailerService->sendEmail($data['email'], $data['title'], $body, $data);
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
        $data["title"] =  "Enquiry from ".$req->name;
        // Render the email body using the Blade view
        $body = view('frontend.mail.consumermail', $data)->render();
        // Call your mailer service to send the email
        $this->mailerService->sendEmail($data['email'], $data['title'], $body, $data);

        $data["email"] = "ecosansar@yahoo.com";
        $data["title"] =  "Enquiry from ".$req->name. " for ".$details->name;


      // Render the email body using the Blade view
      $body = view('frontend.mail.adminconsumermail', $data)->render();
      // Call your mailer service to send the email
      $this->mailerService->sendEmail($data['email'], $data['title'], $body, $data);

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
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $details = SABPost::where('id',$req->id)->first();

        $enquiry = new SABEnquiry();
        $enquiry->user_id = $details->user_id;
        $enquiry->post_id = $req->id;
        $enquiry->login_id = $user_id;
        $enquiry->name = $req->name;
        $enquiry->email = $req->email;
        $enquiry->mobile = $req->mobile;
        $enquiry->message = $req->message;

       $enquiry->save();

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
       $user_id = session()->get('user_id');
       $user_type = session()->get('user_type');
        $details = BusinessPost::where('id',$req->id)->first();
        $enquiry = new BusinessEnquiry();
        $enquiry->user_id = $details->user_id;
        $enquiry->post_id = $req->id;
        $enquiry->login_user_id = $user_id;
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
            $data["title"] =  "Connection Details for Your Interest";
            // Render the email body using the Blade view
            $body = view('frontend.mail.userthankuemail', $data)->render();
            // Call your mailer service to send the email
            $this->mailerService->sendEmail($data['email'], $data['title'], $body, $data);
        }

        $data = [
            'name' => $req->name,
            'post_email' => $req->email,
            'mobile' => $req->mobile,
            'msg' => $req->message,
        ];

            // print_r($data);die;
        $data["email"] = $details->email;
        $data["title"] =  "Enquiry from ".$req->name;
         // Render the email body using the Blade view
         $body = view('frontend.mail.businessmail', $data)->render();
         // Call your mailer service to send the email
         $this->mailerService->sendEmail($data['email'], $data['title'], $body, $data);


        $data["email"] = "ecosansar@yahoo.com";
        // $data["title"] = "IIV India Registered Valuers Foundation | Payment Success | Thank you";
        $data["title"] =  "Enquiry from ".$req->name. " for ".$details->name;
       // Render the email body using the Blade view
       $body = view('frontend.mail.adminconsumermail', $data)->render();
       // Call your mailer service to send the email
       $this->mailerService->sendEmail($data['email'], $data['title'], $body, $data);


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
        $user_id = session()->get('user_id');
        $details = SABPost::where('id',$req->post_id)->first();
        $enquiry = new SABReview();
         // Check if a review already exists for this post by the same user
    $existingReview = SABReview::where('post_id', $req->post_id)
    ->where('login_user_id', $user_id)
    ->first();

if ($existingReview) {
    // If review exists, update it
    $existingReview->title = $req->title;
    $existingReview->message = $req->message;
    $existingReview->rating = $req->rating;
    $existingReview->save();
//  $notification = ConsumerAskReview::where('post_id',$details->id)->where('login_user_id',$details->user_id)->where('user_id',$user_id)->first();
     $notification = ConsumerAskReview::where('login_user_id',$details->user_id)->where('user_id',$user_id)->first();
    //  echo "<pre>";
    //  print_r($notification);die;

    $notification->change_review = 'changedreview';
    $notification->save();
    Session::flash('success', 'Review Updated Successfully');
} else {
    $enquiry->user_id = $details->user_id;
    $enquiry->post_id = $req->post_id;
    $enquiry->login_user_id = $user_id;
    $enquiry->title = $req->title;
    $enquiry->message = $req->message;
    $enquiry->rating = $req->rating;
     $enquiry->type = 'sab';
    $enquiry->save();

    //  $notification = ConsumerAskReview::where('post_id',$details->id)->where('login_user_id',$details->user_id)->where('user_id',$user_id)->first();
     $notification = ConsumerAskReview::where('login_user_id',$details->user_id)->where('user_id',$user_id)->first();
    //  echo "<pre>";
    //  print_r($notification);die;
    $notification->status = 'read';
    $notification->save();
    Session::flash('success', 'Review Sent Successfully');
}
 return redirect('/');
    }

    public function consumerreviewsave(Request $req){
        $req->validate([
            'title' => 'required',
            'message' => 'required',
            'rating' => 'required',
        ]);
        $details = ConsumerPost::where('id',$req->post_id)->first();
        $enquiry = new ConsumerReview();
        $user_id = session()->get('user_id');

       // Check if a review already exists for this post by the same user
   $existingReview = ConsumerReview::where('post_id', $req->post_id)
       ->where('login_user_id', $user_id)
       ->first();

   if ($existingReview) {
       // If review exists, update it
       $existingReview->title = $req->title;
       $existingReview->message = $req->message;
       $existingReview->rating = $req->rating;
       $existingReview->save();
//  $notification = ConsumerAskReview::where('post_id',$details->id)->where('login_user_id',$details->user_id)->where('user_id',$user_id)->first();
        $notification = ConsumerAskReview::where('login_user_id',$details->user_id)->where('user_id',$user_id)->first();
       //  echo "<pre>";
       //  print_r($notification);die;

       $notification->change_review = 'changedreview';
       $notification->save();
       Session::flash('success', 'Review Updated Successfully');
   } else {
       $enquiry->user_id = $details->user_id;
       $enquiry->post_id = $req->post_id;
       $enquiry->login_user_id = $user_id;
       $enquiry->title = $req->title;
       $enquiry->message = $req->message;
       $enquiry->rating = $req->rating;
        $enquiry->type = 'consumer';
       $enquiry->save();

       //  $notification = ConsumerAskReview::where('post_id',$details->id)->where('login_user_id',$details->user_id)->where('user_id',$user_id)->first();
        $notification = ConsumerAskReview::where('login_user_id',$details->user_id)->where('user_id',$user_id)->first();
       //  echo "<pre>";
       //  print_r($notification);die;
       $notification->status = 'read';
       $notification->save();
       Session::flash('success', 'Review Sent Successfully');
   }
       return redirect('/');
    }

    public function businessreviewsave(Request $req){
        $req->validate([
            'title' => 'required',
            'message' => 'required',
            'rating' => 'required',
        ]);
        $details = BusinessPost::where('id',$req->post_id)->first();
        $enquiry = new BusinessReview();

        $user_id = session()->get('user_id');

        // Check if a review already exists for this post by the same user
    $existingReview = BusinessReview::where('post_id', $req->post_id)
        ->where('login_user_id', $user_id)
        ->first();

    if ($existingReview) {
        // If review exists, update it
        $existingReview->title = $req->title;
        $existingReview->message = $req->message;
        $existingReview->rating = $req->rating;
        $existingReview->save();
 //  $notification = ConsumerAskReview::where('post_id',$details->id)->where('login_user_id',$details->user_id)->where('user_id',$user_id)->first();
         $notification = ConsumerAskReview::where('login_user_id',$details->user_id)->where('user_id',$user_id)->first();
        //  echo "<pre>";
        //  print_r($notification);die;

        $notification->change_review = 'changedreview';
        $notification->save();
        Session::flash('success', 'Review Updated Successfully');
    } else {
        $enquiry->user_id = $details->user_id;
        $enquiry->post_id = $req->post_id;
        $enquiry->login_user_id = $user_id;
        $enquiry->title = $req->title;
        $enquiry->message = $req->message;
        $enquiry->rating = $req->rating;
         $enquiry->type = 'business';
        $enquiry->save();

        //  $notification = ConsumerAskReview::where('post_id',$details->id)->where('login_user_id',$details->user_id)->where('user_id',$user_id)->first();
         $notification = ConsumerAskReview::where('login_user_id',$details->user_id)->where('user_id',$user_id)->first();
        //  echo "<pre>";
        //  print_r($notification);die;
        $notification->status = 'read';
        $notification->save();
        Session::flash('success', 'Review Sent Successfully');
    }
        return redirect('/');
    }

    public function sendReviewRequest($id)
    {
      $user_id = session()->get('user_id');
      $user_type = session()->get('user_type');

       // Find the record by ID
    $condata = ConsumerEnquiry::find($id);
    $postdata = ConsumerPost::where('id',$condata->post_id)->first();

       $conaskrev = new ConsumerAskReview();
        $conaskrev->user_id = $condata->login_user_id;
        $conaskrev->login_user_id = $postdata->user_id;
        $conaskrev->post_id = $postdata->id;
         $conaskrev->name = $postdata->name;
        $conaskrev->flag = 'asked';
        $conaskrev->type = $user_type;
        $conaskrev->save();





    if ($condata) {
       $data = [
            'name' => $condata->name,
            'post_name' => $postdata->name,
            'email' => $condata->email,
            'post_id' => $postdata->id,
             'link' => url('/conpostprofile/' . $postdata->user_id . '?review_id=' . $conaskrev->id),
            ];


            // $data["title"] = "IIV India Registered Valuers Foundation | Payment Success | Thank you";
            $data["title"] =  $postdata->name . " has requested for review";
            // Mail::to(Auth::user()->email)->send(new Payment_done_mail($data));
            // Mail::send('frontend.mail.consumeraskreview', $data, function($message)use($data){
            //     $message->to($data["email"], $data["email"])
            //             ->subject($data["title"]);
            // });

            // Render the email body using the Blade view
            $body = view('frontend.mail.consumeraskreview', $data)->render();
            // Call your mailer service to send the email
            $this->mailerService->sendEmail($data['email'], $data['title'], $body, $data);

        // Update the flag field to indicate the review email has been sent
        $condata->flag = 'asked'; // Assuming flag is 1 for sent, 0 for not sent
        $condata->save();




        return response()->json(['status' => 'success']);
    }

    return response()->json(['status' => 'error']);
}

public function conmarkAsRead($id)
{
    try {
        // Find the notification by ID
        $notification = ConsumerAskReview::find($id);

        if ($notification) {
            // Mark the notification as read by updating `read_at` (or `flag`)
            $notification->status = 'read';  // assuming you have a `read_at` timestamp column
            // Alternatively, if you are using the `flag` field:
            // $notification->flag = 'read';
            $notification->save();

            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Notification not found.'], 404);
        }
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'An error occurred.'], 500);
    }
}

  public function bussendReviewRequest($id)
    {
      $user_id = session()->get('user_id');
       $user_type = session()->get('user_type');

    // Find the record by ID
    $condata = BusinessEnquiry::find($id);
    $postdata = BusinessPost::where('id',$condata->post_id)->first();

     $users = EcosansarUsers::where('id',$postdata->user_id)->first();

        $conaskrev = new ConsumerAskReview();
        $conaskrev->user_id = $condata->login_user_id;
        $conaskrev->login_user_id = $postdata->user_id;
        $conaskrev->post_id = $postdata->id;
         $conaskrev->name = $users->name;
        $conaskrev->flag = 'asked';
         $conaskrev->type = $user_type;
        $conaskrev->save();

    if ($condata) {
       $data = [
            'name' => $condata->name,
            'post_name' => $users->name,
            'email' => $condata->email,
            'post_id' => $postdata->id,
             'link' => url('/buspostprofile/' . $postdata->user_id. '?review_id=' . $conaskrev->id),
            ];


            // $data["title"] = "IIV India Registered Valuers Foundation | Payment Success | Thank you";
            $data["title"] =  $users->name . " has requested for review";
            // Mail::to(Auth::user()->email)->send(new Payment_done_mail($data));
            // Mail::send('frontend.mail.consumeraskreview', $data, function($message)use($data){
            //     $message->to($data["email"], $data["email"])
            //             ->subject($data["title"]);
            // });

            // Render the email body using the Blade view
            $body = view('frontend.mail.consumeraskreview', $data)->render();
            // Call your mailer service to send the email
            $this->mailerService->sendEmail($data['email'], $data['title'], $body, $data);


        // Update the flag field to indicate the review email has been sent
        $condata->flag = 'asked'; // Assuming flag is 1 for sent, 0 for not sent
        $condata->save();



        return response()->json(['status' => 'success']);
    }

    return response()->json(['status' => 'error']);
}
public function busmarkAsRead($id)
{
    try {
        // Find the notification by ID
        $notification = ConsumerAskReview::find($id);

        if ($notification) {
            // Mark the notification as read by updating `read_at` (or `flag`)
            $notification->status = 'read';  // assuming you have a `read_at` timestamp column
            // Alternatively, if you are using the `flag` field:
            // $notification->flag = 'read';
            $notification->save();

            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Notification not found.'], 404);
        }
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'An error occurred.'], 500);
    }
}

  public function sabsendReviewRequest($id)
    {
      $user_id = session()->get('user_id');
      $user_type = session()->get('user_type');

    // Find the record by ID
    $condata = SABEnquiry::find($id);
    $postdata = SABPost::where('id',$condata->post_id)->first();


        $conaskrev = new ConsumerAskReview();
        $conaskrev->user_id = $condata->login_id;
        $conaskrev->login_user_id = $postdata->user_id;
        $conaskrev->post_id = $postdata->id;
         $conaskrev->name = $postdata->name;
        $conaskrev->flag = 'asked';
        $conaskrev->type = $user_type;
        $conaskrev->save();

    if ($condata) {
       $data = [
            'name' => $condata->name,
            'post_name' => $postdata->name,
            'email' => $condata->email,
            'post_id' => $postdata->id,
             'link' => url('/sabpostprofile/' . $postdata->user_id. '?review_id=' . $conaskrev->id),
            ];


            // $data["title"] = "IIV India Registered Valuers Foundation | Payment Success | Thank you";
            $data["title"] =  $postdata->name . " has requested for review";
            // Mail::to(Auth::user()->email)->send(new Payment_done_mail($data));
            // Mail::send('frontend.mail.sabaskreview', $data, function($message)use($data){
            //     $message->to($data["email"], $data["email"])
            //             ->subject($data["title"]);
            // });

            // Render the email body using the Blade view
            $body = view('frontend.mail.sabaskreview', $data)->render();
            // Call your mailer service to send the email
            $this->mailerService->sendEmail($data['email'], $data['title'], $body, $data);

        // Update the flag field to indicate the review email has been sent
        $condata->flag = 'asked'; // Assuming flag is 1 for sent, 0 for not sent
        $condata->save();



        return response()->json(['status' => 'success']);
    }

    return response()->json(['status' => 'error']);
}
public function sabmarkAsRead($id)
{
    try {
        // Find the notification by ID
        $notification = ConsumerAskReview::find($id);

        if ($notification) {
            // Mark the notification as read by updating `read_at` (or `flag`)
            $notification->status = 'read';  // assuming you have a `read_at` timestamp column
            // Alternatively, if you are using the `flag` field:
            // $notification->flag = 'read';
            $notification->save();

            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Notification not found.'], 404);
        }
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'An error occurred.'], 500);
    }
}

public function updateReview(Request $request)
{

    // Validate the input
    $request->validate([
        'review_id' => 'required',
        'source' => 'required|in:consumer,business,sab', // Validate the source
        'message' => 'required'
    ]);

    // Determine the correct model based on the source
    $review = null;
    switch ($request->source) {
        case 'consumer':
            $review = ConsumerReview::findOrFail($request->review_id);
            break;
        case 'business':
            $review = BusinessReview::findOrFail($request->review_id);
            break;
        case 'sab':
            $review = SabReview::findOrFail($request->review_id);
            break;
        default:
            return response()->json(['success' => false, 'message' => 'Invalid source'], 400);
    }

    // Update the review data
    $review->message = $request->message;
    $review->rating = $request->rating;
    $review->title = $request->title;
    $review->save();

    // Return a success response for AJAX
    return response()->json(['success' => true]);
}

 public function changeconReviewRequest($id)
    {

      $user_id = session()->get('user_id');
      $user_type = session()->get('user_type');

    // Find the record by ID
    $condata = ConsumerReview::find($id);

    $postdata = ConsumerPost::where('id',$condata->post_id)->first();
     $userdata = Ecosansarusers::where('id',$condata->login_user_id)->first();
      $notificationchange = ConsumerAskReview::where('user_id',$condata->login_user_id)->where('login_user_id',$user_id)->first();
        $conaskrev = new ChangeReview();
        $conaskrev->user_id = $condata->login_user_id;
        $conaskrev->login_user_id = $postdata->user_id;
        $conaskrev->post_id = $postdata->id;
         $conaskrev->name = $postdata->name;
        $conaskrev->flag = 'asked';
        $conaskrev->type = $user_type;
        $conaskrev->save();

    if ($condata) {
       $data = [
            'name' => $condata->name,
            'post_name' => $postdata->name,
            'email' => $userdata->email,
            'post_id' => $postdata->id,
           'link' => url('/edit-con-review/' . $postdata->user_id . '/' . $id . '?review_id=' . $notificationchange->id)
            ];


            // $data["title"] = "IIV India Registered Valuers Foundation | Payment Success | Thank you";
            $data["title"] =  $postdata->name . " has requested to change review";
            // Mail::to(Auth::user()->email)->send(new Payment_done_mail($data));
            // Mail::send('frontend.mail.sabaskreview', $data, function($message)use($data){
            //     $message->to($data["email"], $data["email"])
            //             ->subject($data["title"]);
            // });

            // Render the email body using the Blade view
            $body = view('frontend.mail.sabaskreview', $data)->render();
            // Call your mailer service to send the email
            $this->mailerService->sendEmail($data['email'], $data['title'], $body, $data);



        $notificationchange->change_review = 'changereview';
        $notificationchange->save();



        return response()->json(['status' => 'success']);
    }

    return response()->json(['status' => 'error']);
}
public function editconReview($id, $rid)
{
    $user_id = session()->get('user_id');
    $user_type = session()->get('user_type');
  $review_id = request()->query('review_id');
    // Check if user is logged in; if not, redirect to login
     if (null === $user_id || $user_id === '') {
            // User is not logged in, redirect to the login page
             $redirectUrl = url("/edit-con-review/{$id}/{$rid}") . '?review_id=' . $review_id;
             session()->put('redirect_changerev', $redirectUrl);
            //  session()->put('redirect_askrev', route('conpostprofile', $u_id));
            return redirect()->route('consumer_login');
        }

    // Find the review by ID
    $review = ConsumerReview::find($rid);
    $post_id = $review->post_id;
    // Check if the review exists
    if (!$review) {
        return redirect('/')->with('error', 'Review not found.');
    }

     // Retrieve the review request based only on user_id
     $reviewRequest = ConsumerAskReview::where('id', $review_id)->where('user_id', $user_id)->first();

      //$reviewRequest = ConsumerAskReview::where('id', $review_id)->first();



    // Check if the review request exists and belongs to the logged-in user
    if (!$reviewRequest) {

        Session::flash('warning', 'Unauthorized access to this review request.');
        return redirect('/');
    }

  $users = EcosansarUsers::where('id', $review->user_id)->first();
    // Pass the review data to the view
    return view('frontend.coneditreview', compact('review','id','post_id','users'));
}

 public function changesabReviewRequest($id)
    {

      $user_id = session()->get('user_id');
      $user_type = session()->get('user_type');

    // Find the record by ID
    $condata =SABReview::find($id);
    // echo "<pre>";
    // print_r($condata);die;
    $postdata = SABPost::where('id',$condata->post_id)->first();
     $userdata = Ecosansarusers::where('id',$condata->login_user_id)->first();
      $notificationchange = ConsumerAskReview::where('user_id',$condata->login_user_id)->where('login_user_id',$user_id)->first();
        $conaskrev = new ChangeReview();
        $conaskrev->user_id = $condata->login_user_id;
        $conaskrev->login_user_id = $postdata->user_id;
        $conaskrev->post_id = $postdata->id;
         $conaskrev->name = $postdata->name;
        $conaskrev->flag = 'asked';
        $conaskrev->type = $user_type;
        $conaskrev->save();

    if ($condata) {
       $data = [
            'name' => $condata->name,
            'post_name' => $postdata->name,
            'email' => $userdata->email,
            'post_id' => $postdata->id,
           'link' => url('/edit-sab-review/' . $postdata->user_id . '/' . $id . '?review_id=' . $notificationchange->id)
            ];


            // $data["title"] = "IIV India Registered Valuers Foundation | Payment Success | Thank you";
            $data["title"] =  $postdata->name . " has requested to change review";
            // Mail::to(Auth::user()->email)->send(new Payment_done_mail($data));
            // Mail::send('frontend.mail.sabaskreview', $data, function($message)use($data){
            //     $message->to($data["email"], $data["email"])
            //             ->subject($data["title"]);
            // });

            // Render the email body using the Blade view
            $body = view('frontend.mail.sabaskreview', $data)->render();
            // Call your mailer service to send the email
            $this->mailerService->sendEmail($data['email'], $data['title'], $body, $data);



        $notificationchange->change_review = 'changereview';
        $notificationchange->save();



        return response()->json(['status' => 'success']);
    }

    return response()->json(['status' => 'error']);
}
public function editsabReview($id, $rid)
{

    $user_id = session()->get('user_id');
    $user_type = session()->get('user_type');
  $review_id = request()->query('review_id');
    // Check if user is logged in; if not, redirect to login
     if (null === $user_id || $user_id === '') {
            // User is not logged in, redirect to the login page
             $redirectUrl = url("/edit-sab-review/{$id}/{$rid}") . '?review_id=' . $review_id;
             session()->put('redirect_changerev', $redirectUrl);
            //  session()->put('redirect_askrev', route('conpostprofile', $u_id));
            return redirect()->route('consumer_login');
        }

    // Find the review by ID
    $review = SABReview::find($rid);
    $post_id = $review->post_id;
    // Check if the review exists
    if (!$review) {
        return redirect('/')->with('error', 'Review not found.');
    }

     // Retrieve the review request based only on user_id
     $reviewRequest = ConsumerAskReview::where('id', $review_id)->where('user_id', $user_id)->first();

      //$reviewRequest = ConsumerAskReview::where('id', $review_id)->first();



    // Check if the review request exists and belongs to the logged-in user
    if (!$reviewRequest) {

        Session::flash('warning', 'Unauthorized access to this review request.');
        return redirect('/');
    }
 $users = EcosansarUsers::where('id', $review->user_id)->first();
    // Pass the review data to the view
    return view('frontend.sabeditreview', compact('review','id','post_id','users'));
}

public function changebusReviewRequest($id)
    {

      $user_id = session()->get('user_id');
      $user_type = session()->get('user_type');

    // Find the record by ID
    $condata = BusinessReview::find($id);

    $postdata = BusinessPost::where('id',$condata->post_id)->first();
     $userdata = Ecosansarusers::where('id',$condata->login_user_id)->first();
      $notificationchange = ConsumerAskReview::where('user_id',$condata->login_user_id)->where('login_user_id',$user_id)->first();
        $conaskrev = new ChangeReview();
        $conaskrev->user_id = $condata->login_user_id;
        $conaskrev->login_user_id = $postdata->user_id;
        $conaskrev->post_id = $postdata->id;
         $conaskrev->name = $postdata->name;
        $conaskrev->flag = 'asked';
        $conaskrev->type = $user_type;
        $conaskrev->save();

    if ($condata) {
       $data = [
            'name' => $condata->name,
            'post_name' => $postdata->name,
            'email' => $userdata->email,
            'post_id' => $postdata->id,
           'link' => url('/edit-bus-review/' . $postdata->user_id . '/' . $id . '?review_id=' . $notificationchange->id)
            ];


            // $data["title"] = "IIV India Registered Valuers Foundation | Payment Success | Thank you";
            $data["title"] =  $postdata->name . " has requested to change review";
            // Mail::to(Auth::user()->email)->send(new Payment_done_mail($data));
            // Mail::send('frontend.mail.sabaskreview', $data, function($message)use($data){
            //     $message->to($data["email"], $data["email"])
            //             ->subject($data["title"]);
            // });

            // Render the email body using the Blade view
            $body = view('frontend.mail.sabaskreview', $data)->render();
            // Call your mailer service to send the email
            $this->mailerService->sendEmail($data['email'], $data['title'], $body, $data);


        $notificationchange->change_review = 'changereview';
        $notificationchange->save();



        return response()->json(['status' => 'success']);
    }

    return response()->json(['status' => 'error']);
}
public function editbusReview($id, $rid)
{
    $user_id = session()->get('user_id');
    $user_type = session()->get('user_type');
  $review_id = request()->query('review_id');
   // Retrieve the review request based only on user_id
     $reviewRequest = ConsumerAskReview::where('id', $review_id)->where('user_id', $user_id)->first();

    // Check if user is logged in; if not, redirect to login
     if (null === $user_id || $user_id === '') {

            // User is not logged in, redirect to the login page
            // $redirectUrl = url('/edit-bus-review', ['id' => $id,'review_id' => $rid]);
             $redirectUrl = url("/edit-bus-review/{$id}/{$rid}") . '?review_id=' . $review_id;

             session()->put('redirect_changerev', $redirectUrl);
            //  session()->put('redirect_askrev', route('conpostprofile', $u_id));
            return redirect()->route('consumer_login');
        }

    // Find the review by ID
    $review =BusinessReview::find($rid);
    $post_id = $review->post_id;
    // Check if the review exists
    if (!$review) {
        return redirect('/')->with('error', 'Review not found.');
    }



      //$reviewRequest = ConsumerAskReview::where('id', $review_id)->first();



    // Check if the review request exists and belongs to the logged-in user
    if (!$reviewRequest) {

        Session::flash('warning', 'Unauthorized access to this review request.');
        return redirect('/');
    }

  $users = EcosansarUsers::where('id', $review->user_id)->first();
    // Pass the review data to the view
    return view('frontend.buseditreview', compact('review','id','post_id','users'));
}

}
