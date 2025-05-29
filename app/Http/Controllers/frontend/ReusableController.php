<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\frontend\EcosansarUsers;
use App\Models\frontend\ReusablePost;
use App\Models\frontend\ReusableEnquiry;
use App\Models\frontend\ReusableAskReview;
use App\Models\frontend\ReusableReview;
use App\Models\frontend\ChangeReusableReview;
use App\Models\admin\ReusableResource;
use App\Models\admin\BreadcrumImage;
use App\Models\admin\Weight;
use App\Models\frontend\UserActivityLog;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Models\admin\GoogleAdsense;
use Illuminate\Support\Facades\Session;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Log; 

class ReusableController extends Controller
{
     private function configureMailer() {
    $mail = new PHPMailer(true);

    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = env('MAIL_HOST', 'email-smtp.ap-south-1.amazonaws.com');
    $mail->SMTPAuth = true;
    $mail->Username = env('MAIL_USERNAME', 'AKIAU6GDYQUALD5BWSMU');
    $mail->Password = env('MAIL_PASSWORD', 'BEzdqoQCdnG1whfi7OU35Y94cVcs+7PQbTerX6qngnbj');
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Sender email
    $mail->setFrom(env('MAIL_FROM_ADDRESS', 'support@mailing.ecosansar.com'), env('MAIL_FROM_NAME', 'Team ecoSansar'));

    return $mail;
}
    
    public function listings()
{
    $user_id = session()->get('user_id');
    $user_type = session()->get('user_type');
    $breadcrumbimage = BreadcrumImage::latest()->first();

    $query = ReusablePost::with(['resource', 'weight'])
       // ->where('reusable_posts.user_id', '!=', $user_id)
         ->where('reusable_posts.request_fulfilled', 0)
        ->where('reusable_posts.active', 1)
        ->leftJoin(
        DB::raw('(SELECT user_id, AVG(rating) as average_rating FROM reusable_reviews GROUP BY user_id) as user_ratings'),
        'reusable_posts.user_id',  // ✅ Join on recuab_posts.user_id
        '=',
        'user_ratings.user_id'
    )
    ->select('reusable_posts.*', 'user_ratings.average_rating');

//     if ($user_type === 'consumer') {
//     $query->where(function ($q) {
//         // Both Sell & Buy from Contributor
//         $q->where('user_type', 'consumer')
//           ->orWhere('user_type', 'sab')
//           ->orWhere(function ($subQuery) {
//               // Buy posts from Corporate (Business)
//               $subQuery->where('user_type', 'business')->where('sale_giveaway', '=', 'Buy');
//           });
//     });
// } elseif ($user_type === 'sab') {
//     $query->where(function ($q) {
//         // Sell posts from Contributor
//         $q->where(function ($subQuery) {
//             $subQuery->where('user_type', 'consumer')->where('sale_giveaway', '!=', 'Buy');
//         })
//         // Both Sell & Buy posts from Resource Collector
//         ->orWhere('user_type', 'sab')
//         // Buy posts from Corporate (Business)
//         ->orWhere(function ($subQuery) {
//             $subQuery->where('user_type', 'business')->where('sale_giveaway', '=', 'Buy');
//         });
//     });
// }elseif ($user_type === 'business') {
//     $query->where(function ($q) {
//         // Sell posts from Resource Collector
//         $q->where(function ($subQuery) {
//             $subQuery->where('user_type', 'sab')->where('sale_giveaway', '!=', 'Buy');
//         })
//         // Both Buy and Sell posts from Corporate (Business)
//         ->orWhere('user_type', 'business');
//     });
// }


    $posts = $query->orderBy('id','desc')->paginate(20);
    $res = ReusableResource::get();
    $weight = Weight::orderByRaw('CAST(min_weight AS UNSIGNED) ASC')->get();
           // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on Reusable Browse listings';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

    return view('frontend/listings/reusablelistingslist', compact('res', 'weight', 'posts', 'user_type', 'user_id', 'breadcrumbimage'));
}
     public function reusable_add_post()
    {
        $breadcrumbimage = BreadcrumImage::latest()->first();

        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $users = EcosansarUsers::where('id', $user_id)->first();
        $resources = ReusableResource::get();
         $weights = Weight::orderByRaw('CAST(min_weight AS UNSIGNED) ASC')->get();
        
          // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on Reusable add post';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        
        return view('frontend/userdetails/reusablepostadd', compact('users', 'user_id', 'resources', 'weights', 'breadcrumbimage'));
    }
    public function reusable_post_save(Request $request)
    {

        // echo "<pre>";
        // print_r($request->all());die;

        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $users = EcosansarUsers::where('id', $user_id)->first();
        if ($request->sale_giveaway == 'Buy') {
            $request->validate([
                'address' => 'required',
                'sale_giveaway' => 'required',
                'quantity' => 'required',
                'resource_type' => 'required',
                'resource_img' => 'mimes:jpg,jpeg,png,webp', // Adjust mime types and max size as needed
    ]);
        } else {
            $request->validate([
                'address' => 'required',
                'sale_giveaway' => 'required',
                'quantity' => 'required',
                
                'resource_type' => 'required',
                'resource_img' => 'required|mimes:jpg,jpeg,png,webp', // Adjust mime types and max size as needed
    ]);
            
        }
        $user = new ReusablePost();
        $user->user_id = $user_id;
          $user->user_type = $user_type;
        $user->name = $users->name;
        $user->email = $users->email;
        $user->mobile = $users->mobile;
        $user->address = $request->address;
        $user->sale_giveaway = $request->sale_giveaway;
        $user->quantity = $request->quantity;
        $user->clean_unclean = $request->clean_unclean;
        $user->packaged = $request->packaged;
           $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->resource_price = $request->resource_price;
        $user->description = $request->description;
        
        
       // Function to resize an image using the GD library
function resizeImage($source, $width, $height)
{
    // Get the original image dimensions and type
    list($originalWidth, $originalHeight, $type) = getimagesize($source);

    // Calculate the new dimensions while maintaining the aspect ratio
    $ratio = $originalWidth / $originalHeight;
    if ($width / $height > $ratio) {
        $width = $height * $ratio;
    } else {
        $height = $width / $ratio;
    }

    // Create a new blank image with the calculated dimensions
    $newImage = imagecreatetruecolor($width, $height);

    // Load the source image based on its type
    switch ($type) {
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($source);
            break;
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($source);
            break;
        case IMAGETYPE_GIF:
            $sourceImage = imagecreatefromgif($source);
            break;
        case IMAGETYPE_WEBP:
            $sourceImage = imagecreatefromwebp($source);
            break;
        default:
            throw new Exception('Unsupported image type');
    }

    // Resize the image
    imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);

    // Start output buffering to capture the image content
    ob_start();
    switch ($type) {
        case IMAGETYPE_JPEG:
            imagejpeg($newImage);
            break;
        case IMAGETYPE_PNG:
            imagepng($newImage);
            break;
        case IMAGETYPE_GIF:
            imagegif($newImage);
            break;
        case IMAGETYPE_WEBP:
            imagewebp($newImage);
            break;
    }
    $imageContent = ob_get_clean(); // Get the image content from the buffer

    // Free up memory
    imagedestroy($newImage);
    imagedestroy($sourceImage);

    return $imageContent; // Return the resized image content as a binary string
}

 
            
