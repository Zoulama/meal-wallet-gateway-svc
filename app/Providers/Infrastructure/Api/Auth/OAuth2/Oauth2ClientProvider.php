<?php


namespace App\Providers\Infrastructure\Api\Auth\OAuth2;

use Illuminate\Support\ServiceProvider;
use MealWallet\Infrastructure\Api\Auth\OAuth2\Client;
use MealWallet\Infrastructure\Api\Auth\OAuth2\ClientInterface;
use MealWallet\Infrastructure\Secrets\SecretManagerInterface;

class Oauth2ClientProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ClientInterface::class, function ($app) {

            return new Client(
                $app->make(SecretManagerInterface::class)->get('KIBARO_GATEWAY_OAUTH2_ACCESS_TOKEN_URL')
                //env('KIBARO_GATEWAY_OAUTH2_ACCESS_TOKEN_URL')
            );
        });
    }
}
