<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\ReusableResource;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\frontend\ReusableItemEnquiry;

class ReusableResourceController extends Controller
{
     public function list(){
        $result = ReusableResource::orderBy('id','DESC')->get();
        return view('admin/reusableresource/list',compact('result'));
    }
    public function add(){
        $url = route('reusable_resource.save');
        return view('admin/reusableresource/add',compact('url'));
    }
    public function save(Request $req){
        $req->validate([
            'reusable_resource_name' => 'required',
        ]);
        $resource = new ReusableResource();
        $resource->reusable_resource_name = $req->reusable_resource_name;
        $resource->save();
        Alert::success('success','Resource Added Successfully');
        return redirect()->route('reusable_resource.list');
    }
    public function edit($id){
        $url = route('reusable_resource.update', $id);
        $resource = ReusableResource::where('id',$id)->first();
        return view('admin/reusableresource/add',compact('url','resource'));
    }
    public function update(Request $req, $id){
        $req->validate([
            'reusable_resource_name' => 'required',
        ]);
        $resource = ReusableResource::find($id);
        $resource->reusable_resource_name = $req->reusable_resource_name;
        $resource->save();
        Alert::success('success','Resource Updated Successfully');
        return redirect()->route('reusable_resource.list');
    }
    public function delete($id){
        ReusableResource::where('id',$id)->delete();
        Alert::success('success','Resource Deleted Successfully');
        return redirect()->route('reusable_resource.list');
    }
     public function reusableEnquiryList()
    {
        $result = ReusableItemEnquiry::latest()->get();

        return view('admin.reusableresource.reusable_item_enquiry_list', compact('result'));
    }
    
    public function enquiryDestroy($id)
    {
        $enquiry = ReusableItemEnquiry::find($id);
    
        if (!$enquiry) {
            return redirect()->back()->with('error', 'Enquiry not found.');
        }
    
        $enquiry->delete();
        Alert::success('success','Resource enquiry deleted successfully.');
        return redirect()->back();
    }
}
