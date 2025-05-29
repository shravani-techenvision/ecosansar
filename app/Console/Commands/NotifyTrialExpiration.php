<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
 
use Carbon\Carbon;
use App\Models\frontend\EcosansarUsers;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class NotifyTrialExpiration extends Command
{
    

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:trial-expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users whose trial plan is expiring in 7 days';

    /**
     * Execute the console command.
     */
 public function handle()
{
    $today = Carbon::now();
        $threeDaysAgo = Carbon::now()->addDays(3);
        $twoDaysAgo = Carbon::now()->addDays(2);
        $oneDaysAgo = Carbon::now()->addDays(1);
Log::info('Seven days ago: ' . $threeDaysAgo->toDateTimeString());
        Log::info('One day ago: ' . $twoDaysAgo->toDateTimeString());
        Log::info('Four days ago: ' . $oneDaysAgo->toDateTimeString());
   

   // Get users whose trial plan expires in 1-3 days based on plan_Expiration_date
    // $users = EcosansarUsers::where('plan', 1)  // Assuming 1 means a trial plan
    $users = EcosansarUsers::where(function($query) use ($threeDaysAgo, $twoDaysAgo, $oneDaysAgo) {
            $query->whereDate('plan_expiration_date', '=', $threeDaysAgo)
                  ->orWhereDate('plan_expiration_date', '=', $twoDaysAgo)
                  ->orWhereDate('plan_expiration_date', '=', $oneDaysAgo);
        })
        ->get();
         // Assume trial period is 15 days (you can adjust this as needed)
   

      foreach ($users as $user) {
            if ($user->plan == 1) {
        // Calculate the days left for the plan to expire
        $daysLeft = Carbon::parse($user->plan_expiration_date)->diffInDays(Carbon::now());

        // Send the email with the user data and days left
        $this->sendReminderEmail($user, $daysLeft);
    
        $mobileNumber = $user->mobile; // Adjust field name to match your database
        $planExpiryDate = Carbon::parse($user->plan_expiration_date)->toFormattedDateString();
        $this->sendSMS($mobileNumber, $planExpiryDate);
            }
    }
     foreach ($users as $user) {
            if ($user->plan != 1) {
        // Calculate the days left for the plan to expire
        $daysLeft = Carbon::parse($user->plan_expiration_date)->diffInDays(Carbon::now());

        // Send the email with the user data and days left
        $this->sendReminderEmail($user, $daysLeft);
    
        $mobileNumber = $user->mobile; // Adjust field name to match your database
        $planExpiryDate = Carbon::parse($user->plan_expiration_date)->toFormattedDateString();
        $this->sendSMS($mobileNumber, $planExpiryDate);
            }
    }

        $this->info('Trial plan expiry reminders sent successfully.');
        
}
private function sendReminderEmail($user, $daysLeft)
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
                $mail->addAddress($user->email); // Add recipient
                $mail->Subject = 'Trial Plan Expiry Notice';
                $mail->isHTML(true);
                $mail->Body = view('frontend.mail.planexpire', ['user' => $user,
    'daysLeft' => $daysLeft])->render();

                // Send email
                $mail->send();

                // Log success
                $this->info("Reminder email sent to: {$user->email}");
            } catch (\Exception $e) {
                // Log error
                \Log::error("Error sending email to {$user->email}: " . $e->getMessage());
            }
    }
private function sendSMS($mobile, $expiryDate)
{
    // Initialize cURL
    $curl = curl_init();

    // Template ID and API key (ensure the template supports dynamic variables)
    $templateId = '6697c308d6fc0523883d13f3'; // Replace with your valid template ID
    $apiKey = '425683A51aEfNfhS6697c59aP1'; // Replace with your actual Msg91 API key

    // Prepare the dynamic message data (expiry date in this case)
    $data = json_encode([
        'template_id' => $templateId,
        'short_url' => '0',
        'realTimeResponse' => '1',
        'recipients' => [
            [
                'mobiles' => '91' . $mobile, // Add country code (91 for India)
                'var' => $expiryDate, // Pass the dynamic variable (expiry date)
            ]
        ]
    ]);

    // Set cURL options
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://control.msg91.com/api/v5/flow", // API endpoint
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
            "content-type: application/json",
        ],
    ]);

    // Execute the cURL request and handle the response
    $response = curl_exec($curl);
    $err = curl_error($curl);

    // Close cURL session
    curl_close($curl);

    // Handle errors or successful response
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
}

    
}
