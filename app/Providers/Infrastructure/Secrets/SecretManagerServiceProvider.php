<?php


namespace App\Providers\Infrastructure\Secrets;


use Google\Cloud\SecretManager\V1\SecretManagerServiceClient;
use Illuminate\Support\ServiceProvider;
use MealWallet\Infrastructure\CloudRun\Metadata\ProjectID\CloudRunProjectIDInterface;
use MealWallet\Infrastructure\Secrets\SecretManager;
use MealWallet\Infrastructure\Secrets\SecretManagerInterface;


class SecretManagerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SecretManagerInterface::class, function ($app) {
            return new SecretManager(
                $app->make(CloudRunProjectIDInterface::class),
                'meal-wallet-authentication-svc',
                'latest',
                new SecretManagerServiceClient()
            );
        });
    }
}
