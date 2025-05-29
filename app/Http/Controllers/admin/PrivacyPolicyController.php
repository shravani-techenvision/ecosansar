<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\PrivacyPolicy;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class PrivacyPolicyController extends Controller
{
    public function add(){
        $url = route('privacypolicy.save');
        return view('admin/privacypolicy/add',compact('url'));
    }
    public function save(Request $req){
        $req->validate([
            'content' => 'required',
        ]);
        $htmlContent = $req->content;
        $modifiedContent = Str::replaceFirst('../assets/', '/assets/', $htmlContent);
        $about = new PrivacyPolicy();
        $about->content = $req->content;;
        $about->save();
        Alert::success('success','PrivacyPolicy content added successfully');
        return redirect()->route('privacypolicy.add');
    }
    public function edit($id){
        $url = route('privacypolicy.update',$id);
        $about = PrivacyPolicy::where('id',$id)->first();
        return view('admin/privacypolicy/add',compact('url','about'));
    }
    public function update(Request $req, $id){
        $req->validate([
            'content' => 'required',
        ]);
        $about = PrivacyPolicy::find($id);
        $about->content = $req->content;
        $about->save();
        Alert::success('success','PrivacyPolicy content updated successfully');
        return redirect()->route('privacypolicy.edit',$id);
    }
   
}
