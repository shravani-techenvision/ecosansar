<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\frontend\EcosansarUsers;
use App\Models\frontend\ConsumerPost;
use App\Models\frontend\BusinessPost;
use App\Models\frontend\ConsumerResourcePost;
use App\Models\frontend\ConsumerReview;
use App\Models\frontend\BusinessReview;
use App\Models\frontend\SABPost;
use App\Models\frontend\SABReview;
use App\Models\frontend\SABEnquiry;
use App\Models\frontend\SABEnquiryMessages;
use App\Models\frontend\SABResourcePost;
use App\Models\frontend\BusinessResourcePost;
use App\Models\admin\Resource;
use App\Models\admin\Weight;
use App\Models\admin\GoogleAdsense;
use App\Models\admin\Faq;
use App\Models\admin\About;
use App\Models\admin\Category;
use App\Models\admin\Service;
use App\Models\frontend\UserContact;
use App\Models\frontend\UserActivityLog;
use RealRashid\SweetAlert\Facades\Alert;
use Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Craftsys\Msg91\Facade\Msg91;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use App\Services\PHPMailerService;
use Illuminate\Support\Facades\View;
use App\Models\admin\Blog;
use App\Models\admin\BlogCategory;
use App\Models\admin\BlogTag;
use App\Models\admin\Volunteer;
use App\Models\frontend\Comment;
use App\Models\frontend\ConsumerEnquiry;
use App\Models\frontend\ConsumerAskReview;
use App\Models\frontend\BusinessEnquiry;

class IndexController extends Controller
{
    protected $mailerService;
    public function __construct(PHPMailerService $mailerService)
    {
        $this->mailerService = $mailerService;
    }


