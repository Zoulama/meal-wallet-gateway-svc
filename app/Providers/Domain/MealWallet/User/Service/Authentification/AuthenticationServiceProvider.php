<?php


namespace App\Providers\Domain\MealWallet\User\Service\Authentification;


use Illuminate\Support\ServiceProvider;
use MealWallet\Infrastructure\Secrets\SecretManagerInterface;
use MealWallet\Domain\User\Service\Authentification\AuthenticationService;
use MealWallet\Domain\User\Service\Authentification\AuthenticationServiceInterface;


class AuthenticationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AuthenticationServiceInterface::class, function ($app) {

            return new AuthenticationService(
                $app->make('Aws::Cognito::IdentityProvider'),
                env('AWS_COGNITO_USER_POOL_CLIENT_ID'),//$app->make(SecretManagerInterface::class)->get('AWS_COGNITO_USER_POOL_CLIENT_ID'),
                env('AWS_COGNITO_USER_POOL_ID') //$app->make(SecretManagerInterface::class)->get('AWS_COGNITO_USER_POOL_ID')
            );
        });
    }
}