            $user->resource_type = $request->resource_type;


// Upload file to S3
    if ($request->hasFile('resource_img')) {
        $file = $request->file('resource_img');
        $filePath = 'Reusableposts';
        $fileName = $user_id . '_' . $user->id . '_' . $request->resource_type  .'.'. $file->getClientOriginalExtension();
        
          $fileTempPath = $file->getRealPath(); // Get the temporary file path

    // Set desired dimensions for resizing (e.g., 800px wide)
    $newWidth = 800;
    $newHeight = 600; // You can adjust this based on your aspect ratio logic

    // Use the resizeImage function to get the resized image content
    $resizedImageContent = resizeImage($fileTempPath, $newWidth, $newHeight);

    // Upload to S3
    Storage::disk('s3')->put($filePath . '/' . $fileName, $resizedImageContent);
$user->resource_img = $fileName;
    }
 $user->save();
    
      
            // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Reusable post add';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end
        
        if ($request->action === 'post_another') {
      Session::flash('success', 'Data saved successfully. You can post another.');
      return redirect()->back();
 } else {
        return redirect()->route('reusable_listings')->with('success', 'Post Added Successfully. You can view in my profile page');
    }

    }
        public function reusable_listing_details($id)
    {
        // Check if the user is logged in
        $breadcrumbimage = BreadcrumImage::latest()->first();

         $user_id = session()->get('user_id');
        $conpost = ReusablePost::where('id', $id)->first();
        $post_id = $conpost->id;
        $u_id = $conpost->user_id;
        $user_type = session()->get('user_type');
        if (null === $user_id || $user_id === '') {
            // User is not logged in, redirect to the login page
            session()->put('redirect_to_list', route('reusable_listing_details', $id));
            session()->put('redirect_wp', route('reusable_listing_details', $id));
            return redirect()->route('consumer_login');
        }
        // Fetch the user's role from the database
        $user = DB::table('ecosansar_users')->where('id', $user_id)->first();
         $enquiry = ReusableEnquiry::where('post_user_id',$u_id)->where('login_user_id',$user_id)->first();
         
       // If there is a connection, check if a review exists
if ($enquiry) {
    
    $review = ReusableReview::where('user_id', $u_id)
        ->where('login_user_id', $user_id)
        ->first();
 
    // Hide the button if a $review exists
    $hideAddReviewButton = $review ? true : false;
} else {
    
    // If no connection, also hide the button
    $hideAddReviewButton = true;
}
 
        
        if (($user && $user->user_type === 'business') || ($user && $user->user_type === 'sab') || ($user && $user->user_type === 'consumer')) {
            // User is logged in as a consumer, proceed to fetch the listing details
            $consumerpostsres = ReusablePost::where('id', $id)->get();


            $posts = ReusablePost::leftjoin('resources', 'resources.id', 'reusable_posts.resource_type')
                ->join('weights', 'weights.id', 'reusable_posts.quantity')
                ->select('reusable_posts.*', 'reusable_posts.id as conid','weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure','resources.resource_name')
                ->where('reusable_posts.id', $id)
                ->first();
            $noofposts = ReusablePost::where('user_id', $u_id)->where('active',1)->count();
            
            
            // Get user details along with the count of reviews and the average rating from recyclable_reviews
    $users = DB::table('ecosansar_users as eu')
        ->leftJoin('reusable_reviews as rr', 'eu.id', '=', 'rr.user_id')
        ->where('eu.id', $u_id)
        ->select(
            'eu.*',
            DB::raw('COUNT(DISTINCT rr.id) as reviews_count'),
            DB::raw('ROUND(AVG(rr.rating), 1) as average_rating')
        )
        ->first();

   // Get the count of reviews for the user from recyclable_reviews table
    $reviewsCount = DB::table('reusable_reviews')
        ->where('user_id', $u_id)
        ->count(); 
     // Calculate the average rating
    $averageRating = DB::table('reusable_reviews')
        ->where('user_id', $u_id)
        ->avg('rating');
    $averageRating = $averageRating ? round($averageRating, 1) : 0;
            $loginuser = EcosansarUsers::where('id', $user_id)->first();
          $afterfilter = GoogleAdsense::where('place_of_adsense','After search filter')->first();
            return view('frontend/listings/reusablelistingdetails', compact('user_id','consumerpostsres', 'posts', 'id', 'u_id', 'post_id' , 'noofposts', 'hideAddReviewButton',
            'users', 'loginuser','afterfilter', 'breadcrumbimage', 'averageRating', 'reviewsCount'));
        }
        // If the user is not logged in as a consumer, redirect to the login page
        session()->put('redirect_to', route('con_listing_details', $id));
        session()->put('redirect_wp', route('con_listing_details', $id));
        return redirect()->route('consumer_login');
    }
    
