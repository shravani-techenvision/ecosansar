<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Faq;
use App\Models\admin\Category;
use RealRashid\SweetAlert\Facades\Alert;

class FaqController extends Controller
{
    public function list(){
        $result = Faq::select('faqs.*','categories.category_name')
        ->join('categories', 'faqs.category', '=', 'categories.id')
        ->orderBy('id','DESC')
        ->get();
        return view('admin/faq/list',compact('result'));
    }
    public function add(){
        $url = route('faq.save');
        $category = Category::get();
        return view('admin/faq/add',compact('url','category'));
    }
    public function save(Request $req){
        $req->validate([
            'category' => 'required',
            'question' => 'required',
            'answer' => 'required',
        ]);
        $faq = new Faq();
        $faq->category = $req->category;
        $faq->question = $req->question;
        $faq->answer = $req->answer;
        $faq->save();
        Alert::success('success','FAQ Added Successfully');
        return redirect()->route('faq.list');
    }
    public function edit($id){
        $url = route('faq.update', $id);
        $faq = Faq::where('id',$id)->first();
        
        $category = Category::get();
        return view('admin/faq/add',compact('url','faq','category'));
    }
    public function update(Request $req, $id){
        $req->validate([
            'category' => 'required',
            'question' => 'required',
            'answer' => 'required',
        ]);
        $faq = Faq::find($id);
        $faq->category = $req->category;
        $faq->question = $req->question;
        $faq->answer = $req->answer;
        $faq->save();
        Alert::success('success','FAQ Updated Successfully');
        return redirect()->route('faq.list');
    }
    public function delete($id){
        Faq::where('id',$id)->delete();
        Alert::success('success','FAQ Deleted Successfully');
        return redirect()->route('faq.list');
    }
}
