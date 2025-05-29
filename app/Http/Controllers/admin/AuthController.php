<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Auth;
use App\Models\User;
use App\Models\admin\Volunteer;
use App\Models\frontend\EcosansarUsers;
use App\Models\frontend\RecyclablePost;
use App\Models\frontend\RecyclableReview;
 use App\Models\frontend\ReusablePost;
use App\Rules\MatchOldPassword;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function  admin_login(){
        return view('admin.auth.login');
    }
    public function admin_store(Request $request)
{
    $input = $request->all();

    // Validate input
    $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required|min:8',
    ]);

    // Check in the users table
    $user = \App\Models\User::where('email', $input['email'])->first();
    if ($user) {
        if ($user->active != 1) {
            return redirect()->route('admin_login')->withErrors([
                'email' => 'Your account is inactive. Please contact the administrator.',
            ]);
        }

        if (auth()->attempt(['email' => $input['email'], 'password' => $input['password']])) {
            if (auth()->user()->type == 'superadmin') {
                return redirect()->route('admin_dashboard');
            } else {
                return redirect()->route('admin_dashboard');
            }
        } else {
            return redirect()->route('admin_login')->withErrors([
                'password' => 'You have entered an incorrect password.',
            ]);
        }
    }

    // Check in the volunteers table
    $volunteer = \App\Models\admin\Volunteer::where('email', $input['email'])->first();
    if ($volunteer) {
        if ($volunteer->active != 1) {
            return redirect()->route('admin_login')->withErrors([
                'email' => 'Your volunteer account is inactive. Please contact the administrator.',
            ]);
        }

        if (\Hash::check($input['password'], $volunteer->password)) {
            auth('volunteer')->loginUsingId($volunteer->id); // Log in the volunteer user
            return redirect()->route('volunteer_dashboard'); // Redirect to volunteer dashboard
        } else {
            return redirect()->route('admin_login')->withErrors([
                'password' => 'You have entered an incorrect password.',
            ]);
        }
    }

    // If no user or volunteer is found
    return redirect()->route('admin_login')->withErrors([
        'email' => 'The selected email does not exist.',
        'password' => 'You have entered an incorrect password.',
    ]);
}

        public function admin_dashboard (){
            
            $users = EcosansarUsers::where('is_delete','0')->count();
            
            $Resourceusers = EcosansarUsers::where('user_type','sab')->where('is_delete','0')->count();
            $Contributorusers = EcosansarUsers::where('user_type','consumer')->where('is_delete','0')->count();
            $Corporateusers = EcosansarUsers::where('user_type','business')->where('is_delete','0')->count();
            
            $recyclablepost = RecyclablePost::where('active','1')->count();
            $reusablepost = ReusablePost::where('active','1')->count();
            
            
             
            $data=compact('users','Resourceusers','Contributorusers', 'Corporateusers', 'recyclablepost','reusablepost');
            
            return view('index')->with($data);
        }
         public function adminuser_dashboard (){
            
            $users = EcosansarUsers::where('is_delete','0')->count();
            
            $Resourceusers = EcosansarUsers::where('user_type','sab')->where('is_delete','0')->count();
            $Contributorusers = EcosansarUsers::where('user_type','consumer')->where('is_delete','0')->count();
            $Corporateusers = EcosansarUsers::where('user_type','business')->where('is_delete','0')->count();
            
            $Contributorpost = RecyclablePost::where('active','1')->count();
            $Resourcepost =ReusablePost::where('active','1')->count();
             
            
            $totalpostCount = $Resourcepost + $Contributorpost;
             
            $data=compact('users','Resourceusers','Contributorusers','Corporateusers','totalpostCount','Resourcepost','Contributorpost','Corporatepost');
            
            return view('index')->with($data);
        }
         public function volunteer_dashboard (){
            
            $users = EcosansarUsers::where('is_delete','0')->count();
            
            $Resourceusers = EcosansarUsers::where('user_type','sab')->where('is_delete','0')->count();
            $Contributorusers = EcosansarUsers::where('user_type','consumer')->where('is_delete','0')->count();
            $Corporateusers = EcosansarUsers::where('user_type','business')->where('is_delete','0')->count();
            
            $Contributorpost = RecyclablePost::where('active','1')->count();
            $Resourcepost = ReusablePost::where('active','1')->count();
             
            
            $totalpostCount = $Resourcepost + $Contributorpost ;
             
            $data=compact('users','Resourceusers','Contributorusers','Corporateusers','totalpostCount','Resourcepost','Contributorpost','Corporatepost');
            
            return view('index')->with($data);
        }
        public function admin_profile($id)
        {
            $url=route('admin_profile_update',$id);

            // $user=User::where('id',$id)->where('type','superadmin')->first();
             $user=User::where('id',$id)->first();
            // echo "<pre>";
            // print_r($user->first_name);die;
            $data=compact('url','user');

            return view('admin/profile')->with($data);
        }
        public function admin_profile_update(Request $request,$id)
        {

            $request->validate([
                'first_name' => 'required',
                'email' => 'required',
                'password' => $request->filled('password') ? 'min:8' : '', // Conditional validation
                // 'profile_pic' =>'required'
            ]);

            $user = User::find($id);
            $user->first_name=$request->first_name;
            $user->last_name=$request->last_name;
            $user->email=$request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            } else {
                $user->password = $user->password;
            }
            
            if ($request->hasFile('profile_pic')) {
        $imageFile = $request->file('profile_pic');
        $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
        $s3Directory = 'AdminImages';
        $s3Path = $s3Directory . '/' . $imageName;

        // Get the file contents as a stream
        $fileStream = file_get_contents($imageFile->getRealPath());

        // Upload the file to S3 using the put method
        $uploaded = Storage::disk('s3')->put($s3Path, $fileStream);

        if ($uploaded) {
            // Save the S3 file path in the database
             $user->profile_pic = $imageName;
        }
    }
            $user->save();
            Alert::success('Success','Admin Information Updated Successfully');
             return redirect()->route('admin_dashboard');
        }
        public function adminuser_profile($id)
        {
            $url=route('adminuser_profile_update',$id);

            // $user=User::where('id',$id)->where('type','superadmin')->first();
             $user=User::where('id',$id)->first();
            // echo "<pre>";
            // print_r($user->first_name);die;
            $data=compact('url','user');

            return view('admin/profile')->with($data);
        }
        public function adminuser_profile_update(Request $request,$id)
        {

            $request->validate([
                'first_name' => 'required',
                'email' => 'required',
                'password' => $request->filled('password') ? 'min:8' : '', // Conditional validation
                // 'profile_pic' =>'required'
            ]);

            $user = User::find($id);
            $user->first_name=$request->first_name;
            $user->last_name=$request->last_name;
            $user->email=$request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            } else {
                $user->password = $user->password;
            }
            
            if ($request->hasFile('profile_pic')) {
        $imageFile = $request->file('profile_pic');
        $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
        $s3Directory = 'AdminImages';
        $s3Path = $s3Directory . '/' . $imageName;

        // Get the file contents as a stream
        $fileStream = file_get_contents($imageFile->getRealPath());

        // Upload the file to S3 using the put method
        $uploaded = Storage::disk('s3')->put($s3Path, $fileStream);

        if ($uploaded) {
            // Save the S3 file path in the database
             $user->profile_pic = $imageName;
        }
    }
            $user->save();
            Alert::success('Success','Admin Information Updated Successfully');
             return redirect()->route('adminuser_dashboard');
        }
         public function volunteer_profile($id)
        {
            $url=route('volunteer_profile_update',$id);

            // $user=User::where('id',$id)->where('type','superadmin')->first();
             $category=Volunteer::where('id',$id)->first();
            // echo "<pre>";
            // print_r($user);die;
            $data=compact('url','category');

            return view('admin/volunteer/add')->with($data);
        }
        public function volunteer_profile_update(Request $request,$id)
        {

            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => $request->filled('password') ? 'min:8' : '', // Conditional validation
                // 'profile_pic' =>'required'
            ]);

            $category = Volunteer::find($id);
            $category->name = $request->name;
            $category->email = $request->email;
            if ($request->filled('password')) {
                $category->password = Hash::make($request->password);
            } else {
                $category->password = $category->password;
            }
            
           $category->type = 'volunteer';
        $category->added_by = Auth::id();
     $category->description = $request->description;
    if ($request->hasFile('image')) {
        $imageFile = $request->file('image');
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
            Alert::success('Success','Volunteer Information Updated Successfully');
             return redirect()->route('volunteer_dashboard');
        }
        
        public function changepassword(){
             $url=route('changepassword_store');
            
            return view('admin/changepassword',compact('url'));
        }
        public function changePassword_store(Request $request)
        {
            // echo "<pre>";
            // print_r($request->all());die;
            $request->validate([
                'password' => ['required', new MatchOldPassword],
                'new_password' => ['required','min:8',],
                'confirm_password' => ['same:new_password'],
            ]);

            $valuerpass = User::find(Auth::id());
            $valuerpass->password=$request->password;
            $valuerpass->password=$request->new_password;
            $valuerpass->password=Hash::make($request->confirm_password);
            $valuerpass->save();

            Alert::success('Success','Password Updated Successfully');
             return redirect()->route('admin_dashboard');
        }
        public function adminchangepassword(){
              $url=route('adminchangepassword_store');
            return view('admin/changepassword',compact('url'));
        }
        public function adminchangePassword_store(Request $request)
        {
            // echo "<pre>";
            // print_r($request->all());die;
            $request->validate([
                'password' => ['required', new MatchOldPassword],
                'new_password' => ['required','min:8',],
                'confirm_password' => ['same:new_password'],
            ]);

            $valuerpass = User::find(Auth::id());
            $valuerpass->password=$request->password;
            $valuerpass->password=$request->new_password;
            $valuerpass->password=Hash::make($request->confirm_password);
            $valuerpass->save();

            Alert::success('Success','Password Updated Successfully');
             return redirect()->route('adminuser_dashboard');
        }

     public function signOut() {
        Session::flush();
        Auth::logout();
         return Redirect('admin_login');
    }
     public function changeAdminStatus(Request $req)
    {
        //dd($item);
        $doc = User::find($req->user_id);
        $doc->active = $req->status;
        $doc->save();
    }
    public function changeVolunteerStatus(Request $req)
    {
        //dd($item);
        $doc = Volunteer::find($req->user_id);
        $doc->active = $req->status;
        $doc->save();
    }
}


