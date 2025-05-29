<?php
namespace App\Services;

use App\Models\frontend\Notify;
use App\Models\frontend\ConsumerPost;
use App\Models\frontend\EcosansarUsers;
use App\Models\frontend\SABPost;
use App\Models\frontend\BusinessPost;
use App\Models\frontend\ConsumerResourcePost;
use App\Models\frontend\SABResourcePost;
use App\Models\frontend\BusinessResourcePost;
use App\Models\admin\Pincode;
use App\Models\admin\Resource;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Craftsys\Msg91\Facade\Msg91;

class NotificationValidationService
{
 public static function validateAndCheckAvailability(array $pincodeIds, array $resourceTypes, $user_id )
    {
         $users = EcosansarUsers::find($user_id);
    $userEmail = $users->email;
     $userType = $users->user_type;
        $userId = $users->id;
        // Check if the user_type matches 'sab' or 'business'
    if ($userType === 'sab' || $userType === 'business') {
        // Fetch actual pincode values from the Pincode table
$actualPincodes = Pincode::whereIn('id', $pincodeIds)->pluck('pincode')->toArray();
      // Check for an exact match between pincode and resource_type in the related tables
$matchingsellPosts  = ConsumerPost::whereIn('pincode', $actualPincodes)
 ->where('user_id', '!=', $userId) // Exclude the current user's posts
    ->where('sale_giveaway', '!=', 'Buy') // Exclude posts marked as 'Buy'
    ->whereHas('resourcePosts', function ($query) use ($actualPincodes, $resourceTypes) {
        $query->whereIn('resource_type', $resourceTypes)
              ->whereIn('post_id', function ($subQuery) use ($actualPincodes) {
                  $subQuery->select('id')
                           ->from('consumer_posts')
                           ->whereIn('pincode', $actualPincodes);
              });
    })
    ->get();
   // Count the matching posts
        $matchingCount = $matchingsellPosts->count();
  Log::info("count: {$matchingCount}");
        if ($matchingCount === 0) {
            Log::info("error");
        }
        // Prepare details to pass to the email view
        $details = [
            'pincode' => implode(', ', $actualPincodes), // You can join pincode values if there are multiple
            'resource' => implode(', ', $resourceTypes), // Join resource types if there are multiple
        ]; 
         if (!$matchingsellPosts->isEmpty()) {
                self::sendEmail($userEmail, $details, $matchingsellPosts);
            }
         
    }elseif ($userType !== 'business' && $userType !== 'sab') {
         // Fetch actual pincode values from the Pincode table
$actualPincodes = Pincode::whereIn('id', $pincodeIds)->pluck('pincode')->toArray();
      // Check for an exact match between pincode and resource_type in the related tables
$matchingPosts  = ConsumerPost::whereIn('pincode', $actualPincodes)
 ->where('user_id', '!=', $userId) // Exclude the current user's posts
    ->whereHas('resourcePosts', function ($query) use ($actualPincodes, $resourceTypes) {
        $query->whereIn('resource_type', $resourceTypes)
              ->whereIn('post_id', function ($subQuery) use ($actualPincodes) {
                  $subQuery->select('id')
                           ->from('consumer_posts')
                           ->whereIn('pincode', $actualPincodes);
              });
    })
    ->get();
   // Count the matching posts
        $matchingCount = $matchingPosts->count();
         // Prepare details to pass to the email view
        $details = [
            'pincode' => implode(', ', $actualPincodes), // You can join pincode values if there are multiple
            'resource' => implode(', ', $resourceTypes), // Join resource types if there are multiple
        ]; 
         if (!$matchingPosts->isEmpty()) {
                self::sendEmail($userEmail, $details, $matchingPosts);
            } 
    }
    
}
 private static function sendEmail($userEmail, $details, $posts)
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
                $mail->Subject = 'Trial Plan Expiry Notice';
                $mail->isHTML(true);
               $mail->Body = view('frontend.mail.notify', [
               'details' => $details,
            'posts' => $posts,
            ])->render();

                // Send email
                $mail->send();

                // Log success
               Log::info("Reminder email sent to: {$userEmail}");
            } catch (\Exception $e) {
                // Log error
                \Log::error("Error sending email to {$userEmail}: " . $e->getMessage());
            }
    }
}
