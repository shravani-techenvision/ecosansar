<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\frontend\SABEnquiry;
use App\Models\frontend\RecyclablePost;
use App\Models\frontend\SABReview;
use App\Models\frontend\BusinessReview;
use App\Models\frontend\BusinessEnquiry;
use App\Models\frontend\BusinessAskReview;
use App\Models\frontend\ReusableEnquiry;
use App\Models\frontend\RecyclableEnquiry;
use App\Models\frontend\RecyclableAskReviews;
use App\Models\frontend\RecyclableReview;
use App\Models\frontend\ConsumerAskReview;
 
use App\Models\frontend\EcosansarUsers;
use App\Models\frontend\ConsumerReview;
use App\Models\frontend\ChangeReview;
use App\Models\frontend\UserActivityLog;
use RealRashid\SweetAlert\Facades\Alert;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
// use App\Services\PHPMailerService;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log; 

class EnquiryController extends Controller
{
   private function configureMailer() {
    $mail = new PHPMailer(true);

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = env('MAIL_HOST', 'email-smtp.ap-south-1.amazonaws.com');
    $mail->SMTPAuth = true;
    $mail->Username = env('MAIL_USERNAME', 'AKIAU6GDYQUALD5BWSMU');
    $mail->Password = env('MAIL_PASSWORD', 'BEzdqoQCdnG1whfi7OU35Y94cVcs+7PQbTerX6qngnbj');
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Sender email
    $mail->setFrom(env('MAIL_FROM_ADDRESS', 'support@mailing.ecosansar.com'), env('MAIL_FROM_NAME', 'Team ecoSansar'));

    return $mail;
}

