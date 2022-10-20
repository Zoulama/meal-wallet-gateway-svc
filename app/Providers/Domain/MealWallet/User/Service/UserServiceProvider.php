<?php


namespace App\Providers\Domain\MealWallet\User\Service;


use Illuminate\Support\ServiceProvider;
use MealWallet\Domain\User\Repository\UserRepositoryInterface;
use MealWallet\Domain\User\Service\UserService;
use MealWallet\Domain\User\Service\UserServiceInterface;
//use MealWallet\Infrastructure\User\Repository\UserRepositoryInterface;

class UserServiceProvider  extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(UserServiceInterface::class, function ($app) {
            return new UserService(
                $app->make(UserRepositoryInterface::class)
            );
        });
    }
}
