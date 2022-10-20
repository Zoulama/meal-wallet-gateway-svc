<?php


namespace App\Providers\Infrastructure\Api\Rest\Client\User;


use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use MealWallet\Infrastructure\Api\Rest\Client\User\Mapper\UserMapper;
use MealWallet\Infrastructure\Api\Rest\Client\User\UserApiClientInterface;
use MealWallet\Infrastructure\Api\Rest\Client\User\UserApiGuzzleHttpClient;
use MealWallet\Infrastructure\CloudRun\Metadata\OAuth\IDToken\OAuthIDTokenServiceInterface;
use MealWallet\Infrastructure\Secrets\SecretManagerInterface;

class UserApiClientProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(UserApiClientInterface::class, function ($app) {
            $userServiceUri = $app->make(SecretManagerInterface::class)->get('KIBARO_BACKEND_USERS_URI');

            //$userServiceUri =  env('KIBARO_BACKEND_USERS_URI');

            return new UserApiGuzzleHttpClient(
                new Client([
                    'base_uri' => $userServiceUri,
                    'headers' => [
                        'Authorization' => sprintf(
                            'Bearer %s',
                            $app->make(OAuthIDTokenServiceInterface::class)->token(
                                $userServiceUri
                            )
                        )
                    ]
                ]),
                new UserMapper()
            );
        });

    }
}
