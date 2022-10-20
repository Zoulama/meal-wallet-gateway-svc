<?php


namespace App\Http\Controllers\Authentication;


use App\Http\Controllers\Controller;
use MealWallet\Infrastructure\Api\Auth\OAuth2\Client;
use Exception;
use Illuminate\Http\JsonResponse;
use MealWallet\Infrastructure\Api\Auth\OAuth2\ClientInterface;

class FetchAccessTokenController extends Controller
{

    /**
     * @var ClientInterface
     */
    private $oauth2Client;

    /**
     * FetchAccessTokenController constructor.
     * @param ClientInterface $oauth2Client
     */
    public function __construct(ClientInterface $oauth2Client)
    {
        $this->oauth2Client = $oauth2Client;
    }


    /**
     * @param string $clientId
     * @param string $clientSecret
     * @return JsonResponse
     */
    public function fetch(
        string $clientId,
        string $clientSecret
    )
    {
        try {
            return response()->json(
                [
                    'status' => 'success',
                    'data' => $this->oauth2Client->accessTokenFromClientIdAndSecret(
                        $clientId,
                        $clientSecret
                    )
                ]

            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => 0,
                    'StatusDescription' => $e->getMessage()
                ], 401
            );
        }

    }
}
