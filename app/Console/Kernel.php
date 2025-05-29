<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\DeactivateSABPosts::class,
    Commands\DeactivateConsumerPosts::class,
    Commands\DeactivateBusinessPosts::class,
     Commands\NotifyTrialExpiration::class,
  Commands\UpdateUserStatus::class,
   Commands\SendNotifications::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('posts:sab:deactivate')->daily();
    $schedule->command('posts:consumer:deactivate')->daily();
     $schedule->command('posts:business:deactivate')->daily();
     $schedule->command('notify:trial-expiration')->daily();
      $schedule->command('user:update-status')->daily();
       $schedule->command('send:notifications')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