//     public function reusable_post_filter(Request $request) {
//     $user_id = session()->get('user_id');
//      $user_type = session()->get('user_type');

//     // First Query: Exclude user and check active status
//     $query = ReusablePost::with(['resource', 'weight'])
//         ->where('user_id', '!=', $user_id)
//         ->where('active', 1);

//   // Apply Access Level Logic
//     if ($user_type === 'consumer') {
//         $query->where(function ($q) {
//             $q->where('user_type', 'consumer')
//               ->orWhere('user_type', 'sab')
//               ->orWhere(function ($subQuery) {
//                   $subQuery->where('user_type', 'business')->where('sale_giveaway', '=', 'Buy');
//               });
//         });
//     } elseif ($user_type === 'sab') {
//         $query->where(function ($q) {
//             $q->where(function ($subQuery) {
//                 $subQuery->where('user_type', 'consumer')->where('sale_giveaway', '!=', 'Buy');
//             })
//             ->orWhere('user_type', 'sab')
//             ->orWhere(function ($subQuery) {
//                 $subQuery->where('user_type', 'business')->where('sale_giveaway', '=', 'Buy');
//             });
//         });
//     } elseif ($user_type === 'business') {
//         $query->where(function ($q) {
//             $q->where(function ($subQuery) {
//                 $subQuery->where('user_type', 'sab')->where('sale_giveaway', '!=', 'Buy');
//             })
//             ->orWhere('user_type', 'business');
//         });
//     }

//     // Apply Filters using OR for flexible matching
//     $applyFilters = function($q) use ($request) {
//         // Resource Type Filter
//         if ($request->has('resource') && !empty($request->resource)) {
//             $q->whereIn('resource_type', $request->resource);
//         }

//         // Sale or Giveaway Filter
//         if ($request->has('sale_giveaway') && !empty($request->sale_giveaway)) {
//             $q->orWhere('sale_giveaway', $request->sale_giveaway);
//         }

//         // Weight Filter
//         if ($request->has('weight') && !empty($request->weight)) {
//             $q->orWhereIn('quantity', $request->weight);
//         }

//         // User Type Filter
//         if ($request->has('user_type') && !empty($request->user_type)) {
//             $q->orWhere('user_type', $request->user_type);
//         }
//     };

//     // Apply the filters to both queries
//     $query->where($applyFilters);
     

//     // Execute and process images for both queries
//     $posts = $query->get()->map(function ($post) {
//         $imagePath = !empty($post->resource_img) ? 'Reusableposts/' . $post->resource_img : null;
//         $post->image_url = $imagePath && Storage::disk('s3')->exists($imagePath)
//             ? Storage::disk('s3')->url($imagePath)
//             : asset('frontend/assets/img/ecosansar.png');
//         return $post;
//     });

    

//     return response()->json([
//         'posts' => $posts,
        
//     ]);
// }

// public function reusable_post_sort(Request $request)
// {
//     $user_id = session()->get('user_id');
//     $user_type = session()->get('user_type');

//     $query = ReusablePost::with(['resource', 'weight'])
//         ->where('reusable_posts.user_id', '!=', $user_id)
//         ->where('reusable_posts.active', 1)
//         ->leftJoin(
//         DB::raw('(SELECT user_id, AVG(rating) as average_rating FROM reusable_reviews GROUP BY user_id) as user_ratings'),
//         'reusable_posts.user_id',  // ✅ Join on reusable_posts.user_id
//         '=',
//         'user_ratings.user_id'
//     )
//     ->select('reusable_posts.*', 'user_ratings.average_rating');

