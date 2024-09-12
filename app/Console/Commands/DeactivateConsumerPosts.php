<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\frontend\ConsumerPost;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Mail;
use App\Models\frontend\EcosansarUsers;

class DeactivateConsumerPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:consumer:deactivate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate consumer posts that are older than 7 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Running cron job to deactivate consumer posts at ' . Carbon::now()->toDateTimeString());

        $today = Carbon::now();
        $sevenDaysAgo = Carbon::now()->subDays(7);
        $fourDaysAgo = Carbon::now()->subDays(2);
        $fiveDaysAgo = Carbon::now()->subDays(1);

        Log::info('Today: ' . $today->toDateTimeString());
        Log::info('Seven days ago: ' . $sevenDaysAgo->toDateTimeString());
        Log::info('One day ago: ' . $fiveDaysAgo->toDateTimeString());
        Log::info('Four days ago: ' . $fourDaysAgo->toDateTimeString());

        // Fetch and deactivate posts older than 7 days
        $postsToDeactivate = ConsumerPost::where('active', 1)
                                         ->whereDate('post_date', '<=', $sevenDaysAgo)
                                         ->get();

        Log::info('Number of posts found to deactivate: ' . $postsToDeactivate->count());

        foreach ($postsToDeactivate as $post) {
            Log::info('Deactivating Post ID: ' . $post->id . ' Created At: ' . $post->post_date);
        }

        $updated = ConsumerPost::where('active', 1)
                               ->whereDate('post_date', '<=', $sevenDaysAgo)
                               ->update(['active' => 0]);

        Log::info('Number of posts deactivated: ' . $updated);
        
        
        
        
        $postsTosevenDays = ConsumerPost::where('active', 0)
                                             ->whereDate('post_date', '=', $sevenDaysAgo)
                                             ->get();
                                             
       foreach ($postsTosevenDays as $post) {
            
            $users = EcosansarUsers::where('id',$post->user_id)->first();

            $data = [
                'email' => $post->email,
                'name' => $users->name,
                'title' => 'Your Listing on The ZeroWaste Community Tool Has Been Deactivated',
                'post' => $post,
            ];

            Mail::send('frontend.mail.sevendayconsumedeactivermail', $data, function($message) use ($data) {
                $message->to($data['email'], $data['email'])
                        ->subject($data['title']);
            });

            //Log::info('Sent 4-day reminder for Post ID: ' . $post->id . ' Created At: ' . $post->post_date);
        } 
        

        // Send reminders for posts created 4 days ago
        $postsToRemindFourDays = ConsumerPost::where('active', 1)
                                             ->whereDate('post_date', '=', $fourDaysAgo)
                                             ->get();

        foreach ($postsToRemindFourDays as $post){
            
            $users = EcosansarUsers::where('id',$post->user_id)->first();
            
            $userpost = BusinessPost::join('business_resource_posts', 'business_resource_posts.post_id', 'business_posts.id')
               ->join('resources', 'resources.id', 'business_resource_posts.resource_type')
                ->join('weights', 'business_posts.quantity', '=', 'weights.id')
              ->select('business_posts.*', 'resources.resource_name','weights.min_weight', 'weights.min_measure', 'weights.max_weight','weights.max_measure')
              ->where('business_posts.id', $post->id)->first();
            
            $data = [
                'email' => $post->email,
                'name' => $users->name,
                'resource_type' => $userpost->resource_name,
                'weight' => isset($userpost->min_weight) ? $userpost->min_weight . ' ' . $userpost->min_measure . ' to ' . $userpost->max_weight . ' ' . $userpost->max_measure : '',
                'date' => $post->post_date,
                'title' => 'Your Listing on The ZeroWaste Community Tool is due for Deactivation Soon',
                'post' => $post,
            ];

            Mail::send('frontend.mail.consumerremindermail', $data, function($message) use ($data){
                $message->to($data['email'], $data['email'])
                        ->subject($data['title']);
            });

            Log::info('Sent 4-day reminder for Post ID: ' . $post->id . ' Created At: ' . $post->post_date);
        }

        // Send reminders for posts created 1 day ago
        $postsToRemindFiveDays = ConsumerPost::where('active', 1)
                                             ->whereDate('post_date', '=', $fiveDaysAgo)
                                             ->get();

        foreach ($postsToRemindFiveDays as $post) {
            
            $users = EcosansarUsers::where('id',$post->user_id)->first();
            
            $data = [
                'email' => $post->email,
                'name' => $users->name,
                'title' => 'Your Listing on The ZeroWaste Community Tool is due for Deactivation Soon',
                'post' => $post,
            ];

            Mail::send('frontend.mail.onedayconsumerremindermail', $data, function($message) use ($data) {
                $message->to($data['email'], $data['email'])
                        ->subject($data['title']);
            });

            Log::info('Sent 5-day reminder for Post ID: ' . $post->id . ' Created At: ' . $post->post_date);
        }

        return 0;
    }
}
