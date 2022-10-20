<?php


namespace App\Providers\Infrastructure\Api\Rest\Client\Organization;


use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use MealWallet\Infrastructure\Api\Rest\Client\Organization\Mapper\OrganizationMapper;
use MealWallet\Infrastructure\Api\Rest\Client\Organization\OrganizationApiClientInterface;
use MealWallet\Infrastructure\Api\Rest\Client\Organization\OrganizationApiGuzzleHttpClient;
use MealWallet\Infrastructure\CloudRun\Metadata\OAuth\IDToken\OAuthIDTokenServiceInterface;
use MealWallet\Infrastructure\Secrets\SecretManagerInterface;

class OrganizationApiClientProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(OrganizationApiClientInterface::class, function ($app) {
            $organizationServiceUri = $app->make(SecretManagerInterface::class)->get('KIBARO_BACKEND_ORGANIZATION_URI');
            //$organizationServiceUri =  env('KIBARO_BACKEND_ORGANIZATION_URI');
            return new OrganizationApiGuzzleHttpClient(
                new Client([
                    'base_uri' => $organizationServiceUri,
                    'headers' => [
                        'Authorization' => sprintf(
                            'Bearer %s',
                            $app->make(OAuthIDTokenServiceInterface::class)->token(
                                $organizationServiceUri
                            )
                        )
                    ]
                ]),
                new OrganizationMapper()
            );
        });
    }
}
