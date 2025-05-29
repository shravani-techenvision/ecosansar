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
use App\Models\User;
use App\Models\admin\SubscriptionModule;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use App\Models\frontend\UserContact;
use Illuminate\Support\Facades\Storage;
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
  public function reusableposts(){
    $result = ReusablePost::where('active',1)->orderBy('id','desc')->get();
    return view('admin/usertype/reusablepostslist',compact('result'));
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
       
    $users = ReusablePost:: 
       join('resources', 'resources.id', 'reusable_posts.resource_type')
        ->join('weights', 'reusable_posts.quantity', '=', 'weights.id')
      ->select('reusable_posts.*', 'resources.resource_name','weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
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

 public function volunteerlist(){
        $result = Volunteer::orderBy('id','DESC')->get();
        return view('admin/volunteer/list',compact('result'));
   }
   public function volunteeradd(){
        $url = route('volunteer.save');
        return view('admin/volunteer/add',compact('url'));
   }  
  public function volunteersave(Request $req){
    $req->validate([
        'name' => 'required',
        'email' => 'required',
        'password' => 'required'
    ]);
     
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
    $req->validate([
        'name' => 'required',
         'email' => 'required',
         
    ]);
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
  
}
