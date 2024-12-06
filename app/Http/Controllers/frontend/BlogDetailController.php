<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\frontend\Comment;
use App\Models\frontend\CommentReply;
use App\Models\admin\BlogCategory;
use App\Models\admin\BlogTag;
use App\Models\admin\Blog;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class BlogDetailController extends Controller
{
     public function validateCaptcha(Request $request)
    {
        // Validate user input including the CAPTCHA
        $validator = Validator::make($request->all(), [
            'userInput' => 'required',
        ]);

        // Retrieve CAPTCHA value from session
        $captchaNumber = session('captcha');

        // Check if CAPTCHA validation failed
        if ($validator->fails() || $request->input('userInput') !== $captchaNumber) {
            return redirect()->back()->withErrors(['userInput' => 'CAPTCHA validation failed.']);
        }

        // CAPTCHA validation succeeded
        return redirect()->back()->with('success', 'CAPTCHA validated successfully!');
    }
    public function save(Request $req){
        
   $req->validate([
              'email' => 'required|email',
            'name' => 'required',
            'comment' => 'required',
            'captcha' => 'required'
        ]);
         
             // Validate CAPTCHA input
    if (!$this->validateCaptcha($req)) {
         
        return redirect()->back()->withErrors(['captcha' => 'CAPTCHA validation failed.'])->withInput();
    }
     // If CAPTCHA validation succeeds, continue processing the contact form submission
    // Retrieve CAPTCHA value from session
     $captchaNumber = session('captcha');
     $userInput = $req->input('captcha');

    if ($userInput !== $captchaNumber) {
        
        // If the user input doesn't match the CAPTCHA value, return an error
        return redirect()->back()->withErrors(['captcha' => 'CAPTCHA validation failed.'])->withInput();
    }

        $comment = new Comment();
        $comment->blog_id = $req->blog_id;
        $comment->login_id = $req->login_id;
        $comment->name = $req->name;
        $comment->email = $req->email;
        $comment->comment = $req->comment;
       
        $comment->save();
         Session::flash('success', 'Comment Saved Successfully');
       return redirect()->back();
    }
    public function saveReply(Request $request)
    {
        $reply = new CommentReply();
        $reply->comment_id = $request->comment_id;
         $reply->name = $request->name;
          $reply->email = $request->email;
         $reply->login_id = $request->login_id;
          $reply->blog_id = $request->blog_id;
        $reply->comment = $request->reply;
        $reply->save();
    
      return response()->json([
        'success' => true,
        'reply' => [
            'reply' => $reply->reply, // Return the reply text
            'name' => $reply->name // Include the name if needed
        ]
    ]);
    }
    public function user_blog_add(){
         $category = BlogCategory::get();
         $tag = BlogTag::get();
         $blog = null;
        $categories = [];
        $tags = [];
        $url = route('user_blog.save');
        return view('frontend/blog/blogadd',compact('url','category','tag','categories','tags'));
        
    }
     public function user_blog_save(Request $request) 
    {
       
        // Validate the form input
        $request->validate([
            'blog_name' => 'required|string|max:255',
            'category' => 'required|array',
            'tag' => 'required|array',
        ]);
        // echo "<pre>";
        // print_r($request->all());die;


        // Store the blog data
        $blog = new Blog();

        // Set blog fields
        $blog->blog_name = $request->blog_name;
        $blog->active = 0;
        $blog->posted_by = 'user';
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

        Session::flash('success', 'Post Added Successfully');
       return redirect()->back();
    }

}
