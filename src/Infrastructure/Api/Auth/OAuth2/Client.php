<?php


namespace MealWallet\Infrastructure\Api\Auth\OAuth2;


use League\OAuth2\Client\Provider\GenericProvider;

class Client implements ClientInterface
{

    /**
     * @var string
     */
    private $urlAccessToken;

    /**
     * @var string
     */
    private $urlAuthorize;

    /**
     * @var string
     */
    private $urlResourceOwnerDetails;

    /**
     * @var GenericProvider
     */
    private $provider;

    /**
     * Client constructor.
     * @param string $urlAccessToken
     * @param string|null $urlAuthorize
     * @param string|null $urlResourceOwnerDetails
     */
    public function __construct(
        string $urlAccessToken,
        ?string $urlAuthorize = null,
        ?string $urlResourceOwnerDetails = null){

        $this->urlAccessToken = $urlAccessToken;
        $this->urlAuthorize = $urlAuthorize;
        $this->urlResourceOwnerDetails = $urlResourceOwnerDetails;
    }

    /**
     * @inheritDoc
     */
    public function accessTokenFromClientIdAndSecret(
        string $clientId,
        string $clientSecret
    ): array
    {
        $provider = new GenericProvider(
            [
                'clientId' => $clientId,
                'clientSecret' => $clientSecret,
                'urlAccessToken' => $this->urlAccessToken,
                'urlAuthorize' => $this->urlAuthorize,
                'urlResourceOwnerDetails' => $this->urlResourceOwnerDetails
            ]);

        return [
            'AccessToken'=>$provider->getAccessToken('client_credentials')->getToken(),
            'ExpiresIn'=>$provider->getAccessToken('client_credentials')->getExpires(),
            'TokenType'=>'Bearer',
            'RefreshToken'=>$provider->getAccessToken('client_credentials')->getRefreshToken()
        ];
    }
}
