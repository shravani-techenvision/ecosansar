<?php
namespace App\Services;

use App\Models\frontend\Notify;
use App\Models\frontend\BusinessPost;
use App\Models\frontend\BusinessResourcePost;
use App\Models\frontend\NotificationLog;
use App\Models\admin\Pincode;
use App\Models\admin\Resource;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Craftsys\Msg91\Facade\Msg91;
 

class NotificationBusinessService
{
  public static function sendNotifications($pincodeValue, $resource, $postType, $user_id, $post_id, $postaddusertype)
{
    Log::info("Sending notifications for pincode: {$pincodeValue}, resource: {$resource}");
     Log::info("Post id: {$post_id}");
    $pincode = Pincode::where('pincode', $pincodeValue)->first();
    Log::info("Pincode found: " . json_encode($pincode));

    if (!$pincode) {
        Log::error("No matching pincode found for value: {$pincodeValue}");
        return;
    }

    $matchingNotifies = Notify::with('user')
    ->whereRaw("FIND_IN_SET(?, pincode)", [$pincode->id])
    ->whereRaw("FIND_IN_SET(?, resource)", [$resource])
    ->get();
    Log::info("Matching notifications count: " . $matchingNotifies->count());
    // Log the details of $matchingNotifies
Log::info("Matching notifications details: " . json_encode($matchingNotifies->toArray()));

   foreach ($matchingNotifies as $notify) {
    if (!isset($notify->user) || empty($notify->user->email)) {
        Log::error("No user or email found for notify ID: {$notify->id}");
        continue;
    }

    $userEmail = $notify->user->email;
    $userType = $notify->user->user_type;
    $userId = $notify->user->id;
     $userName = $notify->user->name;
    $notifyId = $notify->id; // Get notify ID
    Log::info("User type: {$userType}, Email: {$userEmail}, userid: {$userId}");

    $resourceValue = Resource::find($resource);
    $details = [
        'pincode' => $pincodeValue,
        'resource' => $resourceValue ? $resourceValue->resource_name : 'Unknown',
        'userName' => $userName,
        'userType' => $userType
    ];

    if ($userType !== 'consumer' && $userType !== 'sab') {
     $businessPosts = BusinessPost::join('business_resource_posts', 'business_posts.id', '=', 'business_resource_posts.post_id')
 ->select('business_posts.*', 'business_resource_posts.resource_type')
    ->where('business_posts.pincode', $pincodeValue)
   ->where('business_posts.user_id', '!=', $userId)
    ->where('business_resource_posts.resource_type',$resource)
     ->where('business_posts.active', '=', 1)
     ->where('business_posts.id','=',$post_id)
    ->first();
    
    if ($businessPosts) {
     Log::info('Business Post Found: ' . json_encode($businessPosts));
    // Proceed to send email with this post
    self::sendEmail($userEmail, $details, $businessPosts, $businessPosts->id, $notifyId, $businessPosts->user->user_type);
} else {
    Log::info("No business post found with the given conditions.");
}    
 
 
    } elseif ($userType === 'consumer'|| $userType === 'sab' ) {
 
$businessbuyPosts = BusinessPost::join('business_resource_posts', 'business_posts.id', '=', 'business_resource_posts.post_id')
  ->select('business_posts.*', 'business_resource_posts.resource_type')
    ->where('business_posts.pincode', $pincodeValue)
   ->where('business_posts.user_id', '!=', $userId)
    ->where('business_posts.sale_giveaway', '=', 'Buy')
    ->where('business_resource_posts.resource_type',$resource)
    ->where('business_posts.active', '=', 1)
     ->where('business_posts.id','=',$post_id)
    ->first();
    
    if ($businessbuyPosts) {
     Log::info('Business Buy Post Found: ' . json_encode($businessbuyPosts));
    // Proceed to send email with this post
    self::sendEmail($userEmail, $details, $businessbuyPosts, $businessbuyPosts->id, $notifyId, $businessbuyPosts->user->user_type);
} else {
    Log::info("No business buy post found with the given conditions.");
}
  
    }  
}

}

    private static function sendEmail($userEmail, $details, $posts, $postId, $notifyId, $postUsertype)
    {
         // Use PHPMailer as you had in your original code
        $mail = new PHPMailer(true);

         try {
                // SMTP configuration
                $mail->isSMTP();
                $mail->Host = 'email-smtp.ap-south-1.amazonaws.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'AKIAU6GDYQUALD5BWSMU';
                $mail->Password = 'BEzdqoQCdnG1whfi7OU35Y94cVcs+7PQbTerX6qngnbj';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Email content
                $mail->setFrom('support@mailing.ecosansar.com', 'Team ecoSansar');
                $mail->addAddress($userEmail); // Add recipient
                $mail->Subject = 'New posts notifications';
                $mail->isHTML(true);
                  

// Generate the dynamic link
$dynamicLink = url('bus_listing_details' . '/' . $postId);
               $mail->Body = view('frontend.mail.notify', [
               'details' => $details,
            'posts' => $posts,
            'dynamicLink' => $dynamicLink, // Pass the link
            ])->render();

                // Send email
                $mail->send();

                // Log success
               Log::info("Reminder email sent to: {$userEmail}");
              //  $notificationStatus = 1; // Mark as sent
               // Save notification log
        NotificationLog::create([
            'post_id' => $postId,
            'notify_id' => $notifyId,
            'post_usertype' => $postUsertype,
           // 'notification_status' => $notificationStatus
            // Save posts as JSON
        ]);
            } catch (\Exception $e) {
                // Log error
                \Log::error("Error sending email to {$userEmail}: " . $e->getMessage());
            }
    }
}
