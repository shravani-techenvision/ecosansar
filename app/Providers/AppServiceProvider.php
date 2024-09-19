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

                // Application Settings
                Config::set('app.name', $secrets['APP_NAME'] ?? '');
                Config::set('app.env', $secrets['APP_ENV'] ?? 'production');
                Config::set('app.key', $secrets['APP_KEY'] ?? '');
                Config::set('app.debug', $secrets['APP_DEBUG'] ?? false);
                Config::set('app.url', $secrets['APP_URL'] ?? '');

                // Log Settings
                Config::set('logging.channels.stack', $secrets['LOG_CHANNEL'] ?? 'stack');
                Config::set('logging.level', $secrets['LOG_LEVEL'] ?? 'debug');

                // Database Settings
                Config::set('database.connections.mysql.host', $secrets['DB_HOST'] ?? '');
                Config::set('database.connections.mysql.port', $secrets['DB_PORT'] ?? '3306');
                Config::set('database.connections.mysql.database', $secrets['DB_DATABASE'] ?? '');
                Config::set('database.connections.mysql.username', $secrets['DB_USERNAME'] ?? '');
                Config::set('database.connections.mysql.password', $secrets['DB_PASSWORD'] ?? '');

                // Mail Settings
                Config::set('mail.mailers.smtp.host', $secrets['MAIL_HOST'] ?? '');
                Config::set('mail.mailers.smtp.port', $secrets['MAIL_PORT'] ?? '465');
                Config::set('mail.mailers.smtp.username', $secrets['MAIL_USERNAME'] ?? '');
                Config::set('mail.mailers.smtp.password', $secrets['MAIL_PASSWORD'] ?? '');
                Config::set('mail.mailers.smtp.encryption', $secrets['MAIL_ENCRYPTION'] ?? 'tls');
                Config::set('mail.from.address', $secrets['MAIL_FROM_ADDRESS'] ?? '');
                Config::set('mail.from.name', $secrets['MAIL_FROM_NAME'] ?? '');

                // Redis Settings
                Config::set('database.redis.default.host', $secrets['REDIS_HOST'] ?? '127.0.0.1');
                Config::set('database.redis.default.password', $secrets['REDIS_PASSWORD'] ?? null);
                Config::set('database.redis.default.port', $secrets['REDIS_PORT'] ?? '6379');

                // AWS Settings
                Config::set('filesystems.disks.s3.key', $secrets['AWS_ACCESS_KEY_ID'] ?? '');
                Config::set('filesystems.disks.s3.secret', $secrets['AWS_SECRET_ACCESS_KEY'] ?? '');
                Config::set('filesystems.disks.s3.region', $secrets['AWS_DEFAULT_REGION'] ?? 'ap-south-1');
                Config::set('filesystems.disks.s3.bucket', $secrets['AWS_BUCKET'] ?? '');

                // Other services (e.g., Pusher, MSG91)
                Config::set('broadcasting.connections.pusher.app_id', $secrets['PUSHER_APP_ID'] ?? '');
                Config::set('broadcasting.connections.pusher.key', $secrets['PUSHER_APP_KEY'] ?? '');
                Config::set('broadcasting.connections.pusher.secret', $secrets['PUSHER_APP_SECRET'] ?? '');
                Config::set('broadcasting.connections.pusher.options.cluster', $secrets['PUSHER_APP_CLUSTER'] ?? 'mt1');
                Config::set('broadcasting.connections.pusher.options.useTLS', true);

                Config::set('services.msg91.auth_key', $secrets['MSG91_AUTH_KEY'] ?? '');
                Config::set('services.msg91.sender_id', $secrets['MSG91_SENDER_ID'] ?? 'ECSNSR');
                Config::set('services.msg91.route', $secrets['MSG91_ROUTE'] ?? '4');

                // Additional secret mappings as needed...
            }
        } catch (\Exception $e) {
            // Log any errors for troubleshooting
            error_log('Error fetching secrets from AWS Secrets Manager: ' . $e->getMessage());
        }
    }
}