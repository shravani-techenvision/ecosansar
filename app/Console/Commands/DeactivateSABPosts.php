<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\frontend\SABPost;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Mail;


class DeactivateSABPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:sab:deactivate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate SAB posts that are older than 7 days';

    /**
     * Execute the console command.
     */
     public function handle()
    {
        Log::info('Running cron job to deactivate Sab posts at ' . Carbon::now()->toDateTimeString());

        $today = Carbon::now();
        $sevenDaysAgo = Carbon::now()->subDays(7);
        $fourDaysAgo = Carbon::now()->subDays(4);
        $fiveDaysAgo = Carbon::now()->subDays(1);

        Log::info('Today: ' . $today->toDateTimeString());
        Log::info('Seven days ago: ' . $sevenDaysAgo->toDateTimeString());
        Log::info('One day ago: ' . $fiveDaysAgo->toDateTimeString());
        Log::info('Four days ago: ' . $fourDaysAgo->toDateTimeString());

        // Fetch and deactivate posts older than 7 days
        $postsToDeactivate = SABPost::where('active', 1)
                                         ->whereDate('post_date', '<=', $sevenDaysAgo)
                                         ->get();

        Log::info('Number of sab posts found to deactivate: ' . $postsToDeactivate->count());

        foreach ($postsToDeactivate as $post) {
            Log::info('Deactivating Post ID: ' . $post->id . ' Created At: ' . $post->post_date);
        }

        $updated = SABPost::where('active', 1)
                               ->whereDate('post_date', '<=', $sevenDaysAgo)
                               ->update(['active' => 0]);

        Log::info('Number of posts deactivated: ' . $updated);

        // Send reminders for posts created 4 days ago
        $postsToRemindFourDays = SABPost::where('active', 1)
                                             ->whereDate('post_date', '=', $fourDaysAgo)
                                             ->get();

        foreach ($postsToRemindFourDays as $post) {
            $data = [
                'email' => $post->email,
                'title' => 'Reminder: Your post will be deactivated soon',
                'post' => $post,
            ];

            Mail::send('frontend.mail.sabremindermail', $data, function($message) use ($data) {
                $message->to($data['email'], $data['email'])
                        ->subject($data['title']);
            });

            Log::info('Sent 4-day reminder for Post ID: ' . $post->id . ' Created At: ' . $post->post_date);
        }

        // Send reminders for posts created 1 day ago
        $postsToRemindFiveDays = SABPost::where('active', 1)
                                             ->whereDate('post_date', '=', $fiveDaysAgo)
                                             ->get();

        foreach ($postsToRemindFiveDays as $post) {
            $data = [
                'email' => $post->email,
                'title' => 'Reminder: Your post will be deactivated soon',
                'post' => $post,
            ];

            Mail::send('frontend.mail.sabremindermail', $data, function($message) use ($data) {
                $message->to($data['email'], $data['email'])
                        ->subject($data['title']);
            });

            Log::info('Sent 5-day reminder for Post ID: ' . $post->id . ' Created At: ' . $post->post_date);
        }

        return 0;
    }
}
