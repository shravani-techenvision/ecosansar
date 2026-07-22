<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\frontend\EcosansarUsers;
use App\Models\frontend\RecyclablePost;
use App\Models\frontend\RecyclableReview;
use App\Models\frontend\ReusablePost;
use App\Models\frontend\ReusableReview;
use App\Models\frontend\UserActivityLog;
use App\Models\admin\PlanHistory;
use App\Models\admin\Volunteer;
use App\Models\admin\ReusableResource;
use App\Models\admin\Weight;
use App\Models\AdminActivityLog;
use App\Models\User;
use App\Models\OurImpact;
use App\Models\admin\SubscriptionModule;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use App\Models\frontend\UserContact;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Hash;
use Auth;

class AdminController extends Controller
{
  public function usercontact(){
    $result = UserContact::orderBy('id','desc')
    ->get();

    return view('admin/usertype/usercontactlist',compact('result'));
  }
  public function businesslist(){

    $result = EcosansarUsers::where('user_type','business')->where('is_delete','0')
    ->orderBy('id','desc')
    ->get();
    $plans = SubscriptionModule::where('active',1)->get();

    return view('admin/usertype/businesslist',compact('result','plans'));
  }

   public function businessassignplan(Request $request){
       $request->validate([
        'user_id' => 'required|exists:ecosansar_users,id',
        'plan' => 'required|integer',
    ]);

    // Find the user
    $user = EcosansarUsers::find($request->user_id);

    if (!$user) {
        return redirect()->back()->with('error', 'User not found.');
    }
     $plan = SubscriptionModule::find($request->plan);
    if (!$plan) {
        return redirect()->back()->with('error', 'Plan not found.');
    }
    $planPrice = $plan->plan_price;
 // Convert plan validity (months) to days. You can adjust the number of days per month if needed (e.g., 30 or 31 days per month)
    $daysInMonth = 30; // Assume 30 days in a month (you can adjust this if needed)
     $validityInDays = $request->plan_validity * $daysInMonth;

   try {
    // Store the plan history in plan_history table
    PlanHistory::create([
        'user_id' => $user->id,
        'plan_id' => $request->plan,
        'plan_validity' => $request->plan_validity,
        'plan_expiration_date' => Carbon::now()->addDays($validityInDays),
        'plan_price' => $planPrice,
    ]);
} catch (\Exception $e) {
    // Log the error message
    \Log::error('Error saving plan history: ' . $e->getMessage());
    return redirect()->back()->with('error', 'Error saving plan history: ' . $e->getMessage());
}


    // Assign the selected plan to the user
    $user->plan = $request->plan;
    $user->plan_expiration_date = Carbon::now()->addDays($validityInDays); // Example: 30-day expiration

    // Check if the plan expiration date is in the past, and deactivate the user
    if ($user->plan_expiration_date < Carbon::now()) {
        $user->status = 0;  // You can change 'inactive' to any status field you have
    } else {
        $user->status = 1;  // Set status to active if the plan is still valid
    }

    $user->save();


// Determine the redirect route based on user_type
    $redirectRoute = null;
   // Redirect based on user_type
    switch ($request->user_type) {
        case 'sab':
            $redirectRoute = 'user.sablist'; // Replace with your actual admin route
            break;
        case 'business':
            $redirectRoute = 'user.businesslist'; // Replace with your actual business route
            break;
        case 'consumer':
            $redirectRoute = 'user.consumerlist'; // Replace with your actual consumer route
            break;
    }
// Ensure the redirect route is valid
if ($redirectRoute === null) {
    return redirect()->back()->with('error', 'Unable to determine redirect route.');
}
    return redirect()->route($redirectRoute)->with('success', 'Plan assigned successfully.');
   }

  public function edituser($id){
    $url = route('user.updateuser', $id);

    $user = EcosansarUsers::where('id',$id)->first();
    // echo "<pre>";
    // print_r($user);
    // die;
    return view('admin/usertype/adduser',compact('url','user' ));
   }

