<?php


namespace App\Providers\Domain\MealWallet\Account\Repository;


use Illuminate\Support\ServiceProvider;
use MealWallet\Domain\Account\Repository\AccountRepository;
use MealWallet\Domain\Account\Repository\AccountRepositoryInterface;
use MealWallet\Infrastructure\Api\Rest\Client\Account\AccountApiClientInterface;

class AccountRepositoryProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AccountRepositoryInterface::class, function ($app) {
            return new AccountRepository(
                $app->make(AccountApiClientInterface::class)
            );
        });
    }
}
