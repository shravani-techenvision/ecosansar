<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\BlogCategory;
use App\Models\admin\BlogTag;
use App\Models\admin\Volunteer;
use App\Models\admin\Blog;
use App\Models\frontend\Comment;
use App\Models\frontend\CommentReply;
use RealRashid\SweetAlert\Facades\Alert;
use Str;

class BlogController extends Controller
{
    public function blog_category_list(){

        $blog_category = BlogCategory::orderBy('id', 'DESC')->get();
        // echo'<pre>';
        // print_r($state);
        // die;
        $data = compact('blog_category');
        return view('admin.blog.category_list')->with($data);
    }
     public function blog_category_add(){
        $url = route('blog.blog_category_save');
        return view('admin/blog/category_add',compact('url'));
    }
     public function blog_category_save(Request $req){
        $req->validate([
            'category_name' => 'required|unique:blog_categories,category_name',
        ]);
        $slug = str_replace(' ','-',$req->category_name);
        $blogcategory = new BlogCategory();
        $blogcategory->category_name = $req->category_name;
        $blogcategory->bc_slug = $slug;
        $blogcategory->save();
        Alert::success('success','Category Added Successfully');
        return redirect()->route('blog.blog_category_list');
    }
    public function blog_category_edit($id){
        $url = route('blog.blog_category_update', $id);
        $blogcategory = BlogCategory::where('id',$id)->first();
        return view('admin/blog/category_add',compact('url','blogcategory'));
    }
    public function blog_category_update(Request $req, $id){
         $blogcategory = BlogCategory::find($id);
         $currentCategoryName = strtolower($blogcategory->category_name);
    $newCategoryName = strtolower($req->category_name);
        if ($newCategoryName === $currentCategoryName) {
             $req->validate([
            'category_name' => 'required',
        ]);
         }else{
            $req->validate([
            'category_name' => 'required|unique:blog_categories,category_name',
        ]);
         }

         $blogcategory = BlogCategory::find($id);
         $slug = str_replace(' ','-',$req->category_name);
         $blogcategory->category_name = $req->category_name;
         $blogcategory->bc_slug = $slug;
        $blogcategory->save();
        Alert::success('success','Category Updated Successfully');
        return redirect()->route('blog.blog_category_list');
    }

public function blog_category_delete($id)
{
    // Find the category
    $category = BlogCategory::find($id);

    if ($category) {
        // Define the "Uncategorized" category ID
        $uncategorizedCategoryId = 11; // Change this to your actual "Uncategorized" category ID
        // Get all posts with the deleted category
        $posts = Blog::whereRaw("FIND_IN_SET(?, category)", [$id])->get();

        foreach ($posts as $post) {
            $categories = explode(',', $post->category);

            if (count($categories) === 1 && $categories[0] == $id) {
                // If the post has only the deleted category, assign the "Uncategorized" category
                $post->category = $uncategorizedCategoryId;
            } else {
                // Remove the deleted category from the array
                $categories = array_diff($categories, [$id]);

                // Update the post's category field with the remaining categories
                $post->category = implode(',', $categories);
            }

            $post->save();
        }

        // Delete the category
        $category->delete();

        // Show a success alert message
        Alert::success('success', 'Category Deleted Successfully. Posts with this single category were reassigned to "Uncategorized", and posts with multiple categories were updated.');

        // Redirect to the category list
        return redirect()->route('blog.blog_category_list');
    }

    // If the category does not exist, show an error message
    Alert::error('error', 'Category not found.');
    return redirect()->route('blog.blog_category_list');
}




    public function blog_tag_list(){

        $blog_tag = BlogTag::orderBy('id', 'DESC')->get();
        $data = compact('blog_tag');
        return view('admin.blog.tag_list')->with($data);
    }
     public function blog_tag_add(){
        $url = route('blog.blog_tag_save');
        return view('admin/blog/tag_add',compact('url'));
    }
     public function blog_tag_save(Request $req){
        $req->validate([
            'tag_name' => 'required',
        ]);
        $slug = str_replace(' ','-',$req->tag_name);
        $blogtag = new BlogTag();
        $blogtag->tag_name = $req->tag_name;
        $blogtag->bt_slug = $slug;
        $blogtag->save();
        Alert::success('success','Tag Added Successfully');
        return redirect()->route('blog.blog_tag_list');
    }
     public function blog_tag_edit($id){
        $url = route('blog.blog_tag_update', $id);
        $blogtag = BlogTag::where('id',$id)->first();
        return view('admin/blog/tag_add',compact('url','blogtag'));
    }
    public function blog_tag_update(Request $req, $id){
       $req->validate([
            'tag_name' => 'required',
        ]);
        $slug = str_replace(' ','-',$req->tag_name);
         $blogtag = BlogTag::find($id);
         $blogtag->tag_name = $req->tag_name;
         $blogtag->bt_slug = $slug;
        $blogtag->save();
        Alert::success('success','Tag Updated Successfully');
        return redirect()->route('blog.blog_tag_list');
    }
    public function blog_tag_delete($id)
{
    BlogTag::where('id',$id)->delete();
    Alert::success('success','Tag Deleted Successfully');
    return redirect()->route('blog.blog_tag_list');
}


