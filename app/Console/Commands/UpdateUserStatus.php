<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\frontend\EcosansarUsers;
use Illuminate\Support\Facades\Log;

class UpdateUserStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user status to inactive if plan expiration date is past';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       // Get all users whose plan expiration date is less than the current date
        $users = EcosansarUsers::where('plan_expiration_date', '<', Carbon::now())
            ->where('status', '!=', '0') // Only update active users
            ->get();

        // Loop through each user and update the status
        foreach ($users as $user) {
            $user->status = '0';  // Set status to inactive
            $user->save();
            $this->info("User {$user->id} status updated to inactive.");
        }

        $this->info('User status update completed.');
    }
}
