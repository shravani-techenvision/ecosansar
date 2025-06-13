<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\frontend\EcosansarUsers;
use App\Models\frontend\RecyclablePost;
use App\Models\frontend\ReusablePost;
 use App\Models\frontend\ReusableEnquiry;
use App\Models\frontend\RecyclableEnquiry;
use App\Models\frontend\RecyclableAskReviews;
use App\Models\frontend\RecyclableReview;
use App\Models\frontend\ReusableReview;
use App\Models\admin\BreadcrumImage;
use App\Models\frontend\SABEnquiryMessages;
use App\Models\frontend\Comment;
use App\Models\frontend\CommentReply;
use App\Models\admin\Resource;
use App\Models\admin\Pincode;
use App\Models\admin\Weight;
use App\Models\admin\Faq;
use App\Models\admin\About;
use App\Models\admin\Volunteer;
use App\Models\admin\Category;
use App\Models\admin\GoogleAdsense;
use App\Models\admin\Blog;
use App\Models\admin\BlogCategory;
use App\Models\admin\BlogTag;
use App\Models\admin\Service;
use App\Models\admin\Contact;

use App\Models\frontend\UserContact;
use App\Models\frontend\RepairContact;
use App\Models\frontend\UserActivityLog;
use App\Models\frontend\Notify;
use App\Models\frontend\NotificationLog;
use RealRashid\SweetAlert\Facades\Alert;
use Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;
use Mail;
use Carbon\Carbon;
use Craftsys\Msg91\Facade\Msg91;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use App\Services\PHPMailerService;
use Illuminate\Support\Facades\View;
use App\Services\NotificationService;
use App\Services\NotificationSABService;
use App\Services\NotificationBusinessService;
use App\Services\NotificationValidationService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Exception;
use Illuminate\Pagination\Paginator;



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
                'registration_url' => url('/user_register'),
            ], 404);
        }

        if ($user->is_delete == 1) {
            // User not found
            return response()->json([
                'status' => 'error',
                'message' => 'User deactivated. Please activate',
               // 'registration_url' => 'https://ecosansar.com/user_activate/' . $user->id,
               'registration_url' => url('user_activate/' . $user->id),

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
                // 'registration_url' => 'https://ecosansar.com/loginverify_otp/' . $user->id,
                'registration_url' => url('loginverify_otp/' . $user->id),

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
        $breadcrumbimage = BreadcrumImage::latest()->first();
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on terms conditions page';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        return view('frontend/temrs_condition', compact('breadcrumbimage'));
    }
    public function index(Request $request)
    {
        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');

       $query = RecyclablePost::with(['resource', 'weight'])
        //->where('recyclable_posts.user_id', '!=', $user_id)
        ->where('recyclable_posts.active', 1)
         ->where('recyclable_posts.request_fulfilled', 0)
        ->leftJoin(
        DB::raw('(SELECT user_id, AVG(rating) as average_rating FROM recyclable_reviews GROUP BY user_id) as user_ratings'),
        'recyclable_posts.user_id',  // ✅ Join on recyclable_posts.user_id
        '=',
        'user_ratings.user_id'
    )
    ->select('recyclable_posts.*', 'user_ratings.average_rating');

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


    $posts = $query->orderBy('id','desc')->take(4)->get();

   //fetch reusable posts
   $query = ReusablePost::with(['resource', 'weight'])
       // ->where('reusable_posts.user_id', '!=', $user_id)
         ->where('reusable_posts.request_fulfilled', 0)
        ->where('reusable_posts.active', 1)
        ->leftJoin(
        DB::raw('(SELECT user_id, AVG(rating) as average_rating FROM reusable_reviews GROUP BY user_id) as user_ratings'),
        'reusable_posts.user_id',  //  oin on reusable_posts.user_id
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


    $reusableposts = $query->orderBy('id','desc')->take(4)->get();


         // Fetch only the latest 3 blogs
         $blogs = Blog::where('active', 1)
            ->orderBy('id', 'desc')
            ->take(3)
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
         $Contributorusers = EcosansarUsers::where('user_type','consumer')->where('is_delete','0')->count();
         $collagentusers = EcosansarUsers::where('user_type','sab')->where('is_delete','0')->count();
         $totlenoofrecyclablelistings = RecyclablePost::where('active','1')->count();
         $totlenoofreusablelistings = ReusablePost::where('active','1')->count();
         $totnooflistings = $totlenoofrecyclablelistings + $totlenoofreusablelistings;
         $totalrecyclableresources = RecyclablePost::join('weights', 'recyclable_posts.quantity', '=', 'weights.id')
        ->selectRaw('SUM(weights.min_weight) as total_min_weight')
        ->first();
        $totalreusableresources = ReusablePost::join('weights', 'reusable_posts.quantity', '=', 'weights.id')
        ->selectRaw('SUM(weights.min_weight) as total_min_weight')
        ->first();
        $totnoresources = $totalrecyclableresources->total_min_weight + $totalreusableresources->total_min_weight;
        $totalrecyclableconn = RecyclableEnquiry::count();
         $totalreusableconn = ReusableEnquiry::count();
         $totalconn = $totalrecyclableconn + $totalreusableconn;

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


        return view('frontend/index', compact('user_type', 'blogs', 'posts', 'reusableposts', 'Contributorusers', 'collagentusers', 'totnooflistings',
         'totnoresources', 'totalconn'));
    }



    public function profile($id)
    {
        $breadcrumbimage = BreadcrumImage::latest()->first();

          $userid = session()->get('user_id');
         $user_type = session()->get('user_type');
        $users = EcosansarUsers::where('id', $id)->first();
         $utype = $users->user_type;

        // $uniqueListings = RecyclablePost::with(['resource', 'weight'])
        //     ->select('recyclable_posts.*')
        //     ->where('recyclable_posts.user_id', $id)
        //     ->where('recyclable_posts.user_type', $utype)
        //     ->where('recyclable_posts.active', '=', 1)
        //   ->paginate(8);
        // Fetch recyclable posts
$perPage = 10;
$page = request()->get('page', 1);
$offset = ($page - 1) * $perPage;

// First query: recyclable_posts
$recyclable = DB::table('recyclable_posts')
    ->leftJoin('resources', 'resources.id', '=', 'recyclable_posts.resource_type')
      ->leftJoin('ecosansar_users', 'ecosansar_users.id', '=', 'recyclable_posts.user_id')
    ->select(
        'recyclable_posts.id',
        'recyclable_posts.sale_giveaway',
         'recyclable_posts.address',
        'recyclable_posts.created_at',
         'recyclable_posts.resource_img',
        'resources.resource_name',
        'ecosansar_users.name',
        DB::raw("'recyclable' as source")
    )
    ->where('recyclable_posts.user_id', $id)
    ->where('recyclable_posts.user_type', $utype)
    ->where('recyclable_posts.request_fulfilled', 0)
    ->where('recyclable_posts.active', 1);

// Second query: reusable_posts
$reusable = DB::table('reusable_posts')
    ->leftJoin('resources', 'resources.id', '=', 'reusable_posts.resource_type') // ✅ fixed join
     ->leftJoin('ecosansar_users', 'ecosansar_users.id', '=', 'reusable_posts.user_id')
    ->select(
        'reusable_posts.id',
        'reusable_posts.sale_giveaway',
        'reusable_posts.address',
        'reusable_posts.created_at',
        'reusable_posts.resource_img',
        'resources.resource_name',
        'ecosansar_users.name',
        DB::raw("'reusable' as source")
    )
    ->where('reusable_posts.user_id', $id)
    ->where('reusable_posts.user_type', $utype)
    ->where('reusable_posts.request_fulfilled', 0)
    ->where('reusable_posts.active', 1);


// Combine using unionAll
$combined = $recyclable->unionAll($reusable);

// Paginated query
$results = DB::table(DB::raw("({$combined->toSql()}) as combined"))
    ->mergeBindings($combined)
    ->orderBy('created_at', 'desc')
    ->offset($offset)
    ->limit($perPage)
    ->get();

// Count total records for pagination
$total = DB::table(DB::raw("({$combined->toSql()}) as combined"))
    ->mergeBindings($combined)
    ->count();



$uniqueListings = new LengthAwarePaginator(
    $results,
    $total,
    $perPage,
    $page,
    ['path' => request()->url(), 'query' => request()->query()]
);

// First query: recyclable_posts
$recyclable = DB::table('recyclable_posts')
    ->leftJoin('resources', 'resources.id', '=', 'recyclable_posts.resource_type')
      ->leftJoin('ecosansar_users', 'ecosansar_users.id', '=', 'recyclable_posts.user_id')
    ->select(
        'recyclable_posts.id',
        'recyclable_posts.sale_giveaway',
         'recyclable_posts.address',
        'recyclable_posts.created_at',
         'recyclable_posts.resource_img',
        'resources.resource_name',
        'ecosansar_users.name',
        DB::raw("'recyclable' as source")
    )
    ->where('recyclable_posts.user_id', $id)
    ->where('recyclable_posts.user_type', $utype)
     ->where('recyclable_posts.request_fulfilled', 0)
    ->where('recyclable_posts.active', 0);

// Second query: reusable_posts
$reusable = DB::table('reusable_posts')
    ->leftJoin('resources', 'resources.id', '=', 'reusable_posts.resource_type') // ✅ fixed join
     ->leftJoin('ecosansar_users', 'ecosansar_users.id', '=', 'reusable_posts.user_id')
    ->select(
        'reusable_posts.id',
        'reusable_posts.sale_giveaway',
        'reusable_posts.address',
        'reusable_posts.created_at',
        'reusable_posts.resource_img',
        'resources.resource_name',
        'ecosansar_users.name',
        DB::raw("'reusable' as source")
    )
    ->where('reusable_posts.user_id', $id)
    ->where('reusable_posts.user_type', $utype)
     ->where('reusable_posts.request_fulfilled', 0)
    ->where('reusable_posts.active', 0);

// Combine using unionAll
$combined = $recyclable->unionAll($reusable);

// Paginated query
$results = DB::table(DB::raw("({$combined->toSql()}) as combined"))
    ->mergeBindings($combined)
    ->orderBy('created_at', 'desc')
    ->offset($offset)
    ->limit($perPage)
    ->get();

// Count total records for pagination
$total = DB::table(DB::raw("({$combined->toSql()}) as combined"))
    ->mergeBindings($combined)
    ->count();



$deactiveuniqueListings = new LengthAwarePaginator(
    $results,
    $total,
    $perPage,
    $page,
    ['path' => request()->url(), 'query' => request()->query()]
);

//fetch fulfilled requests
// First query: recyclable_posts
$recyclable = DB::table('recyclable_posts')
    ->leftJoin('resources', 'resources.id', '=', 'recyclable_posts.resource_type')
      ->leftJoin('ecosansar_users', 'ecosansar_users.id', '=', 'recyclable_posts.user_id')
    ->select(
        'recyclable_posts.id',
        'recyclable_posts.sale_giveaway',
         'recyclable_posts.address',
        'recyclable_posts.created_at',
         'recyclable_posts.resource_img',
        'resources.resource_name',
        'ecosansar_users.name',
        DB::raw("'recyclable' as source")
    )
    ->where('recyclable_posts.user_id', $id)
    ->where('recyclable_posts.user_type', $utype)
     ->where('recyclable_posts.request_fulfilled', 1);


// Second query: reusable_posts
$reusable = DB::table('reusable_posts')
    ->leftJoin('resources', 'resources.id', '=', 'reusable_posts.resource_type') // ✅ fixed join
     ->leftJoin('ecosansar_users', 'ecosansar_users.id', '=', 'reusable_posts.user_id')
    ->select(
        'reusable_posts.id',
        'reusable_posts.sale_giveaway',
        'reusable_posts.address',
        'reusable_posts.created_at',
        'reusable_posts.resource_img',
        'resources.resource_name',
        'ecosansar_users.name',
        DB::raw("'reusable' as source")
    )
    ->where('reusable_posts.user_id', $id)
    ->where('reusable_posts.user_type', $utype)
     ->where('reusable_posts.request_fulfilled', 1);


// Combine using unionAll
$combined = $recyclable->unionAll($reusable);

// Paginated query
$results = DB::table(DB::raw("({$combined->toSql()}) as combined"))
    ->mergeBindings($combined)
    ->orderBy('created_at', 'desc')
    ->offset($offset)
    ->limit($perPage)
    ->get();

// Count total records for pagination
$total = DB::table(DB::raw("({$combined->toSql()}) as combined"))
    ->mergeBindings($combined)
    ->count();



$fulfilledListings = new LengthAwarePaginator(
    $results,
    $total,
    $perPage,
    $page,
    ['path' => request()->url(), 'query' => request()->query()]
);

        // $deactiveuniqueListings = RecyclablePost::with(['resource', 'weight'])
        //     ->select('recyclable_posts.*')
        //     ->where('recyclable_posts.user_id', $id)
        //     ->where('recyclable_posts.user_type', $utype)
        //     ->where('recyclable_posts.active', '=', 0)
        //      ->paginate(8);

      //  $enquiries = RecyclableEnquiry :: where('post_user_id', $id)->where('user_type',$user_type)->paginate(10);


    // First query from recyclable_enquiries
    $recyclable = DB::table('recyclable_enquiries')
        ->select('id', 'name', 'email', 'mobile', 'flag', 'message', 'loggedin_user_type', 'created_at', DB::raw("'recyclable' as source"))
        ->where('post_user_id', $id)
        ->where('user_type', $user_type);

    // Second query from reusable_enquiries
    $reusable = DB::table('reusable_enquiries')
        ->select('id', 'name', 'email', 'mobile', 'flag', 'message', 'loggedin_user_type', 'created_at', DB::raw("'reusable' as source"))
        ->where('post_user_id', $id)
        ->where('user_type', $user_type);

    // Combine using unionAll
    $query = $recyclable->unionAll($reusable);

    // Wrap the union query as a subquery to use paginate
    $enquiries = DB::table(DB::raw("({$query->toSql()}) as combined"))
        ->mergeBindings($query)
        ->orderBy('created_at', 'desc')
        ->paginate($perPage);

     // First query from recyclable_enquiries for own profile
    $recyclableown = DB::table('recyclable_enquiries')
     ->join('ecosansar_users', 'recyclable_enquiries.post_user_id', '=', 'ecosansar_users.id')
        ->select(
        'recyclable_enquiries.id',
        'recyclable_enquiries.name',
        'recyclable_enquiries.email',
        'recyclable_enquiries.mobile',
        'recyclable_enquiries.flag',
        'recyclable_enquiries.message',
        'recyclable_enquiries.loggedin_user_type',
        'recyclable_enquiries.created_at',
        'ecosansar_users.name as post_user_name',
         'ecosansar_users.mobile as post_mobile',
        DB::raw("'recyclable' as source")
    )
        ->where('recyclable_enquiries.login_user_id', $userid)
        ->where('recyclable_enquiries.loggedin_user_type', $user_type);

    // Second query from reusable_enquiries for own profile
    $reusableown = DB::table('reusable_enquiries')
       ->join('ecosansar_users', 'reusable_enquiries.post_user_id', '=', 'ecosansar_users.id')
    ->select(
        'reusable_enquiries.id',
        'reusable_enquiries.name',
        'reusable_enquiries.email',
        'reusable_enquiries.mobile',
        'reusable_enquiries.flag',
        'reusable_enquiries.message',
        'reusable_enquiries.loggedin_user_type',
        'reusable_enquiries.created_at',
        'ecosansar_users.name as post_user_name',
         'ecosansar_users.mobile as post_mobile',
        DB::raw("'reusable' as source")
    )
        ->where('reusable_enquiries.login_user_id', $id)
        ->where('reusable_enquiries.loggedin_user_type', $user_type);

    // Combine using unionAll for own profile
    $queryown = $recyclableown->unionAll($reusableown);

    // Wrap the union query as a subquery to use paginate for own profile
    $ownenquiries = DB::table(DB::raw("({$queryown->toSql()}) as combined"))
        ->mergeBindings($queryown)
        ->orderBy('created_at', 'desc')
        ->paginate($perPage);


// Get Recyclable Reviews
$recyclable = RecyclableReview::where('login_user_id', $userid)
    ->select('id', 'title', 'user_id', 'message', 'rating', 'login_user_id', 'created_at', DB::raw("'recyclable' as source"))
   ->toBase();

// Get Reusable Reviews
$reusable = ReusableReview::where('login_user_id', $userid)
    ->select('id', 'title', 'user_id', 'message', 'rating', 'login_user_id', 'created_at', DB::raw("'reusable' as source"))
   ->toBase();

// Merge both collections
$combined = $recyclable->unionAll($reusable);
  // Wrap the union query in a subquery and paginate
$reviewsgiven = DB::table(DB::raw("({$combined->toSql()}) as combined"))
    ->mergeBindings($combined)
    ->orderBy('created_at', 'desc')
    ->paginate($perPage);

        //$reviewsgiven = RecyclableReview::where('login_user_id',$userid)->paginate(10);
      // Convert to base query builders using ->toBase()
$recyclableQuery = RecyclableReview::select('id', 'user_id', 'message', 'rating', 'login_user_id', 'created_at', DB::raw("'recyclable' as source"))->where('user_id', $userid)->toBase();
$reusableQuery = ReusableReview::select('id', 'user_id', 'message', 'rating', 'login_user_id', 'created_at', DB::raw("'reusable' as source"))->where('user_id', $userid)->toBase();

// Perform unionAll
$combinedQuery = $recyclableQuery->unionAll($reusableQuery);

// Wrap the union query in a subquery and paginate
$reviewsrecieved = DB::table(DB::raw("({$combinedQuery->toSql()}) as combined"))
    ->mergeBindings($combinedQuery)
    ->orderBy('created_at', 'desc')
    ->paginate($perPage);


// Fetch both sets and tag them with a source
$recyclable = RecyclableReview::where('login_user_id', $userid)
    ->get()
    ->map(function ($item) {
        $item->source = 'recyclable';
        return $item;
    });

$reusable = ReusableReview::where('login_user_id', $userid)
    ->get()
    ->map(function ($item) {
        $item->source = 'reusable';
        return $item;
    });

// Merge both
$merged = $recyclable->merge($reusable);

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

        $url = route('profile_update', $id);
        return view('frontend/profile', compact('users', 'url', 'utype',   'uniqueListings','deactiveuniqueListings', 'enquiries', 'reviewsgiven', 'reviewsrecieved',
        'breadcrumbimage', 'fulfilledListings', 'ownenquiries'
          ));
    }
    public function profile_update(Request $req, $id)
    {

        $user =  EcosansarUsers::find($id);
        $user->name = $req->name;
        $user->mobile = $req->mobile;
        $user->address = $req->address;
        $user->email = $req->email;

        $user->save();
        Session::flash('success', 'Data updated successfully');
        return redirect()->back();
    }

      public function recyclablepostprofile($u_id)
    {

         // Retrieve the review_id from the query string
       $review_id = request()->query('review_id');
            $user_id = session()->get('user_id');
        $conpost = RecyclablePost::where('user_id', $u_id)->first();

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
             $redirectUrl = route('recyclablepostprofile', ['id' => $u_id]) . ($review_id ? '?review_id=' . $review_id : '');
             session()->put('redirect_askrev', $redirectUrl);

            return redirect()->route('consumer_login');
        }


 \DB::enableQueryLog();
    // Check for existing connection (BusinessEnquiry)
$busrev = RecyclableEnquiry::where('login_user_id', $user_id)
    ->where('post_user_id', $u_id)
->first();



// Check for a review request only if a review_id is provided
$reviewRequest = null;
if ($review_id) {
    $reviewRequest = RecyclableAskReviews::where('id', $review_id)
        ->where('user_id', $user_id)
        ->first();
}

// Validate access
if (!$busrev || ($review_id && !$reviewRequest)) {
    Session::flash('warning', 'You have not connected with this user. Please connect first then give review');
    return redirect('/');
}
  //Retrieve the review request based only on user_id
    $reviewRequest = RecyclableAskReviews::where('id', $review_id)->where('user_id', $user_id)->first();


    //Check if the review request has already been submitted (status is 'read')
    if ($reviewRequest && $reviewRequest->status === 'read') {
        Session::flash('success', 'You have already given a review.');
        return redirect('/');
    }



        $conlistreviews = RecyclableReview::where('post_id', $post_id)->where('user_id', $u_id)->get();
        $users = EcosansarUsers::where('id', $u_id)->first();

        return view('frontend/recyclablepostprofile', compact('users', 'conlistreviews', 'u_id', 'post_id'));
    }

    public function about()
    {
          // user activity start
        $userid = session()->get('user_id');
        $breadcrumbimage = BreadcrumImage::latest()->first();
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on about page';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        return view('frontend/about', compact('breadcrumbimage'));
    }
     public function privacypolicy()
    {
          // user activity start
        $userid = session()->get('user_id');
        $breadcrumbimage = BreadcrumImage::latest()->first();
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on privacypolicy page';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        return view('frontend/privacypolicy', compact('breadcrumbimage'));
    }

    public function blog()
    {
        // Fetch all blogs where active = 1
        // $blogs = Blog::where('active', 1)->orderBy('id','desc')->get();
          $breadcrumbimage = BreadcrumImage::latest()->first();
        $blogs = Blog::where('active', 1)
        ->orderBy('id', 'desc')
       ->paginate(12)
        ->through(function ($blog) {
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

        return view('frontend.blog', compact('blogs', 'categories', 'tags', 'breadcrumbimage'));
    }

    public function blog_detail($slug){

     // Fetch the blog by ID
       $breadcrumbimage = BreadcrumImage::latest()->first();
    $blog = Blog::where('slug',$slug)->first();

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
       $categoriesall = DB::table('blog_categories')
    ->select('blog_categories.*', DB::raw('(SELECT COUNT(*) FROM blogs WHERE FIND_IN_SET(blog_categories.id, blogs.category) AND blogs.active = 1 AND blogs.deleted_at IS NULL) as blogs_count'))
    ->get();
        $tagsall = BlogTag::all();
        $latestBlogs = Blog::where('active', 1) // Only active blogs
    ->whereNull('deleted_at') // Exclude soft-deleted blogs
    ->orderBy('created_at', 'desc') // Sort by latest
    ->limit(5) // Limit the number of blogs
    ->get();
    // Fetch comments associated with this blog post
    $comments = Comment::with('replies')->where('blog_id', $blog->id)->where('active',1)->get();
  // Generate CAPTCHA
        $captcha = $this->generateCaptcha();
         // Store CAPTCHA value in session
        session(['captcha' => $captcha]);
    // Return the view with the blog data
    return view('frontend.blog-detail', compact('blog','categories','tags','categoriesall','tagsall','userid','comments','captcha', 'latestBlogs', 'breadcrumbimage'));
    }
       public function categoryBlogs($slug)
    {
        // Fetch the category by ID
        $category = BlogCategory::where('bc_slug',$slug)->first();
          $breadcrumbimage = BreadcrumImage::latest()->first();
        // Fetch blogs related to the category
        $blogs = Blog::where('active', 1)
            ->where(function ($query) use ($category) {
                $query->where('category', $category->id) // Check for exact match
                      ->orWhere('category', 'LIKE', "%,$category->id,%") // Match in the middle
                      ->orWhere('category', 'LIKE', "$category->id,%")   // Match at the start
                      ->orWhere('category', 'LIKE', "%,$category->id");  // Match at the end
            })
             ->orderBy('id', 'DESC') // Fetch in descending order
            ->paginate(3);
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
        return view('frontend.blog', compact('blogs', 'categories', 'tags', 'category', 'breadcrumbimage'));
    }

    public function tagBlogs($slug)
    {
        // Fetch the tag by ID
        $tag = BlogTag::where('bt_slug',$slug)->first();
      $breadcrumbimage = BreadcrumImage::latest()->first();
        // Fetch blogs related to the tag
        $blogs = Blog::where('active', 1)
        ->where(function ($query) use ($tag) {
            $query->where('tag', $tag->id) // Check for exact match
                  ->orWhere('tag', 'LIKE', "%,$tag->id,%") // Match in the middle
                  ->orWhere('tag', 'LIKE', "$tag->id,%")   // Match at the start
                  ->orWhere('tag', 'LIKE', "%,$tag->id");  // Match at the end
        })
         ->orderBy('id', 'DESC') // Fetch in descending order
       ->paginate(3);
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
        return view('frontend/blog', compact('blogs', 'categories', 'tags', 'tag', 'breadcrumbimage'));
    }

    public function faq()
    {

      // user activity start
        $userid = session()->get('user_id');
          $breadcrumbimage = BreadcrumImage::latest()->first();
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
        return view('frontend/faq', compact('faqs','categories', 'breadcrumbimage'));
    }

    public function howitsworks()
    {
       // user activity start
        $userid = session()->get('user_id');
        $breadcrumbimage = BreadcrumImage::latest()->first();
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on how it works page';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end
        $howitwork = About::get();
        return view('frontend/howitsworks',compact('howitwork', 'breadcrumbimage'));
    }
    public function workwithus()
    {
       // user activity start
        $userid = session()->get('user_id');
          $breadcrumbimage = BreadcrumImage::latest()->first();
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on Work with us page';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }

        return view('frontend/workwithus',compact('breadcrumbimage'));
    }
     public function service()
    {
       // user activity start
        $userid = session()->get('user_id');
          $breadcrumbimage = BreadcrumImage::latest()->first();
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on service page';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end
        $service = Service::get();
        return view('frontend/service',compact('service', 'breadcrumbimage'));
    }
    public function repairmap(){
         $userid = session()->get('user_id');
         $breadcrumbimage = BreadcrumImage::latest()->first();

        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on Repair map page';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        return view('frontend.repairmap', compact('breadcrumbimage'));
    }
     public function findcollectionagent(){
         $userid = session()->get('user_id');
         $breadcrumbimage = BreadcrumImage::latest()->first();

        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on Find Collection Agent page';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        return view('frontend.findcollectionagent', compact('breadcrumbimage'));
    }
   public function searchPincode(Request $request)
{
    $request->validate([
        'pincode' => 'required'
    ]);

    $users = DB::table('ecosansar_users as eu')
        ->leftJoin('recyclable_reviews as rr', 'eu.id', '=', 'rr.user_id')
        ->where('eu.user_type', 'sab')
        ->where('eu.pincode', $request->pincode)
        ->select(
            'eu.id',
            'eu.name',
            'eu.address',
            'eu.mobile',
            DB::raw('ROUND(AVG(rr.rating), 1) as avg_rating') // e.g. 4.3 stars
        )
        ->groupBy('eu.id', 'eu.name', 'eu.address', 'eu.mobile')
       ->paginate(10);

    return response()->json($users);
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
          $breadcrumbimage = BreadcrumImage::latest()->first();
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
        $contact = Contact::first();

        // Store CAPTCHA value in session
        session(['captcha' => $captcha]);
        return view('frontend/contact',compact('captcha','contact', 'breadcrumbimage'));
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
            // 'email' => 'ecosansar@yahoo.com',
            'email' => 'support@ecosansar.com',
            'useremail' => $req->email,
            'phone' => $req->phone_no,
            'sub' => $req->subject,
            'msg' => $req->message,
            ];


            $data["title"] =  "New contact from ". $req->name;

            // Render the email body using the Blade view
            $body = view('frontend.mail.contactmail', $data)->render();

            // Try sending the email
            try {
                // Call your mailer service to send the email
                $response = $this->mailerService->sendEmail($data['email'], $data['title'], $body, $data);

                Session::flash('success', 'Contact Details Sent Successfully');
                return redirect()->back();
            } catch (\Exception $e) {
                // If there is any exception, redirect with failure message
                return redirect()->back()->with('error', 'Failed to send email. Please try again later.');
            }

    }
      public function repair_contact_store(Request $req){
           $userid = session()->get('user_id');
           $user = EcosansarUsers::where('id',$userid)->first();
       if($req->type_of_service != 'Other'){
        $req->validate([
            'name' => 'required',
            'phone_no' => 'required',
            'location' => 'required',
            'pincode' => 'required',
            'type_of_service' => 'required',

        ]);
       } else {
            $req->validate([
            'name' => 'required',
            'phone_no' => 'required',
            'location' => 'required',
            'pincode' => 'required',

            'other_service' => 'required'
        ]);
       }
        $contact = new RepairContact;
        $contact->user_id = $userid;
        $contact->login_contact = $user->mobile;
        $contact->name = $req->name;
        $contact->phone_no = $req->phone_no;
        $contact->location = $req->location;
         $contact->pincode = $req->pincode;
         if($req->type_of_service != 'Other'){
            $contact->type_of_service = $req->type_of_service;
         } else {
            $contact->other_service = $req->other_service;
         }
        $contact->save();
       $data = [

            'name' =>  $req->name,
            // 'email' => 'ecosansar@yahoo.com',
            'email' => 'userfortesting456@gmail.com',

            'phone' => $req->phone_no,
            'location' => $req->location,
            'pincode' => $req->pincode,
            ];


            $data["title"] =  "New contact from repair map form";

            // Render the email body using the Blade view
            $body = view('frontend.mail.repairmapmail', $data)->render();

            // Try sending the email
            try {
                // Call your mailer service to send the email
                $response = $this->mailerService->sendEmail($data['email'], $data['title'], $body, $data);

                Session::flash('success', 'Contact Details Sent Successfully');
                return redirect()->back();
            } catch (\Exception $e) {
                // If there is any exception, redirect with failure message
                return redirect()->back()->with('error', 'Failed to send email. Please try again later.');
            }
    }
    public function user_register()
    {
         // Generate CAPTCHA
        $captcha = $this->generateCaptcha();

        // Store CAPTCHA value in session
        session(['captcha' => $captcha]);
        return view('frontend/auth/register',compact('captcha'));
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

    public function recyclable_choose_one() {
        $breadcrumbimage = BreadcrumImage::latest()->first();

        return view('frontend/userdetails/displaypostoption', compact('breadcrumbimage'));
    }
    public function reusable_choose_one() {
        $breadcrumbimage = BreadcrumImage::latest()->first();
        return view('frontend/userdetails/displayreusablepostoption', compact('breadcrumbimage'));
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
    public function getLatLongFromPincode($pincode)
{
    $apiKey = "AIzaSyCPfLLFN-fT9hed5CBwFZFKBOpoB_KChL0&libraries=places"; // Store your Google API key in .env file
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$pincode}&key={$apiKey}";

    $response = Http::get($url);
    $data = $response->json();

    if (isset($data['results'][0]['geometry']['location'])) {
        $latitude = $data['results'][0]['geometry']['location']['lat'];
        $longitude = $data['results'][0]['geometry']['location']['lng'];
        return [$latitude, $longitude];
    } else {
        return [null, null]; // If the API doesn't return results
    }
}
 public function consumer_save(Request $req)
    {
       // Extend Validator with 'valid_captcha'
        Validator::extend('valid_captcha', function ($attribute, $value, $parameters, $validator) {
            // Fetch the captcha value stored in the session
            $sessionCaptcha = session()->get('captcha');

            // Validate if the user input matches the session captcha
            return $value === $sessionCaptcha;
        });


        $rules = [
            'type_of_user' => 'required',
            'name' => 'required',
            'pincode' => 'required|min:6|max:6',
            'address' => 'required',
            'mobile' => 'required|unique:ecosansar_users,mobile',
            'terms' => 'required',
            'captcha' => 'required|valid_captcha',

        ];


        if ($req->type_of_user == 'consumer') {
            $rules['type_of_residences'] = 'required';
        }

        if ($req->type_of_user == 'business') {
            $rules['email'] = 'required';
        }
    // Define custom error messages

        $messages = [
            'mobile.required' => 'The mobile number is required.',
            'mobile.unique' => 'This number is in use',
            'captcha.required' => 'Captcha required',
            'captcha.valid_captcha' => 'Invalid captcha',
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
                   // $errors['mobile'][0] .= ' but deactivated. <a href="https://ecosansar.com/user_activate/' . $user->id . '">Click to activate</a>';
                   $errors['mobile'][0] .= ' but deactivated. <a href="' . url('user_activate/' . $user->id) . '">Click to activate</a>';

                } elseif ($user->is_verify == 0) {
                    //$errors['mobile'][0] .= ' but not verified. <a href="https://ecosansar.com/loginverify_otp/' . $user->id . '">Click to verify</a>';
                    $errors['mobile'][0] .= ' but not verified. <a href="' . url('loginverify_otp', ['id' => $user->id]) . '">Click to verify</a>';

                } else {
                   // $errors['mobile'][0] .= ' .<a href="https://ecosansar.com/consumer_login"> Click to login</a>';
                   $errors['mobile'][0] .= '. <a href="' . url('consumer_login') . '">Click to login</a>';

                }
            }

            return response()->json(['errors' => $errors], 422);
        }


        // echo "<pre>";
        //     print_r($req->all());
        //     die;


       // Fetch lat/long based on pincode
    list($latitude, $longitude) = $this->getLatLongFromPincode($req->pincode);


        $user = new EcosansarUsers;
        $user->user_type = $req->type_of_user;
        $user->name = $req->name;
        $user->mobile = $req->mobile;
        $user->address = $req->address;
        $user->pincode = $req->pincode;
         $user->latitude = $latitude;
    $user->longitude = $longitude;
        $user->type_of_residences = $req->type_of_residences;
        $user->email = $req->email;
        //  $user->password = Hash::make($req->password);

        $user->is_checked = 1;




     // Determine the prefix and increment the unique ID
if ($req->type_of_user == 'consumer') {
    $prefix = 'CTB';

    // Fetch the latest unique_id with prefix 'CR'
    $lastConsumer = EcosansarUsers::where('unique_id', 'like', $prefix . '-%')
                                    ->orderBy('id', 'desc')
                                    ->first();

    if ($lastConsumer) {
        // Extract the numeric part from the unique_id
        $lastNumber = (int) str_replace($prefix . '-', '', $lastConsumer->unique_id);
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1; // Start from 1 if no existing consumer
    }

    $user->unique_id = $prefix . '-' . $newNumber;
} elseif ($req->type_of_user == 'sab') {
    $prefix = 'RC';

    // Fetch the latest unique_id with prefix 'RC'
    $lastSab = EcosansarUsers::where('unique_id', 'like', $prefix . '-%')
                              ->orderBy('id', 'desc')
                              ->first();

    if ($lastSab) {
        // Extract the numeric part from the unique_id
        $lastNumber = (int) str_replace($prefix . '-', '', $lastSab->unique_id);
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1; // Start from 1 if no existing sab
    }

    $user->unique_id = $prefix . '-' . $newNumber;
}else{
    $prefix = 'CP';

    // Fetch the latest unique_id with prefix 'RC'
    $lastCorp = EcosansarUsers::where('unique_id', 'like', $prefix . '-%')
                              ->orderBy('id', 'desc')
                              ->first();

    if ($lastCorp) {
        // Extract the numeric part from the unique_id
        $lastNumber = (int) str_replace($prefix . '-', '', $lastCorp->unique_id);
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1; // Start from 1 if no existing sab
    }

    $user->unique_id = $prefix . '-' . $newNumber;
}

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
           'otp' => 'required|array|size:6',
            'otp.*' => 'required|digits:1',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
          $otp = implode('', $request->otp); // Convert array to a single OTP string
//dd($otp);

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
        //if ($user && $user->is_checked && $otp == $user->otp && now()->lessThanOrEqualTo($user->otp_expires_at) && $user->is_verify == 1 && $user->is_delete == 0 && $user->status == 1) {
        if ($user && $user->is_checked && $otp == $user->otp && now()->lessThanOrEqualTo($user->otp_expires_at) && $user->is_verify == 1 && $user->is_delete == 0 ) {

            // Authentication successful
            session()->put('user_id', $user->id);
            session()->put('user_type', $user->user_type);
            // echo $request->has('remember');die;
            Log::info('Session Data:', session()->all());



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

             // Log session data before redirect checks
        Log::info('Session data before redirect', session()->all());

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

        // Check for WhatsApp redirect
        if (session()->has('redirect_wp')) {
            $redirect_wpto = session()->pull('redirect_wp');
            Log::info('Redirecting to WhatsApp share URL', ['redirect_url' => $redirect_wpto]);
            return redirect($redirect_wpto);
        }
     $redirectTo = $request->input('redirect') ?? route('profile', ['id' => $user->id]);
      // Flash only if it's a direct login (i.e., no custom redirect)
  Session::flash('success', 'Logged in Successfully');
return redirect()->to($redirectTo); // ✅ Ensures a valid response



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
            $data["title"] =  "Welcome to The ZeroWaste Community Tool";

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
            $data["title"] =  "Welcome to The ZeroWaste Community Tool";

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

    public function recyclable_add_post()
    {
        $breadcrumbimage = BreadcrumImage::latest()->first();

        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $users = EcosansarUsers::where('id', $user_id)->first();
        $resources = Resource::get();
        $weights = Weight::orderByRaw('CAST(min_weight AS UNSIGNED) ASC')->get();

       // dd($weights->pluck('min_weight'));

          // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on Recyclable add post';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }

        return view('frontend/userdetails/recyclablepostadd', compact('user_type', 'users', 'user_id', 'resources', 'weights', 'breadcrumbimage'));
    }
//       public function recyclable_post_save(Request $request)
//     {

//         // echo "<pre>";
//         // print_r($request->all());die;

//         $user_id = session()->get('user_id');
//         $user_type = session()->get('user_type');
//         $users = EcosansarUsers::where('id', $user_id)->first();
//         if ($request->sale_giveaway == 'Buy') {
//             $request->validate([
//                 'pincode' => 'required|exists:pincodes,pincode',
//                 'address' => 'required',
//                 'sale_giveaway' => 'required',
//                 'quantity' => 'required',
//                 'resource_type' => 'required',
//                 'resource_img' => 'mimes:jpg,jpeg,png,webp', // Adjust mime types and max size as needed
//     ]);
//         } else {
//             $request->validate([
//                 'pincode' => 'required|exists:pincodes,pincode',
//                 'address' => 'required',
//                 'sale_giveaway' => 'required',
//                 'quantity' => 'required',

//                 'resource_type' => 'required',
//                 'resource_img' => 'required|mimes:jpg,jpeg,png,webp', // Adjust mime types and max size as needed
//     ]);

//         }
//         $user = new RecyclablePost();
//         $user->user_id = $user_id;
//           $user->user_type = $user_type;
//         $user->name = $users->name;
//         $user->email = $users->email;
//         $user->mobile = $users->mobile;
//         $user->pincode = $request->pincode;
//         $user->address = $request->address;
//         $user->sale_giveaway = $request->sale_giveaway;
//         $user->quantity = $request->quantity;
//         $user->clean_unclean = $request->clean_unclean;
//         $user->packaged = $request->packaged;
//           $user->latitude = $request->latitude;
//         $user->longitude = $request->longitude;
//         $user->resource_price = $request->resource_price;
//         $user->description = $request->description;


//       // Function to resize an image using the GD library
// function resizeImage($source, $width, $height)
// {
//     // Get the original image dimensions and type
//     list($originalWidth, $originalHeight, $type) = getimagesize($source);

//     // Calculate the new dimensions while maintaining the aspect ratio
//     $ratio = $originalWidth / $originalHeight;
//     if ($width / $height > $ratio) {
//         $width = $height * $ratio;
//     } else {
//         $height = $width / $ratio;
//     }

//     // Create a new blank image with the calculated dimensions
//     $newImage = imagecreatetruecolor($width, $height);

//     // Load the source image based on its type
//     switch ($type) {
//         case IMAGETYPE_JPEG:
//             $sourceImage = imagecreatefromjpeg($source);
//             break;
//         case IMAGETYPE_PNG:
//             $sourceImage = imagecreatefrompng($source);
//             break;
//         case IMAGETYPE_GIF:
//             $sourceImage = imagecreatefromgif($source);
//             break;
//         case IMAGETYPE_WEBP:
//             $sourceImage = imagecreatefromwebp($source);
//             break;
//         default:
//             throw new Exception('Unsupported image type');
//     }

//     // Resize the image
//     imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);

//     // Start output buffering to capture the image content
//     ob_start();
//     switch ($type) {
//         case IMAGETYPE_JPEG:
//             imagejpeg($newImage);
//             break;
//         case IMAGETYPE_PNG:
//             imagepng($newImage);
//             break;
//         case IMAGETYPE_GIF:
//             imagegif($newImage);
//             break;
//         case IMAGETYPE_WEBP:
//             imagewebp($newImage);
//             break;
//     }
//     $imageContent = ob_get_clean(); // Get the image content from the buffer

//     // Free up memory
//     imagedestroy($newImage);
//     imagedestroy($sourceImage);

//     return $imageContent; // Return the resized image content as a binary string
// }



//             $user->resource_type = $request->resource_type;


// // Upload file to S3
//     if ($request->hasFile('resource_img')) {
//         $file = $request->file('resource_img');
//         $filePath = 'Recyclableposts';
//         $fileName = $user_id . '_' . $user->id . '_' . $request->resource_type  .'.'. $file->getClientOriginalExtension();

//           $fileTempPath = $file->getRealPath(); // Get the temporary file path

//     // Set desired dimensions for resizing (e.g., 800px wide)
//     $newWidth = 800;
//     $newHeight = 600; // You can adjust this based on your aspect ratio logic

//     // Use the resizeImage function to get the resized image content
//     $resizedImageContent = resizeImage($fileTempPath, $newWidth, $newHeight);

//     // Upload to S3
//     Storage::disk('s3')->put($filePath . '/' . $fileName, $resizedImageContent);
// $user->resource_img = $fileName;
//     }
//  $user->save();


//             // user activity start
//         $userid = session()->get('user_id');
//         if ($userid){
//             $userActivity = new UserActivityLog();
//             $userActivity->user_id = $userid;
//             $userActivity->activity = 'Recyclable post add';
//             $userActivity->url = request()->fullUrl();   // Get the full URL of the request
//             $userActivity->ip_address = request()->ip();
//             $userActivity->save();
//         }
//         // user activity end

//         if ($request->action === 'post_another') {
//       Session::flash('success', 'Data saved successfully. You can post another.');
//       return redirect()->back();
//  } else {
//         return redirect()->route('listings')->with('success', 'Post Added Successfully. You can view in my profile page');
//     }

//     }


 public function recyclable_post_save(Request $request)
    {

        // echo "<pre>";
        // print_r($request->all());die;

        $user_id = session()->get('user_id');
        $user_type = session()->get('user_type');
        $users = EcosansarUsers::where('id', $user_id)->first();
        if ($request->sale_giveaway == 'Buy') {
            $request->validate([
                'pincode' => 'required|exists:pincodes,pincode',
                'address' => 'required',
                'sale_giveaway' => 'required',
                'quantity' => 'required',
                'resource_type' => 'required',
                'resource_img' => 'mimes:jpg,jpeg,png,webp', // Adjust mime types and max size as needed
    ]);
        } else {
            $request->validate([
                'pincode' => 'required|exists:pincodes,pincode',
                'address' => 'required',
                'sale_giveaway' => 'required',
                'quantity' => 'required',

                'resource_type' => 'required',
                'resource_img' => 'required|mimes:jpg,jpeg,png,webp', // Adjust mime types and max size as needed
    ]);

        }
        $user = new RecyclablePost();
        $user->user_id = $user_id;
          $user->user_type = $user_type;
        $user->name = $users->name;
        $user->email = $users->email;
        $user->mobile = $users->mobile;
        $user->pincode = $request->pincode;
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
    list($originalWidth, $originalHeight, $type) = getimagesize($source);

    $newImage = imagecreatetruecolor($width, $height);

    switch ($type) {
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($source);
            break;
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($source);
            // Preserve transparency for PNG
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
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

    // This now forces the image to resize to EXACT width/height
    imagecopyresampled(
        $newImage, $sourceImage,
        0, 0, 0, 0,
        $width, $height,
        $originalWidth, $originalHeight
    );

    ob_start();
    switch ($type) {
        case IMAGETYPE_JPEG:
            imagejpeg($newImage, null, 80); // compress JPEG
            break;
        case IMAGETYPE_PNG:
            imagepng($newImage, null, 6); // compress PNG
            break;
        case IMAGETYPE_GIF:
            imagegif($newImage);
            break;
        case IMAGETYPE_WEBP:
            imagewebp($newImage, null, 80); // compress WebP
            break;
    }
    $imageContent = ob_get_clean();

    imagedestroy($newImage);
    imagedestroy($sourceImage);

    return $imageContent;
}




            $user->resource_type = $request->resource_type;


// Upload file to S3
   if ($request->hasFile('resource_img')) {
    $file = $request->file('resource_img');
    $fileName = $user_id . '_' . $user->id . '_' . $request->resource_type  .'.'. $file->getClientOriginalExtension();

    $fileTempPath = $file->getRealPath(); // Get the temporary file path

    // Resize for main (800x600)
    $mainImageContent = resizeImage($fileTempPath, 800, 600);
    Storage::disk('s3')->put('Recyclableposts/' . $fileName, $mainImageContent);

    // Resize for thumbnail (265x265)
    $thumbImageContent = resizeImage($fileTempPath, 265, 265);
    Storage::disk('s3')->put('Recyclableposts/265x265/' . $fileName, $thumbImageContent);

    // Save filename in DB
    $user->resource_img = $fileName;
}

 $user->save();


            // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Recyclable post add';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

        if ($request->action === 'post_another') {
      Session::flash('success', 'Data saved successfully. You can post another.');
      return redirect()->back();
 } else {
        return redirect()->route('listings')->with('success', 'Post Added Successfully. You can view in my profile page');
    }

    }


public function listings()
{
    $user_id = session()->get('user_id');
    $user_type = session()->get('user_type');
    $breadcrumbimage = BreadcrumImage::latest()->first();

    $query = RecyclablePost::with(['resource', 'weight', 'user'])
   // ->where('recyclable_posts.user_id', '!=', $user_id)
     ->where('recyclable_posts.request_fulfilled', 0)
    ->where('recyclable_posts.active', 1)
    ->leftJoin(
        DB::raw('(SELECT user_id, AVG(rating) as average_rating FROM recyclable_reviews GROUP BY user_id) as user_ratings'),
        'recyclable_posts.user_id',  // ✅ Join on recyclable_posts.user_id
        '=',
        'user_ratings.user_id'
    )
    ->select('recyclable_posts.*', 'user_ratings.average_rating');

    $posts = $query->orderBy('id','desc')->paginate(20);


    $res = Resource::get();

    $weight = Weight::orderByRaw("
    CASE
        WHEN min_measure = 'kg' THEN 1
        WHEN min_measure = 'ton' THEN 2
        WHEN min_measure = 'piece' THEN 3
        ELSE 4
    END ASC,
    CAST(min_weight AS UNSIGNED) ASC
")->get();

           // user activity start
        $userid = session()->get('user_id');
        if ($userid){
            $userActivity = new UserActivityLog();
            $userActivity->user_id = $userid;
            $userActivity->activity = 'Clicked on Recyclable Browse listings';
            $userActivity->url = request()->fullUrl();   // Get the full URL of the request
            $userActivity->ip_address = request()->ip();
            $userActivity->save();
        }
        // user activity end

    return view('frontend/listings/listingslist', compact('res', 'weight', 'posts', 'user_type', 'user_id', 'breadcrumbimage'));
}


// with accesslevel and without nearby pincode search
// public function recyclable_post_filter(Request $request) {
//     $user_id = session()->get('user_id');
//      $user_type = session()->get('user_type');

//     // First Query: Exclude user and check active status
//     $query = RecyclablePost::with(['resource', 'weight', 'user'])
//       // ->where('recyclable_posts.user_id', '!=', $user_id)
//         ->where('recyclable_posts.request_fulfilled', 0)
//     ->where('recyclable_posts.active', 1)
//     ->leftJoin(
//         DB::raw('(SELECT user_id, AVG(rating) as average_rating FROM recyclable_reviews GROUP BY user_id) as user_ratings'),
//         'recyclable_posts.user_id',  // ✅ Join on recyclable_posts.user_id
//         '=',
//         'user_ratings.user_id'
//     )
//     ->select('recyclable_posts.*', 'user_ratings.average_rating');

//   // Apply Access Level Logic
//     // if ($user_type === 'consumer') {
//     //     $query->where(function ($q) {
//     //         $q->where('user_type', 'consumer')
//     //           ->orWhere('user_type', 'sab')
//     //           ->orWhere(function ($subQuery) {
//     //               $subQuery->where('user_type', 'business')->where('sale_giveaway', '=', 'Buy');
//     //           });
//     //     });
//     // } elseif ($user_type === 'sab') {
//     //     $query->where(function ($q) {
//     //         $q->where(function ($subQuery) {
//     //             $subQuery->where('user_type', 'consumer')->where('sale_giveaway', '!=', 'Buy');
//     //         })
//     //         ->orWhere('user_type', 'sab')
//     //         ->orWhere(function ($subQuery) {
//     //             $subQuery->where('user_type', 'business')->where('sale_giveaway', '=', 'Buy');
//     //         });
//     //     });
//     // } elseif ($user_type === 'business') {
//     //     $query->where(function ($q) {
//     //         $q->where(function ($subQuery) {
//     //             $subQuery->where('user_type', 'sab')->where('sale_giveaway', '!=', 'Buy');
//     //         })
//     //         ->orWhere('user_type', 'business');
//     //     });
//     // }

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

//         if ($request->has('weight') && !empty($request->weight)) {
//     $weights = is_array($request->weight) ? $request->weight : [$request->weight];
//     $q->orWhereIn('quantity', $weights);
// }


//         // Address Filter (Partial Match)
//         if ($request->has('pincode') && !empty($request->pincode)) {
//             $q->orWhere('pincode', 'LIKE', '%' . $request->pincode . '%');
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
//         $imagePath = !empty($post->resource_img) ? 'Recyclableposts/' . $post->resource_img : null;
//         $post->image_url = $imagePath && Storage::disk('s3')->exists($imagePath)
//             ? Storage::disk('s3')->url($imagePath)
//             : asset('frontend/assets/img/ecosansar.png');
//         return $post;
//     });



//     return response()->json([
//         'posts' => $posts,

//     ]);
// }

public function recyclable_post_filter(Request $request)
{
    $user_id = session()->get('user_id');
    $user_type = session()->get('user_type');

    // Get the user's latitude and longitude from pincode
    $user_pincode = $request->input('pincode');
    list($user_latitude, $user_longitude) = $this->getLatLongFromPincode($user_pincode);

    // Base query
    $query = RecyclablePost::with(['resource', 'weight', 'user'])
        ->leftJoin(
            DB::raw('(SELECT user_id, AVG(rating) as average_rating FROM recyclable_reviews GROUP BY user_id) as user_ratings'),
            'recyclable_posts.user_id',
            '=',
            'user_ratings.user_id'
        );

    // Select columns with distance if lat/long exists
    if ($user_latitude && $user_longitude) {
        $query->selectRaw('recyclable_posts.*, user_ratings.average_rating,
            ROUND(6371 * acos(
                cos(radians(?)) *
                cos(radians(recyclable_posts.latitude)) *
                cos(radians(recyclable_posts.longitude) - radians(?)) +
                sin(radians(?)) *
                sin(radians(recyclable_posts.latitude))
            ), 2) AS distance', [
                $user_latitude,
                $user_longitude,
                $user_latitude
            ]);
    } else {
        $query->select('recyclable_posts.*', 'user_ratings.average_rating');
    }

    // Apply base filters
    $query->where('recyclable_posts.request_fulfilled', 0)
          ->where('recyclable_posts.active', 1);

    // Flexible filters
    $query->where(function ($q) use ($request) {
        if ($request->has('resource') && !empty($request->resource)) {
            $q->whereIn('resource_type', $request->resource);
        }

        if ($request->has('sale_giveaway') && !empty($request->sale_giveaway)) {
            $q->orWhere('sale_giveaway', $request->sale_giveaway);
        }

        if ($request->has('weight') && !empty($request->weight)) {
            $weights = is_array($request->weight) ? $request->weight : [$request->weight];
            $q->orWhereIn('quantity', $weights);
        }

        if ($request->has('user_type') && !empty($request->user_type)) {
            $q->orWhere('user_type', $request->user_type);
        }
    });

    // Order by distance if available, else fallback
    if ($user_latitude && $user_longitude) {
        $query->orderBy('distance', 'asc');
    } else {
        $query->orderBy('created_at', 'desc');
    }

    // Map image URLs
    $posts = $query->get()->map(function ($post) {
        $imagePath = !empty($post->resource_img) ? 'Recyclableposts/' . $post->resource_img : null;
        $post->image_url = $imagePath && Storage::disk('s3')->exists($imagePath)
            ? Storage::disk('s3')->url($imagePath)
            : asset('frontend/assets/img/ecosansar.png');
        return $post;
    });

    return response()->json(['posts' => $posts]);
}





public function recyclable_post_sort(Request $request)
{
    $user_id = session()->get('user_id');
    $user_type = session()->get('user_type');

    $query = RecyclablePost::with(['resource', 'weight', 'user'])
    //   ->where('recyclable_posts.user_id', '!=', $user_id)
        ->where('recyclable_posts.request_fulfilled', 0)
    ->where('recyclable_posts.active', 1)
    ->leftJoin(
        DB::raw('(SELECT user_id, AVG(rating) as average_rating FROM recyclable_reviews GROUP BY user_id) as user_ratings'),
        'recyclable_posts.user_id',  // ✅ Join on recyclable_posts.user_id
        '=',
        'user_ratings.user_id'
    )
    //->join('ecosansar_users', 'ecosansar_users.id', '=', 'recyclable_posts.user_id')
    ->select('recyclable_posts.*', 'user_ratings.average_rating');

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
        $query->select('recyclable_posts.*', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure', 'user_ratings.average_rating')
            ->join('weights', 'recyclable_posts.quantity', '=', 'weights.id')
            ->orderByRaw('CAST(weights.min_weight AS SIGNED) ASC');
        break;

    case '4': // Largest Quantity
        $query->select('recyclable_posts.*', 'weights.min_weight', 'weights.min_measure', 'weights.max_weight', 'weights.max_measure', 'user_ratings.average_rating')
            ->join('weights', 'recyclable_posts.quantity', '=', 'weights.id')
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
        $imagePath = !empty($post->resource_img) ? 'Recyclableposts/' . $post->resource_img : null;
        $post->image_url = $imagePath && Storage::disk('s3')->exists($imagePath)
            ? Storage::disk('s3')->url($imagePath)
            : asset('frontend/assets/img/ecosansar.png');
        return $post;
    });

    return response()->json($posts);
}

public function getPincodes() {
        $pincodes = Pincode::pluck('pincode');
        return response()->json($pincodes);
    }



    public function recyclable_listing_details($id)
    {
        // Check if the user is logged in
        $breadcrumbimage = BreadcrumImage::latest()->first();

         $user_id = session()->get('user_id');
        $conpost = RecyclablePost::with(['resource', 'weight'])->where('id', $id)->first();
        $post_id = $conpost->id;
        $u_id = $conpost->user_id;
        $user_type = session()->get('user_type');
        if (null === $user_id || $user_id === '') {
            // User is not logged in, redirect to the login page
            session()->put('redirect_to_list', route('recyclable_listing_details', $id));
            session()->put('redirect_wp', route('recyclable_listing_details', $id));
            return redirect()->route('consumer_login');
        }
        // Fetch the user's role from the database
        $user = DB::table('ecosansar_users')->where('id', $user_id)->first();
         $enquiry = RecyclableEnquiry::where('post_user_id',$u_id)->where('login_user_id',$user_id)->first();

       // If there is a connection, check if a review exists
if ($enquiry) {

    $review = RecyclableReview::where('user_id', $u_id)
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



            $posts = RecyclablePost::with(['resource', 'weight'])
                ->select('recyclable_posts.*')
                ->where('recyclable_posts.id', $id)
                ->first();
            $noofposts = RecyclablePost::where('user_id', $u_id)->where('active',1)->count();

            //$users = EcosansarUsers::where('id', $u_id)->first();
            // Get user details along with the count of reviews and the average rating from recyclable_reviews
    $users = DB::table('ecosansar_users as eu')
        ->leftJoin('recyclable_reviews as rr', 'eu.id', '=', 'rr.user_id')
        ->where('eu.id', $u_id)
        ->select(
            'eu.*',
            DB::raw('COUNT(DISTINCT rr.id) as reviews_count'),
            DB::raw('ROUND(AVG(rr.rating), 1) as average_rating')
        )
        ->first();

   // Get the count of reviews for the user from recyclable_reviews table
    $reviewsCount = DB::table('recyclable_reviews')
        ->where('user_id', $u_id)
        ->count();
     // Calculate the average rating
    $averageRating = DB::table('recyclable_reviews')
        ->where('user_id', $u_id)
        ->avg('rating');
    $averageRating = $averageRating ? round($averageRating, 1) : 0;

            $loginuser = EcosansarUsers::where('id', $user_id)->first();
          $afterfilter = GoogleAdsense::where('place_of_adsense','After search filter')->first();
            return view('frontend/listings/recyclablelistingdetails', compact('user_id', 'posts', 'id', 'u_id', 'post_id' , 'noofposts', 'hideAddReviewButton',
            'users', 'loginuser','afterfilter', 'breadcrumbimage', 'reviewsCount', 'averageRating'));
        }
        // If the user is not logged in as a consumer, redirect to the login page
        session()->put('redirect_to', route('con_listing_details', $id));
        session()->put('redirect_wp', route('con_listing_details', $id));
        return redirect()->route('consumer_login');
    }



    public function recyclable_deactivate(Request $request)
    {
        $postId = $request->input('post_id');
        $postType = strtolower($request->input('post_type'));

        if ($postType === 'recyclable') {
        $post =  RecyclablePost::find($postId);
    } elseif ($postType === 'reusable') {
        $post =  ReusablePost::find($postId);
    } else {
        return response()->json(['success' => false, 'message' => 'Invalid post type.'], 400);
    }
        if ($post) {
            $post->active = 0;
            $post->save();

        // user activity start
            $userid = session()->get('user_id');
            if ($userid){
                $userActivity = new UserActivityLog();
                $userActivity->user_id = $userid;
                $userActivity->activity = 'Clicked on Recyclable post deactivate';
                $userActivity->url = request()->fullUrl();   // Get the full URL of the request
                $userActivity->ip_address = request()->ip();
                $userActivity->save();
            }
            // user activity end
             Session::flash('success', 'Post deactivated successfully.');
            return response()->json(['success' => true ]);


        }

        return response()->json(['success' => false, 'message' => 'Post not found.'], 404);
    }
    public function recyclable_reactivate(Request $request)
    {
        $postId = $request->input('post_id');
        $postType = strtolower($request->input('post_type'));

       if ($postType === 'recyclable') {
        $post =  RecyclablePost::find($postId);
    } elseif ($postType === 'reusable') {
        $post =  ReusablePost::find($postId);
    } else {
        return response()->json(['success' => false, 'message' => 'Invalid post type.'], 400);
    }
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
                $userActivity->activity = 'Clicked on Recyclable post reactivate';
                $userActivity->url = request()->fullUrl();   // Get the full URL of the request
                $userActivity->ip_address = request()->ip();
                $userActivity->save();
            }
            // user activity end
             Session::flash('success', 'Post reactivated successfully.');
             return response()->json(['success' => true ]);
        }

        return response()->json(['success' => false, 'message' => 'Post not found.'], 404);
    }
    public function markAsFulfilled(Request $request)
{
    $postId = $request->post_id;
    $postType = strtolower($request->post_type);

    if ($postType === 'recyclable') {
        $post = RecyclablePost::find($postId);
    } elseif ($postType === 'reusable') {
        $post = ReusablePost::find($postId);
    } else {
        return response()->json(['message' => 'Invalid post type'], 400);
    }

    if ($post) {
        $post->request_fulfilled = 1;
        $post->save();
         // user activity start
            $userid = session()->get('user_id');
            if ($userid){
                $userActivity = new UserActivityLog();
                $userActivity->user_id = $userid;
                $userActivity->activity = 'Clicked on Recyclable post reactivate';
                $userActivity->url = request()->fullUrl();   // Get the full URL of the request
                $userActivity->ip_address = request()->ip();
                $userActivity->save();
            }
            // user activity end
             Session::flash('success', 'Post fulfilled successfully.');
        return response()->json(['success' => true]);
    }

    return response()->json(['message' => 'Post not found'], 404);
}


    public function get_recyclable_post_details(Request $request)
    {
        $postid = $request->dataId;
        $sab = RecyclablePost::where('id', $postid)->first();
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



    public function notify_me(){
         $user_id = session()->get('user_id');
             // Fetch existing data
        $notifyMe = Notify::where('user_id',$user_id)->first(); // Adjust the model name based on your project
        if($notifyMe){
         // Ensure pincode is an array
    $notifyMe->pincode = explode(',', $notifyMe->pincode); // Convert string to array
     // Ensure resource is an array
    $notifyMe->resource = explode(',', $notifyMe->resource); // Convert string to array
        }
         $url = route('notify_me_store');
        $pincodes = Pincode::get();
        $resources = Resource::get();
        if($notifyMe){
        return view('frontend/notifyme',compact('pincodes','resources','url','notifyMe'));
        }else{
            return view('frontend/notifyme',compact('pincodes','resources','url'));
        }
    }
   public function notify_me_store(Request $request)
{
    $user_id = session()->get('user_id');

    // Validate the input
    $request->validate([
        'pincode' => 'required|array|min:1', // Ensure it's an array with at least one item
        'pincode.*' => 'exists:pincodes,id', // Validate each pincode ID exists
        'resource_type' => 'required|array|min:1', // Ensure it's an array with at least one item
        'resource_type.*' => 'exists:resources,id', // Validate each resource type ID exists
    ]);

     // Send notifications
   // NotificationValidationService::validateAndCheckAvailability($request->pincode, $request->resource_type, $user_id);

    // Combine the values into comma-separated strings
    $pincodeString = implode(',', $request->pincode);
    $resourceString = implode(',', $request->resource_type);

    // Save the data in a single record
    // Notify::create([
    //     'user_id' => $user_id,
    //     'pincode' => $pincodeString,
    //     'resource' => $resourceString,
    // ]);

    // Check if a record for the user already exists
    $existingNotify = Notify::where('user_id', $user_id)->first();

    if ($existingNotify) {
        // Update the existing record
        $existingNotify->pincode = $pincodeString;
        $existingNotify->resource = $resourceString;
        $existingNotify->save();

        // Flash success message
        Session::flash('success', 'Preference updated successfully');
    } else {
        // Create a new record if none exists
        Notify::create([
            'user_id' => $user_id,
            'pincode' => $pincodeString,
            'resource' => $resourceString,
        ]);

        // Flash success message
        Session::flash('success', 'Preference Added successfully');
    }

    // Flash success message
    Session::flash('success', 'Preference Added Successfully');

    // Redirect to the desired page
    return redirect()->to('/');
}
 public function notify_me_edit($id) {
       $url = route('notify_me_update', $id);
        $pincodes = Pincode::get();
        $resources = Resource::get();

         // Fetch existing data
        $notifyMe = Notify::find($id); // Adjust the model name based on your project
         // Ensure pincode is an array
    $notifyMe->pincode = explode(',', $notifyMe->pincode); // Convert string to array
     // Ensure resource is an array
    $notifyMe->resource = explode(',', $notifyMe->resource); // Convert string to array

        return view('frontend/notifyme',compact('pincodes','resources','notifyMe','url'));
    }

    public function notify_me_update(Request $request, $id) {
     $notifyMe = Notify::find($id);

    // If record doesn't exist, you might want to handle that case
    if (!$notifyMe) {
        return redirect()->route('notify_me_edit', $id)->with('error', 'Record not found.');
    }

   // Ensure that the inputs are always arrays
    $pincodeArray = is_array($request->pincode) ? $request->pincode : [];
    $resourceArray = is_array($request->resource_type) ? $request->resource_type : [];

    // Combine the selected values into comma-separated strings
    $pincodeString = implode(',', $pincodeArray);  // Convert array to comma-separated string
    $resourceString = implode(',', $resourceArray);  // Convert array to comma-separated string

    // Update the record
    $notifyMe->pincode = $pincodeString;
    $notifyMe->resource = $resourceString;

    // Save the changes
    $notifyMe->save();

    // Redirect back with success message
    return redirect()->route('notify_me_edit', $id)->with('success', 'Notifications updated successfully!');
}
public function notification_logs()
{
    $user_id = session()->get('user_id');
     $notifyRecord = Notify::where('user_id', $user_id)->first();
    $notifications = [];

    $notifications = [];
    if ($notifyRecord) {
        $notifications = NotificationLog::where('notify_id', $notifyRecord->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Paginate results
    }

    return view('frontend.notificationlogs', compact('notifications'));
}
public function updateNotificationStatus($id, Request $request)
{
     // Find the notification by ID
    $notification = NotificationLog::find($id);  // Adjust model as necessary

    if ($notification) {
        // Update the status to 1 (or whatever status you need)
        $notification->notification_status = 1;
        $notification->save();

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false]);
}


}
