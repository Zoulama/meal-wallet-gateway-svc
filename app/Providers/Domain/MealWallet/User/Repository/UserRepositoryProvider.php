<?php


namespace App\Providers\Domain\MealWallet\User\Repository;


use Illuminate\Support\ServiceProvider;
use MealWallet\Infrastructure\Api\Rest\Client\User\UserApiClientInterface;
use MealWallet\Domain\User\Repository\UserRepository;
use MealWallet\Domain\User\Repository\UserRepositoryInterface;

//use MealWallet\Infrastructure\User\Repository\UserRepositoryInterface;

//use MealWallet\Infrastructure\User\Repository\UserRepository;



class UserRepositoryProvider  extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(UserRepositoryInterface::class, function ($app) {
            return new UserRepository(
                $app->make(UserApiClientInterface::class)
            );
        });

      /*  $this->app->singleton(UserRepositoryInterface::class, function ($app) {
            return new UserRepository();
        });*/
    }
}