     public function blog_list(){

       $blog_list = Blog::orderBy('id', 'DESC')->get();

    foreach ($blog_list as $blog) {
        // Split the category IDs
        $categoryIds = explode(',', $blog->category);
        // Fetch the category names based on the IDs
        $categories = BlogCategory::whereIn('id', $categoryIds)->pluck('category_name')->toArray();
        // Join the category names with commas and assign them to a new property
        $blog->category_name = implode(', ', $categories);
    }

        $data = compact('blog_list');
        return view('admin.blog.blog_list')->with($data);
    }
     public function blog_add(){
         $category = BlogCategory::get();
         $tag = BlogTag::get();
         $volunteer = Volunteer::get();
         $blog = null;
        $categories = [];
        $tags = [];
        $url = route('blog.blog_save');
        return view('admin/blog/blog_add',compact('url','category','tag','categories','tags','volunteer'));
    }
    public function blog_save(Request $request)
    {
        // Validate the form input
        $request->validate([
            'blog_name' => 'required|string|max:255',
            'category' => 'required|array',
            'tag' => 'required|array',
        ]);


        // Store the blog data
        $blog = new Blog();
        $slug = Str::slug($request->blog_name, '-');
        // Set blog fields
        $blog->blog_name = $request->blog_name;
        $blog->slug = $slug;
        $blog->active = 1;
        if($request->posted_by != null){
         $blog->posted_by =  $request->posted_by;
        }else{
          $blog->posted_by = 'admin';
        }

        // Convert relative image paths in content to full URLs
        $content = $request->content;

        // Replace relative image paths with full URLs in content
        $content = preg_replace('/src="(assets\/images\/[^"]+)"/', 'src="https://al.uniquefinds-online.com/Ecosansar/$1"', $content);
        //  $content = preg_replace('/src="(public\/assets\/images\/[^"]+)"/', 'src="https://al.uniquefinds-online.com/Ecosansar/$1"', $content);

        $blog->content = $content; // Save modified content

        // Convert category and tag arrays to comma-separated strings and save them directly in the database
        $blog->category = implode(',', $request->input('category')); // Converts array to comma-separated string
        $blog->tag = implode(',', $request->input('tag'));           // Converts array to comma-separated string

        // Save the blog to the database
        $blog->save();

        Alert::success('success','Blog Added Successfully');
        return redirect()->route('blog.blog_list');
    }
    public function blog_edit($id)
    {
         $url = route('blog.blog_update', $id);
        // Find the blog by its ID
        $blog = Blog::findOrFail($id);
     $volunteer = Volunteer::get();
        // Get all available categories and tags from the database
        $category = BlogCategory::all(); // Assuming you have a 'Category' model
        $tag = BlogTag::all();           // Assuming you have a 'Tag' model

        // Get the categories and tags already associated with this blog
        $categories = explode(',', $blog->category); // Convert comma-separated category string into an array
        $tags = explode(',', $blog->tag);           // Convert comma-separated tag string into an array

        // Pass the blog data and the category and tag options to the view
        return view('admin.blog.blog_add', compact('blog', 'category', 'tag', 'categories', 'tags','url','volunteer'));
    }

    public function blog_update(Request $request, $id)
    {
        // Validate the form input
        $request->validate([
            'blog_name' => 'required|string|max:255',
            'category' => 'required|array',
            'tag' => 'required|array',
        ]);

        // Find the existing blog by its ID
        $blog = Blog::findOrFail($id);
        $slug = Str::slug($request->blog_name, '-');

            // Set blog fields
            $blog->blog_name = $request->blog_name;
            $blog->slug = $slug;
            $blog->content = $request->content;


            // Convert category and tag arrays to comma-separated strings and save them directly in the database
            $blog->category = implode(',', $request->input('category')); // Converts array to comma-separated string
            $blog->tag = implode(',', $request->input('tag'));           // Converts array to comma-separated string

            // Save the blog to the database
            $blog->save();

            Alert::success('success','Blog Updated Successfully');
            return redirect()->route('blog.blog_list');
    }
     public function blog_delete($id){
         Blog::where('id',$id)->delete();
        Alert::success('success','Blog Deleted Successfully');
        return redirect()->route('blog.blog_list');
    }
    public function comment_list(){

        $comment_list = Comment::orderBy('id', 'DESC')->get();
        $data = compact('comment_list');
        return view('admin.blog.comment_list')->with($data);
    }
    public function comment_status_update(Request $req)
    {
        //dd($item);
        $doc = Comment::find($req->user_id);
        $doc->active = $req->status;
        $doc->save();
    }
     public function comment_reply_list(){

        $comment_list = CommentReply::orderBy('id', 'DESC')->get();
        $data = compact('comment_list');
        return view('admin.blog.comment_reply_list')->with($data);
    }
  public function commentreply_status_update(Request $req)
    {
        //dd($item);
        $doc = CommentReply::find($req->user_id);
        $doc->active = $req->status;
        $doc->save();
    }
     public function changeBlogStatus(Request $req)
    {
        //dd($item);
        $doc = Blog::find($req->user_id);
        $doc->active = $req->status;
        $doc->save();
    }
}
