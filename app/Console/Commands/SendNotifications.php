<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\frontend\Notify;
use App\Models\frontend\ConsumerPost;
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

class SendNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications based on pincode and resource match';

    /**
     * Execute the console command.
     */
    public function handle()
    {
      // Fetch all Notify records
    $matchingNotifies = Notify::with('user')  // Include user relation
        ->get(); // Get all Notify records

    Log::info("Matching notifications count: " . $matchingNotifies->count());

    // Loop through each matching notify record
    foreach ($matchingNotifies as $notify) {
        $userEmail = $notify->user->email;
        $userType = $notify->user->user_type;
        $userId = $notify->user->id;

        Log::info("User type: {$userType}, Email: {$userEmail}");

        // Dynamically get pincode and resource values from the notify record itself
        $pincodeValues = $notify->pincode;  // Assuming it's a comma-separated list of pincode IDs
        $resourceValues = $notify->resource;  // Assuming it's a comma-separated list of resource IDs

        // Loop through each pincode in the notify record
        foreach (explode(',', $pincodeValues) as $pincodeValue) {
            // Fetch the pincode from the database based on the pincode ID
            $pincode = Pincode::find($pincodeValue);

            if ($pincode) {
                // Loop through each resource and compare with consumer posts
                foreach (explode(',', $resourceValues) as $resource) {
                    // Fetch matching consumer posts based on pincode and resource
                    $consumerPosts = ConsumerPost::join('consumer_resource_posts', 'consumer_posts.id', '=', 'consumer_resource_posts.post_id')
                        ->where('consumer_posts.pincode', $pincode->pincode)
                        ->where('consumer_resource_posts.resource_type', $resource)
                        ->get();

                    Log::info("Consumer posts count for pincode {$pincode->pincode} and resource {$resource}: " . $consumerPosts->count());

                    // Check if any matching posts are found
                    if ($consumerPosts->isNotEmpty()) {
                        // Send notifications based on the matching posts
                        foreach ($consumerPosts as $post) {
                            // Logic to send notifications (email, SMS, etc.)
                            // For example:
                            // Mail::to($userEmail)->send(new NotificationMail($post));
                        }
                    }
                }
            } else {
                Log::info("Pincode {$pincodeValue} not found.");
            }
        }
    }
    }
}