   public function updateuser(Request $req, $id){

    // echo "<pre>";
    // print_r($req->all());
    // die;

    $req->validate([
        'name' => 'required',
        'user_type' => 'required',
         'mobile' => 'required',
          'address' => 'required',
           'pincode' => 'required',
            'type_of_residences' => 'required',
             //'email' => 'required',
    ]);

    $user = EcosansarUsers::find($id);
    $user->name = $req->name;
    $user->user_type = $req->user_type;
    $user->mobile = $req->mobile;
    $user->address = $req->address;
    $user->pincode = $req->pincode;

    $user->type_of_residences = $req->type_of_residences;
    $user->email = $req->email;
    $user->save();

    Alert::success('success','User Updated Successfully');

    if($user->user_type == 'business'){
        return redirect()->route('user.businesslist');
    }elseif($user->user_type == 'consumer'){
        return redirect()->route('user.consumerlist');
    }elseif($user->user_type == 'sab'){
         return redirect()->route('user.sablist');
    }

   }

   public function deleteuser($id){

    $result = EcosansarUsers::where('id', $id)->first();
    $result->is_delete = '1';
    $result->save();

    Alert::success('success','User delete Successfully');
    if($result->user_type == 'business'){
        return redirect()->route('user.businesslist');
    }elseif($result->user_type == 'consumer'){
        return redirect()->route('user.consumerlist');
    }elseif($result->user_type == 'sab'){
         return redirect()->route('user.sablist');
    }

  }

  public function sablist(){
    $result = EcosansarUsers::where('user_type','sab')->where('is_delete','0')
    ->orderBy('id','desc')->get();
     $plans = SubscriptionModule::where('active',1)->get();
    return view('admin/usertype/sablist',compact('result','plans'));
  }
  
