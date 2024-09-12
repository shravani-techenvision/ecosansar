<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\frontend\EcosansarUsers;
use App\Models\frontend\BusinessPost;
use App\Models\frontend\SABPost;
use App\Models\frontend\SABReview;
use App\Models\frontend\ConsumerPost;
use App\Models\frontend\ConsumerReview;
use App\Models\frontend\UserActivityLog;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use App\Models\frontend\UserContact;

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
    
    return view('admin/usertype/businesslist',compact('result'));
  }
  
  public function edituser($id){
    $url = route('user.updateuser', $id);
    $user = EcosansarUsers::where('id',$id)->first();
    // echo "<pre>";
    // print_r($user);
    // die;
    return view('admin/usertype/adduser',compact('url','user'));
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
    return view('admin/usertype/sablist',compact('result'));
  }
  public function consumerlist(){
    $result = EcosansarUsers::where('user_type','consumer')->where('is_delete','0')
     ->orderBy('id','desc')->get();
    
    return view('admin/usertype/consumerlist',compact('result'));
  }
  public function changeStatus(Request $request)
    {
        $user = EcosansarUsers::find($request->user_id);
        $user->is_checked = $request->status;
        $user->save();
        return response()->json(['success'=>'Status change successfully.']);
    }
  public function businessview($id){
    $users = EcosansarUsers::where('id', $id)->first();
    $data=compact('users');
    return view('admin/usertype/businessview')->with($data);
  }
  public function sabview($id){
    $users = EcosansarUsers::where('id', $id)->first();
    $data=compact('users');
    return view('admin/usertype/sabview')->with($data);
  }
  public function consumerview($id){
    $users = EcosansarUsers::where('id', $id)->first();
    $data=compact('users');
    return view('admin/usertype/consumerview')->with($data);
  }
  public function businessposts(){
    $result = BusinessPost::orderBy('id','desc')->get();
   
    return view('admin/usertype/businesspostslist',compact('result'));
  }
  public function sabposts(){
    $result = SABPost::orderBy('id','desc')->get();
    return view('admin/usertype/sabpostslist',compact('result'));
  }
  public function consumerposts(){
    $result = ConsumerPost::orderBy('id','desc')->get();
    return view('admin/usertype/consumerpostslist',compact('result'));
  }
  public function businesspostsview($id){
    $users = BusinessPost::join('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
       ->join('resources', 'resources.id', 'business_resource_posts.resource_type')
        ->join('weights', 'business_posts.quantity', '=', 'weights.id')
      ->select('business_posts.*', 'resources.resource_name','weights.min_weight', 'weights.min_measure', 'weights.max_weight','weights.max_measure','business_resource_posts.resource_img')
      ->where('business_posts.id', $id)->first();
        
    $postimg = DB::table('business_resource_posts')
     ->join('resources', 'resources.id', 'business_resource_posts.resource_type')
      ->select('business_resource_posts.*', 'resources.resource_name')
    ->where('business_resource_posts.user_id', $users->user_id)
    ->where('business_resource_posts.post_id',$id)->get();
    
    // echo"<pre>";
    // print_r($postimg);
    // die;
    
    $data=compact('users','postimg');
    return view('admin/usertype/businesspostsview')->with($data);
  }
  public function sabpostsview($id){
       
    $users = SABPost::join('s_a_b_resource_posts', 's_a_b_resource_posts.post_id', 's_a_b_posts.id')
       ->join('resources', 'resources.id', 's_a_b_resource_posts.resource_type')
        ->join('weights', 's_a_b_posts.quantity', '=', 'weights.id')
      ->select('s_a_b_posts.*', 'resources.resource_name','weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
        ->where('s_a_b_posts.id', $id)
        ->first();
  
    $postimg = DB::table('s_a_b_resource_posts')
    ->join('resources', 'resources.id', 's_a_b_resource_posts.resource_type')
    ->select('s_a_b_resource_posts.*', 'resources.resource_name')
    ->where('s_a_b_resource_posts.user_id', $users->user_id)
    ->where('s_a_b_resource_posts.post_id',$id)->get();
    
    $data=compact('users','postimg');
    return view('admin/usertype/sabpostsview')->with($data);
  }
  public function consumerpostsview($id){
      
    $users = ConsumerPost::join('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
       ->join('resources', 'resources.id', 'consumer_resource_posts.resource_type')
        ->join('weights', 'consumer_posts.quantity', '=', 'weights.id')
        ->select('consumer_posts.*', 'resources.resource_name','weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
        ->where('consumer_posts.id', $id)
        ->first();
        
    $postimg = DB::table('consumer_resource_posts')
    ->join('resources', 'resources.id', 'consumer_resource_posts.resource_type')
    ->select('consumer_resource_posts.*', 'resources.resource_name')
    ->where('consumer_resource_posts.user_id', $users->user_id)
    ->where('consumer_resource_posts.post_id',$id)->get();
        
    $data=compact('users','postimg');
    return view('admin/usertype/consumerpostsview')->with($data);
  }
  public function sabreviews(){
    $result = SABReview::join('s_a_b_posts','s_a_b_posts.id','s_a_b_reviews.post_id')
    ->join('ecosansar_users','ecosansar_users.id','s_a_b_posts.user_id')
    ->select('s_a_b_reviews.*','s_a_b_posts.name','ecosansar_users.name as username')
    ->get();
    return view('admin/usertype/sabreview',compact('result'));
  }
  public function consumerreviews(){
    $result = ConsumerReview::join('consumer_posts','consumer_posts.id','consumer_reviews.post_id')
    ->join('ecosansar_users','ecosansar_users.id','consumer_posts.user_id')
    ->select('consumer_reviews.*','consumer_posts.name','ecosansar_users.name as username')
    ->get();
    return view('admin/usertype/consumerreview',compact('result'));
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
  
  
  
  public function sabpostreportlist(){
      
     $result = SABPost::join('ecosansar_users','ecosansar_users.id','s_a_b_posts.user_id')
       ->join('s_a_b_resource_posts', 's_a_b_resource_posts.post_id', 's_a_b_posts.id')
        ->join('resources', 'resources.id', 's_a_b_resource_posts.resource_type')
        ->select('s_a_b_posts.*','ecosansar_users.name as username','resources.resource_name')
        ->get();
        
       // print_r($result);
         
      $data=compact('result');
    
    return view('admin/usertype/sabpostreportlist')->with($data);
  }
  
  public function shortsabReportList(Request $request) {
      
       $request->validate([
        'start_date' => 'required',
        'end_date' => 'required',
       ]);
    // Ensure that startdate and enddate are provided, otherwise use default values
     $startDate = $request->start_date;
   $endDate = $request->end_date;

    // Fetch the user activity logs within the date range
    $result = SABPost::join('ecosansar_users','ecosansar_users.id','s_a_b_posts.user_id')
       ->join('s_a_b_resource_posts', 's_a_b_resource_posts.post_id', 's_a_b_posts.id')
        ->join('resources', 'resources.id', 's_a_b_resource_posts.resource_type')
        ->select('s_a_b_posts.*','ecosansar_users.name as username','resources.resource_name')
        ->whereBetween('s_a_b_posts.post_date', [$startDate, $endDate])
        //->where('s_a_b_posts.active','1')
        ->get();

    $data = compact('result');
    
    return view('admin.usertype.consumerpostreportlist')->with($data);
}
  
  public function businesspostreportlist(){
      
     $result22 = BusinessPost::join('ecosansar_users','ecosansar_users.id','business_posts.user_id')
      ->join('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
        ->join('resources', 'resources.id', 'business_resource_posts.resource_type')
        ->select('business_posts.*','ecosansar_users.name as username','resources.resource_name')
        ->get();
    
    $result = BusinessPost::join('ecosansar_users', 'ecosansar_users.id', '=', 'business_posts.user_id')
    ->join('business_resource_posts', 'business_resource_posts.post_id', '=', 'business_posts.id')
    ->join('resources', 'resources.id', '=', 'business_resource_posts.resource_type')
    ->select('business_posts.*', 'ecosansar_users.name as username', DB::raw('GROUP_CONCAT(resources.resource_name SEPARATOR ", ") as resource_names'))
    ->groupBy('business_posts.id', 'business_posts.user_id','ecosansar_users.name')
    ->get();
    
    // echo "<pre>";
    // print_r($result);
    // die;
         
      $data=compact('result');
    
    return view('admin/usertype/businesspostreportlist')->with($data);
  }
  
  public function shortbusinessReportList(Request $request) {
      
       $request->validate([
        'start_date' => 'required',
        'end_date' => 'required',
       ]);
       
    // Ensure that startdate and enddate are provided, otherwise use default values
     $startDate = $request->start_date;
   $endDate = $request->end_date;

    // Fetch the user activity logs within the date range
    $result = BusinessPost::join('ecosansar_users','ecosansar_users.id','business_posts.user_id')
       ->join('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
        ->join('resources', 'resources.id', 'business_resource_posts.resource_type')
        ->select('business_posts.*','ecosansar_users.name as username','resources.resource_name')
        ->whereBetween('business_posts.post_date', [$startDate, $endDate])
        //->where('s_a_b_posts.active','1')
        ->get();

    $data = compact('result');
    
    return view('admin.usertype.businesspostreportlist')->with($data);
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

  
  
  
  
  
}
