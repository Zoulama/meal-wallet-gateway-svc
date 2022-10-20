<?php


namespace App\Providers\Infrastructure\Api\Rest\Client\Account;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
use MealWallet\Infrastructure\Api\Rest\Client\Account\AccountApiClientInterface;
use MealWallet\Infrastructure\Api\Rest\Client\Account\AccountApiGuzzleHttpClient;
use MealWallet\Infrastructure\Api\Rest\Client\Account\Mapper\AccountMapper;
use MealWallet\Infrastructure\CloudRun\Metadata\OAuth\IDToken\OAuthIDTokenServiceInterface;
use MealWallet\Infrastructure\Secrets\SecretManagerInterface;

class AccountApiClientProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AccountApiClientInterface::class, function ($app) {
            $accountServiceUri = $app->make(SecretManagerInterface::class)->get('KIBARO_BACKEND_ORGANIZATION_URI');

            //$accountServiceUri = env('KIBARO_BACKEND_REPORTS_URI');
            return new AccountApiGuzzleHttpClient(
                new Client([
                    'base_uri' => $accountServiceUri,
                    'headers' => [
                        'Authorization' => sprintf(
                            'Bearer %s',
                            $app->make(OAuthIDTokenServiceInterface::class)->token(
                                $accountServiceUri
                            )
                        )
                    ]
                ]),
                new AccountMapper()
            );
        });
    }
}
