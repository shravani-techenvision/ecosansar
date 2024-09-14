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
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
        // Set the default string length for database schema
        Schema::defaultStringLength(191);

        // Initialize the AWS Secrets Manager Client
        $client = new SecretsManagerClient([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION', 'ap-south-1'), // Use your AWS region
        ]);

        // Fetch the secret value from AWS Secrets Manager
        try {
            $result = $client->getSecretValue([
                'SecretId' => 'ecosansar-dev/app/secrets', // Replace with your secret name
            ]);

            if (isset($result['SecretString'])) {
                // Parse the secret string
                $secrets = json_decode($result['SecretString'], true);

                // Manually map each secret to its respective environment variable
                if (isset($secrets['APP_KEY'])) {
                    Config::set('app.key', $secrets['APP_KEY']);
                    putenv("APP_KEY={$secrets['APP_KEY']}");
                }

                if (isset($secrets['DB_HOST'])) {
                    Config::set('database.connections.mysql.host', $secrets['DB_HOST']);
                    putenv("DB_HOST={$secrets['DB_HOST']}");
                }

                if (isset($secrets['DB_DATABASE'])) {
                    Config::set('database.connections.mysql.database', $secrets['DB_DATABASE']);
                    putenv("DB_DATABASE={$secrets['DB_DATABASE']}");
                }

                if (isset($secrets['DB_USERNAME'])) {
                    Config::set('database.connections.mysql.username', $secrets['DB_USERNAME']);
                    putenv("DB_USERNAME={$secrets['DB_USERNAME']}");
                }

                if (isset($secrets['DB_PASSWORD'])) {
                    Config::set('database.connections.mysql.password', $secrets['DB_PASSWORD']);
                    putenv("DB_PASSWORD={$secrets['DB_PASSWORD']}");
                }

                if (isset($secrets['MAIL_HOST'])) {
                    Config::set('mail.mailers.smtp.host', $secrets['MAIL_HOST']);
                    putenv("MAIL_HOST={$secrets['MAIL_HOST']}");
                }

                if (isset($secrets['MAIL_PORT'])) {
                    Config::set('mail.mailers.smtp.port', $secrets['MAIL_PORT']);
                    putenv("MAIL_PORT={$secrets['MAIL_PORT']}");
                }

                if (isset($secrets['MAIL_USERNAME'])) {
                    Config::set('mail.mailers.smtp.username', $secrets['MAIL_USERNAME']);
                    putenv("MAIL_USERNAME={$secrets['MAIL_USERNAME']}");
                }

                if (isset($secrets['MAIL_PASSWORD'])) {
                    Config::set('mail.mailers.smtp.password', $secrets['MAIL_PASSWORD']);
                    putenv("MAIL_PASSWORD={$secrets['MAIL_PASSWORD']}");
                }

                if (isset($secrets['MAIL_ENCRYPTION'])) {
                    Config::set('mail.mailers.smtp.encryption', $secrets['MAIL_ENCRYPTION']);
                    putenv("MAIL_ENCRYPTION={$secrets['MAIL_ENCRYPTION']}");
                }

                if (isset($secrets['AWS_ACCESS_KEY_ID'])) {
                    Config::set('filesystems.disks.s3.key', $secrets['AWS_ACCESS_KEY_ID']);
                    putenv("AWS_ACCESS_KEY_ID={$secrets['AWS_ACCESS_KEY_ID']}");
                }

                if (isset($secrets['AWS_SECRET_ACCESS_KEY'])) {
                    Config::set('filesystems.disks.s3.secret', $secrets['AWS_SECRET_ACCESS_KEY']);
                    putenv("AWS_SECRET_ACCESS_KEY={$secrets['AWS_SECRET_ACCESS_KEY']}");
                }

                if (isset($secrets['AWS_DEFAULT_REGION'])) {
                    Config::set('filesystems.disks.s3.region', $secrets['AWS_DEFAULT_REGION']);
                    putenv("AWS_DEFAULT_REGION={$secrets['AWS_DEFAULT_REGION']}");
                }

                if (isset($secrets['AWS_BUCKET'])) {
                    Config::set('filesystems.disks.s3.bucket', $secrets['AWS_BUCKET']);
                    putenv("AWS_BUCKET={$secrets['AWS_BUCKET']}");
                }

                // Map additional secret variables as needed...
                // Add any other secrets from the Secrets Manager that you want to set
            }
        } catch (\Exception $e) {
            // Log any errors for troubleshooting
            error_log('Error fetching secrets from AWS Secrets Manager: ' . $e->getMessage());
        }
    }
}