//     // Apply Access Level Logic
//     if ($user_type === 'consumer') {
//         $query->where(function ($q) {
//             $q->where('user_type', 'consumer')
//               ->orWhere('user_type', 'sab')
//               ->orWhere(function ($subQuery) {
//                   $subQuery->where('user_type', 'business')->where('sale_giveaway', '=', 'Buy');
//               });
//         });
//     } elseif ($user_type === 'sab') {
//         $query->where(function ($q) {
//             $q->where(function ($subQuery) {
//                 $subQuery->where('user_type', 'consumer')->where('sale_giveaway', '!=', 'Buy');
//             })
//             ->orWhere('user_type', 'sab')
//             ->orWhere(function ($subQuery) {
//                 $subQuery->where('user_type', 'business')->where('sale_giveaway', '=', 'Buy');
//             });
//         });
//     } elseif ($user_type === 'business') {
//         $query->where(function ($q) {
//             $q->where(function ($subQuery) {
//                 $subQuery->where('user_type', 'sab')->where('sale_giveaway', '!=', 'Buy');
//             })
//             ->orWhere('user_type', 'business');
//         });
//     }


//     // Sorting Logic
//     if ($request->has('sort_by')) {
//         switch ($request->sort_by) {
//             case '1': // Newest First
//                 $query->orderBy('created_at', 'desc');
//                 break;
//             case '2': // Oldest First
//                 $query->orderBy('created_at', 'asc');
//                 break;
//             case '3': // Smallest Quantity
//         $query->select('reusable_posts.*', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
//             ->join('weights', 'reusable_posts.quantity', '=', 'weights.id')
//             ->orderByRaw('CAST(weights.min_weight AS SIGNED) ASC');
//         break;

//     case '4': // Largest Quantity
//         $query->select('reusable_posts.*', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
//             ->join('weights', 'reusable_posts.quantity', '=', 'weights.id')
//             ->orderByRaw('CAST(weights.max_weight AS SIGNED) DESC');
//         break;
//           case '5': // Highest Ratings
//               $query->orderByDesc('user_ratings.average_rating'); // Ordering by post rating
//         break;
//             case '6': // Lowest Ratings
//               $query->orderBy('user_ratings.average_rating', 'asc');
//         break;
//             default:
//                 $query->orderBy('created_at', 'desc'); // Default to Newest First
//         }
//     }

//     $posts = $query->get()->map(function ($post) {
//         $imagePath = !empty($post->resource_img) ? 'Reusableposts/' . $post->resource_img : null;
//         $post->image_url = $imagePath && Storage::disk('s3')->exists($imagePath)
//             ? Storage::disk('s3')->url($imagePath)
//             : asset('frontend/assets/img/ecosansar.png');
//         return $post;
//     });

//     return response()->json($posts);
// }


public function reusable_post_filter(Request $request) {
    $user_id = session()->get('user_id');
     $user_type = session()->get('user_type');

    // First Query: Exclude user and check active status
    $query = ReusablePost::with(['resource', 'weight', 'user'])
      // ->where('reusable_posts.user_id', '!=', $user_id)
        ->where('reusable_posts.request_fulfilled', 0)
    ->where('reusable_posts.active', 1)
    ->leftJoin(
        DB::raw('(SELECT user_id, AVG(rating) as average_rating FROM reusable_reviews GROUP BY user_id) as user_ratings'),
        'reusable_posts.user_id',  // ✅ Join on reusable_posts.user_id
        '=',
        'user_ratings.user_id'
    )
    ->select('reusable_posts.*', 'user_ratings.average_rating');

   // Apply Access Level Logic
    // if ($user_type === 'consumer') {
    //     $query->where(function ($q) {
    //         $q->where('user_type', 'consumer')
    //           ->orWhere('user_type', 'sab')
    //           ->orWhere(function ($subQuery) {
    //               $subQuery->where('user_type', 'business')->where('sale_giveaway', '=', 'Buy');
    //           });
    //     });
    // } elseif ($user_type === 'sab') {
    //     $query->where(function ($q) {
    //         $q->where(function ($subQuery) {
    //             $subQuery->where('user_type', 'consumer')->where('sale_giveaway', '!=', 'Buy');
    //         })
    //         ->orWhere('user_type', 'sab')
    //         ->orWhere(function ($subQuery) {
    //             $subQuery->where('user_type', 'business')->where('sale_giveaway', '=', 'Buy');
    //         });
    //     });
    // } elseif ($user_type === 'business') {
    //     $query->where(function ($q) {
    //         $q->where(function ($subQuery) {
    //             $subQuery->where('user_type', 'sab')->where('sale_giveaway', '!=', 'Buy');
    //         })
    //         ->orWhere('user_type', 'business');
    //     });
    // }

    // Apply Filters using OR for flexible matching
    $applyFilters = function($q) use ($request) {
        // Resource Type Filter
        if ($request->has('resource') && !empty($request->resource)) {
            $q->whereIn('resource_type', $request->resource);
        }

        // Sale or Giveaway Filter
        if ($request->has('sale_giveaway') && !empty($request->sale_giveaway)) {
            $q->orWhere('sale_giveaway', $request->sale_giveaway);
        }

        // Weight Filter
        if ($request->has('weight') && !empty($request->weight)) {
    $weights = is_array($request->weight) ? $request->weight : [$request->weight];
    $q->orWhereIn('quantity', $weights);
}

        // Address Filter (Partial Match)
        if ($request->has('pincode') && !empty($request->pincode)) {
            $q->orWhere('pincode', 'LIKE', '%' . $request->pincode . '%');
        }

        // User Type Filter
        if ($request->has('user_type') && !empty($request->user_type)) {
            $q->orWhere('user_type', $request->user_type);
        }
    };

    // Apply the filters to both queries
    $query->where($applyFilters);
     

    // Execute and process images for both queries
    $posts = $query->get()->map(function ($post) {
        $imagePath = !empty($post->resource_img) ? 'Reusableposts/' . $post->resource_img : null;
        $post->image_url = $imagePath && Storage::disk('s3')->exists($imagePath)
            ? Storage::disk('s3')->url($imagePath)
            : asset('frontend/assets/img/ecosansar.png');
        return $post;
    });

    

    return response()->json([
        'posts' => $posts,
        
    ]);
}

