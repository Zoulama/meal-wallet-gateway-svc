<?php


namespace App\Providers\Domain\MealWallet\Account\Service;

use Illuminate\Support\ServiceProvider;
use MealWallet\Domain\Account\Repository\AccountRepositoryInterface;
use MealWallet\Domain\Account\Service\AccountService;
use MealWallet\Domain\Account\Service\AccountServiceInterface;

class AccountServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AccountServiceInterface::class, function ($app) {
            return new AccountService(
                $app->make(AccountRepositoryInterface::class)
            );
        });
    }
}

