<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Resource;
use RealRashid\SweetAlert\Facades\Alert;

class ResourceController extends Controller
{
    public function list(){
        $result = Resource::orderBy('id','DESC')->get();
        return view('admin/resource/list',compact('result'));
    }
    public function add(){
        $url = route('resource.save');
        return view('admin/resource/add',compact('url'));
    }
    public function save(Request $req){
        $req->validate([
            'resource_name' => 'required',
        ]);
        $resource = new Resource();
        $resource->resource_name = $req->resource_name;
        $resource->save();
        Alert::success('success','Resource Added Successfully');
        return redirect()->route('resource.list');
    }
    public function edit($id){
        $url = route('resource.update', $id);
        $resource = Resource::where('id',$id)->first();
        return view('admin/resource/add',compact('url','resource'));
    }
    public function update(Request $req, $id){
        $req->validate([
            'resource_name' => 'required',
        ]);
        $resource = Resource::find($id);
        $resource->resource_name = $req->resource_name;
        $resource->save();
        Alert::success('success','Resource Updated Successfully');
        return redirect()->route('resource.list');
    }
    public function delete($id){
        Resource::where('id',$id)->delete();
        Alert::success('success','Resource Deleted Successfully');
        return redirect()->route('resource.list');
    }
}