    public function recyclable_enquiry_save(Request $req){
         $user_id = session()->get('user_id');
         $user_type = session()->get('user_type');
        $req->validate([
            'name' => 'required',
           // 'email' => 'required',
            'mobile' => 'required',
            'message' => 'required'
        ]);
         $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        
        $details = RecyclablePost::where('id',$req->id)->first();

        $enquiry = new RecyclableEnquiry();
        $enquiry->post_user_id = $details->user_id; 
        $enquiry->login_user_id = $user_id;
        $enquiry->post_id = $req->id;
         $enquiry->loggedin_user_type = $user_type;
         $enquiry->user_type = $details->user_type;
        $enquiry->name = $req->name;
        $enquiry->email = $req->email;
        $enquiry->mobile = $req->mobile;
        $enquiry->message = $req->message;
        $enquiry->save();

        
        
         $users = EcosansarUsers::where('id',$details->user_id)->first();
        
        // echo "<pre>";
        // print_r($post);die;
        
        if($req->email){
            
             $userdata = [
            'post_name' => $details->name,
            'name' =>  $req->name,
            'email' => $req->email,
            'mobile' => $details->mobile,
            'post_email' =>$details->email,
            ];
            $userdata["title"] =  "Connection Details for Your Interest";
           
            try {
            // Configure PHPMailer
            $mail = $this->configureMailer();
            
            // Add recipient
            $mail->addAddress($userdata['email']);

            // Email subject and body
            $mail->Subject = $userdata['title'];
            $mail->isHTML(true);
            $mail->Body = view('frontend.mail.userthankuemail', $userdata)->render();

            // Send the email
            $mail->send();
            Log::info("Reminder email sent to: {$userdata['email']}");
        } catch (Exception $e) {
            Log::error("Error sending email to {$userdata['email']}: " . $e->getMessage());
        }
            
            
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
        
        try {
            // Configure PHPMailer
            $mail = $this->configureMailer();
            
            // Add recipient
            $mail->addAddress($data['email']);

            // Email subject and body
            $mail->Subject = $data['title'];
            $mail->isHTML(true);
            $mail->Body = view('frontend.mail.consumermail', $data)->render();

            // Send the email
            $mail->send();
            Log::info("Reminder email sent to: {$data['email']}");
        } catch (Exception $e) {
            Log::error("Error sending email to {$data['email']}: " . $e->getMessage());
        }
        
        
        $adminemail = User::where('type','admin')->first();
        
        $data["email"] = $adminemail->email;
       
        Log::info("Sending admin email to: " . $data['email']);  // Debug log
        $data["title"] =  "Enquiry from ".$req->name. " for ".$details->name;
       
         try {
            // Configure PHPMailer
            $mail = $this->configureMailer();
            
            // Add recipient
            $mail->addAddress($data['email']);

            // Email subject and body
            $mail->Subject = $data['title'];
            $mail->isHTML(true);
            $mail->Body = view('frontend.mail.adminconsumermail', $data)->render();

            // Send the email
            $mail->send();
            Log::info("Reminder email sent to: {$data['email']}");
        } catch (Exception $e) {
            Log::error("Error sending email to {$data['email']}: " . $e->getMessage());
        }
        
        
        
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
        
        $result = ReusableEnquiry::join('ecosansar_users', 'ecosansar_users.id', 'reusable_enquiries.post_user_id')
        ->join('reusable_posts', 'reusable_enquiries.post_id', 'reusable_posts.id')
        // ->join('resources', 'resources.id', 'business_resource_posts.resource_type')
        ->select('reusable_enquiries.*', 'ecosansar_users.name as username', 'reusable_posts.name as postname')
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
  
  
    
    
    
     public function recyclablereviewsave(Request $req){
        
        $req->validate([
            'title' => 'required',
            'message' => 'required',
            'rating' => 'required',
        ]);
        $details = RecyclablePost::where('id',$req->post_id)->first();
        $enquiry = new RecyclableReview();
        $user_id = session()->get('user_id'); 
        
          // Check if a review already exists for this post by the same user
    $existingReview = RecyclableReview::where('post_id', $req->post_id)
        ->where('login_user_id', $user_id)
        ->first();

    if ($existingReview) {
        // If review exists, update it
        $existingReview->title = $req->title;
        $existingReview->message = $req->message;
        $existingReview->rating = $req->rating;
        $existingReview->save();
 //  $notification = ConsumerAskReview::where('post_id',$details->id)->where('login_user_id',$details->user_id)->where('user_id',$user_id)->first();
         $notification = RecyclableAskReviews::where('login_user_id',$details->user_id)->where('user_id',$user_id)->first();
        //  echo "<pre>";
        //  print_r($notification);die;
         if($notification){
        $notification->change_review = 'changedreview';
        $notification->save();
         }
        Session::flash('success', 'Review Updated Successfully');
    } else {
        $enquiry->user_id = $details->user_id;
        $enquiry->post_id = $req->post_id;
        $enquiry->login_user_id = $user_id;
        $enquiry->title = $req->title;
        $enquiry->message = $req->message;
        $enquiry->rating = $req->rating;
         $enquiry->type = $details->user_type;
        $enquiry->save();
        
        //  $notification = ConsumerAskReview::where('post_id',$details->id)->where('login_user_id',$details->user_id)->where('user_id',$user_id)->first();
         $notification = RecyclableAskReviews::where('login_user_id',$details->user_id)->where('user_id',$user_id)->first();
        //  echo "<pre>";
        //  print_r($notification);die;
        if($notification){
        $notification->status = 'read';
        $notification->save();
        }
        Session::flash('success', 'Review Sent Successfully');
    }
     return redirect('/');
    }
    
    
    
    public function sendReviewRequest($id)
    {
      $user_id = session()->get('user_id');
      $user_type = session()->get('user_type');
      
       // Find the record by ID
    $condata = RecyclableEnquiry::find($id);
    $postdata = RecyclablePost::where('id',$condata->post_id)->first();
      
       $conaskrev = new RecyclableAskReviews();
        $conaskrev->user_id = $condata->login_user_id;
        $conaskrev->login_user_id = $postdata->user_id;
        $conaskrev->post_id = $postdata->id;
         $conaskrev->name = $postdata->name;
        $conaskrev->flag = 'asked';
        $conaskrev->type = $user_type;
        $conaskrev->user_type = $condata->loggedin_user_type;
        $conaskrev->save();
      
   
     
        

    if ($condata) {
       $data = [
            'name' => $condata->name,
            'post_name' => $postdata->name,
            'email' => $condata->email,
            'post_id' => $postdata->id,
             'link' => url('/recyclablepostprofile/' . $postdata->user_id . '?review_id=' . $conaskrev->id),
            ];
            
             
            
            // $data["title"] =  $postdata->name . " has requested for review";
             $data["title"] =  "Share Your Feedback on ". $postdata->name ."'s " ."Service"; 
            
            // Mail::send('frontend.mail.consumeraskreview', $data, function($message)use($data){
            //     $message->to($data["email"], $data["email"])
            //             ->subject($data["title"]);
            // });
            
            // Render the email body using the Blade view
           // $body = view('frontend.mail.consumeraskreview', $data)->render();
            // Call your mailer service to send the email
          //  $this->mailerService->sendEmail($data['email'], $data['title'], $body, $data);
          
          try {
            // Configure PHPMailer
            $mail = $this->configureMailer();
            
            // Add recipient
            $mail->addAddress($data['email']);

            // Email subject and body
            $mail->Subject = $data['title'];
            $mail->isHTML(true);
            $mail->Body = view('frontend.mail.consumeraskreview', $data)->render();

            // Send the email
            $mail->send();
            Log::info("Reminder email sent to: {$data['email']}");
        } catch (Exception $e) {
            Log::error("Error sending email to {$data['email']}: " . $e->getMessage());
        }

        // Update the flag field to indicate the review email has been sent
        $condata->flag = 'asked'; // Assuming flag is 1 for sent, 0 for not sent
        $condata->save();
        
        
       
   
       return response()->json([
    'status' => 'success',
    'review_id' => $conaskrev->id,
    'post_name' => $postdata->name,
    'post_user_id' => $postdata->user_id,
    'user_type' => $condata->loggedin_user_type
]);

    }

    return response()->json(['status' => 'error']);
}
 
 
//to update from my prrofile page under reviews given tab 
public function updateReview(Request $request, $id) {
    $review = RecyclableReview::find($id);
    
    if (!$review) {
        return response()->json(['success' => false, 'message' => 'Review not found']);
    }

    // Update record
    $review->title = $request->title;
    $review->message = $request->message;
    $review->rating = $request->rating;
    $review->save();

    return response()->json(['success' => true]);
}


 public function changeReviewRequest($id)
    {
        
      $user_id = session()->get('user_id');
      $user_type = session()->get('user_type');
      
    // Find the record by ID
    $condata = RecyclableReview::find($id);
    
    $postdata = RecyclablePost::where('id',$condata->post_id)->first();
     $userdata = Ecosansarusers::where('id',$condata->login_user_id)->first();
      $notificationchange = RecyclableAskReviews::where('user_id',$condata->login_user_id)->where('login_user_id',$user_id)->first();  
      
       if (!$notificationchange) {
        // Create a new record in ConsumerAskReview if it doesn't exist
        $notificationchange = RecyclableAskReviews::create([
            'user_id' => $condata->login_user_id,
            'login_user_id' => $user_id,
            'post_id' => $postdata->id,
            'status' => 'read',
            'flag' => 'asked',
            'name' => $postdata->name,
            'change_review' => 'changereview',
            'type' => $user_type
        ]);
    }

      
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
            'name' => $userdata->name,
            'post_name' => $postdata->name,
            'email' => $userdata->email,
            'post_id' => $postdata->id,
           'link' => url('/edit-recyclable-review/' . $postdata->user_id . '/' . $id . '?review_id=' . $notificationchange->id)
            ];
            
             
            
            $data["title"] =  "Request to Update Your Review";  
             
            
 try {
            // Configure PHPMailer
            $mail = $this->configureMailer();
            
            // Add recipient
            $mail->addAddress($data['email']);

            // Email subject and body
            $mail->Subject = $data['title'];
            $mail->isHTML(true);
            $mail->Body = view('frontend.mail.businesschangereview', $data)->render();

            // Send the email
            $mail->send();
            Log::info("Reminder email sent to: {$data['email']}");
        } catch (Exception $e) {
            Log::error("Error sending email to {$data['email']}: " . $e->getMessage());
        }
       
      
        $notificationchange->change_review = 'changereview';
        $notificationchange->save();
        
       
   Session::flash('success', 'Review request sent successfully!');
        return response()->json(['status' => 'success']);
    }

    return response()->json(['status' => 'error']);
}
public function editReview($id, $rid)
{
    $user_id = session()->get('user_id');
    $user_type = session()->get('user_type');
  $review_id = request()->query('review_id');  
    // Check if user is logged in; if not, redirect to login
     if (null === $user_id || $user_id === '') {
            // User is not logged in, redirect to the login page
             $redirectUrl = url("/edit-recyclable-review/{$id}/{$rid}") . '?review_id=' . $review_id; 
             session()->put('redirect_changerev', $redirectUrl);
            //  session()->put('redirect_askrev', route('conpostprofile', $u_id));
            return redirect()->route('consumer_login');
        }
        
    // Find the review by ID
    $review = RecyclableReview::find($rid);
    $post_id = $review->post_id;
    // Check if the review exists
    if (!$review) {
        return redirect('/')->with('error', 'Review not found.');
    }
    
     // Retrieve the review request based only on user_id
     $reviewRequest = RecyclableAskReviews::where('id', $review_id)->where('user_id', $user_id)->first();
    
      //$reviewRequest = ConsumerAskReview::where('id', $review_id)->first();
 
   

    // Check if the review request exists and belongs to the logged-in user
    if (!$reviewRequest) {
         
        Session::flash('warning', 'Unauthorized access to this review request.');
        return redirect('/');
    }
    
  $users = EcosansarUsers::where('id', $review->user_id)->first();
    // Pass the review data to the view
    return view('frontend.recyclableeditreview', compact('review','id','post_id','users'));
}
 public function Consumerconnectreportlist(){
        
        $result = RecyclableEnquiry::join('ecosansar_users', 'ecosansar_users.id', 'recyclable_enquiries.post_user_id')
        ->join('recyclable_posts', 'recyclable_enquiries.post_id', 'recyclable_posts.id')
        ->select('recyclable_enquiries.*', 'ecosansar_users.name as username', 'recyclable_posts.name as postname')
        ->get();

        
      $data=compact('result');
    
    return view('admin/usertype/Consumerconnectreportlist')->with($data);
  }
 
}
