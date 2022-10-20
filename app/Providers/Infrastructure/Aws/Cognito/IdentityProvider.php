<?php


namespace App\Providers\Infrastructure\Aws\Cognito;


use Aws\Sdk;
use Illuminate\Support\ServiceProvider;
use MealWallet\Infrastructure\Secrets\SecretManagerInterface;

class IdentityProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('Aws::Cognito::IdentityProvider', function ($app) {
            $aws = new Sdk(
                [
                    'credentials' => [
                        'key' => $app->make(SecretManagerInterface::class)->get('AWS_ACCESS_KEY'),
                        'secret' => $app->make(SecretManagerInterface::class)->get('AWS_SECRET_KEY'),
                    ],
                    'region' => $app->make(SecretManagerInterface::class)->get('AWS_REGION'),
                    'version' =>$app->make(SecretManagerInterface::class)->get('AWS_VERSION'),
                    'user_pool_id' => $app->make(SecretManagerInterface::class)->get('AWS_COGNITO_USER_POOL_ID'),
                ]
            );

            return $aws->createCognitoIdentityProvider();
        });
    }
}
