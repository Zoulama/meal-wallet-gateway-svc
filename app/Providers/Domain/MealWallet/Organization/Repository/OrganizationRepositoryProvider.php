<?php


namespace App\Providers\Domain\MealWallet\Organization\Repository;


use Illuminate\Support\ServiceProvider;
use MealWallet\Infrastructure\Api\Rest\Client\Organization\OrganizationApiClientInterface;
use MealWallet\Domain\Organization\Repository\OrganizationRepository;
use MealWallet\Domain\Organization\Repository\OrganizationRepositoryInterface;

class OrganizationRepositoryProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(OrganizationRepositoryInterface::class, function ($app) {
            return new OrganizationRepository(
                $app->make(OrganizationApiClientInterface::class)
            );
        });
    }
}
