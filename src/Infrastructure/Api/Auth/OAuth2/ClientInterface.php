<?php


namespace MealWallet\Infrastructure\Api\Auth\OAuth2;


interface ClientInterface
{

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @return array
     */
    public function accessTokenFromClientIdAndSecret(
        string $clientId,
        string $clientSecret
    ):array ;
}
