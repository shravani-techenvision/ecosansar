<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\frontend\BusinessPost;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Mail;

class DeactivateBusinessPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:business:deactivate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate business posts that are older than 7 days';

    /**
     * Execute the console command.
     */
   public function handle()
    {
        Log::info('Running cron job to deactivate business posts at ' . Carbon::now()->toDateTimeString());

        $today = Carbon::now();
        $sevenDaysAgo = Carbon::now()->subDays(7);
        $fourDaysAgo = Carbon::now()->subDays(2);
        $fiveDaysAgo = Carbon::now()->subDays(1);

        Log::info('Today: ' . $today->toDateTimeString());
        Log::info('Seven days ago: ' . $sevenDaysAgo->toDateTimeString());
        Log::info('One day ago: ' . $fiveDaysAgo->toDateTimeString());
        Log::info('Four days ago: ' . $fourDaysAgo->toDateTimeString());

        // Fetch and deactivate posts older than 7 days
        $postsToDeactivate = BusinessPost::where('active', 1)
                                         ->whereDate('post_date', '<=', $sevenDaysAgo)
                                         ->get();

        Log::info('Number of business posts found to deactivate: ' . $postsToDeactivate->count());

        foreach ($postsToDeactivate as $post) {
            Log::info('Deactivating Post ID: ' . $post->id . ' Created At: ' . $post->post_date);
        }

        $updated = BusinessPost::where('active', 1)
                               ->whereDate('post_date', '<=', $sevenDaysAgo)
                               ->update(['active' => 0]);
                               
                               
                               
        
        $postsTosevenDays = BusinessPost::where('active', 0)
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

            Mail::send('frontend.mail.sevendaybusinessrdeactivemail', $data, function($message) use ($data) {
                $message->to($data['email'], $data['email'])
                        ->subject($data['title']);
            });

            //Log::info('Sent 4-day reminder for Post ID: ' . $post->id . ' Created At: ' . $post->post_date);
        }                    
        
        
        
        
                               

        Log::info('Number of posts deactivated: ' . $updated);

        // Send reminders for posts created 4 days ago
        $postsToRemindFourDays = BusinessPost::where('active', 1)
                                             ->whereDate('post_date', '=', $fourDaysAgo)
                                             ->get();

        foreach ($postsToRemindFourDays as $post) {
            
            $users = EcosansarUsers::where('id',$post->user_id)->first();

            $data = [
                'email' => $post->email,
                'name' => $users->name,
                'title' => 'Your Listing on The ZeroWaste Community Tool is due for Deactivation Soon',
                'post' => $post,
            ];

            Mail::send('frontend.mail.businessremindermail', $data, function($message) use ($data) {
                $message->to($data['email'], $data['email'])
                        ->subject($data['title']);
            });

            Log::info('Sent 4-day reminder for Post ID: ' . $post->id . ' Created At: ' . $post->post_date);
        }

        // Send reminders for posts created 1 day ago
        $postsToRemindFiveDays = BusinessPost::where('active', 1)
                                             ->whereDate('post_date', '=', $fiveDaysAgo)
                                             ->get();

        foreach ($postsToRemindFiveDays as $post){
            
            $users = EcosansarUsers::where('id',$post->user_id)->first();
            
            $data = [
                'email' => $post->email,
                'name' => $users->name,
                'title' => 'Your Listing on The ZeroWaste Community Tool is due for Deactivation Soon',
                'post' => $post,
            ];

            Mail::send('frontend.mail.onedaybusinessremindermail', $data, function($message) use ($data) {
                $message->to($data['email'], $data['email'])
                        ->subject($data['title']);
            });

            Log::info('Sent 5-day reminder for Post ID: ' . $post->id . ' Created At: ' . $post->post_date);
        }

        return 0;
    }
}
