<?php

namespace App\Providers;

use Aws\SecretsManager\SecretsManagerClient;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Set the default string length for database schema
        Schema::defaultStringLength(191);

        // Initialize the AWS Secrets Manager Client
        $client = new SecretsManagerClient([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION', 'your-default-region'), // Use your AWS region
        ]);

        // Fetch the secret value
        try {
            $result = $client->getSecretValue([
                'SecretId' => 'laravel/app/secrets', // Replace with your secret name
            ]);

            if (isset($result['SecretString'])) {
                // Parse the secret string
                $secrets = json_decode($result['SecretString'], true);

                // Set environment variables dynamically
                foreach ($secrets as $key => $value) {
                    // Set each secret as an environment variable
                    Config::set($key, $value);
                    putenv("$key=$value");
                }
            }
        } catch (\Exception $e) {
            // Log any errors
            error_log('Error fetching secrets from AWS Secrets Manager: ' . $e->getMessage());
        }
    }
}