    public function sendOtp(Request $request)
    {
        // print_r($request->all());
        // die;
        // Validate the request data

        $request->validate([
            'contact' => 'required|digits:10', // Assuming Indian 10 digit phone number
        ]);

        $contact = $request->input('contact');
        // Check if the user exists in the ecosansar_users table
        $user = DB::table('ecosansar_users')
            ->where('mobile', $contact)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found. Please register',
                'registration_url' => 'https://ecosansar.com/user_register',
            ], 404);
        }

        if ($user->is_delete == 1) {
            // User not found
            return response()->json([
                'status' => 'error',
                'message' => 'User deactivated. Please activate',
                'registration_url' => 'https://ecosansar.com/user_activate/' . $user->id,
            ], 404);
        }


        $userver = DB::table('ecosansar_users')
            ->where('is_verify', 1)
            ->where('mobile', $contact)->first();

        //    echo $contact;
        //   // echo "<pre>";
        //    print_r($userver);
        //    die;

        if (!$userver) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not verified. Please verify',
                'registration_url' => 'https://ecosansar.com/loginverify_otp/' . $user->id,
            ], 404);
        }

        // Generate a 6-digit random OTP
        $otp = mt_rand(100000, 999999);

        $templateId = '6697c308d6fc0523883d13f3'; // Ensure this is a valid string from MSG91
        $apiKey = config('services.msg91.authkey'); // Fetch authkey from config

        // Update OTP and expiration time in the database
        DB::table('ecosansar_users')
            ->where('mobile', $contact)
            ->update([
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(10), // OTP valid for 10 minutes
            ]);

        // Prepare the data for the cURL request
        $data = json_encode([
            'template_id' => $templateId,
            'short_url' => '0',
            'realTimeResponse' => '1',
            'recipients' => [
                [
                    'mobiles' => '91' . $contact,
                    'var' => $otp
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

        if ($err) {
            return response()->json([
                'status' => 'error',
                'message' => "cURL Error #: $err",
            ], 500);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => $response,
            ]);
        }
    }



    public function loginverify_otp($id)
    {
        // Validate the request data
        // echo "<pre>";
        // print_r($request->all());
        // die;
        // $request->validate([
        //     'contact' => 'required|digits:10', // Assuming Indian 10 digit phone number
        // ]);
        //
        // Check if the user exists in the ecosansar_users table
        $user = DB::table('ecosansar_users')
            ->where('id', $id)->first();

        $contact = $user->mobile;

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found please register first .',
            ], 404);
        }

        // $userver = DB::table('ecosansar_users')
        // ->where('is_verify',1)
        // ->where('mobile', $contact)->first();

        //  if (!$userver) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'User not verified.',
        //     ], 404);
        // }

        // Generate a 6-digit random OTP
        $otp = mt_rand(100000, 999999);

        $templateId = '6697c327d6fc05609f5064c2'; // Ensure this is a valid string from MSG91
        $apiKey = config('services.msg91.authkey'); // Fetch authkey from config

        // Update OTP and expiration time in the database
        DB::table('ecosansar_users')
            ->where('mobile', $contact)
            ->update([
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(10), // OTP valid for 10 minutes
            ]);

        // Prepare the data for the cURL request
        $data = json_encode([
            'template_id' => $templateId,
            'short_url' => '0',
            'realTimeResponse' => '1',
            'recipients' => [
                [
                    'mobiles' => '91' . $contact,
                    'var' => $otp
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

        if ($err) {
            return response()->json([
                'status' => 'error',
                'message' => "cURL Error #: $err",
            ], 500);
        } else {
            // return response()->json([
            //     'status' => 'success',
            //     'message' => $response,
            // ]);
            return redirect()->route('register_otp', ['id' => $user->id]);
        }
    }


    public function resendOtp(Request $request)
    {
        // Validate the request data
        // echo "<pre>";
        // print_r($request->all());
        // die;

        $request->validate([
            'contact' => 'required|digits:10', // Assuming Indian 10 digit phone number
        ]);

        $contact = $request->input('contact');
        // Check if the user exists in the ecosansar_users table
        $user = DB::table('ecosansar_users')
            ->where('mobile', $contact)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found please register first .',
            ], 404);
        }

        $userver = DB::table('ecosansar_users')
            ->where('is_verify', 1)
            ->where('mobile', $contact)->first();

        //  if (!$userver) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'User not verified.',
        //     ], 404);
        // }

        // Generate a 6-digit random OTP
        $otp = mt_rand(100000, 999999);

        $templateId = '6697c327d6fc05609f5064c2'; // Ensure this is a valid string from MSG91
        $apiKey = config('services.msg91.authkey'); // Fetch authkey from config

        // Update OTP and expiration time in the database
        DB::table('ecosansar_users')
            ->where('mobile', $contact)
            ->update([
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(10), // OTP valid for 10 minutes
            ]);

        // Prepare the data for the cURL request
        $data = json_encode([
            'template_id' => $templateId,
            'short_url' => '0',
            'realTimeResponse' => '1',
            'recipients' => [
                [
                    'mobiles' => '91' . $contact,
                    'var' => $otp
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

        if ($err) {
            return response()->json([
                'status' => 'error',
                'message' => "cURL Error #: $err",
            ], 500);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => $response,
                'user_id' => $user->id,
            ]);
        }
    }


    public function terms_conditions()
    {

        // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on terms conditions page';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        return view('frontend/temrs_condition');
    }
    public function index(Request $request)
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');

        // Fetching the total min_weight for BusinessPost
$busMinWeightSum = BusinessPost::join('weights', 'business_posts.quantity', '=', 'weights.id')
    ->selectRaw('SUM(weights.min_weight) as total_min_weight')
    ->first();

// Fetching the total min_weight for ConsumerPost
$conMinWeightSum = ConsumerPost::join('weights', 'consumer_posts.quantity', '=', 'weights.id')
    ->selectRaw('SUM(weights.min_weight) as total_min_weight')
    ->first();

// Fetching the total min_weight for SABPost
$sabMinWeightSum = SABPost::join('weights', 's_a_b_posts.quantity', '=', 'weights.id')
    ->selectRaw('SUM(weights.min_weight) as total_min_weight')
    ->first();

// Calculating the combined total min_weight
$totalMinWeight = $busMinWeightSum->total_min_weight + $conMinWeightSum->total_min_weight + $sabMinWeightSum->total_min_weight;


        //Business posts
        $listings = BusinessPost::leftjoin('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
            ->leftjoin('resources', 'resources.id', 'business_resource_posts.resource_type')
            ->select('business_posts.*', 'resources.resource_name', 'business_resource_posts.resource_img')
            ->where('active', 1);
        // Exclude user's own posts if logged in
        if ($user_id) {
            $listings->where('business_posts.user_id', '!=', $user_id);
        }

        $listings = $listings->latest()->take(3)->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $busuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();

            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $busuniqueListings->push($uniqueListing);
        }

        //Business posts except sell
        $listingsnotsell = BusinessPost::leftjoin('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
            ->leftjoin('resources', 'resources.id', 'business_resource_posts.resource_type')
            ->join('weights', 'business_posts.quantity', '=', 'weights.id')
            ->join('ecosansar_users', 'ecosansar_users.id', '=', 'business_posts.user_id')

            ->select('business_posts.*', 'resources.resource_name', 'business_resource_posts.resource_img')
            ->where('active', 1)
            ->where('sale_giveaway', '=', 'Buy')
            ->orderBy('business_posts.created_at', 'asc');

        // Exclude user's own posts if logged in
        if ($user_id) {
            $listingsnotsell->where('business_posts.user_id', '!=', $user_id);
        }

        $listingsnotsell = $listingsnotsell->latest()->take(3)->get();

        // Extract unique post IDs
        $postIds = $listingsnotsell->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $busuniqueListingsnotsell = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listingsnotsell->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $busuniqueListingsnotsell->push($uniqueListing);
        }


        //SAB posts

        $listings = SABPost::leftjoin('s_a_b_resource_posts', 's_a_b_resource_posts.post_id', 's_a_b_posts.id')
            ->leftjoin('resources', 'resources.id', 's_a_b_resource_posts.resource_type')
            ->select('s_a_b_posts.*', 'resources.resource_name', 's_a_b_resource_posts.resource_img')
            ->where('active', 1);
        if ($user_id) {
            $listings->where('s_a_b_posts.user_id', '!=', $user_id);
        }

        $listings = $listings->latest()->take(3)->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $sabuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $sabuniqueListings->push($uniqueListing);
        }

        //Consumer posts
        $listings = ConsumerPost::leftjoin('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
            ->leftjoin('resources', 'resources.id', 'consumer_resource_posts.resource_type')
            ->select('consumer_posts.*', 'resources.resource_name', 'consumer_resource_posts.resource_img')
            ->where('active', 1);
        if ($user_id) {
            $listings->where('consumer_posts.user_id', '!=', $user_id);
        }

        $listings = $listings->latest()->take(3)->get();
        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $conuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $conuniqueListings->push($uniqueListing);
        }

        //consumersell posts

        $listings = ConsumerPost::leftjoin('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
            ->leftjoin('resources', 'resources.id', 'consumer_resource_posts.resource_type')
            ->join('weights', 'consumer_posts.quantity', '=', 'weights.id')
            ->join('ecosansar_users', 'ecosansar_users.id', '=', 'consumer_posts.user_id')
            ->select('consumer_posts.*', 'resources.resource_name', 'consumer_resource_posts.resource_img')
            ->where('active', 1)
            ->where('sale_giveaway', '!=', 'Buy')
            ->orderBy('consumer_posts.created_at', 'asc');

        if ($user_id) {
            $listings->where('consumer_posts.user_id', '!=', $user_id);
        }

        $listings = $listings->latest()->take(3)->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $conuniqueListingsnotbuy = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $conuniqueListingsnotbuy->push($uniqueListing);
        }

        $blistings = BusinessPost::get()->each(function ($item) {
            $item->type = 'business';
        });
        $slistings = SABPost::get()->each(function ($item) {
            $item->type = 'sab';
        });
        $clistings = ConsumerPost::get()->each(function ($item) {
            $item->type = 'consumer';
        });

          // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on home page';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        $alllistings = $blistings->merge($slistings)->merge($clistings);
        $res = Resource::get();


        $users = EcosansarUsers::where('is_delete','0')->count();

            $Resourceusers = EcosansarUsers::where('user_type','sab')->where('is_delete','0')->count();
            $Contributorusers = EcosansarUsers::where('user_type','consumer')->where('is_delete','0')->count();
            $Corporateusers = EcosansarUsers::where('user_type','business')->where('is_delete','0')->count();

            $Contributorpost = ConsumerPost::where('active','1')->count();
            $Resourcepost = SABPost::where('active','1')->count();
            $Corporatepost = BusinessPost::where('active','1')->count();

            $totalpostCount = $Resourcepost + $Contributorpost + $Corporatepost;
            $afterbanner = GoogleAdsense::where('place_of_adsense','After banner image')->first();
            $beforestatistics = GoogleAdsense::where('place_of_adsense','Before our statistics')->first();
        return view('frontend/index', compact('totalMinWeight','conuniqueListingsnotbuy', 'user_type', 'busuniqueListings', 'sabuniqueListings', 'conuniqueListings', 'blistings', 'slistings', 'clistings',
        'alllistings', 'res', 'busuniqueListingsnotsell','users','Resourceusers','Contributorusers','Corporateusers','totalpostCount',
        'Resourcepost','Contributorpost','Corporatepost','afterbanner','beforestatistics'));
    }

    //   public function filter(Request $request)
    //     {
    //         // Initialize the query builders with joins to their respective resource pivot tables
    //         $businessQuery = BusinessPost::join('business_resource_posts', 'business_resource_posts.post_id', '=', 'business_posts.id');
    //         $sabQuery = SABPost::join('s_a_b_resource_posts', 's_a_b_resource_posts.post_id', '=', 's_a_b_posts.id');
    //         $consumerQuery = ConsumerPost::join('consumer_resource_posts', 'consumer_resource_posts.post_id', '=', 'consumer_posts.id');

    //         // Apply the filter based on the type if it's present in the request
    //         if ($request->has('type') && $request->type != '') {
    //             $businessQuery->where(function ($query) use ($request) {
    //                 $query->where('business_posts.sale_giveaway', $request->type)
    //                       ->orWhere('business_posts.clean_unclean', $request->type);
    //             });
    //             $sabQuery->where(function ($query) use ($request) {
    //                 $query->where('s_a_b_posts.sale_giveaway', $request->type)
    //                       ->orWhere('s_a_b_posts.clean_unclean', $request->type);
    //             });
    //             $consumerQuery->where(function ($query) use ($request) {
    //                 $query->where('consumer_posts.sale_giveaway', $request->type)
    //                       ->orWhere('consumer_posts.clean_unclean', $request->type);
    //             });
    //         }

    //         // Apply the filter based on the resource if it's present in the request
    //         if ($request->has('resource') && $request->resource != '') {
    //             $resourceId = $request->resource;
    //             $businessQuery->where('business_resource_posts.resource_type', $resourceId);
    //             $sabQuery->where('s_a_b_resource_posts.resource_type', $resourceId);
    //             $consumerQuery->where('consumer_resource_posts.resource_type', $resourceId);
    //         }

    //         // Get the filtered results with distinct to avoid duplicates
    //         $businessPosts = $businessQuery->distinct()->select('business_posts.*')->get();
    //         $sabPosts = $sabQuery->distinct()->select('s_a_b_posts.*')->get();
    //         $consumerPosts = $consumerQuery->distinct()->select('consumer_posts.*')->get();
    //         // Return the results to the view
    //         return view('frontend/filter', [
    //             'businessPosts' => $businessPosts,
    //             'sabPosts' => $sabPosts,
    //             'consumerPosts' => $consumerPosts
    //         ]);
    //     }

    public function profile($id)
    {
        $userid = session()->get('user_id');
        $users = EcosansarUsers::where('id', $id)->first();
        $utype = $users->user_type;
        $conrev = ConsumerReview::join('ecosansar_users','ecosansar_users.id','=','consumer_reviews.login_user_id')
        ->select('consumer_reviews.*','ecosansar_users.name')
        ->where('consumer_reviews.user_id', $id)->orderBy('id','desc')->get();

        $sabrev = SABReview::join('ecosansar_users','ecosansar_users.id','=','s_a_b_reviews.login_user_id')
        ->select('s_a_b_reviews.*','ecosansar_users.name')
            ->where('s_a_b_reviews.user_id', $id)->orderBy('id','desc')->get();
        $busrev = BusinessReview::join('ecosansar_users','ecosansar_users.id','=','business_reviews.login_user_id')
        ->select('business_reviews.*','ecosansar_users.name')
            ->where('business_reviews.user_id', $id)->orderBy('id','desc')->get();

            $conenq = ConsumerEnquiry::where('user_id', $id)
            ->orderBy('id')
            ->get()
            ->unique(function ($item) {
                return $item->user_id . '-' . $item->login_user_id;
            });


               $busenq = BusinessEnquiry::where('user_id', $id)
            ->orderBy('id')
            ->get()
            ->unique(function ($item) {
                return $item->user_id . '-' . $item->login_user_id;
            });

        $sabenq = SABEnquiry::where('user_id', $id)
            ->orderBy('id')
            ->get()
            ->unique(function ($item) {
                return $item->user_id . '-' . $item->login_id;
            });

        // Initialize collections for the different types of reviews
$consumerReviews = ConsumerReview::where('login_user_id', $userid)->get()->map(function ($review) {
    $review->type = 'consumer';
    return $review;
});

$businessReviews = BusinessReview::where('login_user_id', $userid)->get()->map(function ($review) {
    $review->type = 'business';
    return $review;
});

$sabReviews = SABReview::where('login_user_id', $userid)->get()->map(function ($review) {
    $review->type = 'sab';
    return $review;
});

// Combine all reviews
$reviews = $consumerReviews->merge($businessReviews)->merge($sabReviews);

        $listings = ConsumerPost::leftjoin('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
            ->leftjoin('resources', 'resources.id', 'consumer_resource_posts.resource_type')
            ->select('consumer_posts.*', 'resources.resource_name', 'consumer_resource_posts.resource_img')
            ->where('consumer_posts.user_id', $id)
            ->where('consumer_posts.active', '=', 1)
            ->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $uniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $uniqueListings->push($uniqueListing);
        }



        $deactivelistings = ConsumerPost::leftjoin('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
            ->leftjoin('resources', 'resources.id', 'consumer_resource_posts.resource_type')
            ->select('consumer_posts.*', 'resources.resource_name', 'consumer_resource_posts.resource_img')
            ->where('consumer_posts.user_id', $id)
            ->where('consumer_posts.active', '=', 0)
            ->get();

        // Extract unique post IDs
        $deactivepostIds = $deactivelistings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names

        $deactiveuniqueListings = collect([]);
        foreach ($deactivepostIds as $postId) {
            $postListings = $deactivelistings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $deactiveuniqueListings->push($uniqueListing);
        }




        $sablistings = SABPost::leftjoin('s_a_b_resource_posts', 's_a_b_resource_posts.post_id', 's_a_b_posts.id')
            ->leftjoin('resources', 'resources.id', 's_a_b_resource_posts.resource_type')
            ->select('s_a_b_posts.*', 'resources.resource_name', 's_a_b_resource_posts.resource_img')
            ->where('s_a_b_posts.user_id',  $id)
            ->where('s_a_b_posts.active', '=', 1)
            ->get();

        // Extract unique post IDs
        $sabpostIds = $sablistings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $sabuniqueListings = collect([]);
        foreach ($sabpostIds as $postId) {
            $sabpostListings = $sablistings->where('id', $postId);
            $resourceNames = $sabpostListings->pluck('resource_name')->implode(', ');
            $resourceImages = $sabpostListings->pluck('resource_img')->first();
            $sabuniqueListing = $sabpostListings->first();
            $sabuniqueListing->resource_names = $resourceNames;
            $sabuniqueListing->resource_img = $resourceImages;
            $sabuniqueListings->push($sabuniqueListing);
        }


        $deactivesablistings = SABPost::leftjoin('s_a_b_resource_posts', 's_a_b_resource_posts.post_id', 's_a_b_posts.id')
            ->leftjoin('resources', 'resources.id', 's_a_b_resource_posts.resource_type')
            ->select('s_a_b_posts.*', 'resources.resource_name', 's_a_b_resource_posts.resource_img')
            ->where('s_a_b_posts.user_id',  $id)
            ->where('s_a_b_posts.active', '=', 0)
            ->get();

        // Extract unique post IDs
        $deactivesabpostIds = $deactivesablistings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $deactivesabuniqueListings = collect([]);
        foreach ($deactivesabpostIds as $postId) {
            $sabpostListings = $deactivesablistings->where('id', $postId);
            $resourceNames = $sabpostListings->pluck('resource_name')->implode(', ');
            $resourceImages = $sabpostListings->pluck('resource_img')->first();
            $sabuniqueListing = $sabpostListings->first();
            $sabuniqueListing->resource_names = $resourceNames;
            $sabuniqueListing->resource_img = $resourceImages;
            $deactivesabuniqueListings->push($sabuniqueListing);
        }





        $buslistings = BusinessPost::leftjoin('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
            ->leftjoin('resources', 'resources.id', 'business_resource_posts.resource_type')
            ->select('business_posts.*', 'resources.resource_name', 'business_resource_posts.resource_img')
            ->where('business_posts.user_id',  $id)
            ->where('business_posts.active', '=', 1)
            ->get();


        // Extract unique post IDs
        $buspostIds = $buslistings->pluck('id')->unique();

        // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on profile page';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        // Filter listings to get only one record per post and include all resource names
        $busuniqueListings = collect([]);
        foreach ($buspostIds as $postId) {
            $buspostListings = $buslistings->where('id', $postId);
            $resourceNames = $buspostListings->pluck('resource_name')->implode(', ');
            $resourceImages = $buspostListings->pluck('resource_img')->first();
            $busuniqueListing = $buspostListings->first();
            $busuniqueListing->resource_names = $resourceNames;
            $busuniqueListing->resource_img = $resourceImages;
            $busuniqueListings->push($busuniqueListing);
        }


          $deactivebuslistings = BusinessPost::leftjoin('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
            ->leftjoin('resources', 'resources.id', 'business_resource_posts.resource_type')
            ->select('business_posts.*', 'resources.resource_name', 'business_resource_posts.resource_img')
            ->where('business_posts.user_id',  $id)
            ->where('business_posts.active', '=', 0)
            ->get();

            // Extract unique post IDs
        $deactivebuspostIds = $deactivebuslistings->pluck('id')->unique();

         // Filter listings to get only one record per post and include all resource names
        $deactivebusuniqueListings = collect([]);
        foreach ($deactivebuspostIds as $postId) {
            $buspostListings = $deactivebuslistings->where('id', $postId);
            $resourceNames = $buspostListings->pluck('resource_name')->implode(', ');
            $resourceImages = $buspostListings->pluck('resource_img')->first();
            $busuniqueListing = $buspostListings->first();
            $busuniqueListing->resource_names = $resourceNames;
            $busuniqueListing->resource_img = $resourceImages;
            $deactivebusuniqueListings->push($busuniqueListing);
        }


        $url = route('profile_update', $id);
        return view('frontend/profile', compact('users', 'url', 'utype', 'conrev', 'sabrev', 'uniqueListings',
        'deactiveuniqueListings','sabuniqueListings','deactivesabuniqueListings',
        'busuniqueListings','deactivebusuniqueListings','conenq','busenq','sabenq','busrev','reviews'));
    }
    public function profile_update(Request $req, $id)
    {

        $user =  EcosansarUsers::find($id);
        $user->name = $req->name;
        $user->mobile = $req->mobile;
        $user->address = $req->address;
        $user->email = $req->email;

        $user->save();
        Alert::success('success', 'Profile Updated Successfully');
        return redirect()->back();
    }

    public function conpostprofile($u_id)
    {
     // Retrieve the review_id from the query string
     $review_id = request()->query('review_id');
    $user_id = session()->get('user_id');
    $user_type = session()->get('user_type');

    // Check if user is logged in; if not, redirect to login
     if (null === $user_id || $user_id === '') {
            // User is not logged in, redirect to the login page
             $redirectUrl = route('conpostprofile', ['id' => $u_id]) . ($review_id ? '?review_id=' . $review_id : '');
             session()->put('redirect_askrev', $redirectUrl);
            //  session()->put('redirect_askrev', route('conpostprofile', $u_id));
            return redirect()->route('consumer_login');
        }


    // Retrieve the ConsumerPost for the provided $u_id
    $conpost = ConsumerPost::where('user_id', $u_id)->first();

    // Check if $conpost exists; if not, redirect to home with an error message
    if (!$conpost) {
        Session::flash('error', 'Post not found.');
        return redirect('/');
    }

    $post_id = $conpost->id;

    // Retrieve the review request based only on user_id
     $reviewRequest = ConsumerAskReview::where('id', $review_id)->where('user_id', $user_id)->first();
      //$reviewRequest = ConsumerAskReview::where('id', $review_id)->first();

    // Check if the review request has already been submitted (status is 'read')
    // if ($reviewRequest && $reviewRequest->status === 'read') {
    //     Session::flash('success', 'You have already given a review.');
    //     return redirect('/');
    // }

    // Check if the review request exists and belongs to the logged-in user
    if (!$reviewRequest) {
        Session::flash('warning', 'Unauthorized access to this review request.');
        return redirect('/');
    }

    // Retrieve reviews and user details for the post profile view
    $conlistreviews = ConsumerReview::where('post_id', $post_id)
                        ->where('user_id', $u_id)
                        ->get();
    $users = EcosansarUsers::where('id', $u_id)->first();

    return view('frontend/postprofile', compact('users', 'conlistreviews', 'u_id', 'post_id'));
}

    public function sabpostprofile($u_id)
    {
         // Retrieve the review_id from the query string
     $review_id = request()->query('review_id');
         $user_id = session()->get('user_id');
        $conpost = SABPost::where('user_id', $u_id)->first();
        $post_id = $conpost->id;
        $u_id = $conpost->user_id;
         $user_type = session()->get('user_type');
        if (null === $user_id || $user_id === '') {
            // User is not logged in, redirect to the login page
             $redirectUrl = route('sabpostprofile', ['id' => $u_id]) . ($review_id ? '?review_id=' . $review_id : '');
             session()->put('redirect_askrev', $redirectUrl);

            return redirect()->route('consumer_login');
        }


         // Retrieve the review request and check if it has already been read
    $reviewRequest = ConsumerAskReview::where('id', $review_id)->where('user_id', $user_id)
                        ->first();


    if ($reviewRequest && $reviewRequest->status === 'read') {
        // Redirect to home with a message indicating the review has already been submitted
         Session::flash('error', 'Error');
       return redirect('/');
    }
     // Check if the review request exists and belongs to the logged-in user
    if (!$reviewRequest) {
        Session::flash('warning', 'Unauthorized access to this review request.');
        return redirect('/');
    }

        $conlistreviews = SABReview::where('post_id', $post_id)->where('user_id', $u_id)->get();
        $users = EcosansarUsers::where('id', $u_id)->first();

        return view('frontend/sabpostprofile', compact('users', 'conlistreviews', 'u_id', 'post_id'));
    }
    public function buspostprofile($u_id)
    {
         // Retrieve the review_id from the query string
     $review_id = request()->query('review_id');
          $user_id = session()->get('user_id');
        $conpost = BusinessPost::where('user_id', $u_id)->first();
        $post_id = $conpost->id;
        $u_id = $conpost->user_id;

         $user_type = session()->get('user_type');
        if (null === $user_id || $user_id === '') {
            // User is not logged in, redirect to the login page
             $redirectUrl = route('buspostprofile', ['id' => $u_id]) . ($review_id ? '?review_id=' . $review_id : '');
             session()->put('redirect_askrev', $redirectUrl);

            return redirect()->route('consumer_login');
        }

         // Retrieve the review request and check if it has already been read
    $reviewRequest = ConsumerAskReview::where('id', $review_id)->where('user_id', $user_id)
                        ->first();


    if ($reviewRequest && $reviewRequest->status === 'read') {
        // Redirect to home with a message indicating the review has already been submitted
         Session::flash('error', 'Error');
       return redirect('/');
    }
    // Check if the review request exists and belongs to the logged-in user
    if (!$reviewRequest) {
        Session::flash('warning', 'Unauthorized access to this review request.');
        return redirect('/');
    }

        $conlistreviews = BusinessReview::where('post_id', $post_id)->where('user_id', $u_id)->get();
        $users = EcosansarUsers::where('id', $u_id)->first();

        return view('frontend/buspostprofile', compact('users', 'conlistreviews', 'u_id', 'post_id'));
    }
    public function filter()
    {
        return view('frontend/auth/consumerlogin');
    }

    public function about()
    {
          // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on about page';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end
        $afterbanner = GoogleAdsense::where('place_of_adsense','After about breadcrumb')->first();
        return view('frontend/about',compact('afterbanner'));
    }

    public function privacypolicy()
    {
          // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on about page';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        return view('frontend/privacypolicy');
    }

    public function blog()
    {
        // Fetch all blogs where active = 1
        // $blogs = Blog::where('active', 1)->orderBy('id','desc')->get();
        $blogs = Blog::where('active', 1)
        ->orderBy('id', 'desc')
        ->get()
        ->map(function ($blog) {
            // Check if posted_by is 'admin', 'user', or an ID
            if ($blog->posted_by === 'admin') {
                $blog->posted_by_name = 'Admin';
            } elseif ($blog->posted_by === 'user') {
                $blog->posted_by_name = 'User';
            } elseif (is_numeric($blog->posted_by)) {
                // If it's a numeric value, fetch the volunteer name
                $volunteer = Volunteer::find($blog->posted_by);
                $blog->posted_by_name = $volunteer ? $volunteer->name : 'Unknown Volunteer';
            }

            return $blog;
        });

        // Fetch all categories and tags for the sidebar
        $categories = BlogCategory::all();
        $tags = BlogTag::all();

        return view('frontend.blog', compact('blogs', 'categories', 'tags'));
    }

    public function blog_detail($id){
     // Fetch the blog by ID
    $blog = Blog::findOrFail($id);
    // Resolve posted_by_name
    if ($blog->posted_by === 'admin') {
        $blog->posted_by_name = 'Admin';
    } elseif ($blog->posted_by === 'user') {
        $blog->posted_by_name = 'User';
    } else {
        // Assuming the value is a volunteer ID, fetch the volunteer's name
        $volunteer = Volunteer::find($blog->posted_by);
        $blog->posted_by_name = $volunteer ? $volunteer->name : 'Unknown Volunteer';
    }
    $userid = session()->get('user_id');
    // Split the category and tag fields and fetch their names from the database
    $categoryIds = explode(',', $blog->category);
    $tagIds = explode(',', $blog->tag);

   // Fetch category and tag models based on the IDs
    $categories = BlogCategory::whereIn('id', $categoryIds)->get(); // Get models instead of names
    $tags = BlogTag::whereIn('id', $tagIds)->get(); // Get models instead of names

     // Fetch all categories and tags to show in the sidebar
        $categoriesall = BlogCategory::all();
        $tagsall = BlogTag::all();
    // Fetch comments associated with this blog post
    $comments = Comment::with('replies')->where('blog_id', $id)->where('active',1)->get();
  // Generate CAPTCHA
        $captcha = $this->generateCaptcha();
         // Store CAPTCHA value in session
        session(['captcha' => $captcha]);
    // Return the view with the blog data
    return view('frontend.blog-detail', compact('blog','categories','tags','categoriesall','tagsall','id','userid','comments','captcha'));
    }
    public function categoryBlogs($id)
    {
        // Fetch the category by ID
        $category = BlogCategory::findOrFail($id);

        // Fetch blogs related to the category
        $blogs = Blog::where('active', 1)
            ->where(function ($query) use ($id) {
                $query->where('category', $id) // Check for exact match
                      ->orWhere('category', 'LIKE', "%,$id,%") // Match in the middle
                      ->orWhere('category', 'LIKE', "$id,%")   // Match at the start
                      ->orWhere('category', 'LIKE', "%,$id");  // Match at the end
            })
             ->orderBy('id', 'DESC') // Fetch in descending order
            ->get();
        $blogs->each(function ($blog) {
    if ($blog->posted_by == 'admin') {
        $blog->posted_by_name = 'Admin'; // Static name for admin
    } elseif ($blog->posted_by == 'user') {
        $blog->posted_by_name = 'User'; // Static name for user
    } else {
        // Assuming posted_by is the Volunteer ID
        $volunteer = \App\Models\admin\Volunteer::find($blog->posted_by); // Find the volunteer by ID
        if ($volunteer) {
            $blog->posted_by_name = $volunteer->name; // Set the volunteer name
        } else {
            $blog->posted_by_name = 'Unknown'; // In case the volunteer ID doesn't exist
        }
    }
});

        // Fetch all categories and tags to show in the sidebar
        $categories = BlogCategory::all();
        $tags = BlogTag::all();

        // Return the view with the filtered blogs
        return view('frontend.blog', compact('blogs', 'categories', 'tags', 'category'));
    }

    public function tagBlogs($id)
    {
        // Fetch the tag by ID
        $tag = BlogTag::findOrFail($id);

        // Fetch blogs related to the tag
        $blogs = Blog::where('active', 1)
        ->where(function ($query) use ($id) {
            $query->where('tag', $id) // Check for exact match
                  ->orWhere('tag', 'LIKE', "%,$id,%") // Match in the middle
                  ->orWhere('tag', 'LIKE', "$id,%")   // Match at the start
                  ->orWhere('tag', 'LIKE', "%,$id");  // Match at the end
        })
         ->orderBy('id', 'DESC') // Fetch in descending order
        ->get();
    $blogs->each(function ($blog) {
    if ($blog->posted_by == 'admin') {
        $blog->posted_by_name = 'Admin'; // Static name for admin
    } elseif ($blog->posted_by == 'user') {
        $blog->posted_by_name = 'User'; // Static name for user
    } else {
        // Assuming posted_by is the Volunteer ID
        $volunteer = \App\Models\admin\Volunteer::find($blog->posted_by); // Find the volunteer by ID
        if ($volunteer) {
            $blog->posted_by_name = $volunteer->name; // Set the volunteer name
        } else {
            $blog->posted_by_name = 'Unknown'; // In case the volunteer ID doesn't exist
        }
    }
});
        // Fetch all categories and tags to show in the sidebar
        $categories = BlogCategory::all();
        $tags = BlogTag::all();

        // Return the view with the filtered blogs
        return view('frontend/blog', compact('blogs', 'categories', 'tags', 'tag'));
    }

    public function ourteam()
    {
        return view('frontend/ourteam');
    }

    public function faq()
    {

      // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on faq page';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        $faqs = Faq::join('categories', 'categories.id', 'faqs.category')
            ->select('faqs.*', 'categories.category_name')
            ->get();
 $categories = Category::orderBy('id','DESC')->get();
        // echo "<pre>";
        // print_r($faqs);
        // die;
        return view('frontend/faq', compact('faqs','categories'));
    }

    public function howitsworks()
    {
       // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on how its works page';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end
        $howitwork = About::get();
        return view('frontend/howitsworks',compact('howitwork'));
    }
    public function service()
    {
       // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on how its works page';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end
        $service = Service::get();
        return view('frontend/service',compact('service'));
    }
 private function generateCaptcha()
    {

        $captchaLength = 6; // Set the length of the CAPTCHA
        $captchaCharacters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'; // Define the characters to be used in the CAPTCHA
        $captcha = '';

        for ($i = 0; $i < $captchaLength; $i++) {
            $randomIndex = rand(0, strlen($captchaCharacters) - 1);
            $captcha .= $captchaCharacters[$randomIndex];
        }

        return $captcha;
    }
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
    public function contact()
    {
        // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on contact page';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end
        // Generate CAPTCHA
        $captcha = $this->generateCaptcha();

        // Store CAPTCHA value in session
        session(['captcha' => $captcha]);
        return view('frontend/contact',compact('captcha'));
    }
    public function contact_store(Request $req){
        $req->validate([
            'email' => 'required|email',
            'name' => 'required',
            'phone_no' => 'required',
            'captcha' => 'required'
        ]);
        // echo "<pre>";
        // print_r($req->all());
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

         $contact = new UserContact;
         $contact->name = $req->name;
        $contact->email = $req->email;
        $contact->phone_no = $req->phone_no;
        $contact->subject = $req->subject;
        $contact->message = $req->message;
        $contact->save();

        $data = [

            'name' =>  $req->name,
            'email' => 'ecosansar@yahoo.com',
            'useremail' => $req->email,
             'phone' => $req->phone_no,
            'sub' => $req->subject,
            'msg' => $req->message,

            ];


            // $data["title"] = "IIV India Registered Valuers Foundation | Payment Success | Thank you";
            $data["title"] =  "New contact from ". $req->name;
            // Mail::to(Auth::user()->email)->send(new Payment_done_mail($data));
            // Mail::send('frontend.mail.contactmail', $data, function($message)use($data){
            //     $message->to($data["email"], $data["email"])
            //             ->subject($data["title"]);
            // });

            // Render the email body using the Blade view
            $body = view('frontend.mail.contactmail', $data)->render();
            // Call your mailer service to send the email
            $this->mailerService->sendEmail($data['email'], $data['title'], $body, $data);

         Session::flash('success', 'Contact Details Sent Successfully');
       return redirect()->back();
    }
    public function user_register()
    {
        return view('frontend/auth/register');
    }
    public function user_type()
    {
        return view('frontend/auth/usertype');
    }
    public function business_add()
    {
        return view('frontend/auth/businessadd');
    }
    public function sab_add()
    {
        return view('frontend/auth/sabadd');
    }
    public function consumer_add()
    {
        return view('frontend/auth/consumeradd');
    }
    public function business_save(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'password' =>  'required|min:8',
            'pincode' => 'required|min:6|max:6',
            'mobile' => 'required|unique:ecosansar_users,mobile',
            'email' => 'required|email',
            'address' => 'required',
            'gst' => 'required|min:15|regex:/^([0-9]){2}([A-Za-z]){5}([0-9]){4}([A-Za-z]){1}([0-9]{1})([A-Za-z]){1}([0-9]{1})?$/',
        ]);
        //  echo $a = Hash::make($req->password);die;

        $user = new EcosansarUsers;
        $user->name = $req->name;
        $user->address = $req->address;
        $user->pincode = $req->pincode;
        $user->contact_person = $req->contact_person;
        $user->mobile = $req->mobile;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->gst = $req->gst;
        $user->user_type = $req->user_type;
        $user->save();
        Alert::success('success', 'Registration Successfull');
        return redirect()->back();
    }

    public function sab_save(Request $req)
    {

        $req->validate([
            'name' => 'required',
            'pincode' => 'required|min:6|max:6',
            'mobile' => 'required|unique:ecosansar_users,mobile',
            'address' => 'required',
            // 'latitude' => 'required',
            // 'longitude' =>'required'
        ]);
        $user = new EcosansarUsers;
        $user->name = $req->name;
        $user->address = $req->address;
        $user->pincode = $req->pincode;
        $user->mobile = $req->mobile;
        $user->latitude = $req->latitude;
        $user->longitude = $req->longitude;
        $user->user_type = $req->user_type;
        $user->save();

        Alert::success('success', 'Registration Successfull');

        return redirect()->back();
    }


    public function consumer_save(Request $req)
    {

        $rules = [
            'type_of_user' => 'required',
            'name' => 'required',
            'pincode' => 'required|min:6|max:6',
            'address' => 'required',
            'mobile' => 'required|unique:ecosansar_users,mobile',
            'terms' => 'required',
        ];

        if ($req->type_of_user == 'consumer') {
            $rules['type_of_residences'] = 'required';
        }

        if ($req->type_of_user == 'business') {
            $rules['email'] = 'required';
        }

        $messages = [
            'mobile.required' => 'The mobile number is required.',
            'mobile.unique' => 'This number is in use',
            // Add more custom messages for the mobile field if needed  Please verify or use another one.
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $user = DB::table('ecosansar_users')
                ->where('mobile', $req->mobile)
                ->first();

            if ($user) {
                if ($user->is_delete == 1) {
                    $errors['mobile'][0] .= ' but deactivated. <a href="https://ecosansar.com/user_activate/' . $user->id . '">Click to activate</a>';
                } elseif ($user->is_verify == 0) {
                    $errors['mobile'][0] .= ' but not verified. <a href="https://ecosansar.com/loginverify_otp/' . $user->id . '">Click to verify</a>';
                } else {
                    $errors['mobile'][0] .= ' .<a href="https://ecosansar.com/consumer_login"> Click to login</a>';
                }
            }

            return response()->json(['errors' => $errors], 422);
        }


        // echo "<pre>";
        //     print_r($req->all());
        //     die;


        $user = new EcosansarUsers;
        $user->user_type = $req->type_of_user;
        $user->name = $req->name;
        $user->mobile = $req->mobile;
        $user->address = $req->address;
        $user->pincode = $req->pincode;
        $user->type_of_residences = $req->type_of_residences;
        $user->email = $req->email;
        //  $user->password = Hash::make($req->password);
        $user->otp = 123456;
        $user->is_checked = 1;
        // $user->latitude = $req->latitude;
        // $user->longitude = $req->longitude;
        $user->save();

        $contact = $req->mobile;

        // Generate a 6-digit random OTP
        $otp = mt_rand(100000, 999999);

        $templateId = '6697c327d6fc05609f5064c2'; // Ensure this is a valid string from MSG91
        $apiKey = config('services.msg91.authkey'); // Fetch authkey from config

        //Update OTP and expiration time in the database
        DB::table('ecosansar_users')
            ->where('mobile', $contact)
            ->update([
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(10), // OTP valid for 10 minutes
            ]);

        // Prepare the data for the cURL request
        $data = json_encode([
            'template_id' => $templateId,
            'short_url' => '0',
            'realTimeResponse' => '1',
            'recipients' => [
                [
                    'mobiles' => '91' . $contact,
                    'var' => $otp
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

        if ($err) {
            return response()->json([
                'status' => 'error',
                'message' => "cURL Error #: $err",
            ], 500);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => $response,
                'user_id' => $user->id,
            ]);
            //return redirect()->route('register_otp', ['id' => $user->id]);
        }
        // Manually log in the user by storing user information in the session
        Session::put('user_id', $user->id);
        Session::put('user_name', $user->name);
        Session::put('user_email', $user->email);
        Session::put('user_type', $user->user_type);
        Session::flash('success', 'Registration Successful');
 return redirect()->route('profile', ['id' => $user->id]);
        //return redirect()->route('consumer_login');
    }

    public function register_otp($id)
    {
        // echo $id;
        $users = EcosansarUsers::where('id', $id)->first();
        return view('frontend/auth/registerotp', compact('users'));
    }
    public function activate_otp($id)
    {
        // echo $id;
        $users = EcosansarUsers::where('id', $id)->first();
        return view('frontend/auth/activateotp', compact('users'));
    }

    public function business_login()
    {
        return view('frontend/auth/businesslogin');
    }
    public function business_store(Request $request)
    {
        // Get the input data from the request
        $input = $request->all();

        // Perform validation on the input data
        $validator = Validator::make($input, [
            'email' => 'required|exists:ecosansar_users,email',
            'password' => 'required|min:8',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->route('business_login')->withErrors($validator)->withInput();
        }

        // Retrieve the user by the provided email address
        $user = EcosansarUsers::where('email', $input['email'])->where('user_type', 'business')->first();

        // Check if user exists and is checked
        if ($user && $user->is_checked && Hash::check($input['password'], $user->password)) {
            // Authentication successful, redirect to business details page
            session()->put('user_id', $user->id);
            session()->put('user_type', $user->user_type);



            // Check if there is a redirect_to value in the session
            $redirect_to = session()->get('redirect_to');
            if ($redirect_to) {
                // If so, redirect the user to that page
                session()->forget('redirect_to'); // Clear the session value
                return redirect($redirect_to);
            }

            // If there's no redirect_to value, redirect to the business_posts page
            return redirect()->route('business_posts');
        } else {
            // Authentication failed, redirect back to login with error message
            if ($user && !$user->is_checked) {
                return redirect()->route('business_login')->withErrors([
                    'email' => 'You need approval from administrator.',
                ])->withInput();
            } else {
                return redirect()->route('business_login')->withErrors([
                    'password' => 'You have entered an incorrect password.',
                ])->withInput();
            }
        }
    }

    public function business_post_save(Request $request)
    {
        // echo "<pre>";
        // print_r($request->all());
        // die;

        $user_id = session()->get('user_id');
        $email = EcosansarUsers::where('id', $user_id)->first();

       // Validate based on sale_giveaway option
if ($request->sale_giveaway == 'Buy') {

    $request->validate([
        'address' => 'required',
        'pincode' => 'required|exists:pincodes,pincode',
        'sale_giveaway' => 'required',
        'quantity' => 'required',
        'clean_unclean' => 'required',
        'packaged' => 'required',
        'resource_type' => 'required|array|min:1',
       'resource_img.*' => 'mimes:jpg,jpeg,png,bmp', // Adjust mime types and max size as needed
    ], [

        'pincode.exists' => 'We are not servicable in this area.'
    ]);

} else {

    $request->validate([
        'address' => 'required',
        'pincode' => 'required|exists:pincodes,pincode',
        'sale_giveaway' => 'required',
        'quantity' => 'required',
        'clean_unclean' => 'required',
        'packaged' => 'required',
        'resource_type' => 'required|array|min:1',
    'resource_img' => 'required|array|min:1',
       'resource_img.*' => 'required|mimes:jpg,jpeg,png,bmp', // Adjust mime types and max size as needed

    ], [

        'pincode.exists' => 'We are not servicable in this area.'
    ]);

    // Check if the number of selected resources matches the number of uploaded images
     if ($request->sale_giveaway !== 'Buy') {
    if (count($request->resource_type) !== count($request->resource_img)) {
        return back()->withErrors(['resource_img' => 'Please upload an image for each resource type.'])->withInput();
    }
     }
}



        // Convert the selected resources to a comma-separated string if needed
        $resourceIds = !empty($request->resource_type) ? implode(',', $request->resource_type) : null;

        // Create and save the main business post
        $user = new BusinessPost();
        $user->user_id = $user_id;
        $user->email = $email->email;
        $user->address = $request->address;
        $user->pincode = $request->pincode;
        $user->sale_giveaway = $request->sale_giveaway;
        $user->quantity = $request->quantity;
        $user->clean_unclean = $request->clean_unclean;
        $user->packaged = $request->packaged;
        $user->description = $request->description;

        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->save();

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
    }
    $imageContent = ob_get_clean(); // Get the image content from the buffer

    // Free up memory
    imagedestroy($newImage);
    imagedestroy($sourceImage);

    return $imageContent; // Return the resized image content as a binary string
}


        // Save resources and images
        foreach ($request->resource_type as $index => $resourceId) {
            if (!empty($resourceId)) {
            $resource = new BusinessResourcePost();
            $resource->user_id = $user_id;
            $resource->post_id = $user->id;
            $resource->resource_type = $resourceId;

            // Check if the corresponding image exists
            if (isset($request->resource_img[$index])) {
                $image = $request->file('resource_img')[$index];
                $imageName = $user_id . '_' . $user->id . '_' . $resourceId . '.' . $image->getClientOriginalExtension();

                // Upload the original image file to S3

               try {
                   // Resize the image
                            $resizedImageContent = resizeImage($image->getRealPath(), 800, 600); // Adjust width and height as needed

                            // Convert resized image content to a stream for S3 upload
                            $resizedImageStream = fopen('php://memory', 'r+');
                            fwrite($resizedImageStream, $resizedImageContent);
                            rewind($resizedImageStream);

                   // Define the S3 path where the file will be stored
                    $s3Directory = 'Businessposts';
                    $s3Path = $s3Directory . '/' . $imageName;

                    // Upload the file to S3 in the specified directory
                  //  $uploaded = Storage::disk('s3')->putFileAs($s3Directory, $image, $imageName);
                  $uploaded = Storage::disk('s3')->put($s3Path, $resizedImageStream);


                if (!$uploaded) {
                    throw new \Exception('Image upload returned false');
                }
                fclose($resizedImageStream);
            } catch (\Exception $e) {
                Log::error('S3 Upload Error: ' . $e->getMessage());
                return response()->json(['error' => 'Image upload to S3 failed: ' . $e->getMessage()], 500);
            }



                // Save the S3 path in the database
                $resource->resource_img = $imageName;
                $resource->save();
            }

            $resource->save();
        }
    }
                // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Corporate post add';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

         Session::flash('success', 'Post Added Successfully. You can view in my profile page');
        return redirect()->route('listings');
    }

    public function business_posts()
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $listings = BusinessPost::join('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
            ->join('resources', 'resources.id', 'business_resource_posts.resource_type')
            ->select('business_posts.*', 'resources.resource_name', 'business_resource_posts.resource_img')
            ->where('business_posts.user_id', '!=', $user_id)
            ->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $uniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->implode(', ');
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $uniqueListings->push($uniqueListing);
        }

        return view('frontend/userdetails/businessposts', compact('uniqueListings'));
    }
    public function business_own_posts()
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $listings = BusinessPost::join('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
            ->join('resources', 'resources.id', 'business_resource_posts.resource_type')
            ->select('business_posts.*', 'resources.resource_name', 'business_resource_posts.resource_img')
            ->where('business_posts.user_id',  $user_id)
            ->where('business_posts.active',  1)
            ->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $uniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $uniqueListings->push($uniqueListing);
        }

         // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on my listing';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        return view('frontend/userdetails/businessownposts', compact('uniqueListings'));
    }
    public function business_details()
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $users = EcosansarUsers::where('id', $user_id)->first();
        $resources = Resource::get();
        $weights = Weight::get();

         // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on add your post';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end


        return view('frontend/userdetails/businessdetails', compact('user_id', 'resources', 'weights', 'users'));
    }

    public function sab_login()
    {
        return view('frontend/auth/sablogin');
    }

    public function user_deactivate()
    {
        // Clear all session data

        // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'User deactivate account';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end



        $user_id = session()->get('user_id');

        $result = EcosansarUsers::where('id', $user_id)->first();
        $result->is_delete = '1';
        $result->save();

        Session::flush();

        // Redirect to the login page

        return redirect('/');
    }

    public function user_activate($id)
    {
        // Clear all session data

        $result = EcosansarUsers::where('id', $id)->first();
        // $result->is_delete = '0';
        // $result->save();

        // $response = Http::post(route('resend_Otp'), [
        // 'user_id' => $result->id,
        // 'contact' => $result->mobile, // Adjust as necessary
        // ]);

        $contact = $result->mobile;

        // Generate a 6-digit random OTP
        $otp = mt_rand(100000, 999999);

        $templateId = '6697c327d6fc05609f5064c2'; // Ensure this is a valid string from MSG91
        $apiKey = config('services.msg91.authkey'); // Fetch authkey from config

        //Update OTP and expiration time in the database
        $user = DB::table('ecosansar_users')
            ->where('id', $id)
            ->update([
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(10), // OTP valid for 10 minutes
            ]);

        // echo"<pre>";
        // print_r($user);
        // die;

        // Prepare the data for the cURL request
        $data = json_encode([
            'template_id' => $templateId,
            'short_url' => '0',
            'realTimeResponse' => '1',
            'recipients' => [
                [
                    'mobiles' => '91' . $contact,
                    'var' => $otp
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

        if ($err) {
            return response()->json([
                'status' => 'error',
                'message' => "cURL Error #: $err",
            ], 500);
        } else {
            // return response()->json([
            //     'status' => 'success',
            //     'message' => $response,
            // ]);
            return redirect()->route('activate_otp', ['id' => $result->id]);
        }

        //  Session::flash('success', 'user actived Successfully');
        // return redirect()->route('send.otp');
        //   return redirect()->route('register_otp', ['id' => $result->id]);

    }

    public function signOut()
    {
        // Clear all session data

         // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'User logout';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        Session::flush();

        // Redirect to the login page
        return redirect('/');
    }

    public function sab_store(Request $request)
    {
        // Get the input data from the request
        $input = $request->all();

        // Perform validation on the input data
        $validator = Validator::make($input, [
            'mobile' => 'required|exists:ecosansar_users,mobile',
            'otp' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->route('sab_login')->withErrors($validator)->withInput();
        }

        // Retrieve the user by the provided email address
        $user = EcosansarUsers::where('mobile', $input['mobile'])->where('user_type', 'sab')->first();

        // Verify the otp
        if ($user && $user->is_checked && ($input['otp'] == $user->otp)) {
            // Authentication successful, redirect to business details page
            session()->put('user_id', $user->id);
            session()->put('user_type', $user->user_type);
            // Check if there is a redirect_to value in the session
            $redirect_to = session()->get('redirect_to');
            //$redirect_to = session('redirect_to');
            if ($redirect_to) {
                // If so, print the value (for debugging purposes)
                //  echo "Redirect To: " . $redirect_to;
                // Redirect the user to that page
                session()->forget('redirect_to'); // Clear the session value
                return redirect($redirect_to);
            }

            // If there's no redirect_to value, redirect to the consumer_posts page
            return redirect()->route('sab_posts');
        } else {
            // Authentication failed, redirect back to login with error message
            if ($user && !$user->is_checked) {
                return redirect()->route('sab_login')->withErrors([
                    'mobile' => 'You need approval from administrator.',
                ])->withInput();
            } else {
                return redirect()->route('sab_login')->withErrors([
                    'otp' => 'You have entered an incorrect otp.',
                ])->withInput();
            }
        }
    }
    public function sab_posts()
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $listings = SABPost::join('s_a_b_resource_posts', 's_a_b_resource_posts.post_id', 's_a_b_posts.id')
            ->join('resources', 'resources.id', 's_a_b_resource_posts.resource_type')
            ->select('s_a_b_posts.*', 'resources.resource_name', 's_a_b_resource_posts.resource_img')
            ->where('s_a_b_posts.user_id', '!=', $user_id)
            ->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $uniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->implode(', ');
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $uniqueListings->push($uniqueListing);
        }


        $buslistings = BusinessPost::join('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
            ->join('resources', 'resources.id', 'business_resource_posts.resource_type')
            ->select('business_posts.*', 'resources.resource_name', 'business_resource_posts.resource_img')
            // ->where('business_posts.user_id', '!=', $user_id)
            ->get();

        // Extract unique post IDs
        $buspostIds = $buslistings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $busuniqueListings = collect([]);
        foreach ($buspostIds as $postId) {
            $buspostListings = $buslistings->where('id', $postId);
            $resourceNames = $buspostListings->pluck('resource_name')->implode(', ');
            $resourceImages = $buspostListings->pluck('resource_img')->implode(', ');
            $busuniqueListing = $buspostListings->first();
            $busuniqueListing->resource_names = $resourceNames;
            $busuniqueListing->resource_img = $resourceImages;
            $busuniqueListings->push($busuniqueListing);
        }

        $conlistings = ConsumerPost::join('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
            ->join('resources', 'resources.id', 'consumer_resource_posts.resource_type')
            ->select('consumer_posts.*', 'resources.resource_name', 'consumer_resource_posts.resource_img')
            ->where('consumer_posts.sale_giveaway', '=', 'Sale')
            ->get();

        // Extract unique post IDs
        $conpostIds = $conlistings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $conuniqueListings = collect([]);
        foreach ($conpostIds as $postId) {
            $conpostListings = $conlistings->where('id', $postId);
            $resourceNames = $conpostListings->pluck('resource_name')->implode(', ');
            $resourceImages = $conpostListings->pluck('resource_img')->implode(', ');
            $conuniqueListing = $conpostListings->first();
            $conuniqueListing->resource_names = $resourceNames;
            $conuniqueListing->resource_img = $resourceImages;
            $conuniqueListings->push($conuniqueListing);
        }

        return view('frontend/userdetails/sabposts', compact('conuniqueListings', 'uniqueListings', 'busuniqueListings'));
    }
    public function sab_own_posts()
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $listings = SABPost::join('s_a_b_resource_posts', 's_a_b_resource_posts.post_id', 's_a_b_posts.id')
            ->join('resources', 'resources.id', 's_a_b_resource_posts.resource_type')
            ->select('s_a_b_posts.*', 'resources.resource_name', 's_a_b_resource_posts.resource_img')
            ->where('s_a_b_posts.user_id', $user_id)
            ->where('s_a_b_posts.active', 1)
            ->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $uniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $uniqueListings->push($uniqueListing);
        }

        // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on my listing';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end


        return view('frontend/userdetails/sabownposts', compact('uniqueListings'));
    }
    public function sab_details()
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $users = EcosansarUsers::where('id', $user_id)->first();
        $resources = Resource::get();
        $weights = Weight::get();

          // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on add your post';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end
        return view('frontend/userdetails/sabdetails', compact('user_id', 'resources', 'weights', 'users'));
    }
    public function sab_post_save(Request $request)
    {


        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');

        $rules = [
            'name' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'pincode' => 'required|exists:pincodes,pincode',
            'sale_giveaway' => 'required',
            'quantity' => 'required',
            'clean_unclean' => 'required',
            'packaged' => 'required',
            'resource_type' => 'required|array|min:1',
        ];

        // // Specific validation rules for 'Giveaway'
        // if ($request->sale_giveaway !== 'Buy') {
        //     $rules['resource_img'] = 'required|array|min:1';
        //     $rules['resource_img.*'] = 'required|mimes:jpg,jpeg,png,bmp|max:10240'; // Adjust mime types and max size as needed
        // }

        // Apply different rules based on the value of 'sale_giveaway'
if ($request->sale_giveaway === 'Buy') {
    // For 'Buy', make images optional but still enforce size limit if images are uploaded
    $rules['resource_img'] = 'array'; // Optional array for Buy
    $rules['resource_img.*'] = 'mimes:jpg,jpeg,png,bmp'; // Optional but size restricted
} else {
    // For 'Sale' and 'Giveaway', images are required
    $rules['resource_img'] = 'required|array|min:1';
    $rules['resource_img.*'] = 'required|mimes:jpg,jpeg,png,bmp';
}

        // Define custom error messages
    $messages = [

        'pincode.exists' => 'Service is not available in this area'
    ];


     $validator = \Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

        // Check if the number of selected resources equals the number of uploaded images
        if ($request->sale_giveaway !== 'Buy') {
            if (count($request->resource_type) !== count($request->resource_img)) {
                return back()->withErrors(['resource_img' => 'Please upload image here.'])->withInput();
            }
        }


    // If there are any errors, redirect back with errors
    if (!empty($errors)) {
        return back()->withErrors($errors)->withInput();
    }

        // Process the data and save the post
        $user = new SABPost();
        $user->user_id = $user_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->pincode = $request->pincode;
        $user->sale_giveaway = $request->sale_giveaway;
        $user->quantity = $request->quantity;
        $user->clean_unclean = $request->clean_unclean;
        $user->packaged = $request->packaged;

        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->save();


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
    }
    $imageContent = ob_get_clean(); // Get the image content from the buffer

    // Free up memory
    imagedestroy($newImage);
    imagedestroy($sourceImage);

    return $imageContent; // Return the resized image content as a binary string
}


       foreach ($request->resource_type as $index => $resourceId) {
    if (!empty($resourceId)) {
        $resource = new SABResourcePost();
        $resource->user_id = $user_id;
        $resource->post_id = $user->id;
        $resource->resource_type = $resourceId;

        if (isset($request->resource_img[$index])) {
            $image = $request->file('resource_img')[$index];
            $imageName = $user_id . '_' . $user->id . '_' . $resourceId . '.' . $image->getClientOriginalExtension();

            try {
                 // Resize the image
                $resizedImageContent = resizeImage($image->getRealPath(), 800, 600); // Adjust width and height as needed

                // Convert resized image content to a stream for S3 upload
                $resizedImageStream = fopen('php://memory', 'r+');
                fwrite($resizedImageStream, $resizedImageContent);
                rewind($resizedImageStream);

                // Define the S3 path where the file will be stored
                $s3Directory = 'SABposts';
                $s3Path = $s3Directory . '/' . $imageName;

                // Upload the file to S3 in the specified directory
               // Upload the resized image to S3
                $uploaded = Storage::disk('s3')->put($s3Path, $resizedImageStream);

                if (!$uploaded) {
                    throw new \Exception('Image upload returned false');
                }
                fclose($resizedImageStream);

             // Get the public URL of the uploaded image
        $imageUrl = Storage::disk('s3')->url($s3Path);


                // Save the S3 path in the database
                $resource->resource_img = $imageName;
                // $resource->resource_img_url = $imageUrl;
                $resource->save();

            } catch (\Exception $e) {
                Log::error('S3 Upload Error: ' . $e->getMessage());
                return response()->json(['error' => 'Image upload to S3 failed: ' . $e->getMessage()], 500);
            }
        }

        $resource->save();
    }
}


              // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Resource post add';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        Session::flash('success', 'Post Added Successfully. You can view in my profile page');
        return redirect()->route('listings');
    }

    public function consumer_login(Request $request)
    {
        if ($request->has('redirect')) {
            session()->put('redirect_to', $request->input('redirect'));
        }
        if ($request->has('redirect_list')) {
            session()->put('redirect_to_list', $request->input('redirect_list'));
        }
        return view('frontend/auth/consumerlogin');
    }

    public function checkContact(Request $request)
    {
        $contact = $request->contact;
        // Check if it's an email or phone number
        if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
            $exists = EcosansarUsers::where('email', $contact)->exists();
        } elseif (preg_match('/^\d{10,15}$/', $contact)) {
            $exists = EcosansarUsers::where('mobile', $contact)->exists();
        } else {
            return response()->json(['error' => 'Invalid contact information'], 400);
        }

        if ($exists) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
    }

    public function consumer_store(Request $request)
    {
        // Get the input data from the request
        $input = $request->all();

        // Custom validation rule to check if the input is a valid mobile
        Validator::extend('mobile', function ($attribute, $value, $parameters, $validator) {
            $mobileRegex = '/^\d{10,15}$/';
            return preg_match($mobileRegex, $value);
        }, 'The contact must be a valid mobile number.');

        // Perform validation on the input data
        $validator = Validator::make($input, [
            'mobile' => 'required|mobile',
            'otp' => 'required',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Retrieve user by mobile number
        $user = EcosansarUsers::where('mobile', $input['mobile'])
            ->whereIn('user_type', ['consumer', 'sab', 'business'])
            ->first();

        // Verify the otp
        if (!$user) {
            // User not found
            return redirect()->back()->withErrors(['contact' => 'User not found please register first.'])->withInput();
        }

        // Handle authentication with OTP
        if ($user && $user->is_checked && $input['otp'] == $user->otp && now()->lessThanOrEqualTo($user->otp_expires_at) && $user->is_verify == 1 && $user->is_delete == 0) {

            // Authentication successful
            session()->put('user_id', $user->id);
            session()->put('user_type', $user->user_type);

                 // user activity start
            $userid = session()->get('user_id');
            if ($userid){
                $userActivity = new UserActivityLog();
                $userActivity->user_id = $userid;
                $userActivity->activity = 'User login';
                $userActivity->url = request()->fullUrl();   // Get the full URL of the request
                $userActivity->ip_address = request()->ip();
                $userActivity->save();
            }
            // user activity end
            //Check for review redirect
         if (session()->has('redirect_askrev')) {
            $redirect_askrevto = session()->pull('redirect_askrev');
            Log::info('Redirecting to WhatsApp share URL', ['redirect_revurl' => $redirect_askrevto]);
            return redirect($redirect_askrevto);
        }
         //Check for change review
         if (session()->has('redirect_changerev')) {

            $redirect_changerevto = session()->pull('redirect_changerev');
           Log::info('Redirecting to WhatsApp share URL', ['redirect_chrevurl' => $redirect_changerevto]);
           return redirect($redirect_changerevto);
       }
            //check for whatsapp url
            if (session()->has('redirect_wp')) {
                $redirect_wpto = session()->pull('redirect_wp');
                Log::info('Redirecting to WhatsApp share URL', ['redirect_url' => $redirect_wpto]);
                return redirect($redirect_wpto);
            }

            // Check if there is a redirect URL
            if (session()->has('redirect_to')) {
                $redirect_to = session()->pull('redirect_to');
                $userType = session('user_type');

                // Redirect based on user type
                if ($userType == 'consumer') {
                    return redirect()->route('consumer_details');
                } elseif ($userType == 'sab') {
                    return redirect()->route('sab_details');
                } elseif ($userType == 'business') {
                    return redirect()->route('business_details');
                } else {
                    return redirect($redirect_to); // Redirect to the stored URL
                }
            }

            if (session()->has('redirect_to_list')) {
                $redirect_to = session()->pull('redirect_to_list');
                $userType = session('user_type');

                if ($userType == 'consumer') {
                    return redirect()->route('listings');
                } elseif ($userType == 'sab') {
                    return redirect()->route('listings');
                } elseif ($userType == 'business') {
                    return redirect()->route('listings');
                } else {
                    return redirect($redirect_to_list); // Redirect to the stored URL
                }
            }

            // if ($user->user_type == 'consumer') {
            //      Session::flash('success', 'Registration Successful');
            //     return redirect()->route('profile', ['id' => $user->id]);
            // } elseif ($user->user_type == 'sab') {
            //      Session::flash('success', 'Registration Successful');
            //     return redirect()->route('profile', ['id' => $user->id]);
            // } elseif ($user->user_type == 'business') {
            //      Session::flash('success', 'Registration Successful');
            //     return redirect()->route('profile', ['id' => $user->id]);
            // }
            if (in_array($user->user_type, ['consumer', 'sab', 'business'])) {
    Session::flash('success', 'Login Successful');
    return redirect()->route('profile', ['id' => $user->id]);
}

        } elseif ($user && now()->greaterThan($user->otp_expires_at)) {
            // OTP expired
            return redirect()->route('consumer_login')->withErrors([
                'otp' => 'OTP has expired. Please request a new one.',
            ])->withInput();
        } else {
            return redirect()->route('consumer_login')->withErrors([
                'otp' => 'You have entered an incorrect OTP.',
            ])->withInput();
        }
    }

    public function verifyOtp(Request $request)
    {
        // Validate the request data
        $request->validate([
            'contact' => 'required|digits:10', // Assuming Indian 10-digit phone number
            'otp' => 'required|digits:6',
        ]);

        $contact = $request->input('contact');
        $otp = $request->input('otp');

        // Use Eloquent model to query and update
        $user = EcosansarUsers::where('mobile', $contact)->first();


        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found please register first.',
            ], 404);
        }

        if ($user->otp_expires_at < now()) {
            return response()->json([
                'status' => 'error',
                'message' => 'OTP has expired. Please request a new OTP.',
            ], 400);
        }

        if ($user->otp != $otp) {
            return response()->json([
                'status' => 'error',
                'message' => 'Incorrect OTP. Please try again.',
            ], 400);
        }

        // user activity start
        // $user22 = EcosansarUsers::where('mobile', $contact)->first();

        //     $userid = session()->get('user_id');
        //     if ($user22 && $user22->is_delete == 1){
        //         $userActivity = new UserActivityLog();
        //         $userActivity->user_id = $userid;
        //         $userActivity->activity = 'User Deactivate';
        //         $userActivity->url = request()->fullUrl();   // Get the full URL of the request
        //         $userActivity->ip_address = request()->ip();
        //         $userActivity->save();
        //     }
        // user activity end
        // OTP is correct, update the is_verify field to 1
        $user->is_verify = 1;
        $user->is_delete = 0;
        //$result->is_delete = '0';
        $user->save();




        if ($user->email && $user->is_verify == 1 && $user->is_register == 0) {

            $user->is_register = 1;
            $user->save();

            $data = [
                'name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->mobile,
                // 'post_email' =>$details->email,
            ];

            $data["email"] = $user->email;
            // $data["title"] = "IIV India Registered Valuers Foundation | Payment Success | Thank you";
            $data["title"] =  "Welcome to The ZeroWaste Community Tool";
            // Mail::to(Auth::user()->email)->send(new Payment_done_mail($data));
            // Mail::send('frontend.mail.userregistrationemail', $data, function ($message) use ($data) {
            //     $message->to($data["email"], $data["email"])
            //         ->subject($data["title"]);
            // });3

            // Render the email body using the Blade view
            $body = view('frontend.mail.userregistrationemail', $data)->render();
            // Call your mailer service to send the email
            $this->mailerService->sendEmail($data['email'], $data['title'], $body, $data);
        }



        Session::put('user_id', $user->id);
        Session::put('user_name', $user->name);
        Session::put('user_email', $user->email);
        Session::put('user_type', $user->user_type);
         Session::flash('success', 'Registration Successful');
                // user activity start

              $userid = session()->get('user_id');
            if ($userid){
                $userActivity = new UserActivityLog();
                $userActivity->user_id = $userid;
                $userActivity->activity = 'User login';
                $userActivity->url = request()->fullUrl();   // Get the full URL of the request
                $userActivity->ip_address = request()->ip();
                $userActivity->save();
            }
        // user activity end

        return response()->json([
            'status' => 'success',
            'message' => 'OTP verified successfully.',
            'user_id' => $user->id
        ]);
    }
    public function activateverifyOtp(Request $request)
    {
        // Validate the request data
        $request->validate([
            'contact' => 'required|digits:10', // Assuming Indian 10-digit phone number
            'otp' => 'required|digits:6',
        ]);

        $contact = $request->input('contact');
        $otp = $request->input('otp');

        // Use Eloquent model to query and update
        $user = EcosansarUsers::where('mobile', $contact)->first();


        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found please register first.',
            ], 404);
        }

        if ($user->otp_expires_at < now()) {
            return response()->json([
                'status' => 'error',
                'message' => 'OTP has expired. Please request a new OTP.',
            ], 400);
        }

        if ($user->otp != $otp) {
            return response()->json([
                'status' => 'error',
                'message' => 'Incorrect OTP. Please try again.',
            ], 400);
        }

        // user activity start
        // $user22 = EcosansarUsers::where('mobile', $contact)->first();

        //     $userid = session()->get('user_id');
        //     if ($user22 && $user22->is_delete == 1){
        //         $userActivity = new UserActivityLog();
        //         $userActivity->user_id = $userid;
        //         $userActivity->activity = 'User Deactivate';
        //         $userActivity->url = request()->fullUrl();   // Get the full URL of the request
        //         $userActivity->ip_address = request()->ip();
        //         $userActivity->save();
        //     }
        // user activity end
        // OTP is correct, update the is_verify field to 1
        $user->is_verify = 1;
        $user->is_delete = 0;
        //$result->is_delete = '0';
        $user->save();




        if ($user->email && $user->is_verify == 1 && $user->is_register == 0) {

            $user->is_register = 1;
            $user->save();

            $data = [
                'name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->mobile,
                // 'post_email' =>$details->email,
            ];

            $data["email"] = $user->email;
            // $data["title"] = "IIV India Registered Valuers Foundation | Payment Success | Thank you";
            $data["title"] =  "Welcome to The ZeroWaste Community Tool";
            // Mail::to(Auth::user()->email)->send(new Payment_done_mail($data));
            // Mail::send('frontend.mail.userregistrationemail', $data, function ($message) use ($data) {
            //     $message->to($data["email"], $data["email"])
            //         ->subject($data["title"]);
            // });

            // Render the email body using the Blade view
            $body = view('frontend.mail.userregistrationemail', $data)->render();
            // Call your mailer service to send the email
            $this->mailerService->sendEmail($data['email'], $data['title'], $body, $data);
        }



        Session::put('user_id', $user->id);
        Session::put('user_name', $user->name);
        Session::put('user_email', $user->email);
        Session::put('user_type', $user->user_type);
         Session::flash('success', 'User Activated Successfully');
                // user activity start

              $userid = session()->get('user_id');
            if ($userid){
                $userActivity = new UserActivityLog();
                $userActivity->user_id = $userid;
                $userActivity->activity = 'User login';
                $userActivity->url = request()->fullUrl();   // Get the full URL of the request
                $userActivity->ip_address = request()->ip();
                $userActivity->save();
            }
        // user activity end

        return response()->json([
            'status' => 'success',
            'message' => 'OTP verified successfully.',
            'user_id' => $user->id
        ]);
    }



    public function consumer_posts()
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        // $listings = ConsumerPost::
        // where('user_id',$user_id)->get();
        // $listings = ConsumerPost::join('consumer_resource_posts','consumer_resource_posts.post_id','consumer_posts.id')
        // ->join('resources','resources.id','consumer_resource_posts.resource_type')
        // ->select('consumer_posts.*','resources.resource_name')
        // ->where('consumer_posts.user_id',$user_id)->get()->unique();
        $listings = ConsumerPost::join('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
            ->join('resources', 'resources.id', 'consumer_resource_posts.resource_type')
            ->select('consumer_posts.*', 'resources.resource_name', 'consumer_resource_posts.resource_img')
            ->where('consumer_posts.user_id', '!=', $user_id)
            ->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $uniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->implode(', ');
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $uniqueListings->push($uniqueListing);
        }

        $buslistings = BusinessPost::join('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
            ->join('resources', 'resources.id', 'business_resource_posts.resource_type')
            ->select('business_posts.*', 'resources.resource_name', 'business_resource_posts.resource_img')
            // ->where('business_posts.user_id', '!=', $user_id)
            ->get();

        // Extract unique post IDs
        $buspostIds = $buslistings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $busuniqueListings = collect([]);
        foreach ($buspostIds as $postId) {
            $buspostListings = $buslistings->where('id', $postId);
            $resourceNames = $buspostListings->pluck('resource_name')->implode(', ');
            $resourceImages = $buspostListings->pluck('resource_img')->implode(', ');
            $busuniqueListing = $buspostListings->first();
            $busuniqueListing->resource_names = $resourceNames;
            $busuniqueListing->resource_img = $resourceImages;
            $busuniqueListings->push($busuniqueListing);
        }

        $sablistings = SABPost::join('s_a_b_resource_posts', 's_a_b_resource_posts.post_id', 's_a_b_posts.id')
            ->join('resources', 'resources.id', 's_a_b_resource_posts.resource_type')
            ->select('s_a_b_posts.*', 'resources.resource_name', 's_a_b_resource_posts.resource_img')
            // ->where('s_a_b_posts.user_id', '!=', $user_id)
            ->get();

        // Extract unique post IDs
        $sabpostIds = $sablistings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $sabuniqueListings = collect([]);
        foreach ($sabpostIds as $postId) {
            $sabpostListings = $sablistings->where('id', $postId);
            $resourceNames = $sabpostListings->pluck('resource_name')->implode(', ');
            $resourceImages = $sabpostListings->pluck('resource_img')->implode(', ');
            $sabuniqueListing = $sabpostListings->first();
            $sabuniqueListing->resource_names = $resourceNames;
            $sabuniqueListing->resource_img = $resourceImages;
            $sabuniqueListings->push($sabuniqueListing);
        }

        return view('frontend/userdetails/consumerposts', compact('uniqueListings', 'busuniqueListings', 'sabuniqueListings'));
    }
    public function consumer_own_posts()
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        // $listings = ConsumerPost::
        // where('user_id',$user_id)->get();
        // $listings = ConsumerPost::join('consumer_resource_posts','consumer_resource_posts.post_id','consumer_posts.id')
        // ->join('resources','resources.id','consumer_resource_posts.resource_type')
        // ->select('consumer_posts.*','resources.resource_name')
        // ->where('consumer_posts.user_id',$user_id)->get()->unique();
        $listings = ConsumerPost::join('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
            ->join('resources', 'resources.id', 'consumer_resource_posts.resource_type')
            ->select('consumer_posts.*', 'resources.resource_name', 'consumer_resource_posts.resource_img')
            ->where('consumer_posts.user_id', $user_id)
            ->where('consumer_posts.active', 1)
            ->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $uniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $uniqueListings->push($uniqueListing);
        }


         // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on my listing';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        return view('frontend/userdetails/consumerownposts', compact('uniqueListings'));
    }
    public function consumer_details()
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $users = EcosansarUsers::where('id', $user_id)->first();
        $resources = Resource::get();
        $weights = Weight::get();

          // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on add your post';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }

        return view('frontend/userdetails/consumerdetails', compact('users', 'user_id', 'resources', 'weights'));
    }
    public function consumer_post_save(Request $request)
    {

        // echo "<pre>";
        // print_r($request->all());die;

        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');

        if ($request->sale_giveaway == 'Buy') {
            $request->validate([
                'address' => 'required',
                'pincode' => 'required|exists:pincodes,pincode',
                'sale_giveaway' => 'required',
                'quantity' => 'required',
                'clean_unclean' => 'required',
                'packaged' => 'required',
                'resource_type' => 'required|array|min:1',
                'resource_img.*' => 'mimes:jpg,jpeg,png,bmp', // Adjust mime types and max size as needed
            ], [

                'pincode.exists' => 'We are not servicable in this area.'
            ]);
        } else {
            $request->validate([
                'address' => 'required',
                'pincode' => 'required|exists:pincodes,pincode',
                'sale_giveaway' => 'required',
                'quantity' => 'required',
                'clean_unclean' => 'required',
                'packaged' => 'required',
                'resource_type' => 'required|array|min:1',
               'resource_img' => 'required|array|min:1',
               'resource_img.*' => 'required|mimes:jpg,jpeg,png,bmp', // Adjust mime types and max size as needed
            ],[

               'pincode.exists' => 'We are not servicable in this area.'
           ]);

            // $request->validate([
            //     'resource_img.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240', // max size is in KB, so 2048 KB = 2 MB
            // ], [
            //     'resource_img.*.max' => 'The image must not be greater than 10 MB.',
            // ]);

            // Check if the number of selected resources matches the number of uploaded images
             if ($request->sale_giveaway !== 'Buy') {
            if (count($request->resource_type) !== count($request->resource_img)) {
                return back()->withErrors(['resource_img' => 'Please upload image here.'])->withInput();
            }
             }
        }

        $selectedResources = $request->input('resource_type');

        // If any resources are selected
        if (!empty($selectedResources)) {
            // Convert the array of selected resource IDs to a comma-separated string
            $resourceIds = implode(',', $selectedResources);
        } else {
            $resourceIds = null; // or any default value if no resources are selected
        }
        $user = new ConsumerPost();
        $user->user_id = $user_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->pincode = $request->pincode;
        //  $user->resource_type=$resourceIds;

        $user->sale_giveaway = $request->sale_giveaway;
        $user->quantity = $request->quantity;
        $user->clean_unclean = $request->clean_unclean;
        $user->packaged = $request->packaged;

        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->save();

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
            }
            $imageContent = ob_get_clean(); // Get the image content from the buffer

            // Free up memory
            imagedestroy($newImage);
            imagedestroy($sourceImage);

            return $imageContent; // Return the resized image content as a binary string
        }

        // Loop through each resource type and its associated image
        foreach ($request->resource_type as $index => $resourceId) {
            // Save resource name
            $resource = new ConsumerResourcePost();
            $resource->user_id = $user_id;
            $resource->post_id = $user->id;
            $resource->resource_type = $resourceId;

            if (isset($request->resource_img[$index])) {
                $image = $request->file('resource_img')[$index];
                $imageName = $user_id . '_' . $user->id . '_' . $resourceId . '.' . $image->getClientOriginalExtension();

                // Upload the original image file to S3

               try {
                   // Resize the image
                            $resizedImageContent = resizeImage($image->getRealPath(), 800, 600); // Adjust width and height as needed

                            // Convert resized image content to a stream for S3 upload
                            $resizedImageStream = fopen('php://memory', 'r+');
                            fwrite($resizedImageStream, $resizedImageContent);
                            rewind($resizedImageStream);

                   // Define the S3 path where the file will be stored
                    $s3Directory = 'Consumerposts';
                    $s3Path = $s3Directory . '/' . $imageName;

                    // Upload the file to S3 in the specified directory
                  //  $uploaded = Storage::disk('s3')->putFileAs($s3Directory, $image, $imageName);
                 $uploaded = Storage::disk('s3')->put($s3Path, $resizedImageStream);


                if (!$uploaded) {
                    throw new \Exception('Image upload returned false');
                }
                fclose($resizedImageStream);
            } catch (\Exception $e) {
                Log::error('S3 Upload Error: ' . $e->getMessage());
                return response()->json(['error' => 'Image upload to S3 failed: ' . $e->getMessage()], 500);
            }



                // Save the S3 path in the database
                $resource->resource_img = $imageName;
                $resource->save();
            }
            $resource->save();
        }

            // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Contributor post add';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        Session::flash('success', 'Post Added Successfully. You can view in my profile page');
        return redirect()->route('listings');
    }
    public function consumer_listing_details($id)
    {

        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $consumerpostsres = ConsumerResourcePost::where('user_id', $user_id)->where('post_id', $id)->get();
        $consumerposts = ConsumerPost::join('weights', 'weights.id', 'consumer_posts.quantity')
            ->select('consumer_posts.*', 'weights.*')
            ->where('consumer_posts.user_id', '!=', $user_id)
            ->where('consumer_posts.id', $id)->first();
        $conreviews = ConsumerReview::where('post_id', $id)->where('user_id', $user_id)->get();

        return view('frontend/userdetails/consumerlistingdetail', compact('consumerpostsres', 'consumerposts', 'conreviews'));
    }
    public function consumer_own_listing_details($id)
    {

        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
         $consumer = ConsumerPost::where('id', $id)->first();;
         $conuserid = $consumer->user_id;
         $conpostid = $consumer->id;
        $consumerpostsres = ConsumerResourcePost::where('user_id', $user_id)->where('post_id', $id)->get();
        $consumerposts = ConsumerPost::join('weights', 'weights.id', 'consumer_posts.quantity')
            ->select('consumer_posts.*', 'weights.*')
            ->where('consumer_posts.user_id', $user_id)
            ->where('consumer_posts.id', $id)->first();
             $conresources1 = ConsumerPost::leftjoin('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
            ->leftjoin('resources', 'resources.id', 'consumer_resource_posts.resource_type')
             ->select('consumer_posts.*',  'resources.resource_name','consumer_resource_posts.post_id')
             ->where('consumer_resource_posts.user_id',$conuserid)
             ->where('consumer_resource_posts.post_id',$conpostid)
             ->get();
            $conresources = $conresources1->pluck('resource_name')->toArray(); // Extract resource names into an array
        $conreviews = ConsumerReview::where('post_id', $id)->where('user_id', $user_id)->get();

          // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on post details';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end
        // echo "<pre>";
        // print_r($consumerposts);die;
        return view('frontend/userdetails/consumerlistingdetail', compact('conresources','consumerpostsres', 'consumerposts', 'conreviews'));
    }

    public function sab_listing_details($id)
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $sab = SABPost::where('id', $id)->first();;
        $sabuserid = $sab->user_id;
        $sabpostid = $sab->post_id;
        $sabpostsres = SABResourcePost::where('user_id', '!=', $user_id)->where('post_id', $id)->get();
        $sabposts = SABPost::join('weights', 'weights.id', 's_a_b_posts.quantity')
            ->select('s_a_b_posts.*', 'weights.*')
            ->where('s_a_b_posts.user_id', '!=', $user_id)
            ->where('s_a_b_posts.id', $id)->first();

        $sabreviews = SABReview::where('post_id', $id)->where('user_id', $user_id)->get();
        $sabenquiries = SabEnquiry::where('post_id', $id)->where('user_id', $sabuserid)->get();
        // echo "<pre>";
        // print_r($consumerposts);die;
        if ($sabenquiries->isEmpty()) {
        } else {
            $enquiry_id = $sabenquiries[0]->id;
        }
        $sabenquirymsg = SABEnquiryMessages::where('post_id', $id)->where('user_id', $sabuserid)->get();
        //      echo "<pre>";
        //    print_r($sabenquirymsg);die;
        if ($sabenquiries->isEmpty()) {
            return view('frontend/userdetails/sablistingdetail', compact('sabpostsres', 'sabposts', 'sabreviews', 'sabenquiries', 'user_id', 'sabuserid', 'id', 'sabenquirymsg'));
        } else {

            return view('frontend/userdetails/sablistingdetail', compact('sabpostsres', 'sabposts', 'sabreviews', 'sabenquiries', 'user_id', 'sabuserid', 'id', 'enquiry_id', 'sabenquirymsg'));
        }
    }
    public function sab_own_listing_details($id)
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $sab = SABPost::where('id', $id)->first();;
         $sabuserid = $sab->user_id;
         $sabpostid = $sab->id;
        $sabpostsres = SABResourcePost::where('user_id', $user_id)->where('post_id', $id)->get();
        $sabposts = SABPost::join('weights', 'weights.id', 's_a_b_posts.quantity')
            ->select('s_a_b_posts.*', 'weights.*')
            ->where('s_a_b_posts.user_id', $user_id)
            ->where('s_a_b_posts.id', $id)->first();
 $sabresources1  = SABPost::join('s_a_b_resource_posts', 's_a_b_resource_posts.post_id', 's_a_b_posts.id')
            ->join('resources', 'resources.id', 's_a_b_resource_posts.resource_type')
            ->select('s_a_b_posts.*', 'resources.resource_name','s_a_b_resource_posts.post_id')
           ->where('s_a_b_resource_posts.user_id',$sabuserid)
             ->where('s_a_b_resource_posts.post_id',$sabpostid)
            ->get();
            // echo "<pre>";
            // print_r($sabresources1);die;
             $sabresources = $sabresources1->pluck('resource_name')->toArray(); // Extract resource names into an array
        $sabreviews = SABReview::where('post_id', $id)->where('user_id', $user_id)->get();
        $sabenquiries = SabEnquiry::where('post_id', $id)->where('user_id', $sabuserid)->get();
        if ($sabenquiries->isEmpty()) {
        } else {
            $enquiry_id = $sabenquiries[0]->id;
        }
        $sabenquirymsg = SABEnquiryMessages::where('post_id', $id)->where('user_id', $sabuserid)->get();

          // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on post details';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        //      echo "<pre>";
        //    print_r($sabenquirymsg);die;
        if ($sabenquiries->isEmpty()) {
            return view('frontend/userdetails/sablistingdetail', compact('sabresources','sabpostsres', 'sabposts', 'sabreviews', 'sabenquiries', 'user_id', 'sabuserid', 'id', 'sabenquirymsg'));
        } else {

            return view('frontend/userdetails/sablistingdetail', compact('sabresources','sabpostsres', 'sabposts', 'sabreviews', 'sabenquiries', 'user_id', 'sabuserid', 'id', 'enquiry_id', 'sabenquirymsg'));
        }
    }

    public function sabsendEnquiryEmail(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'message' => 'required'
        ]);

        $email = $request->input('email');
        $messageContent = $request->input('message');

        $sabenquiry =  new SABEnquiryMessages;
        $sabenquiry->enquiry_id = $request->enquiry_id;
        $sabenquiry->login_id = $request->login_id;
        $sabenquiry->user_id = $request->user_id;
        $sabenquiry->post_id = $request->post_id;
        $sabenquiry->adminmessage = $request->input('message');
        $sabenquiry->type = 'admin';
        $sabenquiry->save();

        $data = [
            'email' => $email,
            'messageContent' => $messageContent,
            'title' => 'Response to your enquiry'
        ];
        // Mail::send('frontend.mail.sabenquirymail', $data, function ($message) use ($data) {
        //     $message->to($data["email"], $data["email"])
        //         ->subject($data["title"]);
        // });

        // Render the email body using the Blade view
        $body = view('frontend.mail.sabenquirymail', $data)->render();
        // Call your mailer service to send the email
        $this->mailerService->sendEmail($data['email'], $data['title'], $body, $data);

        Alert::success('success', 'Mail Send Successfully');
        return redirect()->back();
    }

    public function loginsabsendEnquiryEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'required'
        ]);

        $email = $request->input('email');
        $messageContent = $request->input('message');

        $sabenquiry =  new SABEnquiryMessages;
        $sabenquiry->enquiry_id = $request->enquiry_id;
        $sabenquiry->login_id = $request->login_id;
        $sabenquiry->user_id = $request->user_id;
        $sabenquiry->post_id = $request->post_id;
        $sabenquiry->usermessage = $request->input('message');
        $sabenquiry->type = 'loginuser';
        $sabenquiry->save();

        $data = [
            'email' => $email,
            'messageContent' => $messageContent,
            'title' => 'Response to your enquiry'
        ];
        // Mail::send('frontend.mail.sabenquirymail', $data, function($message)use($data){
        //     $message->to($data["email"], $data["email"])
        //             ->subject($data["title"]);
        // });
        Alert::success('success', 'Mail Send Successfully');
        return redirect()->back();
    }
    public function business_listing_details($id)
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $businesspostsres = BusinessResourcePost::where('user_id', '!=', $user_id)->where('post_id', $id)->get();
        $businessposts = BusinessPost::join('weights', 'weights.id', 'business_posts.quantity')
            ->select('business_posts.*', 'weights.*')
            ->where('business_posts.user_id', '!=', $user_id)
            ->where('business_posts.id', $id)->first();
        //    echo "<pre>";
        //    print_r($businessposts->sale_giveaway);die;
        return view('frontend/userdetails/businesslistingdetail', compact('businesspostsres', 'businessposts'));
    }
    public function business_own_listing_details($id)
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $buspost = BusinessPost::where('id', $id)->first();
        $post_id = $buspost->id;
        $u_id = $buspost->user_id;
        $businesspostsres = BusinessResourcePost::where('user_id', $user_id)->where('post_id', $id)->get();
        $businessposts = BusinessPost::join('weights', 'weights.id', 'business_posts.quantity')
            ->select('business_posts.*', 'weights.*')
            ->where('business_posts.user_id', $user_id)
            ->where('business_posts.id', $id)->first();
             $busresources1 = BusinessPost::leftjoin('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
            ->leftjoin('resources', 'resources.id', 'business_resource_posts.resource_type')
            ->select('business_posts.*',  'resources.resource_name','business_resource_posts.post_id')
            ->where('business_resource_posts.user_id', $u_id)
             ->where('business_resource_posts.post_id', $post_id)
            ->get();
        $busresources = $busresources1->pluck('resource_name')->toArray(); // Extract resource names into an array
        //    echo "<pre>";
        //    print_r($businessposts->sale_giveaway);die;

          // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on post details';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        return view('frontend/userdetails/businesslistingdetail', compact('busresources','businesspostsres', 'businessposts'));
    }

    public function listings()
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        //own posts
        $listings = ConsumerPost::join('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
            ->join('resources', 'resources.id', 'consumer_resource_posts.resource_type')
            ->select('consumer_posts.*', 'resources.resource_name', 'consumer_resource_posts.resource_img')
            ->where('consumer_posts.user_id', $user_id)
            ->where('consumer_posts.active', '=', 1)
            ->orderBy('consumer_posts.created_at', 'asc')
            ->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $ownuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->implode(', ');
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $ownuniqueListings->push($uniqueListing);
        }

        $sablistings = SABPost::join('s_a_b_resource_posts', 's_a_b_resource_posts.post_id', 's_a_b_posts.id')
            ->join('resources', 'resources.id', 's_a_b_resource_posts.resource_type')
            ->select('s_a_b_posts.*', 'resources.resource_name', 's_a_b_resource_posts.resource_img')
            ->where('s_a_b_posts.user_id',  $user_id)
            ->where('s_a_b_posts.active', '=', 1)
            ->orderBy('s_a_b_posts.created_at', 'asc')
            ->get();

        // Extract unique post IDs
        $sabpostIds = $sablistings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $ownsabuniqueListings = collect([]);
        foreach ($sabpostIds as $postId) {
            $sabpostListings = $sablistings->where('id', $postId);
            $resourceNames = $sabpostListings->pluck('resource_name')->implode(', ');
            $resourceImages = $sabpostListings->pluck('resource_img')->implode(', ');
            $sabuniqueListing = $sabpostListings->first();
            $sabuniqueListing->resource_names = $resourceNames;
            $sabuniqueListing->resource_img = $resourceImages;
            $ownsabuniqueListings->push($sabuniqueListing);
        }

        $buslistings = BusinessPost::join('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
            ->join('resources', 'resources.id', 'business_resource_posts.resource_type')
            ->select('business_posts.*', 'resources.resource_name', 'business_resource_posts.resource_img')
            ->where('business_posts.user_id',  $user_id)
            ->where('business_posts.active', '=', 1)
            ->orderBy('business_posts.created_at', 'asc')
            ->get();

        // Extract unique post IDs
        $buspostIds = $buslistings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $ownbusuniqueListings = collect([]);
        foreach ($buspostIds as $postId) {
            $buspostListings = $buslistings->where('id', $postId);
            $resourceNames = $buspostListings->pluck('resource_name')->implode(', ');
            $resourceImages = $buspostListings->pluck('resource_img')->implode(', ');
            $busuniqueListing = $buspostListings->first();
            $busuniqueListing->resource_names = $resourceNames;
            $busuniqueListing->resource_img = $resourceImages;
            $ownbusuniqueListings->push($busuniqueListing);
        }

        //Business posts all

        $listings = BusinessPost::leftjoin('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
            ->leftjoin('resources', 'resources.id', 'business_resource_posts.resource_type')
            // ->join('weights', 'business_posts.quantity', '=', 'weights.id')
            // ->join('ecosansar_users','ecosansar_users.id','=','business_posts.user_id')

            ->select('business_posts.*', 'resources.resource_name', 'business_resource_posts.resource_img')
            ->where('active', 1)
            ->orderBy('business_posts.created_at', 'asc');

        // Exclude user's own posts if logged in
        if ($user_id) {
            $listings->where('business_posts.user_id', '!=', $user_id);
        }

        $listings = $listings->latest()->take(3)->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $busuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $busuniqueListings->push($uniqueListing);
        }

        //Business posts except sell
        $listingsnotsell = BusinessPost::leftjoin('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
            ->leftjoin('resources', 'resources.id', 'business_resource_posts.resource_type')
            ->join('weights', 'business_posts.quantity', '=', 'weights.id')
            ->join('ecosansar_users', 'ecosansar_users.id', '=', 'business_posts.user_id')

            ->select('business_posts.*', 'resources.resource_name', 'business_resource_posts.resource_img')
            ->where('active', 1)
            ->where('sale_giveaway', '=', 'Buy')
            ->orderBy('business_posts.created_at', 'asc');

        // Exclude user's own posts if logged in
        if ($user_id) {
            $listingsnotsell->where('business_posts.user_id', '!=', $user_id);
        }

        $listingsnotsell = $listingsnotsell->latest()->take(3)->get();

        // Extract unique post IDs
        $postIds = $listingsnotsell->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $busuniqueListingsnotsell = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listingsnotsell->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $busuniqueListingsnotsell->push($uniqueListing);
        }


        //SAB posts

        $listings = SABPost::leftjoin('s_a_b_resource_posts', 's_a_b_resource_posts.post_id', 's_a_b_posts.id')
            ->leftjoin('resources', 'resources.id', 's_a_b_resource_posts.resource_type')
            ->join('weights', 's_a_b_posts.quantity', '=', 'weights.id')
            ->join('ecosansar_users', 'ecosansar_users.id', '=', 's_a_b_posts.user_id')

            ->select('s_a_b_posts.*', 'resources.resource_name', 's_a_b_resource_posts.resource_img')

            ->where('active', 1)
            ->orderBy('s_a_b_posts.created_at', 'asc');

        if ($user_id) {
            $listings->where('s_a_b_posts.user_id', '!=', $user_id);
        }

        $listings = $listings->latest()->take(3)->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $sabuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $sabuniqueListings->push($uniqueListing);
        }

        //Consumer posts
        $listings = ConsumerPost::leftjoin('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
            ->leftjoin('resources', 'resources.id', 'consumer_resource_posts.resource_type')
            ->join('weights', 'consumer_posts.quantity', '=', 'weights.id')
            ->join('ecosansar_users', 'ecosansar_users.id', '=', 'consumer_posts.user_id')
            ->select('consumer_posts.*', 'resources.resource_name', 'consumer_resource_posts.resource_img')
            ->where('active', 1)
            ->orderBy('consumer_posts.created_at', 'asc');

        if ($user_id) {
            $listings->where('consumer_posts.user_id', '!=', $user_id);
        }

        $listings = $listings->latest()->take(3)->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $conuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $conuniqueListings->push($uniqueListing);
        }

        //consumersell posts

        $listings = ConsumerPost::leftjoin('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
            ->leftjoin('resources', 'resources.id', 'consumer_resource_posts.resource_type')
            ->join('weights', 'consumer_posts.quantity', '=', 'weights.id')
            ->join('ecosansar_users', 'ecosansar_users.id', '=', 'consumer_posts.user_id')
            ->select('consumer_posts.*', 'resources.resource_name', 'consumer_resource_posts.resource_img')
            ->where('active', 1)
            ->where('sale_giveaway', '!=', 'Buy')
            ->orderBy('consumer_posts.created_at', 'asc');

        if ($user_id) {
            $listings->where('consumer_posts.user_id', '!=', $user_id);
        }

        $listings = $listings->latest()->take(3)->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $conuniqueListingsnotbuy = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $conuniqueListingsnotbuy->push($uniqueListing);
        }

         // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on Browse listings';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        // echo "<pre>";
        // print_r($conuniqueListings);die;
        if ($user_type == 'consumer') {
            return view('frontend/listings/listingslist', compact('ownuniqueListings', 'conuniqueListings', 'user_type', 'sabuniqueListings', 'busuniqueListingsnotsell', 'user_id'));
        } else if ($user_type == 'sab') {
            return view('frontend/listings/listingslist', compact('ownsabuniqueListings', 'busuniqueListingsnotsell', 'user_type', 'sabuniqueListings', 'user_id', 'conuniqueListingsnotbuy'));
        } else if ($user_type == 'business') {
            return view('frontend/listings/listingslist', compact('ownbusuniqueListings', 'busuniqueListings', 'user_type', 'user_id', 'sabuniqueListings', 'conuniqueListingsnotbuy'));
        } else {
            return view('frontend/listings/listingslist', compact('conuniqueListingsnotbuy', 'busuniqueListingsnotsell', 'ownuniqueListings', 'ownsabuniqueListings', 'ownbusuniqueListings', 'conuniqueListings', 'sabuniqueListings', 'busuniqueListings', 'user_type', 'user_id'));
        }
    }
    public function buy_listings()
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');

        //Business posts

        $listings = BusinessPost::join('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
            ->join('resources', 'resources.id', 'business_resource_posts.resource_type')
            ->select('business_posts.*', 'resources.resource_name', 'business_resource_posts.resource_img')
            ->where('sale_giveaway', 'Buy');
        // Exclude user's own posts if logged in
        if ($user_id) {
            $listings->where('business_posts.user_id', '!=', $user_id)->where('sale_giveaway', 'Buy');
        }

        $listings = $listings->latest()->take(3)->get();
        // echo "<pre>";
        // print_r($listings);die;
        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $busuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->implode(', ');
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $busuniqueListings->push($uniqueListing);
        }


        //SAB posts

        $listings = SABPost::join('s_a_b_resource_posts', 's_a_b_resource_posts.post_id', 's_a_b_posts.id')
            ->join('resources', 'resources.id', 's_a_b_resource_posts.resource_type')
            ->select('s_a_b_posts.*', 'resources.resource_name', 's_a_b_resource_posts.resource_img')
            ->where('sale_giveaway', 'Buy');
        if ($user_id) {
            $listings->where('s_a_b_posts.user_id', '!=', $user_id)->where('sale_giveaway', 'Buy');
        }

        $listings = $listings->latest()->take(3)->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $sabuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->implode(', ');
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $sabuniqueListings->push($uniqueListing);
        }

        //Consumer posts
        $listings = ConsumerPost::join('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
            ->join('resources', 'resources.id', 'consumer_resource_posts.resource_type')
            ->select('consumer_posts.*', 'resources.resource_name', 'consumer_resource_posts.resource_img')
            ->where('sale_giveaway', 'Buy');
        if ($user_id) {
            $listings->where('consumer_posts.user_id', '!=', $user_id);
        }

        $listings = $listings->latest()->take(3)->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $conuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->implode(', ');
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $conuniqueListings->push($uniqueListing);
        }
        // echo "<pre>";
        // print_r($conuniqueListings);die;
        if ($user_type == 'consumer') {
            return view('frontend/listings/buylistinglist', compact('conuniqueListings', 'user_type', 'sabuniqueListings', 'busuniqueListings', 'user_id'));
        } else if ($user_type == 'sab') {
            return view('frontend/listings/buylistinglist', compact('conuniqueListings', 'busuniqueListings', 'user_type', 'sabuniqueListings', 'user_id'));
        } else if ($user_type == 'business') {
            return view('frontend/listings/buylistinglist', compact('conuniqueListings', 'busuniqueListings', 'user_type', 'user_id', 'sabuniqueListings'));
        } else {
            return view('frontend/listings/buylistinglist', compact('conuniqueListings', 'sabuniqueListings', 'busuniqueListings', 'user_type', 'user_id'));
        }
    }
    public function con_listing_details($id)
    {
        // Check if the user is logged in

        $user_id = session()->get('user_id');
        $conpost = ConsumerPost::where('id', $id)->first();
        $post_id = $conpost->id;
        $u_id = $conpost->user_id;
        $user_type = session()->get('user_type');
        if (null === $user_id || $user_id === '') {
            // User is not logged in, redirect to the login page
            session()->put('redirect_to_list', route('con_listing_details', $id));
            session()->put('redirect_wp', route('con_listing_details', $id));
            return redirect()->route('consumer_login');
        }
        // Fetch the user's role from the database
        $user = DB::table('ecosansar_users')->where('id', $user_id)->first();
        $conlistreviews = ConsumerReview::where('post_id', $id)->where('user_id', $u_id)->get();

        if (($user && $user->user_type === 'business') || ($user && $user->user_type === 'sab') || ($user && $user->user_type === 'consumer')) {
            // User is logged in as a consumer, proceed to fetch the listing details
            $consumerpostsres = ConsumerResourcePost::where('post_id', $id)->get();


            $consumerposts = ConsumerPost::leftjoin('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
            ->leftjoin('resources', 'resources.id', 'consumer_resource_posts.resource_type')
                ->join('weights', 'weights.id', 'consumer_posts.quantity')
                ->select('consumer_posts.*', 'consumer_posts.id as conid','weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure','resources.resource_name')
                ->where('consumer_posts.id', $id)
                ->first();

            // $conresources = ConsumerResourcePost::join('consumer_posts')
            $conresources1 = ConsumerPost::leftjoin('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
            ->leftjoin('resources', 'resources.id', 'consumer_resource_posts.resource_type')
             ->select('consumer_posts.*',  'resources.resource_name','consumer_resource_posts.post_id')
             ->where('consumer_resource_posts.user_id',$u_id)
             ->where('consumer_resource_posts.post_id',$post_id)
             ->get();
            $conresources = $conresources1->pluck('resource_name')->toArray(); // Extract resource names into an array
                // echo "<pre>";
                // print_r($consumerposts);die;
            $users = EcosansarUsers::where('id', $u_id)->first();
            $loginuser = EcosansarUsers::where('id', $user_id)->first();
            return view('frontend/listings/con_listing_details', compact('user_id','conresources','consumerpostsres', 'consumerposts', 'id', 'u_id', 'post_id', 'conlistreviews', 'users', 'loginuser'));
        }
        // If the user is not logged in as a consumer, redirect to the login page
        session()->put('redirect_to', route('con_listing_details', $id));
        session()->put('redirect_wp', route('con_listing_details', $id));
        return redirect()->route('consumer_login');
    }

    public function sabs_listing_details($id)
    {
        $user_id = session()->get('user_id');

        $user_type = session()->get('user_type');
        $sabpost = SABPost::where('id', $id)->first();
        $post_id = $sabpost->id;
        $u_id = $sabpost->user_id;
        if (null === $user_id || $user_id === '') {
            session()->put('redirect_to_list', route('sabs_listing_details', $id));
            session()->put('redirect_wp', route('sabs_listing_details', $id));
            return redirect()->route('consumer_login'); // Redirect to the login page
        }
        // Fetch the user's role from the database
        $user = DB::table('ecosansar_users')->where('id', $user_id)->first();
        $sablistreviews = SABReview::where('post_id', $id)->where('user_id', $u_id)->get();
        $sabenquiries = SabEnquiry::where('post_id', $id)->where('user_id', $u_id)->get();
        if ($sabenquiries->isEmpty()) {
        } else {
            $enquiry_id = $sabenquiries[0]->id;
        }
        $sabenquirymsg = SABEnquiryMessages::where('post_id', $id)->where('user_id', $u_id)->get();
        // echo "<pre>";
        // print_r($sabenquiries);die;
        // if ($user && $user->user_type === 'business'){
        // User is logged in as a consumer, proceed to fetch the listing details
        $sabpostsres = SABResourcePost::where('post_id', $id)->get();

        $sabposts = SABPost::join('weights', 'weights.id', 's_a_b_posts.quantity')
            ->select('s_a_b_posts.*','s_a_b_posts.id as sabid', 'weights.*')
            ->where('s_a_b_posts.id', $id)
            ->first();
        $sabresources1  = SABPost::join('s_a_b_resource_posts', 's_a_b_resource_posts.post_id', 's_a_b_posts.id')
            ->join('resources', 'resources.id', 's_a_b_resource_posts.resource_type')
            ->select('s_a_b_posts.*', 'resources.resource_name','s_a_b_resource_posts.post_id')
           ->where('s_a_b_resource_posts.user_id',$u_id)
             ->where('s_a_b_resource_posts.post_id',$post_id)
            ->get();
             $sabresources = $sabresources1->pluck('resource_name')->toArray(); // Extract resource names into an array
        $users = EcosansarUsers::where('id', $u_id)->first();

        $loginuser = EcosansarUsers::where('id', $user_id)->first();
        if ($sabenquiries->isEmpty()) {
            return view('frontend/listings/sab_listing_details', compact('sabresources','sabposts', 'sabpostsres', 'id', 'u_id', 'post_id', 'sablistreviews', 'user_id', 'sabenquiries', 'sabenquirymsg', 'users', 'loginuser'));
        } else {
            return view('frontend/listings/sab_listing_details', compact('sabresources','sabposts', 'sabpostsres', 'id', 'u_id', 'post_id', 'sablistreviews', 'user_id', 'sabenquiries', 'enquiry_id', 'sabenquirymsg', 'users', 'loginuser'));
        }
        // }else{
        // return redirect()->route('sab_login');
        // }
    }
    public function bus_listing_details($id)
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $buspost = BusinessPost::where('id', $id)->first();
        $post_id = $buspost->id;
        $u_id = $buspost->user_id;
        if (null === $user_id || $user_id === '') {
            session()->put('redirect_to_list', route('bus_listing_details', $id));
            session()->put('redirect_wp', route('bus_listing_details', $id));
            return redirect()->route('consumer_login'); // Redirect to the login page
        }
        // Fetch the user's role from the database
        $user = DB::table('ecosansar_users')->where('id', $user_id)->first();
        // If the user is not logged in or their user_type is 'business', redirect to the business login page

        // if  ($user && $user->user_type === 'business'){
        // User is logged in as a consumer, proceed to fetch the listing details
        $buspostsres = BusinessResourcePost::where('post_id', $id)->get();

        $busposts = BusinessPost::join('weights', 'weights.id', 'business_posts.quantity')
            ->select('business_posts.*','business_posts.id as busid', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
            ->where('business_posts.id', $id)
            ->first();
        $busresources1 = BusinessPost::leftjoin('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
            ->leftjoin('resources', 'resources.id', 'business_resource_posts.resource_type')
            ->select('business_posts.*',  'resources.resource_name','business_resource_posts.post_id')
            ->where('business_resource_posts.user_id', $u_id)
             ->where('business_resource_posts.post_id', $post_id)
            ->get();
        $busresources = $busresources1->pluck('resource_name')->toArray(); // Extract resource names into an array

        $users = EcosansarUsers::where('id', $u_id)->first();
        $loginuser = EcosansarUsers::where('id', $user_id)->first();
        return view('frontend/listings/bus_listing_details', compact('busresources','buspostsres', 'busposts', 'id', 'u_id', 'post_id', 'users', 'loginuser','user_id'));
        // }
        // If the user is not logged in as a consumer, redirect to the login page
        session()->put('redirect_to_list', route('bus_listing_details', $id));
        session()->put('redirect_wp', route('bus_listing_details', $id));
        return redirect()->route('consumer_login');
    }

    public function con_deactivate(Request $request)
    {
        $postId = $request->input('post_id');

        $post = ConsumerPost::find($postId);
        if ($post) {
            $post->active = 0;
            $post->save();

            return response()->json(['success' => true, 'message' => 'Post deactivated successfully.']);

                // user activity start
            $userid = session()->get('user_id');
            if ($userid){
                $userActivity = new UserActivityLog();
                $userActivity->user_id = $userid;
                $userActivity->activity = 'Clicked on post deactivate';
                $userActivity->url = request()->fullUrl();   // Get the full URL of the request
                $userActivity->ip_address = request()->ip();
                $userActivity->save();
            }
            // user activity end
        }

        return response()->json(['success' => false, 'message' => 'Post not found.'], 404);
    }
    public function sab_deactivate(Request $request)
    {
        $postId = $request->input('post_id');

        $post = SABPost::find($postId);
        if ($post) {
            $post->active = 0;
            $post->save();


                // user activity start
            $userid = session()->get('user_id');
            if ($userid){
                $userActivity = new UserActivityLog();
                $userActivity->user_id = $userid;
                $userActivity->activity = 'Clicked on post deactivate';
                $userActivity->url = request()->fullUrl();   // Get the full URL of the request
                $userActivity->ip_address = request()->ip();
                $userActivity->save();
            }
            // user activity end

             return response()->json(['success' => true, 'message' => 'Post deactivated successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Post not found.'], 404);
    }
    public function bus_deactivate(Request $request)
    {
        $postId = $request->input('post_id');

        $post = BusinessPost::find($postId);
        if ($post) {
            $post->active = 0;
            $post->save();

        // user activity start
            $userid = session()->get('user_id');
            if ($userid){
                $userActivity = new UserActivityLog();
                $userActivity->user_id = $userid;
                $userActivity->activity = 'Clicked on post deactivate';
                $userActivity->url = request()->fullUrl();   // Get the full URL of the request
                $userActivity->ip_address = request()->ip();
                $userActivity->save();
            }
            // user activity end

            return response()->json(['success' => true, 'message' => 'Post deactivated successfully.']);


        }

        return response()->json(['success' => false, 'message' => 'Post not found.'], 404);
    }
    public function bus_reactivate(Request $request)
    {
        $postId = $request->input('post_id');

        $post = BusinessPost::find($postId);
        if ($post) {
            $post->active = 1;
            $post->reactive = 'reactive';
            $post->post_date = Carbon::now()->addDays(7);
            $post->save();

             // user activity start
            $userid = session()->get('user_id');
            if ($userid){
                $userActivity = new UserActivityLog();
                $userActivity->user_id = $userid;
                $userActivity->activity = 'Clicked on post reactivate';
                $userActivity->url = request()->fullUrl();   // Get the full URL of the request
                $userActivity->ip_address = request()->ip();
                $userActivity->save();
            }
            // user activity end

             return response()->json(['success' => true, 'message' => 'Post reactivated successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Post not found.'], 404);
    }
    public function sab_reactivate(Request $request)
    {
        $postId = $request->input('post_id');

        $post = SABPost::find($postId);
        if ($post) {
            $post->active = 1;
            $post->reactive = 'reactive';
            $post->post_date = Carbon::now()->addDays(7);
            $post->save();


              // user activity start
            $userid = session()->get('user_id');
            if ($userid){
                $userActivity = new UserActivityLog();
                $userActivity->user_id = $userid;
                $userActivity->activity = 'Clicked on post reactivate';
                $userActivity->url = request()->fullUrl();   // Get the full URL of the request
                $userActivity->ip_address = request()->ip();
                $userActivity->save();
            }
            // user activity end

              return response()->json(['success' => true, 'message' => 'Post reactivated successfully.']);

        }

        return response()->json(['success' => false, 'message' => 'Post not found.'], 404);
    }
    public function con_reactivate(Request $request)
    {
        $postId = $request->input('post_id');

        $post = ConsumerPost::find($postId);
        if ($post) {
            $post->active = 1;
            $post->reactive = 'reactive';
            $post->post_date = Carbon::now()->addDays(7);
            $post->save();


              // user activity start
            $userid = session()->get('user_id');
            if ($userid){
                $userActivity = new UserActivityLog();
                $userActivity->user_id = $userid;
                $userActivity->activity = 'Clicked on post reactivate';
                $userActivity->url = request()->fullUrl();   // Get the full URL of the request
                $userActivity->ip_address = request()->ip();
                $userActivity->save();
            }
            // user activity end

             return response()->json(['success' => true, 'message' => 'Post reactivated successfully.']);

        }

        return response()->json(['success' => false, 'message' => 'Post not found.'], 404);
    }
    public function con_all_posts()
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');

        $listings = ConsumerPost::join('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
            ->join('resources', 'resources.id', 'consumer_resource_posts.resource_type')
             ->join('weights', 'consumer_posts.quantity', '=', 'weights.id')
            ->select('consumer_posts.*', 'resources.resource_name', 'consumer_resource_posts.resource_img', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
            ->where('consumer_posts.user_id', '!=', $user_id)
            // ->where('sale_giveaway','!=','Buy')
            ->where('active', 1)
            ->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $uniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $uniqueListings->push($uniqueListing);
        }

         //consumersell posts

        $selllistings = ConsumerPost::leftjoin('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
            ->leftjoin('resources', 'resources.id', 'consumer_resource_posts.resource_type')
            ->join('weights', 'consumer_posts.quantity', '=', 'weights.id')
            ->join('ecosansar_users', 'ecosansar_users.id', '=', 'consumer_posts.user_id')
            ->select('consumer_posts.*', 'resources.resource_name', 'consumer_resource_posts.resource_img', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
            ->where('active', 1)
            ->where('sale_giveaway', '!=', 'Buy');


        if ($user_id) {
            $selllistings->where('consumer_posts.user_id', '!=', $user_id);
        }

        $listings = $selllistings->latest()->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $conuniqueListingsnotbuy = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $conuniqueListingsnotbuy->push($uniqueListing);
        }

        foreach ($uniqueListings as $listing) {
            $averageRating = DB::table('consumer_reviews')
                ->where('user_id', $listing->user_id)
                ->avg('rating');

            // Store the average rating in the listing object
            $listing->averageRating = $averageRating ?: 0; // If no rating, set to 0
        }

        $res = Resource::get();
        $weight = Weight::get();

        return view('frontend/listings/con_all_listing', compact('uniqueListings', 'user_id', 'res', 'weight', 'user_type','conuniqueListingsnotbuy'));
    }

    public function con_all_posts_filter(Request $request)
    {
        $user_id = session()->get('user_id');

        // Initialize the query builders with joins to their respective resource pivot tables

        $sabQuery = ConsumerPost::join('consumer_resource_posts', 'consumer_resource_posts.post_id', '=', 'consumer_posts.id')
            ->join('resources', 'resources.id', 'consumer_resource_posts.resource_type')
            ->join('weights', 'consumer_posts.quantity', '=', 'weights.id')
            ->join('ecosansar_users', 'ecosansar_users.id', '=', 'consumer_posts.user_id')
            ->select('ecosansar_users.name', 'consumer_posts.*', 'resources.resource_name', 'consumer_resource_posts.resource_img', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
            ->where('consumer_posts.user_id', '!=', $user_id)

            // ->where('sale_giveaway','!=','Buy')
            ->where('active', 1);;



        // Apply the filter based on the type if it's present in the request
        if ($request->has('sale_giveaway') && $request->sale_giveaway != '') {
            $sabQuery->where(function ($query) use ($request) {
                $query->where('consumer_posts.sale_giveaway', $request->sale_giveaway);
            });
        }

        if ($request->has('clean_unclean') && $request->clean_unclean != '') {
            $sabQuery->where(function ($query) use ($request) {
                $query->where('consumer_posts.clean_unclean', $request->clean_unclean);
            });
        }

        if ($request->has('packaged') && $request->packaged != '') {
            $sabQuery->where(function ($query) use ($request) {
                $query->where('consumer_posts.packaged', $request->packaged);
            });
        }

        if ($request->has('pincode') && $request->pincode != '') {
            $sabQuery->where(function ($query) use ($request) {
                $query->where('consumer_posts.pincode', $request->pincode);
            });
        }
        if ($request->has('weight') && $request->weight != '') {
            $sabQuery->where(function ($query) use ($request) {
                $query->where('consumer_posts.quantity', $request->weight);
            });
        }

        // Apply the filter based on the resources if they are present in the request
        if ($request->has('resource') && !empty($request->resource)) {
            $resourceIds = $request->resource;
            $sabQuery->whereIn('consumer_resource_posts.resource_type', $resourceIds);

            // Fetch resource names for applied filters
            $resources = Resource::whereIn('id', $resourceIds)->get();
            $resourceNames = $resources->pluck('resource_name')->implode(', ');
        }



        // Get the filtered results with distinct to avoid duplicates

        $sabPosts = $sabQuery->distinct()->get();

        $postIds = $sabPosts->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $sabuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $sabPosts->where('id', $postId);
            $weightDetails = $postListings->pluck('min_weight')->first() . ' ' .
                $postListings->pluck('min_measure')->first() . ' to ' .
                $postListings->pluck('max_weight')->first() . ' ' .
                $postListings->pluck('max_measure')->first();
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $uniqueListing->weight_details  = $weightDetails;
            $uniqueListing->formatted_date = date('dS F Y', strtotime($uniqueListing->created_at));


            //$uniqueListing->formatted_date = $uniqueListing->created_at->format('d-m-Y');
            $sabuniqueListings->push($uniqueListing);
        }
        //sell posts
        $selllistings = ConsumerPost::leftjoin('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
            ->leftjoin('resources', 'resources.id', 'consumer_resource_posts.resource_type')
            ->join('weights', 'consumer_posts.quantity', '=', 'weights.id')
            ->join('ecosansar_users', 'ecosansar_users.id', '=', 'consumer_posts.user_id')
            ->select('consumer_posts.*', 'resources.resource_name', 'consumer_resource_posts.resource_img', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
            ->where('consumer_posts.user_id', '!=', $user_id)
            ->where('active', 1)
            ->where('sale_giveaway', '!=', 'Buy');


             // Apply the filter based on the type if it's present in the request
        if ($request->has('sale_giveaway') && $request->sale_giveaway != '') {
            $selllistings->where(function ($query) use ($request) {
                $query->where('consumer_posts.sale_giveaway', $request->sale_giveaway);
            });
        }

        if ($request->has('clean_unclean') && $request->clean_unclean != '') {
            $selllistings->where(function ($query) use ($request) {
                $query->where('consumer_posts.clean_unclean', $request->clean_unclean);
            });
        }

        if ($request->has('packaged') && $request->packaged != '') {
            $selllistings->where(function ($query) use ($request) {
                $query->where('consumer_posts.packaged', $request->packaged);
            });
        }

        if ($request->has('pincode') && $request->pincode != '') {
            $selllistings->where(function ($query) use ($request) {
                $query->where('consumer_posts.pincode', $request->pincode);
            });
        }
        if ($request->has('weight') && $request->weight != '') {
            $selllistings->where(function ($query) use ($request) {
                $query->where('consumer_posts.quantity', $request->weight);
            });
        }

        // Apply the filter based on the resources if they are present in the request
        if ($request->has('resource') && !empty($request->resource)) {
            $resourceIds = $request->resource;
            $selllistings->whereIn('consumer_resource_posts.resource_type', $resourceIds);

            // Fetch resource names for applied filters
            $resources = Resource::whereIn('id', $resourceIds)->get();
            $resourceNames = $resources->pluck('resource_name')->implode(', ');
        }

         // Get the filtered results with distinct to avoid duplicates

        $sabsellPosts = $selllistings->distinct()->get();

        $postIds = $sabsellPosts->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $sabuniquesellListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $sabsellPosts->where('id', $postId);
            $weightDetails = $postListings->pluck('min_weight')->first() . ' ' .
                $postListings->pluck('min_measure')->first() . ' to ' .
                $postListings->pluck('max_weight')->first() . ' ' .
                $postListings->pluck('max_measure')->first();
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $uniqueListing->weight_details  = $weightDetails;
            $uniqueListing->formatted_date = date('dS F Y', strtotime($uniqueListing->created_at));


            //$uniqueListing->formatted_date = $uniqueListing->created_at->format('d-m-Y');
            $sabuniquesellListings->push($uniqueListing);
        }


        //  echo "<pre>";
        //  print_r($sabPosts);die;
        $res = Resource::get();
        //   $sabpostsres = SABResourcePost::where('user_id',$user_id)->where('post_id',$id)->get();
        $sabpostsres = ConsumerResourcePost::where('user_id', $user_id)->get();
        // Return filtered results to the same view for display
        // Return filtered results as JSON response
        $weightDetails = Weight::select('min_weight', 'max_weight', 'min_measure', 'max_measure')
            ->where('id', $request->weight)
            ->first();

        if ($weightDetails) {
            $minWeight = $weightDetails->min_weight;
            $maxWeight = $weightDetails->max_weight;
            $minMeasure = $weightDetails->min_measure;
            $maxMeasure = $weightDetails->max_measure;
        } else {
            // Handle the case where weight details are not found
            $minWeight = null;
            $maxWeight = null;
            $minMeasure = null;
            $maxMeasure = null;
        }

        return response()->json([
            'sabuniqueListings' => $sabuniqueListings,
            'sabuniquesellListings' => $sabuniquesellListings,
            'res' => $res,
            'appliedFilters' => array_merge($request->except('_token'), [
                'min_weight' => $minWeight,
                'max_weight' => $maxWeight,
                'min_measure' => $minMeasure,
                'max_measure' => $maxMeasure,
            ]),
        ]);
    }



    public function con_all_posts_sort(Request $request)
    {
        $user_id = session()->get('user_id');

        $sort = $request->input('sort');

        $query = ConsumerPost::join('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
            ->join('resources', 'resources.id', 'consumer_resource_posts.resource_type')
            ->leftjoin('consumer_reviews', 'consumer_reviews.post_id', 'consumer_posts.id')
            ->join('weights', 'consumer_posts.quantity', '=', 'weights.id')

            ->select('consumer_posts.*', 'resources.resource_name', 'consumer_resource_posts.resource_img', 'consumer_reviews.rating', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
            ->where('consumer_posts.user_id', '!=', $user_id)
            ->where('consumer_posts.active', '=', 1);

        // Apply sorting based on the selected criteria
        switch ($sort) {
            case '1':
                $query->orderBy('consumer_posts.created_at', 'desc'); // Newest first
                break;
            case '2':
                $query->orderBy('consumer_posts.created_at', 'asc'); // Oldest first
                break;
            case '3':
                $query->orderBy('weights.min_weight', 'desc')
                    ->orderBy('weights.max_weight', 'desc'); // Smallest quantity
                break;
            case '4':
                $query->orderBy('weights.min_weight', 'asc')
                    ->orderBy('weights.max_weight', 'asc'); // Largest quantity
                break;
            case '5':
                $query->orderBy('consumer_reviews.rating', 'desc'); // Highest ratings
                break;
            case '6':
                $query->orderBy('consumer_reviews.rating', 'asc'); // Lowest ratings
                break;
            default:
                // Default sorting if needed
                break;
        }

        $listings = $query->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $sabuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $weightDetails = $postListings->pluck('min_weight')->first() . ' ' .
                $postListings->pluck('min_measure')->first() . ' to ' .
                $postListings->pluck('max_weight')->first() . ' ' .
                $postListings->pluck('max_measure')->first();
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $uniqueListing->weight_details  = $weightDetails;
            $uniqueListing->formatted_date = date('dS F Y', strtotime($uniqueListing->created_at));
            $sabuniqueListings->push($uniqueListing);
        }

          //sell posts
        $selllistings = ConsumerPost::leftjoin('consumer_resource_posts', 'consumer_resource_posts.post_id', 'consumer_posts.id')
            ->leftjoin('resources', 'resources.id', 'consumer_resource_posts.resource_type')
            ->join('weights', 'consumer_posts.quantity', '=', 'weights.id')
            ->join('ecosansar_users', 'ecosansar_users.id', '=', 'consumer_posts.user_id')
            ->select('consumer_posts.*', 'resources.resource_name', 'consumer_resource_posts.resource_img', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
            ->where('active', 1)
            ->where('sale_giveaway', '!=', 'Buy');

           // Apply sorting based on the selected criteria
        switch ($sort) {
            case '1':
                $selllistings->orderBy('consumer_posts.created_at', 'desc'); // Newest first
                break;
            case '2':
                $selllistings->orderBy('consumer_posts.created_at', 'asc'); // Oldest first
                break;
            case '3':
                $selllistings->orderBy('weights.min_weight', 'desc')
                    ->orderBy('weights.max_weight', 'desc'); // Smallest quantity
                break;
            case '4':
                $selllistings->orderBy('weights.min_weight', 'asc')
                    ->orderBy('weights.max_weight', 'asc'); // Largest quantity
                break;
            case '5':
                $selllistings->orderBy('consumer_reviews.rating', 'desc'); // Highest ratings
                break;
            case '6':
                $selllistings->orderBy('consumer_reviews.rating', 'asc'); // Lowest ratings
                break;
            default:
                // Default sorting if needed
                break;
        }
         $selllistings = $selllistings->get();

        // Extract unique post IDs
        $postIds = $selllistings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $sabuniquesellListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $selllistings->where('id', $postId);
            $weightDetails = $postListings->pluck('min_weight')->first() . ' ' .
                $postListings->pluck('min_measure')->first() . ' to ' .
                $postListings->pluck('max_weight')->first() . ' ' .
                $postListings->pluck('max_measure')->first();
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $uniqueListing->weight_details  = $weightDetails;
            $uniqueListing->formatted_date = date('dS F Y', strtotime($uniqueListing->created_at));
            $sabuniquesellListings->push($uniqueListing);
        }



        $weightDetails = Weight::select('min_weight', 'max_weight', 'min_measure', 'max_measure')
            ->where('id', $request->weight)
            ->first();

        if ($weightDetails) {
            $minWeight = $weightDetails->min_weight;
            $maxWeight = $weightDetails->max_weight;
            $minMeasure = $weightDetails->min_measure;
            $maxMeasure = $weightDetails->max_measure;
        } else {
            // Handle the case where weight details are not found
            $minWeight = null;
            $maxWeight = null;
            $minMeasure = null;
            $maxMeasure = null;
        }
        return response()->json([
            'sabuniqueListings' => $sabuniqueListings,
            'sabuniquesellListings' => $sabuniquesellListings
        ]);
    }

    public function get_con_post_details(Request $request)
    {
        $postid = $request->dataId;
        $sab = ConsumerPost::where('id', $postid)->first();
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



    public function sab_all_posts()
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $appliedFilters = [];
        $listings = SABPost::leftjoin('s_a_b_resource_posts', 's_a_b_resource_posts.post_id', 's_a_b_posts.id')

            ->leftjoin('resources', 'resources.id', 's_a_b_resource_posts.resource_type')
            ->join('weights', 's_a_b_posts.quantity', '=', 'weights.id')
            ->join('ecosansar_users', 'ecosansar_users.id', '=', 's_a_b_posts.user_id')
            ->select('ecosansar_users.name', 's_a_b_posts.*', 'resources.resource_name', 's_a_b_resource_posts.resource_img', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
            ->where('active', 1)
 ->orderBy('s_a_b_posts.created_at', 'asc');

        if ($user_id) {
            $listings->where('s_a_b_posts.user_id', '!=', $user_id);
        }

        $listings = $listings->latest()->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $sabuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $sabuniqueListings->push($uniqueListing);
        }
        foreach ($sabuniqueListings as $listing) {
            $averageRating = DB::table('s_a_b_reviews')
                ->where('user_id', $listing->user_id)
                ->avg('rating');

            // Store the average rating in the listing object
            $listing->averageRating = $averageRating ?: 0; // If no rating, set to 0
        }

        $res = Resource::get();
        $weight = Weight::get();
        return view('frontend/listings/sab_all_listing', compact('sabuniqueListings', 'res', 'appliedFilters', 'weight', 'user_id', 'user_type'));
    }

    public function sab_all_posts_filter(Request $request)
    {
        $user_id = session()->get('user_id');

        // Initialize the query builders with joins to their respective resource pivot tables

        $sabQuery = SABPost::join('s_a_b_resource_posts', 's_a_b_resource_posts.post_id', '=', 's_a_b_posts.id')
            ->join('resources', 'resources.id', 's_a_b_resource_posts.resource_type')
            ->join('weights', 's_a_b_posts.quantity', '=', 'weights.id')
            ->join('ecosansar_users', 'ecosansar_users.id', '=', 's_a_b_posts.user_id')
            ->select('ecosansar_users.name', 's_a_b_posts.*', 'resources.resource_name', 's_a_b_resource_posts.resource_img', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
            ->where('s_a_b_posts.user_id', '!=', $user_id)
            ->where('active', 1);


        // Apply the filter based on the type if it's present in the request
        if ($request->has('sale_giveaway') && $request->sale_giveaway != '') {
            $sabQuery->where(function ($query) use ($request) {
                $query->where('s_a_b_posts.sale_giveaway', $request->sale_giveaway);
            });
        }

        if ($request->has('clean_unclean') && $request->clean_unclean != '') {
            $sabQuery->where(function ($query) use ($request) {
                $query->where('s_a_b_posts.clean_unclean', $request->clean_unclean);
            });
        }

        if ($request->has('packaged') && $request->packaged != '') {
            $sabQuery->where(function ($query) use ($request) {
                $query->where('s_a_b_posts.packaged', $request->packaged);
            });
        }

        if ($request->has('pincode') && $request->pincode != '') {
            $sabQuery->where(function ($query) use ($request) {
                $query->where('s_a_b_posts.pincode', $request->pincode);
            });
        }
        if ($request->has('weight') && $request->weight != '') {
            $sabQuery->where(function ($query) use ($request) {
                $query->where('s_a_b_posts.quantity', $request->weight);
            });
        }

        // Apply the filter based on the resources if they are present in the request
        if ($request->has('resource') && !empty($request->resource)) {
            $resourceIds = $request->resource;
            $sabQuery->whereIn('s_a_b_resource_posts.resource_type', $resourceIds);

            // Fetch resource names for applied filters
            $resources = Resource::whereIn('id', $resourceIds)->get();
            $resourceNames = $resources->pluck('resource_name')->implode(', ');
        }



        // Get the filtered results with distinct to avoid duplicates

        $sabPosts = $sabQuery->distinct()->get();

        $postIds = $sabPosts->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $sabuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $sabPosts->where('id', $postId);
            $weightDetails = $postListings->pluck('min_weight')->first() . ' ' .
                $postListings->pluck('min_measure')->first() . ' to ' .
                $postListings->pluck('max_weight')->first() . ' ' .
                $postListings->pluck('max_measure')->first();
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $uniqueListing->weight_details  = $weightDetails;
            $uniqueListing->formatted_date = date('dS F Y', strtotime($uniqueListing->created_at));


            //$uniqueListing->formatted_date = $uniqueListing->created_at->format('d-m-Y');
            $sabuniqueListings->push($uniqueListing);
        }
        //  echo "<pre>";
        //  print_r($sabPosts);die;
        $res = Resource::get();
        //   $sabpostsres = SABResourcePost::where('user_id',$user_id)->where('post_id',$id)->get();
        $sabpostsres = SABResourcePost::where('user_id', $user_id)->get();
        // Return filtered results to the same view for display
        // Return filtered results as JSON response
        $weightDetails = Weight::select('min_weight', 'max_weight', 'min_measure', 'max_measure')
            ->where('id', $request->weight)
            ->first();

        if ($weightDetails) {
            $minWeight = $weightDetails->min_weight;
            $maxWeight = $weightDetails->max_weight;
            $minMeasure = $weightDetails->min_measure;
            $maxMeasure = $weightDetails->max_measure;
        } else {
            // Handle the case where weight details are not found
            $minWeight = null;
            $maxWeight = null;
            $minMeasure = null;
            $maxMeasure = null;
        }
        return response()->json([
            'sabuniqueListings' => $sabuniqueListings,
            'res' => $res,
            'appliedFilters' => array_merge($request->except('_token'), [
                'min_weight' => $minWeight,
                'max_weight' => $maxWeight,
                'min_measure' => $minMeasure,
                'max_measure' => $maxMeasure,
            ]),
        ]);
    }

    public function get_post_details(Request $request)
    {
        $postid = $request->dataId;
        $sab = SABPost::where('id', $postid)->first();
        $user_id = session()->get('user_id');
        if ($sab) {
            $uid = $sab->user_id;
            $user = EcosansarUsers::where('id', $uid)->first();

            // Fetch details of the logged-in user
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

    public function bus_all_posts()
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $appliedFilters = [];

        $listings = BusinessPost::leftjoin('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
            ->leftjoin('resources', 'resources.id', 'business_resource_posts.resource_type')
            ->join('weights', 'business_posts.quantity', '=', 'weights.id')
            ->join('ecosansar_users', 'ecosansar_users.id', '=', 'business_posts.user_id')
            ->select('ecosansar_users.name', 'business_posts.*', 'resources.resource_name', 'business_resource_posts.resource_img', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
           // ->where('sale_giveaway', '=', 'Buy')
            ->where('active', 1)
            ->orderBy('business_posts.created_at', 'asc');
        // Exclude user's own posts if logged in
        if ($user_id) {
            $listings->where('business_posts.user_id', '!=', $user_id);
        }

        $listings = $listings->latest()->take(3)->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $busuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $busuniqueListings->push($uniqueListing);
        }

        //Business posts except sell
        $listingsnotsell = BusinessPost::leftjoin('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
            ->leftjoin('resources', 'resources.id', 'business_resource_posts.resource_type')
            ->join('weights', 'business_posts.quantity', '=', 'weights.id')
            ->join('ecosansar_users', 'ecosansar_users.id', '=', 'business_posts.user_id')

            ->select('ecosansar_users.name', 'business_posts.*', 'resources.resource_name', 'business_resource_posts.resource_img', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
            ->where('active', 1)
            ->where('sale_giveaway', '=', 'Buy')
            ->orderBy('business_posts.created_at', 'asc');

        // Exclude user's own posts if logged in
        if ($user_id) {
            $listingsnotsell->where('business_posts.user_id', '!=', $user_id);
        }

        $listingsnotsell = $listingsnotsell->latest()->take(3)->get();

        // Extract unique post IDs
        $postIds = $listingsnotsell->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $busuniqueListingsnotsell = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listingsnotsell->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $busuniqueListingsnotsell->push($uniqueListing);
        }
        foreach ($busuniqueListings as $listing) {
            $averageRating = DB::table('business_reviews')
                ->where('user_id', $listing->user_id)
                ->avg('rating');

            // Store the average rating in the listing object
            $listing->averageRating = $averageRating ?: 0; // If no rating, set to 0
        }
        $res = Resource::get();
        $weight = Weight::get();

        return view('frontend/listings/bus_all_listing', compact('busuniqueListings', 'res', 'appliedFilters', 'weight', 'user_id', 'user_type','busuniqueListingsnotsell'));
    }
    public function bus_all_posts_filter(Request $request)
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');

        // Initialize the query builders with joins to their respective resource pivot tables

        $busQuery = BusinessPost::leftjoin('business_resource_posts', 'business_resource_posts.post_id', '=', 'business_posts.id')
            ->leftjoin('resources', 'resources.id', 'business_resource_posts.resource_type')
            ->join('weights', 'business_posts.quantity', '=', 'weights.id')
            ->join('ecosansar_users', 'ecosansar_users.id', '=', 'business_posts.user_id')
            ->select('ecosansar_users.name', 'business_posts.*', 'resources.resource_name', 'business_resource_posts.resource_img', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
            ->where('business_posts.user_id', '!=', $user_id)
            ->where('active', 1);


        // Apply the filter based on the type if it's present in the request
        if ($request->has('sale_giveaway') && $request->sale_giveaway != '') {
            $busQuery->where(function ($query) use ($request) {
                $query->where('business_posts.sale_giveaway', $request->sale_giveaway);
            });
        }

        if ($request->has('clean_unclean') && $request->clean_unclean != '') {
            $busQuery->where(function ($query) use ($request) {
                $query->where('business_posts.clean_unclean', $request->clean_unclean);
            });
        }

        if ($request->has('packaged') && $request->packaged != '') {
            $busQuery->where(function ($query) use ($request) {
                $query->where('business_posts.packaged', $request->packaged);
            });
        }

        if ($request->has('pincode') && $request->pincode != '') {
            $busQuery->where(function ($query) use ($request) {
                $query->where('business_posts.pincode', $request->pincode);
            });
        }
        if ($request->has('weight') && $request->weight != '') {
            $busQuery->where(function ($query) use ($request) {
                $query->where('business_posts.quantity', $request->weight);
            });
        }


        // Apply the filter based on the resources if they are present in the request
        if ($request->has('resource') && !empty($request->resource)) {
            $resourceIds = $request->resource;
            $busQuery->whereIn('business_resource_posts.resource_type', $resourceIds);

            // Fetch resource names for applied filters
            $resources = Resource::whereIn('id', $resourceIds)->get();
            $resourceNames = $resources->pluck('resource_name')->implode(', ');
        }
        // Get the filtered results with distinct to avoid duplicates

        $busPosts = $busQuery->distinct()->get();
        $postIds = $busPosts->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $busuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $busPosts->where('id', $postId);
            $weightDetails = $postListings->pluck('min_weight')->first() . ' ' .
                $postListings->pluck('min_measure')->first() . ' to ' .
                $postListings->pluck('max_weight')->first() . ' ' .
                $postListings->pluck('max_measure')->first();
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $uniqueListing->weight_details  = $weightDetails;
            $uniqueListing->formatted_date = date('dS F Y', strtotime($uniqueListing->created_at));
            $busuniqueListings->push($uniqueListing);
        }

        //business buy posts
        $busbuyQuery = BusinessPost::leftjoin('business_resource_posts', 'business_resource_posts.post_id', '=', 'business_posts.id')
            ->leftjoin('resources', 'resources.id', 'business_resource_posts.resource_type')
            ->join('weights', 'business_posts.quantity', '=', 'weights.id')
            ->join('ecosansar_users', 'ecosansar_users.id', '=', 'business_posts.user_id')
            ->select('ecosansar_users.name', 'business_posts.*', 'resources.resource_name', 'business_resource_posts.resource_img', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
            ->where('business_posts.user_id', '!=', $user_id)
             ->where('sale_giveaway', '=', 'Buy')
            ->where('active', 1);

         // Apply the filter based on the type if it's present in the request
        if ($request->has('sale_giveaway') && $request->sale_giveaway != '') {
            $busbuyQuery->where(function ($query) use ($request) {
                $query->where('business_posts.sale_giveaway', $request->sale_giveaway);
            });
        }

        if ($request->has('clean_unclean') && $request->clean_unclean != '') {
            $busbuyQuery->where(function ($query) use ($request) {
                $query->where('business_posts.clean_unclean', $request->clean_unclean);
            });
        }

        if ($request->has('packaged') && $request->packaged != '') {
            $busbuyQuery->where(function ($query) use ($request) {
                $query->where('business_posts.packaged', $request->packaged);
            });
        }

        if ($request->has('pincode') && $request->pincode != '') {
            $busbuyQuery->where(function ($query) use ($request) {
                $query->where('business_posts.pincode', $request->pincode);
            });
        }
        if ($request->has('weight') && $request->weight != '') {
            $busbuyQuery->where(function ($query) use ($request) {
                $query->where('business_posts.quantity', $request->weight);
            });
        }

         // Apply the filter based on the resources if they are present in the request
        if ($request->has('resource') && !empty($request->resource)) {
            $resourceIds = $request->resource;
            $busbuyQuery->whereIn('business_resource_posts.resource_type', $resourceIds);

            // Fetch resource names for applied filters
            $resources = Resource::whereIn('id', $resourceIds)->get();
            $resourceNames = $resources->pluck('resource_name')->implode(', ');
        }
        // Get the filtered results with distinct to avoid duplicates

        $busbuyPosts = $busbuyQuery->distinct()->get();
        $buypostIds = $busbuyPosts->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $busuniquebuyListings = collect([]);
        foreach ($buypostIds as $postId) {
            $postListings = $busbuyPosts->where('id', $postId);
            $weightDetails = $postListings->pluck('min_weight')->first() . ' ' .
                $postListings->pluck('min_measure')->first() . ' to ' .
                $postListings->pluck('max_weight')->first() . ' ' .
                $postListings->pluck('max_measure')->first();
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $uniqueListing->weight_details  = $weightDetails;
            $uniqueListing->formatted_date = date('dS F Y', strtotime($uniqueListing->created_at));
            $busuniquebuyListings->push($uniqueListing);
        }


        $res = Resource::get();
        //   $buspostsres = BusinessResourcePost::where('user_id',$user_id)->where('post_id',$id)->get();
        $buspostsres = BusinessResourcePost::where('user_id', $user_id)->get();
        // Return filtered results to the same view for display
        //      echo "<pre>";
        // print_r($request->except('_token'));die;
        // Return filtered results as JSON response
        // return response()->json([
        //     'busuniqueListings' => $busuniqueListings,
        //     'res' => $res,
        //     'appliedFilters' => $request->except('_token'),
        // ]);
        // Assuming $weightName is fetched based on the selected weight ID
        $weightDetails = Weight::select('min_weight', 'max_weight', 'min_measure', 'max_measure')
            ->where('id', $request->weight)
            ->first();

        if ($weightDetails) {
            $minWeight = $weightDetails->min_weight;
            $maxWeight = $weightDetails->max_weight;
            $minMeasure = $weightDetails->min_measure;
            $maxMeasure = $weightDetails->max_measure;
        } else {
            // Handle the case where weight details are not found
            $minWeight = null;
            $maxWeight = null;
            $minMeasure = null;
            $maxMeasure = null;
        }

        return response()->json([
            'busuniqueListings' => $busuniqueListings,
            'busuniquebuyListings' => $busuniquebuyListings,
            'user_type' => $user_type,
            'res' => $res,
            'appliedFilters' => array_merge($request->except('_token'), [
                'min_weight' => $minWeight,
                'max_weight' => $maxWeight,
                'min_measure' => $minMeasure,
                'max_measure' => $maxMeasure,
            ]),
        ]);
    }
    public function get_business_post_details(Request $request)
    {
        $postid = $request->dataId;
        $sab = BusinessPost::where('id', $postid)->first();
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


    //buy filter
    public function sab_all_buy_posts()
    {
        $user_id = session()->get('user_id');
        $appliedFilters = [];
        $listings = SABPost::join('s_a_b_resource_posts', 's_a_b_resource_posts.post_id', 's_a_b_posts.id')
            ->join('resources', 'resources.id', 's_a_b_resource_posts.resource_type')
            ->join('weights', 's_a_b_posts.quantity', '=', 'weights.id')
            ->join('ecosansar_users', 'ecosansar_users.id', '=', 's_a_b_posts.user_id')
            ->select('ecosansar_users.name', 's_a_b_posts.*', 'resources.resource_name', 's_a_b_resource_posts.resource_img', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')

            ->where('sale_giveaway', 'Buy');
        if ($user_id) {
            $listings->where('s_a_b_posts.user_id', '!=', $user_id);
        }

        $listings = $listings->latest()->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $sabuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->implode(', ');
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $sabuniqueListings->push($uniqueListing);
        }

        $res = Resource::get();
        $weight = Weight::get();
        return view('frontend/listings/sab_all_buy_listing', compact('sabuniqueListings', 'res', 'appliedFilters', 'weight'));
    }
    public function sab_all_buy_posts_filter(Request $request)
    {
        $user_id = session()->get('user_id');

        // Initialize the query builders with joins to their respective resource pivot tables

        $sabQuery = SABPost::join('s_a_b_resource_posts', 's_a_b_resource_posts.post_id', '=', 's_a_b_posts.id')
            ->join('resources', 'resources.id', 's_a_b_resource_posts.resource_type')
            ->join('weights', 's_a_b_posts.quantity', '=', 'weights.id')
            ->join('ecosansar_users', 'ecosansar_users.id', '=', 's_a_b_posts.user_id')
            ->select('ecosansar_users.name', 's_a_b_posts.*', 'resources.resource_name', 's_a_b_resource_posts.resource_img', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
            ->where('s_a_b_posts.user_id', '!=', $user_id)
            ->where('sale_giveaway', 'Buy');


        // Apply the filter based on the type if it's present in the request
        if ($request->has('sale_giveaway') && $request->sale_giveaway != '') {
            $sabQuery->where(function ($query) use ($request) {
                $query->where('s_a_b_posts.sale_giveaway', $request->sale_giveaway);
            });
        }

        if ($request->has('clean_unclean') && $request->clean_unclean != '') {
            $sabQuery->where(function ($query) use ($request) {
                $query->where('s_a_b_posts.clean_unclean', $request->clean_unclean);
            });
        }

        if ($request->has('packaged') && $request->packaged != '') {
            $sabQuery->where(function ($query) use ($request) {
                $query->where('s_a_b_posts.packaged', $request->packaged);
            });
        }

        if ($request->has('pincode') && $request->pincode != '') {
            $sabQuery->where(function ($query) use ($request) {
                $query->where('s_a_b_posts.pincode', $request->pincode);
            });
        }
        if ($request->has('weight') && $request->weight != '') {
            $sabQuery->where(function ($query) use ($request) {
                $query->where('s_a_b_posts.quantity', $request->weight);
            });
        }

        // Apply the filter based on the resources if they are present in the request
        if ($request->has('resource') && !empty($request->resource)) {
            $resourceIds = $request->resource;
            $sabQuery->whereIn('s_a_b_resource_posts.resource_type', $resourceIds);

            // Fetch resource names for applied filters
            $resources = Resource::whereIn('id', $resourceIds)->get();
            $resourceNames = $resources->pluck('resource_name')->implode(', ');
        }
        // Get the filtered results with distinct to avoid duplicates

        $sabPosts = $sabQuery->distinct()->get();
        $postIds = $sabPosts->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $sabuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $sabPosts->where('id', $postId);
            $weightDetails = $postListings->pluck('min_weight')->first() . ' ' .
                $postListings->pluck('min_measure')->first() . ' to ' .
                $postListings->pluck('max_weight')->first() . ' ' .
                $postListings->pluck('max_measure')->first();
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->implode(', ');
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $uniqueListing->weight_details  = $weightDetails;
            $uniqueListing->formatted_date = $uniqueListing->created_at->format('d-m-Y');
            $sabuniqueListings->push($uniqueListing);
        }

        $res = Resource::get();
        //   $sabpostsres = SABResourcePost::where('user_id',$user_id)->where('post_id',$id)->get();
        $sabpostsres = SABResourcePost::where('user_id', $user_id)->get();
        // Return filtered results to the same view for display
        // Return filtered results as JSON response
        $weightDetails = Weight::select('min_weight', 'max_weight', 'min_measure', 'max_measure')
            ->where('id', $request->weight)
            ->first();

        if ($weightDetails) {
            $minWeight = $weightDetails->min_weight;
            $maxWeight = $weightDetails->max_weight;
            $minMeasure = $weightDetails->min_measure;
            $maxMeasure = $weightDetails->max_measure;
        } else {
            // Handle the case where weight details are not found
            $minWeight = null;
            $maxWeight = null;
            $minMeasure = null;
            $maxMeasure = null;
        }
        return response()->json([
            'sabuniqueListings' => $sabuniqueListings,
            'res' => $res,
            'appliedFilters' => array_merge($request->except('_token'), [
                'min_weight' => $minWeight,
                'max_weight' => $maxWeight,
                'min_measure' => $minMeasure,
                'max_measure' => $maxMeasure,
            ]),
        ]);
    }

    public function bus_all_buy_posts()
    {
        $user_id = session()->get('user_id');
        $appliedFilters = [];

        $listings = BusinessPost::join('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
            ->join('resources', 'resources.id', 'business_resource_posts.resource_type')
            ->join('weights', 'business_posts.quantity', '=', 'weights.id')
            ->join('ecosansar_users', 'ecosansar_users.id', '=', 'business_posts.user_id')
            ->select('ecosansar_users.name', 'business_posts.*', 'resources.resource_name', 'business_resource_posts.resource_img', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')

            ->where('sale_giveaway', 'Buy');
        // Exclude user's own posts if logged in
        if ($user_id) {
            $listings->where('business_posts.user_id', '!=', $user_id);
        }

        $listings = $listings->latest()->take(3)->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $busuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->implode(', ');
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $busuniqueListings->push($uniqueListing);
        }
        $res = Resource::get();
        $weight = Weight::get();
        return view('frontend/listings/bus_all_buy_listing', compact('busuniqueListings', 'res', 'appliedFilters', 'weight'));
    }
    public function bus_all_buy_posts_filter(Request $request)
    {
        $user_id = session()->get('user_id');

        // Initialize the query builders with joins to their respective resource pivot tables

        $busQuery = BusinessPost::join('business_resource_posts', 'business_resource_posts.post_id', '=', 'business_posts.id')
            ->join('resources', 'resources.id', 'business_resource_posts.resource_type')
            ->join('weights', 'business_posts.quantity', '=', 'weights.id')
            ->join('ecosansar_users', 'ecosansar_users.id', '=', 'business_posts.user_id')
            ->select('ecosansar_users.name', 'business_posts.*', 'resources.resource_name', 'business_resource_posts.resource_img', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')

            ->where('business_posts.user_id', '!=', $user_id)
            ->where('sale_giveaway', 'Buy');


        // Apply the filter based on the type if it's present in the request
        if ($request->has('sale_giveaway') && $request->sale_giveaway != '') {
            $busQuery->where(function ($query) use ($request) {
                $query->where('business_posts.sale_giveaway', $request->sale_giveaway);
            });
        }

        if ($request->has('clean_unclean') && $request->clean_unclean != '') {
            $busQuery->where(function ($query) use ($request) {
                $query->where('business_posts.clean_unclean', $request->clean_unclean);
            });
        }

        if ($request->has('packaged') && $request->packaged != '') {
            $busQuery->where(function ($query) use ($request) {
                $query->where('business_posts.packaged', $request->packaged);
            });
        }

        if ($request->has('pincode') && $request->pincode != '') {
            $busQuery->where(function ($query) use ($request) {
                $query->where('business_posts.pincode', $request->pincode);
            });
        }

        if ($request->has('weight') && $request->weight != '') {
            $busQuery->where(function ($query) use ($request) {
                $query->where('business_posts.quantity', $request->weight);
            });
        }


        // Apply the filter based on the resources if they are present in the request
        if ($request->has('resource') && !empty($request->resource)) {
            $resourceIds = $request->resource;
            $busQuery->whereIn('business_resource_posts.resource_type', $resourceIds);

            // Fetch resource names for applied filters
            $resources = Resource::whereIn('id', $resourceIds)->get();
            $resourceNames = $resources->pluck('resource_name')->implode(', ');
        }
        // Get the filtered results with distinct to avoid duplicates

        // $busPosts = $busQuery->distinct()->select('business_posts.*','business_resource_posts.resource_img')->get();
        $busPosts = $busQuery->distinct()->get();
        $postIds = $busPosts->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $busuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $busPosts->where('id', $postId);
            $weightDetails = $postListings->pluck('min_weight')->first() . ' ' .
                $postListings->pluck('min_measure')->first() . ' to ' .
                $postListings->pluck('max_weight')->first() . ' ' .
                $postListings->pluck('max_measure')->first();
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->implode(', ');
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $uniqueListing->weight_details  = $weightDetails;
            $uniqueListing->formatted_date = date('dS F Y', strtotime($uniqueListing->created_at));
            $busuniqueListings->push($uniqueListing);
        }

        $res = Resource::get();
        //   $buspostsres = BusinessResourcePost::where('user_id',$user_id)->where('post_id',$id)->get();
        $buspostsres = BusinessResourcePost::where('user_id', $user_id)->get();
        // Return filtered results to the same view for display

        $weightDetails = Weight::select('min_weight', 'max_weight', 'min_measure', 'max_measure')
            ->where('id', $request->weight)
            ->first();

        if ($weightDetails) {
            $minWeight = $weightDetails->min_weight;
            $maxWeight = $weightDetails->max_weight;
            $minMeasure = $weightDetails->min_measure;
            $maxMeasure = $weightDetails->max_measure;
        } else {
            // Handle the case where weight details are not found
            $minWeight = null;
            $maxWeight = null;
            $minMeasure = null;
            $maxMeasure = null;
        }

        return response()->json([
            'busuniqueListings' => $busuniqueListings,
            'res' => $res,
            'appliedFilters' => array_merge($request->except('_token'), [
                'min_weight' => $minWeight,
                'max_weight' => $maxWeight,
                'min_measure' => $minMeasure,
                'max_measure' => $maxMeasure,
            ]),
        ]);
    }
    public function get_consumer_post_details(Request $request)
    {
        $postid = $request->dataId;
        $sab = ConsumerPost::where('id', $postid)->first();
        $user_id = session()->get('user_id');
        if ($sab) {
            $uid = $sab->user_id;
            $user = EcosansarUsers::where('id', $uid)->first();
            // Fetch details of the logged-in user
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
    public function sab_all_posts_sort(Request $request)
    {
        $user_id = session()->get('user_id');

        $sort = $request->input('sort');

        $query = SABPost::join('s_a_b_resource_posts', 's_a_b_resource_posts.post_id', 's_a_b_posts.id')
            ->join('resources', 'resources.id', 's_a_b_resource_posts.resource_type')
            ->leftjoin('s_a_b_reviews', 's_a_b_reviews.post_id', 's_a_b_posts.id')
            ->join('weights', 's_a_b_posts.quantity', '=', 'weights.id')

            ->select('s_a_b_posts.*', 'resources.resource_name', 's_a_b_resource_posts.resource_img', 's_a_b_reviews.rating', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
            ->where('s_a_b_posts.user_id', '!=', $user_id)
            ->where('s_a_b_posts.active', '=', 1);

        // Apply sorting based on the selected criteria
        switch ($sort) {
            case '1':
                $query->orderBy('s_a_b_posts.created_at', 'desc'); // Newest first
                break;
            case '2':
                $query->orderBy('s_a_b_posts.created_at', 'asc'); // Oldest first
                break;
            case '3':
                $query->orderBy('weights.min_weight', 'desc')
                    ->orderBy('weights.max_weight', 'desc'); // Smallest quantity
                break;
            case '4':
                $query->orderBy('weights.min_weight', 'asc')
                    ->orderBy('weights.max_weight', 'asc'); // Largest quantity
                break;
            case '5':
                $query->orderBy('s_a_b_reviews.rating', 'desc'); // Highest ratings
                break;
            case '6':
                $query->orderBy('s_a_b_reviews.rating', 'asc'); // Lowest ratings
                break;
            default:
                // Default sorting if needed
                break;
        }

        $listings = $query->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $sabuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $weightDetails = $postListings->pluck('min_weight')->first() . ' ' .
                $postListings->pluck('min_measure')->first() . ' to ' .
                $postListings->pluck('max_weight')->first() . ' ' .
                $postListings->pluck('max_measure')->first();
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $uniqueListing->weight_details  = $weightDetails;
            $uniqueListing->formatted_date = date('dS F Y', strtotime($uniqueListing->created_at));
            $sabuniqueListings->push($uniqueListing);
        }
        $weightDetails = Weight::select('min_weight', 'max_weight', 'min_measure', 'max_measure')
            ->where('id', $request->weight)
            ->first();

        if ($weightDetails) {
            $minWeight = $weightDetails->min_weight;
            $maxWeight = $weightDetails->max_weight;
            $minMeasure = $weightDetails->min_measure;
            $maxMeasure = $weightDetails->max_measure;
        } else {
            // Handle the case where weight details are not found
            $minWeight = null;
            $maxWeight = null;
            $minMeasure = null;
            $maxMeasure = null;
        }
        return response()->json([
            'sabuniqueListings' => $sabuniqueListings,
        ]);
    }

    public function bus_all_posts_sort(Request $request)
    {
        $user_id = session()->get('user_id');

        $sort = $request->input('sort');

        $query = BusinessPost::leftjoin('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
            ->leftjoin('resources', 'resources.id', 'business_resource_posts.resource_type')
            ->leftjoin('business_reviews', 'business_reviews.post_id', 'business_posts.id')
            ->join('weights', 'business_posts.quantity', '=', 'weights.id')

            ->select('business_posts.*', 'resources.resource_name', 'business_resource_posts.resource_img', 'business_reviews.rating', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure')
            ->where('business_posts.user_id', '!=', $user_id)
            ->where('business_posts.active', '=', 1);

        // Apply sorting based on the selected criteria
        switch ($sort) {
            case '1':
                $query->orderBy('business_posts.created_at', 'desc'); // Newest first
                break;
            case '2':
                $query->orderBy('business_posts.created_at', 'asc'); // Oldest first
                break;
            case '3':
                $query->orderBy('weights.min_weight', 'desc')
                    ->orderBy('weights.max_weight', 'desc'); // Smallest quantity
                break;
            case '4':
                $query->orderBy('weights.min_weight', 'asc')
                    ->orderBy('weights.max_weight', 'asc'); // Largest quantity
                break;
            case '5':
                $query->orderBy('business_reviews.rating', 'desc'); // Highest ratings
                break;
            case '6':
                $query->orderBy('business_reviews.rating', 'asc'); // Lowest ratings
                break;
            default:
                // Default sorting if needed
                break;
        }

        $listings = $query->get();

        // Extract unique post IDs
        $postIds = $listings->pluck('id')->unique();

        // Filter listings to get only one record per post and include all resource names
        $busuniqueListings = collect([]);
        foreach ($postIds as $postId) {
            $postListings = $listings->where('id', $postId);
            $weightDetails = $postListings->pluck('min_weight')->first() . ' ' .
                $postListings->pluck('min_measure')->first() . ' to ' .
                $postListings->pluck('max_weight')->first() . ' ' .
                $postListings->pluck('max_measure')->first();
            $resourceNames = $postListings->pluck('resource_name')->implode(', ');
            $resourceImages = $postListings->pluck('resource_img')->first();;
            $uniqueListing = $postListings->first();
            $uniqueListing->resource_names = $resourceNames;
            $uniqueListing->resource_img = $resourceImages;
            $uniqueListing->weight_details  = $weightDetails;
            $uniqueListing->formatted_date = date('dS F Y', strtotime($uniqueListing->created_at));
            $busuniqueListings->push($uniqueListing);
        }
        $weightDetails = Weight::select('min_weight', 'max_weight', 'min_measure', 'max_measure')
            ->where('id', $request->weight)
            ->first();

        if ($weightDetails) {
            $minWeight = $weightDetails->min_weight;
            $maxWeight = $weightDetails->max_weight;
            $minMeasure = $weightDetails->min_measure;
            $maxMeasure = $weightDetails->max_measure;
        } else {
            // Handle the case where weight details are not found
            $minWeight = null;
            $maxWeight = null;
            $minMeasure = null;
            $maxMeasure = null;
        }
        return response()->json([
            'busuniqueListings' => $busuniqueListings,
        ]);
    }
    public function gadsense(){
        return view('gadsense');
    }

}
