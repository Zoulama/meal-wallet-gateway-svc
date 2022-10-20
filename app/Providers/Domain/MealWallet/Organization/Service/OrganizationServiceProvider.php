<?php


namespace App\Providers\Domain\MealWallet\Organization\Service;


use Illuminate\Support\ServiceProvider;
use MealWallet\Domain\Organization\Repository\OrganizationRepositoryInterface;
use MealWallet\Domain\Organization\Service\OrganizationService;
use MealWallet\Domain\Organization\Service\OrganizationServiceInterface;


class OrganizationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(OrganizationServiceInterface::class, function ($app) {
            return new OrganizationService(
                $app->make(OrganizationRepositoryInterface::class)
            );
        });
    }
}
