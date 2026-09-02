<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Service;
use App\Models\frontend\ServiceEnquiry;
use App\Models\frontend\CollectionDrive;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use App\Models\frontend\UserActivityLog;

class ServiceController extends Controller
{
    public function collectionDriveList(){
        $result = CollectionDrive::orderBy('id','DESC')->get();
        return view('admin/service/service_enquiry_list',compact('result'));
    }
    public function deleteCollectionDriveEnquiry($id)
    {
        $enquiry = CollectionDrive::findOrFail($id);
    
        $enquiry->delete();
        $userid = Auth::id();
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Deleted Collection Drive Poster enquiry'.$id;
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end
    
        Alert::success('success', 'Enquiry deleted successfully.');
        return redirect()->route('service_enquiry.list');
    }
   public function list(){
        $result = Service::orderBy('id','DESC')->get();
        return view('admin/service/list',compact('result'));
    }
    public function add(){
        $url = route('service.save');
        return view('admin/service/add',compact('url'));
    }
    public function save(Request $req){
        $req->validate([
            'content' => 'required',
        ]);
        $htmlContent = $req->content;
        $modifiedContent = Str::replaceFirst('../assets/', '/assets/', $htmlContent);
        $about = new Service();
        $about->content = $req->content;;
        $about->save();
        Alert::success('success','Service content added successfully');
        return redirect()->route('service.add');
    }
    public function edit($id){
        $url = route('service.update',$id);
        $about = Service::where('id',$id)->first();
        return view('admin/service/add',compact('url','about'));
    }
    public function update(Request $req, $id){
        $req->validate([
            'content' => 'required',
        ]);
        $about = Service::find($id);
        $about->content = $req->content;
        $about->save();
        Alert::success('success','Service content updated successfully');
        return redirect()->route('service.edit',$id);
    }
    public function delete($id){
        Service::where('id',$id)->delete();
        Alert::success('success','Service content deleted successfully');
        return redirect()->route('service.edit');
    }
    //  public function service_enquiry(){
    //     $result = ServiceEnquiry::orderBy('id','DESC')->get();
    //     return view('admin/service/service_enquiry_list',compact('result'));
    // }
}