public function reusable_post_sort(Request $request)
{
    $user_id = session()->get('user_id');
    $user_type = session()->get('user_type');

    $query = ReusablePost::with(['resource', 'weight', 'user'])
      // ->where('reusable_posts.user_id', '!=', $user_id)
        ->where('reusable_posts.request_fulfilled', 0)
    ->where('reusable_posts.active', 1)
    ->leftJoin(
        DB::raw('(SELECT user_id, AVG(rating) as average_rating FROM reusable_reviews GROUP BY user_id) as user_ratings'),
        'reusable_posts.user_id',  // ✅ Join on reusable_posts.user_id
        '=',
        'user_ratings.user_id'
    )
    ->select('reusable_posts.*', 'user_ratings.average_rating');

    // Apply Access Level Logic
    // if ($user_type === 'consumer') {
    //     $query->where(function ($q) {
    //         $q->where('user_type', 'consumer')
    //           ->orWhere('user_type', 'sab')
    //           ->orWhere(function ($subQuery) {
    //               $subQuery->where('user_type', 'business')->where('sale_giveaway', '=', 'Buy');
    //           });
    //     });
    // } elseif ($user_type === 'sab') {
    //     $query->where(function ($q) {
    //         $q->where(function ($subQuery) {
    //             $subQuery->where('user_type', 'consumer')->where('sale_giveaway', '!=', 'Buy');
    //         })
    //         ->orWhere('user_type', 'sab')
    //         ->orWhere(function ($subQuery) {
    //             $subQuery->where('user_type', 'business')->where('sale_giveaway', '=', 'Buy');
    //         });
    //     });
    // } elseif ($user_type === 'business') {
    //     $query->where(function ($q) {
    //         $q->where(function ($subQuery) {
    //             $subQuery->where('user_type', 'sab')->where('sale_giveaway', '!=', 'Buy');
    //         })
    //         ->orWhere('user_type', 'business');
    //     });
    // }


    // Sorting Logic
    if ($request->has('sort_by')) {
        switch ($request->sort_by) {
            case '1': // Newest First
                $query->orderBy('created_at', 'desc');
                break;
            case '2': // Oldest First
                $query->orderBy('created_at', 'asc');
                break;
            case '3': // Smallest Quantity
        $query->select('reusable_posts.*', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure', 'user_ratings.average_rating')
            ->join('weights', 'reusable_posts.quantity', '=', 'weights.id')
            ->orderByRaw('CAST(weights.min_weight AS SIGNED) ASC');
        break;

    case '4': // Largest Quantity
        $query->select('reusable_posts.*', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure', 'user_ratings.average_rating')
            ->join('weights', 'reusable_posts.quantity', '=', 'weights.id')
            ->orderByRaw('CAST(weights.max_weight AS SIGNED) DESC');
        break;
            case '5': // Highest Ratings
               $query->orderByDesc('user_ratings.average_rating'); // Ordering by post rating
        break;
            case '6': // Lowest Ratings
               $query->orderBy('user_ratings.average_rating', 'asc');
        break;
            default:
                $query->orderBy('created_at', 'desc'); // Default to Newest First
        }
    }

    $posts = $query->get()->map(function ($post) {
        $imagePath = !empty($post->resource_img) ? 'Reusableposts/' . $post->resource_img : null;
        $post->image_url = $imagePath && Storage::disk('s3')->exists($imagePath)
            ? Storage::disk('s3')->url($imagePath)
            : asset('frontend/assets/img/ecosansar.png');
        return $post;
    });

    return response()->json($posts);
}

   public function reusable_enquiry_save(Request $req){
         $user_id = session()->get('user_id');
         $user_type = session()->get('user_type');
        $req->validate([
            'name' => 'required',
           // 'email' => 'required',
            'mobile' => 'required',
            'message' => 'required'
        ]);
         $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        
        $details = ReusablePost::where('id',$req->id)->first();

        $enquiry = new ReusableEnquiry();
        $enquiry->post_user_id = $details->user_id; 
        $enquiry->login_user_id = $user_id;
        $enquiry->post_id = $req->id;
         $enquiry->loggedin_user_type = $user_type;
         $enquiry->user_type = $details->user_type;
        $enquiry->name = $req->name;
        $enquiry->email = $req->email;
        $enquiry->mobile = $req->mobile;
        $enquiry->message = $req->message;
        $enquiry->save();

        
        
         $users = EcosansarUsers::where('id',$details->user_id)->first();
        
        // echo "<pre>";
        // print_r($post);die;
        
        if($req->email){
            
             $userdata = [
            'post_name' => $details->name,
            'name' =>  $req->name,
            'email' => $req->email,
            'mobile' => $details->mobile,
            'post_email' =>$details->email,
            ];
            $userdata["title"] =  "Connection Details for Your Interest";
           
            try {
            // Configure PHPMailer
            $mail = $this->configureMailer();
            
            // Add recipient
            $mail->addAddress($userdata['email']);

            // Email subject and body
            $mail->Subject = $userdata['title'];
            $mail->isHTML(true);
            $mail->Body = view('frontend.mail.userthankuemail', $userdata)->render();

            // Send the email
            $mail->send();
            Log::info("Reminder email sent to: {$userdata['email']}");
        } catch (Exception $e) {
            Log::error("Error sending email to {$userdata['email']}: " . $e->getMessage());
        }
            
            
        }
        
        $data = [
            'name' => $req->name,
            'post_email' => $req->email,
            'mobile' => $req->mobile,
            //'post_email' => $req->email,
            'msg' => $req->message,
        ];
        
            // print_r($data);die;
         $data["email"] = $details->email; 
       
        $data["title"] =  "Enquiry from ".$req->name;
        
       // ✅ Check if email exists and is valid
        if (!empty($data['email']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            try {
                $mail = $this->configureMailer();
                $mail->addAddress($data['email']);
                $mail->Subject = $data['title'];
                $mail->isHTML(true);
                $mail->Body = view('frontend.mail.consumermail', $data)->render();
                $mail->send();
        
                Log::info("Reminder email sent to: {$data['email']}");
            } catch (Exception $e) {
                Log::error("Error sending email to {$data['email']}: " . $e->getMessage());
            }
        } else {
            Log::warning("Email not sent: Invalid or missing email for user.");
        }
        
        $adminemail = User::where('type','admin')->first();
        
        $data["email"] = $adminemail->email;
       
        Log::info("Sending admin email to: " . $data['email']);  // Debug log
        $data["title"] =  "Enquiry from ".$req->name. " for ".$details->name;
       
         try {
            // Configure PHPMailer
            $mail = $this->configureMailer();
            
            // Add recipient
            $mail->addAddress($data['email']);

            // Email subject and body
            $mail->Subject = $data['title'];
            $mail->isHTML(true);
            $mail->Body = view('frontend.mail.adminconsumermail', $data)->render();

            // Send the email
            $mail->send();
            Log::info("Reminder email sent to: {$data['email']}");
        } catch (Exception $e) {
            Log::error("Error sending email to {$data['email']}: " . $e->getMessage());
        }
        
        
        
          $contact = $req->mobile;
    // // Check if the user exists in the ecosansar_users table
    //     $user = DB::table('ecosansar_users')
    //     ->where('mobile', $contact)->first();
    //     // Generate a 6-digit random OTP
    //     $otp = mt_rand(100000, 999999);
    
        $templateId = '6697c3ecd6fc051035577b52'; // Ensure this is a valid string from MSG91
        $apiKey = config('services.msg91.authkey'); // Fetch authkey from config
        
        // Prepare the data for the cURL request
        $data = json_encode([
            'template_id' => $templateId,
            'short_url' => '0',
            'realTimeResponse' => '1',
            'recipients' => [
                [
                    'mobiles' => '91' . $contact,
                    'var1' => $details->name,
                    'var2' => $details->mobile,
                ]
            ]
        ]);
    
        // Initialize cURL
        $curl = curl_init();
    
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://control.msg91.com/api/v5/flow",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authkey: $apiKey",
                "content-type: application/json"
            ],
        ]);
    
        // Execute the cURL request and handle the response
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        
         Session::flash('success', 'Enquiry Sent Successfully');
       return redirect()->back();
    }
    public function get_reusable_post_details(Request $request)
    {
        $postid = $request->dataId;
        $sab = ReusablePost::where('id', $postid)->first();
        $user_id = session()->get('user_id');
        if ($sab) {
            $uid = $sab->user_id;
            $user = EcosansarUsers::where('id', $uid)->first();
            $loggedInUser = EcosansarUsers::find($user_id);
            return response()->json([
                'status' => 'success',
                'post' => $loggedInUser,
                'user' => $user
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found'
            ], 404);
        }
    }
     public function reusablereviewsave(Request $req){
        
        $req->validate([
            'title' => 'required',
            'message' => 'required',
            'rating' => 'required',
        ]);
        $details = ReusablePost::where('id',$req->post_id)->first();
        $enquiry = new ReusableReview();
        $user_id = session()->get('user_id'); 
        
          // Check if a review already exists for this post by the same user
    $existingReview = ReusableReview::where('post_id', $req->post_id)
        ->where('login_user_id', $user_id)
        ->first();

    if ($existingReview) {
        // If review exists, update it
        $existingReview->title = $req->title;
        $existingReview->message = $req->message;
        $existingReview->rating = $req->rating;
        $existingReview->save();
 //  $notification = ConsumerAskReview::where('post_id',$details->id)->where('login_user_id',$details->user_id)->where('user_id',$user_id)->first();
         $notification = ReusableAskReview::where('login_user_id',$details->user_id)->where('user_id',$user_id)->first();
        //  echo "<pre>";
        //  print_r($notification);die;
         if($notification){
        $notification->change_review = 'changedreview';
        $notification->save();
         }
        Session::flash('success', 'Review Updated Successfully');
    } else {
        $enquiry->user_id = $details->user_id;
        $enquiry->post_id = $req->post_id;
        $enquiry->login_user_id = $user_id;
        $enquiry->title = $req->title;
        $enquiry->message = $req->message;
        $enquiry->rating = $req->rating;
         $enquiry->type = $details->user_type;
        $enquiry->save();
        
        //  $notification = ConsumerAskReview::where('post_id',$details->id)->where('login_user_id',$details->user_id)->where('user_id',$user_id)->first();
         $notification = ReusableAskReview::where('login_user_id',$details->user_id)->where('user_id',$user_id)->first();
        //  echo "<pre>";
        //  print_r($notification);die;
        if($notification){
        $notification->status = 'read';
        $notification->save();
        }
        Session::flash('success', 'Review Sent Successfully');
    }
     return redirect('/');
    }
    
    
    
    public function sendReusableReviewRequest($id)
    {
      $user_id = session()->get('user_id');
      $user_type = session()->get('user_type');
      
       // Find the record by ID
    $condata = ReusableEnquiry::find($id);
    $postdata = ReusablePost::where('id',$condata->post_id)->first();
      
       $conaskrev = new ReusableAskReview();
        $conaskrev->user_id = $condata->login_user_id;
        $conaskrev->login_user_id = $postdata->user_id;
        $conaskrev->post_id = $postdata->id;
         $conaskrev->name = $postdata->name;
        $conaskrev->flag = 'asked';
        $conaskrev->type = $user_type;
        $conaskrev->user_type = $condata->loggedin_user_type;
        $conaskrev->save();
      
   
     
        

    if ($condata) {
       $data = [
            'name' => $condata->name,
            'post_name' => $postdata->name,
            'email' => $condata->email,
            'post_id' => $postdata->id,
             'link' => url('/reusablepostprofile/' . $postdata->user_id . '?review_id=' . $conaskrev->id),
            ];
            
             
            
            // $data["title"] =  $postdata->name . " has requested for review";
             $data["title"] =  "Share Your Feedback on ". $postdata->name ."'s " ."Service"; 
            
             
         if (!empty($data['email']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {  
          try {
            // Configure PHPMailer
            $mail = $this->configureMailer();
            
            // Add recipient
            $mail->addAddress($data['email']);

            // Email subject and body
            $mail->Subject = $data['title'];
            $mail->isHTML(true);
            $mail->Body = view('frontend.mail.reusableaskreview', $data)->render();

            // Send the email
            $mail->send();
            Log::info("Reminder email sent to: {$data['email']}");
        } catch (Exception $e) {
            Log::error("Error sending email to {$data['email']}: " . $e->getMessage());
        }
         } else {
    Log::error("Email is missing for ReusableEnquiry ID: {$id}");
    
}

        // Update the flag field to indicate the review email has been sent
        $condata->flag = 'asked'; // Assuming flag is 1 for sent, 0 for not sent
        $condata->save();
        
        
       
   
         return response()->json([
    'status' => 'success',
    'review_id' => $conaskrev->id,
    'post_name' => $postdata->name,
    'post_user_id' => $postdata->user_id,
    'user_type' => $condata->loggedin_user_type
]);
    }

    return response()->json(['status' => 'error']);
}
    
      public function reusablepostprofile($u_id)
    {
         // Retrieve the review_id from the query string
     $review_id = request()->query('review_id'); 
         $user_id = session()->get('user_id');
        $conpost = ReusablePost::where('user_id', $u_id)->first();
       
        // Redirect if the user or post doesn't exist
    if (!$conpost) {
        Session::flash('warning', 'Invalid user or post.');
        return redirect('/');
    }
        $post_id = $conpost->id;
        $u_id = $conpost->user_id;
         $user_type = session()->get('user_type');
        if (null === $user_id || $user_id === '') {
            // User is not logged in, redirect to the login page
             $redirectUrl = route('reusablepostprofile', ['id' => $u_id]) . ($review_id ? '?review_id=' . $review_id : '');
             session()->put('redirect_askrev', $redirectUrl);
              
            return redirect()->route('consumer_login');
        }
        
        
    
    // Check for existing connection (BusinessEnquiry)
$busrev = ReusableEnquiry::where('login_user_id', $user_id)
    ->where('post_user_id', $u_id)
    ->first();

// Check for a review request only if a review_id is provided
$reviewRequest = null;
if ($review_id) {
    $reviewRequest = ReusableAskReview::where('id', $review_id)
        ->where('user_id', $user_id)
        ->first();
}

// Validate access
if (!$busrev || ($review_id && !$reviewRequest)) {
    Session::flash('warning', 'You have not connected with this user. Please connect first then give review');
    return redirect('/');
}  


    
    
        $conlistreviews = ReusableReview::where('post_id', $post_id)->where('user_id', $u_id)->get();
        $users = EcosansarUsers::where('id', $u_id)->first();

        return view('frontend/reusablepostprofile', compact('users', 'conlistreviews', 'u_id', 'post_id'));
    }
    
public function changeReusableReviewRequest($id)
    {
        
      $user_id = session()->get('user_id');
      $user_type = session()->get('user_type');
      
    // Find the record by ID
    $condata = ReusableReview::find($id);
    
    $postdata = ReusablePost::where('id',$condata->post_id)->first();
     $userdata = Ecosansarusers::where('id',$condata->login_user_id)->first();
      $notificationchange = ReusableAskReview::where('user_id',$condata->login_user_id)->where('login_user_id',$user_id)->first();  
      
       if (!$notificationchange) {
        // Create a new record in ConsumerAskReview if it doesn't exist
        $notificationchange = ReusableAskReview::create([
            'user_id' => $condata->login_user_id,
            'login_user_id' => $user_id,
            'post_id' => $postdata->id,
            'status' => 'read',
            'flag' => 'asked',
            'name' => $postdata->name,
            'change_review' => 'changereview',
            'type' => $user_type
        ]);
    }

      
        $conaskrev = new ChangeReusableReview();
        $conaskrev->user_id = $condata->login_user_id;
        $conaskrev->login_user_id = $postdata->user_id;
        $conaskrev->post_id = $postdata->id;
         $conaskrev->name = $postdata->name;
        $conaskrev->flag = 'asked';
        $conaskrev->type = $user_type;
        $conaskrev->save();  

    if ($condata) {
       $data = [
            'name' => $userdata->name,
            'post_name' => $postdata->name,
            'email' => $userdata->email,
            'post_id' => $postdata->id,
           'link' => url('/edit-reusable-review/' . $postdata->user_id . '/' . $id . '?review_id=' . $notificationchange->id)
            ];
            
             
            
            $data["title"] =  "Request to Update Your Review";  
             
   if (!empty($condata->email) && filter_var($condata->email, FILTER_VALIDATE_EMAIL)) {          
 try {
            // Configure PHPMailer
            $mail = $this->configureMailer();
            
            // Add recipient
            $mail->addAddress($data['email']);

            // Email subject and body
            $mail->Subject = $data['title'];
            $mail->isHTML(true);
            $mail->Body = view('frontend.mail.businesschangereview', $data)->render();

            // Send the email
            $mail->send();
            Log::info("Reminder email sent to: {$data['email']}");
        } catch (Exception $e) {
            Log::error("Error sending email to {$data['email']}: " . $e->getMessage());
        }
   } else {
        Log::info("Email not present or invalid. Skipping email for ReusableEnquiry ID: $id");
    }   
      
        $notificationchange->change_review = 'changereview';
        $notificationchange->save();
        
        Session::flash('success', 'Review request sent successfully!');
   
        return response()->json(['status' => 'success']);
    }

    return response()->json(['status' => 'error']);
}
public function editReusableReview($id, $rid)
{
    $user_id = session()->get('user_id');
    $user_type = session()->get('user_type');
  $review_id = request()->query('review_id');  
    // Check if user is logged in; if not, redirect to login
     if (null === $user_id || $user_id === '') {
            // User is not logged in, redirect to the login page
             $redirectUrl = url("/edit-reusable-review/{$id}/{$rid}") . '?review_id=' . $review_id; 
             session()->put('redirect_changerev', $redirectUrl);
            //  session()->put('redirect_askrev', route('conpostprofile', $u_id));
            return redirect()->route('consumer_login');
        }
        
    // Find the review by ID
    $review = ReusableReview::find($rid);
    $post_id = $review->post_id;
    // Check if the review exists
    if (!$review) {
        return redirect('/')->with('error', 'Review not found.');
    }
    
     // Retrieve the review request based only on user_id
     $reviewRequest = ReusableAskReview::where('id', $review_id)->where('user_id', $user_id)->first();
    
      //$reviewRequest = ConsumerAskReview::where('id', $review_id)->first();
 
   

    // Check if the review request exists and belongs to the logged-in user
    if (!$reviewRequest) {
         
        Session::flash('warning', 'Unauthorized access to this review request.');
        return redirect('/');
    }
    
  $users = EcosansarUsers::where('id', $review->user_id)->first();
    // Pass the review data to the view
    return view('frontend.reusableeditreview', compact('review','id','post_id','users'));
}
//to update from my prrofile page under reviews given tab 
public function reusableupdateReview(Request $request, $id) {
    $review = ReusableReview::find($id);
    
    if (!$review) {
        return response()->json(['success' => false, 'message' => 'Review not found']);
    }

    // Update record
    $review->title = $request->title;
    $review->message = $request->message;
    $review->rating = $request->rating;
    $review->save();

    return response()->json(['success' => true]);
}
}
