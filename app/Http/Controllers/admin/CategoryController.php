<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Faq;
use App\Models\admin\Category;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
   public function list(){
        $result = Category::orderBy('id','DESC')->get();
        return view('admin/category/list',compact('result'));
   }
   public function add(){
        $url = route('category.save');
        return view('admin/category/add',compact('url'));
   }
   public function save(Request $req){
    $req->validate([
        'category_name' => 'required',
    ]);
    $category = new Category();
    $category->category_name = $req->category_name;
    $category->save();
    Alert::success('success','Category Added Successfully');
    return redirect()->route('category.list');
   }
   public function edit($id){
    $url = route('category.update', $id);
    $category = Category::where('id',$id)->first();
    return view('admin/category/add',compact('url','category'));
   }
   public function update(Request $req, $id){
    $req->validate([
        'category_name' => 'required',
    ]);
    $category = Category::find($id);
    $category->category_name = $req->category_name;
    $category->save();
    Alert::success('success','Category Updated Successfully');
    return redirect()->route('category.list');
   }
   public function delete($id) {
    // Check if there are any FAQs associated with the category
    $faqs = Faq::where('category', $id)->get();

    // If FAQs exist, soft delete them
    if ($faqs->count() > 0) {
        foreach ($faqs as $faq) {
            $faq->delete(); // Soft delete each FAQ
        }
    }

    // Soft delete the category
    $category = Category::find($id);
    $category->delete();

    // Display success message
    Alert::success('success', 'Category and associated FAQs soft deleted successfully');

    // Redirect to the category list page
    return redirect()->route('category.list');
}

}
