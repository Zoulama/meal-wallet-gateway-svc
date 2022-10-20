<?php


namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use MealWallet\Domain\User\Service\Authentification\AuthenticationServiceInterface;

class AuthenticateUserController extends Controller
{
    /**
     * @var AuthenticationServiceInterface
     */
    private $userAuthenticationService;

    /**
     * AuthenticateUserController constructor.
     * @param AuthenticationServiceInterface $userAuthenticationService
     */
    public function __construct(AuthenticationServiceInterface $userAuthenticationService)
    {
        $this->userAuthenticationService = $userAuthenticationService;
    }

    /**
     * @param string $userName
     * @param string $userPassword
     * @return JsonResponse
     */
    public function authenticate(
        string $userName,
        string $userPassword
    )
    {

        try {
            return response()->json(
                [
                    'status' => 'success',
                    'data' => $this->userAuthenticationService->authenticate(
                        trim(urldecode($userName)),
                        trim(urldecode($userPassword))
                    )
                ]
            );
        } catch(CognitoIdentityProviderException $c) {
            return response()->json(
                [
                    'status' => 'error',
                    'code' =>$c->getStatusCode(),
                    'message' => $c->getAwsErrorMessage()
                ] , $c->getStatusCode()
            );
        } catch (Exception $exception) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => $exception->getCode(),
                    'StatusDescription' => $exception->getMessage()
                ], 401
            );
        }
    }

    public function login(Request $request)
    {

        $validator = Validator::make(
            $request->json()->all(),
            [
                'userName' => ['required', 'email'],
                'userPassword' => ['required', 'string'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => "0000",
                    'StatusDescription' => $validator->errors()
                ]
            );
        }
        try {
            return response()->json(
                [
                    'status' => 'success',
                    'data' => $this->userAuthenticationService->authenticate(
                        trim($request->get("userName")),
                        trim($request->get("userPassword"))
                    )
                ]
            );
        } catch(CognitoIdentityProviderException $c) {
            return response()->json(
                [
                    'status' => 'error',
                    'code' =>$c->getStatusCode(),
                    'message' => $c->getAwsErrorMessage()
                ] , $c->getStatusCode()
            );
        } catch (Exception $exception) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => $exception->getCode(),
                    'StatusDescription' => $exception->getMessage()
                ], 401
            );
        }
    }

    public function adminLogin(Request $request)
    {

        $validator = Validator::make(
            $request->json()->all(),
            [
                'userName' => ['required', 'email'],
                'userPassword' => ['required', 'string'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => "0000",
                    'StatusDescription' => $validator->errors()
                ]
            );
        }
        try {
            return response()->json(
                [
                    'status' => 'success',
                    'data' => $this->userAuthenticationService->authenticate(
                        trim($request->get("userName")),
                        trim($request->get("userPassword"))
                    )
                ]
            );
        } catch(CognitoIdentityProviderException $c) {
            return response()->json(
                [
                    'status' => 'error',
                    'code' =>$c->getStatusCode(),
                    'message' => $c->getAwsErrorMessage()
                ] , $c->getStatusCode()
            );
        } catch (Exception $exception) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => $exception->getCode(),
                    'StatusDescription' => $exception->getMessage()
                ], 401
            );
        }
    }

    /**
     * @param string $userName
     * @return JsonResponse
     */
    public function forgotPassword(string $userName)
    {
        try {
            return response()->json(
                [
                    'status' => 'success',
                    'data' => $this
                        ->userAuthenticationService
                        ->forgotPassword(
                            urldecode($userName),
                    )
                ]
            );
        } catch(CognitoIdentityProviderException $c) {
            return response()->json(
                [
                    'status' => 'error',
                    'code' =>$c->getStatusCode(),
                    'message' => $c->getAwsErrorMessage()
                ] , $c->getStatusCode()
            );
        } catch (Exception $exception) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => $exception->getCode(),
                    'StatusDescription' => $exception->getMessage()
                ], 401
            );
        }
    }

    /**
     * @param string $userName
     * @param string $userPassword
     * @param string $confirmationCode
     * @return JsonResponse
     */
    public function confirmForgotPassword(
        string $userName,
        string $userPassword,
        string $confirmationCode
    )
    {
        try {
            return response()->json(
                [
                    'status' => 'success',
                    'data' => $this
                        ->userAuthenticationService
                        ->confirmForgotPassword(
                        urldecode($userName),
                        urldecode($userPassword),
                        $confirmationCode
                    )
                ]

            );
        } catch(CognitoIdentityProviderException $c) {
            return response()->json(
                [
                    'status' => 'error',
                    'code' =>$c->getStatusCode(),
                    'message' => $c->getAwsErrorMessage()
                ] , $c->getStatusCode()
            );
        } catch (Exception $exception) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => $exception->getCode(),
                    'StatusDescription' => $exception->getMessage()
                ], 401
            );
        }
    }

    /**
     * @param string $accessToken
     * @param string $previousPassword
     * @param string $proposedPassword
     * @return JsonResponse
     */
    public function changePassword(
        string $accessToken,
        string $previousPassword,
        string $proposedPassword
    )
    {
        try {
            return response()->json(
                [
                    'status' => 'success',
                    'data' => $this
                        ->userAuthenticationService
                        ->changePassword(
                            urldecode($accessToken),
                            urldecode($previousPassword),
                            urldecode($proposedPassword)
                        )
                ]
            );
        } catch(CognitoIdentityProviderException $c) {
            return response()->json(
                [
                    'status' => 'error',
                    'code' =>$c->getStatusCode(),
                    'message' => $c->getAwsErrorMessage()
                ] , $c->getStatusCode()
            );
        } catch (Exception $exception) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => $exception->getCode(),
                    'StatusDescription' => $exception->getMessage()
                ], 401
            );
        }
    }
}
