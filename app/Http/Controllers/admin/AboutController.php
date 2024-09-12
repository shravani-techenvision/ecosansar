<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\About;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class AboutController extends Controller
{
    public function list(){
        $result = About::orderBy('id','DESC')->get();
        return view('admin/about/list',compact('result'));
    }
    public function add(){
        $url = route('about.save');
        return view('admin/about/add',compact('url'));
    }
    public function save(Request $req){
        $req->validate([
            'content' => 'required',
        ]);
        $htmlContent = $req->content;
        $modifiedContent = Str::replaceFirst('../assets/', '/assets/', $htmlContent);
        $about = new About();
        $about->content = $req->content;;
        $about->save();
        Alert::success('success','About content added successfully');
        return redirect()->route('about.add');
    }
    public function edit($id){
        $url = route('about.update',$id);
        $about = About::where('id',$id)->first();
        return view('admin/about/add',compact('url','about'));
    }
    public function update(Request $req, $id){
        $req->validate([
            'content' => 'required',
        ]);
        $about = About::find($id);
        $about->content = $req->content;
        $about->save();
        Alert::success('success','About content updated successfully');
        return redirect()->route('about.edit',$id);
    }
    public function delete($id){
        About::where('id',$id)->delete();
        Alert::success('success','About content deleted successfully');
        return redirect()->route('about.edit');
    }
}