    //   Collection Agent (sab) Post access toggle
   public function changePostAccess(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:ecosansar_users,id',
        ]);
    
        $user = EcosansarUsers::findOrFail($request->user_id);
    
        // If checkbox is checked -> 1, otherwise -> 0
        $user->post_access = $request->has('post_access') ? 1 : 0;
    
        $user->save();
        Alert::success('success','Post access updated successfully.');
        return redirect()->back();
    }
  public function consumerlist(){
    $result = EcosansarUsers::where('user_type','consumer')->where('is_delete','0')
     ->orderBy('id','desc')->get();
     $plans = SubscriptionModule::where('active',1)->get();
    return view('admin/usertype/consumerlist',compact('result','plans'));
  }
  public function changeStatus(Request $request)
    {
        $user = EcosansarUsers::find($request->user_id);
        $user->is_checked = $request->status;
        $user->save();
        return response()->json(['success'=>'Status change successfully.']);
    }
  public function businessview($id){
    $users = EcosansarUsers::
    select('ecosansar_users.*')
        ->where('ecosansar_users.id', $id)->first();
    $data=compact('users');
    return view('admin/usertype/businessview')->with($data);
  }
  public function sabview($id){
    $users = EcosansarUsers::
    select('ecosansar_users.*' )
        ->where('ecosansar_users.id', $id)->first();
    $data=compact('users');
    return view('admin/usertype/sabview')->with($data);
  }
  public function consumerview($id){
    $users = EcosansarUsers::
    select('ecosansar_users.*' )
        ->where('ecosansar_users.id', $id)->first();
    $data=compact('users');
    return view('admin/usertype/consumerview')->with($data);
  }
  public function recyclableposts(){
    $result = RecyclablePost::where('active',1)->orderBy('id','desc')->get();

    return view('admin/usertype/recyclablepostslist',compact('result'));
  }
   public function recyclablepostsdelete($id){
    $posts = RecyclablePost::find($id);
     $posts->delete();
     Alert::success('success','Post Deleted Successfully');
        return redirect()->route('user.recyclableposts');
  }
  public function reusableposts(){
    $result = ReusablePost::where('active',1)->orderBy('id','desc')->get();
    return view('admin/usertype/reusablepostslist',compact('result'));
  }
  public function addReusablePost(){
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $users = EcosansarUsers::where('id', $user_id)->first();
        $resources = ReusableResource::get();
        $weights = Weight::orderByRaw('CAST(min_weight AS UNSIGNED) ASC')->get();

          // user activity start
         $userid = Auth::id();
        if ($userid){
            $userActivity = new AdminActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on Reusable add post';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }

        return view('admin/usertype/reusablepostadd', compact('users', 'user_id', 'resources', 'weights'));
    }
    
    public function saveReusablePost(Request $request)
    {

        // echo "<pre>";
        // print_r($request->all());die;

        $user = Auth::user();
        $user_id = $user->id;
        $user_type = $user->type;
        $user_name =$user->first_name;
        $email = $user->email;
        if ($request->sale_giveaway == 'Buy') {
            $request->validate([
                'address' => 'required',
                // 'sale_giveaway' => 'required',
                'quantity' => 'required',
                'resource_type' => 'required',
                'resource_img' => 'mimes:jpg,jpeg,png,webp', // Adjust mime types and max size as needed
            ]);
        } else {
            $request->validate([
                'address' => 'required',
                // 'sale_giveaway' => 'required',
                'quantity' => 'required',

                'resource_type' => 'required',
                'resource_img' => 'required|mimes:jpg,jpeg,png,webp', // Adjust mime types and max size as needed
            ]);
        }
        $user = new ReusablePost();
        $user->user_id = $user_id;
        $user->user_type = $user_type;
        $user->name = $user_name;
        $user->email = $email;
        // $user->mobile = $users->mobile;
        $user->address = $request->address;
        // $user->sale_giveaway = $request->sale_giveaway;
        $user->quantity = $request->quantity;
        $user->clean_unclean = $request->clean_unclean;
        $user->packaged = $request->packaged;
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->resource_price = $request->resource_price;
        $user->description = $request->description;


       // Function to resize an image using the GD library
        function resizeImage($source, $width, $height)
        {
            // Get the original image dimensions and type
            list($originalWidth, $originalHeight, $type) = getimagesize($source);
        
            // Calculate the new dimensions while maintaining the aspect ratio
            $ratio = $originalWidth / $originalHeight;
            if ($width / $height > $ratio) {
                $width = $height * $ratio;
            } else {
                $height = $width / $ratio;
            }
        
            // Create a new blank image with the calculated dimensions
            $newImage = imagecreatetruecolor($width, $height);
        
            // Load the source image based on its type
            switch ($type) {
                case IMAGETYPE_JPEG:
                    $sourceImage = imagecreatefromjpeg($source);
                    break;
                case IMAGETYPE_PNG:
                    $sourceImage = imagecreatefrompng($source);
                    break;
                case IMAGETYPE_GIF:
                    $sourceImage = imagecreatefromgif($source);
                    break;
                case IMAGETYPE_WEBP:
                    $sourceImage = imagecreatefromwebp($source);
                    break;
                default:
                    throw new Exception('Unsupported image type');
            }
        
            // Resize the image
            imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);
        
            // Start output buffering to capture the image content
            ob_start();
            switch ($type) {
                case IMAGETYPE_JPEG:
                    imagejpeg($newImage);
                    break;
                case IMAGETYPE_PNG:
                    imagepng($newImage);
                    break;
                case IMAGETYPE_GIF:
                    imagegif($newImage);
                    break;
                case IMAGETYPE_WEBP:
                    imagewebp($newImage);
                    break;
            }
            $imageContent = ob_get_clean(); // Get the image content from the buffer
        
            // Free up memory
            imagedestroy($newImage);
            imagedestroy($sourceImage);
        
            return $imageContent; // Return the resized image content as a binary string
        }

        $user->resource_type = $request->resource_type;


        // Upload file to S3
        if ($request->hasFile('resource_img')) {
            $file = $request->file('resource_img');
            $filePath = 'Reusableposts';
            $fileName = $user_id . '_' . $user->id . '_' . $request->resource_type . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $fileTempPath = $file->getRealPath(); // Get the temporary file path

            // Set desired dimensions for resizing (e.g., 800px wide)
            $newWidth = 800;
            $newHeight = 600; // You can adjust this based on your aspect ratio logic
        
            // Use the resizeImage function to get the resized image content
            $resizedImageContent = resizeImage($fileTempPath, $newWidth, $newHeight);
        
            // Upload to S3
            Storage::disk('s3')->put($filePath . '/' . $fileName, $resizedImageContent);
            $user->resource_img = $fileName;
        }
        $user->save();


        // user activity start
         $userid = Auth::id();
        if ($userid){
            $userActivity = new AdminActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Reusable post add';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        if ($request->action === 'post_another') {
            Session::flash('success', 'Data saved successfully. You can post another.');
            return redirect()->back();
        } else {
            return redirect()->route('user.reusableposts')->with('success', 'Post Added Successfully. You can view in my profile page');
        }
    }
   public function reusablepostsdelete($id){
    $posts = ReusablePost::find($id);
     $posts->delete();
     
     // user activity start
         $userid = Auth::id();
        if ($userid){
            $userActivity = new AdminActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Reusable post deleted'. $id;
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end
     Alert::success('success','Post Deleted Successfully');
        return redirect()->route('user.reusableposts');
  }
  public function consumerposts(){
    $result = ConsumerPost::orderBy('id','desc')->get();
    return view('admin/usertype/consumerpostslist',compact('result'));
  }
  public function recyclablepostsview($id){
    $users = RecyclablePost::
       join('resources', 'resources.id', 'recyclable_posts.resource_type')
        ->join('weights', 'recyclable_posts.quantity', '=', 'weights.id')
      ->select('recyclable_posts.*', 'resources.resource_name','weights.min_weight', 'weights.min_measure', 'weights.max_weight','weights.max_measure')
      ->where('recyclable_posts.id', $id)->first();

    $data=compact('users');
    return view('admin/usertype/recyclablepostsview')->with($data);
  }
  public function reusablepostsview($id){
    // dd($id);
    // $users = ReusablePost::
    //   join('resources', 'resources.id', 'reusable_posts.resource_type')
    //     ->join('weights', 'reusable_posts.quantity', '=', 'weights.id')
    //   ->select('reusable_posts.*', 'resources.resource_name','weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
    //     ->where('reusable_posts.id', $id)
    //     ->first();
        // $users = ReusablePost::where('id', $id)->first();
        // dd($users);
        
    $users = ReusablePost::join('reusable_resources', 'reusable_resources.id', '=', 'reusable_posts.resource_type')
    ->join('weights', 'weights.id', '=', 'reusable_posts.quantity')
    ->select(
        'reusable_posts.*',
        'reusable_resources.reusable_resource_name as resource_name',
        'weights.min_weight',
        'weights.min_measure',
        'weights.max_weight',
        'weights.max_measure'
    )
    ->where('reusable_posts.id', $id)
    ->first();
    $data=compact('users');
    return view('admin/usertype/reusablepostsview')->with($data);
  }
  public function consumerpostsview($id){

    $users = ConsumerPost::join('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
       ->join('resources', 'resources.id', 'consumer_resource_posts.resource_type')
        ->join('weights', 'consumer_posts.quantity', '=', 'weights.id')
        ->select('consumer_posts.*', 'resources.resource_name','weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure','consumer_resource_posts.resource_img')
        ->where('consumer_posts.id', $id)
        ->first();

    $data=compact('users');
    return view('admin/usertype/consumerpostsview')->with($data);
  }
  public function recyclablereviews(){
    $result = RecyclableReview::join('recyclable_posts','recyclable_posts.id','recyclable_reviews.post_id')
    ->join('ecosansar_users','ecosansar_users.id','recyclable_posts.user_id')
    ->select('recyclable_reviews.*','recyclable_posts.name','ecosansar_users.name as username')
    ->get();
    return view('admin/usertype/recyclablereview',compact('result'));
  }
  public function reusablerreviews(){
    $result = ReusableReview::join('reusable_posts','reusable_posts.id','reusable_reviews.post_id')
    ->join('ecosansar_users','ecosansar_users.id','reusable_posts.user_id')
    ->select('reusable_reviews.*','reusable_posts.name','ecosansar_users.name as username')
    ->get();
    return view('admin/usertype/reusablereview',compact('result'));
  }

  public function consumerpostreportlist(){

    // $result = EcosansarUsers::where('user_type','business')->where('is_delete','0')
    // ->orderBy('id','desc')
    // ->get();
     $result = ConsumerPost::join('ecosansar_users','ecosansar_users.id','consumer_posts.user_id')
       ->join('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
        ->join('resources', 'resources.id', 'consumer_resource_posts.resource_type')
        ->select('consumer_posts.*','ecosansar_users.name as username','resources.resource_name')
        //->where('consumer_posts.active','1')
        ->get();

      $data=compact('result');

    return view('admin/usertype/consumerpostreportlist')->with($data);
  }

  public function shortconsumerReportList(Request $request) {

       $request->validate([
        'start_date' => 'required',
        'end_date' => 'required',
       ]);
    // Ensure that startdate and enddate are provided, otherwise use default values
     $startDate = $request->start_date;
   $endDate = $request->end_date;

    // Fetch the user activity logs within the date range
    $result = ConsumerPost::join('ecosansar_users','ecosansar_users.id','consumer_posts.user_id')
       ->join('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
        ->join('resources', 'resources.id', 'consumer_resource_posts.resource_type')
        ->select('consumer_posts.*','ecosansar_users.name as username','resources.resource_name')
        ->whereBetween('consumer_posts.post_date', [$startDate, $endDate])
        //->where('consumer_posts.active','1')
        ->get();

    $data = compact('result');

    return view('admin.usertype.consumerpostreportlist')->with($data);
}



  public function reusablepostreportlist(){

     $result = ReusablePost::join('ecosansar_users','ecosansar_users.id','reusable_posts.user_id')
        ->join('resources', 'resources.id', 'reusable_posts.resource_type')
        ->select('reusable_posts.*','ecosansar_users.name as username','resources.resource_name')
        ->get();

       // print_r($result);

      $data=compact('result');

    return view('admin/usertype/reusablepostreportlist')->with($data);
  }

  public function shortreusableReportList(Request $request) {

       $request->validate([
        'start_date' => 'required',
        'end_date' => 'required',
       ]);
    // Ensure that startdate and enddate are provided, otherwise use default values
     $startDate = $request->start_date;
   $endDate = $request->end_date;

    // Fetch the user activity logs within the date range
    $result = ReusablePost::join('ecosansar_users','ecosansar_users.id','reusable_posts.user_id')
        ->join('resources', 'resources.id', 'reusable_posts.resource_type')
        ->select('reusable_posts.*','ecosansar_users.name as username','resources.resource_name')
        ->whereBetween('reusable_posts.created_at', [$startDate, $endDate])
        //->where('s_a_b_posts.active','1')
        ->get();

    $data = compact('result');

    return view('admin.usertype.reusablepostreportlist')->with($data);
}

  public function recyclablepostreportlist(){



    $result = RecyclablePost::join('ecosansar_users', 'ecosansar_users.id', '=', 'recyclable_posts.user_id')

    ->join('resources', 'resources.id', '=', 'recyclable_posts.resource_type')
    ->select('recyclable_posts.*', 'ecosansar_users.name as username', DB::raw('GROUP_CONCAT(resources.resource_name SEPARATOR ", ") as resource_names'))
    ->groupBy('recyclable_posts.id', 'recyclable_posts.user_id','ecosansar_users.name')
    ->get();

    // echo "<pre>";
    // print_r($result);
    // die;

      $data=compact('result');

    return view('admin/usertype/recyclablepostreportlist')->with($data);
  }

  public function shortrecyclableReportList(Request $request) {

       $request->validate([
        'start_date' => 'required',
        'end_date' => 'required',
       ]);

    // Ensure that startdate and enddate are provided, otherwise use default values
     $startDate = $request->start_date;
   $endDate = $request->end_date;

    // Fetch the user activity logs within the date range
    $result = RecyclablePost::join('ecosansar_users','ecosansar_users.id','recyclable_posts.user_id')
        ->join('resources', 'resources.id', 'recyclable_posts.resource_type')
        ->select('recyclable_posts.*','ecosansar_users.name as username','resources.resource_name')
        ->whereBetween('recyclable_posts.created_at', [$startDate, $endDate])
        //->where('s_a_b_posts.active','1')
        ->get();

    $data = compact('result');

    return view('admin.usertype.recyclablepostreportlist')->with($data);
}


  public function activityreportlist(){

     $result = UserActivityLog::join('ecosansar_users','ecosansar_users.id','user_activity_logs.user_id')
    //   ->join('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
        // ->join('resources', 'resources.id', 'business_resource_posts.resource_type')
        ->select('user_activity_logs.*','ecosansar_users.name as username')
        ->get();
        
        

      $data=compact('result');

    return view('admin/usertype/activityreportlist')->with($data);
  }
  
    public function adminActivityreportlist()
    {
        $result = AdminActivityLog::with('user')
            ->latest()
            ->get();
    
        return view('admin.usertype.adminactivityreportlist', compact('result'));
    }

  public function shortActivityReportList(Request $request) {

       $request->validate([
        'start_date' => 'required',
        'end_date' => 'required',
       ]);
    // Ensure that startdate and enddate are provided, otherwise use default values
       $startDate = $request->start_date;
   $endDate = $request->end_date;

    // Fetch the user activity logs within the date range
    $result = UserActivityLog::join('ecosansar_users', 'ecosansar_users.id', '=', 'user_activity_logs.user_id')
        ->select('user_activity_logs.*', 'ecosansar_users.name as username')
        ->whereBetween('user_activity_logs.created_at', [$startDate, $endDate])
        ->get();

    // Pass the result to the view
    $data = compact('result');

    return view('admin.usertype.activityreportlist')->with($data);
}


 public function shortAdminActivityReportList(Request $request) {

       $request->validate([
        'start_date' => 'required',
        'end_date' => 'required',
       ]);
    // Ensure that startdate and enddate are provided, otherwise use default values
       $startDate = $request->start_date;
     $endDate = $request->end_date;

    // Fetch the user activity logs within the date range
    $result = AdminActivityLog::with('user')
        ->whereBetween('admin_activity_logs.created_at', [$startDate, $endDate])
        ->get();

    // Pass the result to the view
    $data = compact('result');

    return view('admin.usertype.adminactivityreportlist')->with($data);
}

public function volunteerlist(){
        $result = Volunteer::orderBy('id','DESC')->get();
        return view('admin/volunteer/list',compact('result'));
   }
   public function volunteeradd(){
        $url = route('volunteer.save');
        return view('admin/volunteer/add',compact('url'));
   }
  public function volunteersave(Request $req){

    $category = new Volunteer();
    $category->name = $req->name;
     $category->email = $req->email;
      $category->password = Hash::make($req->password);
       $category->type = 'volunteer';
        $category->added_by = Auth::id();
     $category->description = $req->description;
     if ($req->hasFile('image')) {
        $imageFile = $req->file('image');
        $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
        $s3Directory = 'VolunteerImages';
        $s3Path = $s3Directory . '/' . $imageName;

        // Get the file contents as a stream
        $fileStream = file_get_contents($imageFile->getRealPath());

        // Upload the file to S3 using the put method
        $uploaded = Storage::disk('s3')->put($s3Path, $fileStream);

        if ($uploaded) {
            // Save the S3 file path in the database
            $category->image = $imageName;
        }
    }


    $category->save();
    Alert::success('success','Volunteer Added Successfully');
    return redirect()->route('volunteer.list');
   }
   public function volunteeredit($id){
    $url = route('volunteer.update', $id);
    $category = Volunteer::where('id',$id)->first();
    return view('admin/volunteer/add',compact('url','category'));
   }
   public function volunteerupdate(Request $req, $id){

    $category = Volunteer::find($id);
    $category->name = $req->name;
    $category->email = $req->email;
       if ($req->filled('password')) {
            $category->password = Hash::make($req->password);
        } else {
            $category->password = $category->password;
        }
       $category->type = 'volunteer';
        $category->added_by = Auth::id();
     $category->description = $req->description;
    if ($req->hasFile('image')) {
        $imageFile = $req->file('image');
        $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
        $s3Directory = 'VolunteerImages';
        $s3Path = $s3Directory . '/' . $imageName;

        // Get the file contents as a stream
        $fileStream = file_get_contents($imageFile->getRealPath());

        // Upload the file to S3 using the put method
        $uploaded = Storage::disk('s3')->put($s3Path, $fileStream);

        if ($uploaded) {
            // Save the S3 file path in the database
            $category->image = $imageName;
        }
    }
    $category->save();
    Alert::success('success','Volunteer Updated Successfully');
    return redirect()->route('volunteer.list');
   }

  public function volunteerdelete($id)
   {
        Volunteer::where('id',$id)->delete();

        Alert::success('success','Volunteer Deleted Successfully');
        return redirect('volunteer/list');

   }
    public function volunteerchangeStatus(Request $request)
    {
        $user = Volunteer::find($request->user_id);
        $user->active = $request->status;
        $user->save();
        return response()->json(['success'=>'Status change successfully.']);
    }
    public function adminuserlist(){
        $result = User::orderBy('id','DESC')->where('type','admin')->get();
        return view('admin/adminuser/list',compact('result'));
   }
    public function adminuseradd(){
        $url = route('adminuser.save');
        return view('admin/adminuser/add',compact('url'));
   }
    public function adminusersave(Request $req){
    $req->validate([
        'first_name' => 'required',
    ]);

    $adminuser = new User();
    $adminuser->first_name = $req->first_name;
    $adminuser->last_name = $req->last_name;
    $adminuser->email = $req->email;
    $adminuser->password = Hash::make($req->password);
    $adminuser->type = 'admin';

     if ($req->hasFile('profile_pic')) {
        $imageFile = $req->file('profile_pic');
        $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
        $s3Directory = 'AdminImages';
        $s3Path = $s3Directory . '/' . $imageName;

        // Get the file contents as a stream
        $fileStream = file_get_contents($imageFile->getRealPath());

        // Upload the file to S3 using the put method
        $uploaded = Storage::disk('s3')->put($s3Path, $fileStream);

        if ($uploaded) {
            // Save the S3 file path in the database
            $adminuser->profile_pic = $imageName;
        }
    }
    $adminuser->save();
    Alert::success('success','Admin Added Successfully');
    return redirect()->route('adminuser.list');
   }
   public function requestfulfilledlist(){
      $recyclablePosts = RecyclablePost::
        join('resources', 'resources.id', '=', 'recyclable_posts.resource_type')
         ->join('weights', 'recyclable_posts.quantity', '=', 'weights.id')
      ->select('recyclable_posts.*', 'resources.resource_name','weights.min_weight', 'weights.min_measure', 'weights.max_weight','weights.max_measure')

        ->where('request_fulfilled', 1)
        ->get()
        ->map(function ($item) {
            $item->source = 'recyclable';
            return $item;
        });

    $reusablePosts = ReusablePost::
        join('resources', 'resources.id', '=', 'reusable_posts.resource_type')
         ->join('weights', 'reusable_posts.quantity', '=', 'weights.id')
      ->select('reusable_posts.*', 'resources.resource_name','weights.min_weight', 'weights.min_measure', 'weights.max_weight','weights.max_measure')

        ->where('request_fulfilled', 1)
        ->get()
        ->map(function ($item) {
            $item->source = 'reusable';
            return $item;
        });


        $combinedPosts = $recyclablePosts->concat($reusablePosts);

        return view('admin/requestfulfilled/list', compact('combinedPosts'));

   }
   // List Page
    public function ourImpact()
    {
        $impacts = OurImpact::orderBy('display_order', 'ASC')->get();
        
         $userid = Auth::id();
        if ($userid){
            $userActivity = new AdminActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Viewed Our Impact page management';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        return view('admin.ourimpact.index', compact('impacts'));
    }

    // Add / Update
    public function saveOurImpact(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'count' => 'required|numeric',
            'description' => 'required',
            'display_order' => [
                'required',
                'numeric',
                Rule::unique('our_impacts', 'display_order')->ignore($request->id),
            ],
            'status' => 'required|in:0,1',
        ],[
            'title.required' => 'Please enter the title.',
            'count.required' => 'Please enter the count.',
            'count.numeric' => 'Count must be a number.',
            'description.required' => 'Please enter the description.',
            'display_order.required' => 'Please enter the display order.',
            'display_order.unique' => 'This display order already exists.',
            'status.required' => 'Please select the status.',
        ]);

        OurImpact::updateOrCreate(
            ['id' => $request->id],
            [
                'title' => $request->title,
                'count' => $request->count,
                'suffix' => $request->suffix,
                'description' => $request->description,
                'display_order' => $request->display_order,
                'status' => $request->status,
            ]
        );
        
         $userid = Auth::id();
        if ($userid){
            $userActivity = new AdminActivityLog();
            $userActivity->user_id = $userid;
           $userActivity->activity = $request->id
    ? 'Updated Our Impact section'
    : 'Added new Our Impact section';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        return redirect()->route('admin.ourimpact.index')
                         ->with('success', 'Our Impact saved successfully.');
    }
    
    public function editOurImpact($id)
    {
        $impacts = OurImpact::orderBy('display_order')->get();
    
        $editImpact = OurImpact::findOrFail($id);
        
         $userid = Auth::id();
        if ($userid){
            $userActivity = new AdminActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Opened Our Impact section for editing'.$id;
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end
    
        return view('admin.ourimpact.index', compact('impacts', 'editImpact'));
    }

    // Delete
    public function deleteOurImpact($id)
    {
        $impact = OurImpact::findOrFail($id);

        $impact->delete();
         $userid = Auth::id();
        if ($userid){
            $userActivity = new AdminActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Deleted Our Impact section'.$id;
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        return redirect()->route('admin.ourimpact.index')
                         ->with('success', 'Our Impact deleted successfully.');
    }

}
