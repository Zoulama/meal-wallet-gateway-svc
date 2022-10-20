<?php


namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Registration\Mapper\UserRegisterMapper;
use Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Exception;
use MealWallet\Domain\User\Entity\UserEntity;
use MealWallet\Domain\User\Service\Authentification\AuthenticationServiceInterface;
use MealWallet\Domain\User\Service\Exception\UserServiceException;
use MealWallet\Domain\User\Service\UserServiceInterface;

class RegisterNewUserController extends Controller
{
    const INP_POC_ACCOUNT_ID = '8e4be2fba63699941117e088';
    const INP_POC_DOMAIN = 'yoonwii.com';
    const DEFAULT_ACCOUNT_ID = '60afdacc2aeef4f26d71c990';

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @var AuthenticationServiceInterface
     */
    private $userAuthenticationService;

    /**
     * @var UserRegisterMapper
     */
    private $mapper;


    /**
     * RegisterNewUserController constructor.
     * @param UserServiceInterface $userService
     * @param UserRegisterMapper $mapper
     * @param AuthenticationServiceInterface $userAuthenticationService
     */
    public function __construct(
        UserServiceInterface $userService,
        UserRegisterMapper $mapper,
        AuthenticationServiceInterface $userAuthenticationService
    ){
        $this->userService = $userService;
        $this->mapper = $mapper;
        $this->userAuthenticationService = $userAuthenticationService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(
        Request $request
    )
    {
        $accountId = self::DEFAULT_ACCOUNT_ID;

        $validator = Validator::make(
            $request->json()->all(),
            [
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
                //'group' => ['required', 'string'],
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

        $var = explode('@', strtolower($request->json()->get('email')));
        $domain = array_pop($var);

        if ($domain === self::INP_POC_DOMAIN)
            $accountId = self::INP_POC_ACCOUNT_ID;


        try {

            $userEntity = $this
                ->userService
                ->create(
                    UserRegisterMapper::createRegisterFromHttpRequest(
                        $request,
                        $accountId
                    )
                );

            $this
                ->userAuthenticationService
                ->register(
                    $request->get('email'),
                    $request->get('password'),
                    $request->get('email'),
                    $userEntity->getUserId(),
                    $userEntity->getAccountId()
                )->addUserToGroup(
                    $request->get('email'),
                    'user'
                );

        } catch (UserServiceException $exception) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => $exception->getCode(),
                    'StatusDescription' => $exception->getMessage()
                ], 404
            );
        } catch(CognitoIdentityProviderException $c) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => $c->getStatusCode(),
                    'StatusDescription' => $c->getAwsErrorMessage()
                ], 404
            );
        }

        return response()->json(
            [
                'status' => 'success',
                'data'=> [
                    'kibaroAccountUser'=> $userEntity->toArray()
                ]
            ]
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function adminRegister(
        Request $request
    ) {
        $accountId = self::DEFAULT_ACCOUNT_ID;

        $validator = Validator::make(
            $request->json()->all(),
            [
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
                'group' => ['required', 'string'],
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

            $userEntity = $this
                ->userService
                ->create(
                    UserRegisterMapper::createRegisterFromHttpRequest(
                        $request,
                        $accountId
                    )
                );

            $this
                ->userAuthenticationService
                ->register(
                    $request->get('email'),
                    $request->get('password'),
                    $request->get('email'),
                    $userEntity->getUserId(),
                    $userEntity->getAccountId()
                )->addUserToGroup(
                    $request->get('email'),
                    $request->get('group')
                );

        } catch (UserServiceException $exception) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => $exception->getCode(),
                    'StatusDescription' => $exception->getMessage()
                ], 404
            );
        } catch(CognitoIdentityProviderException $c) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => $c->getStatusCode(),
                    'StatusDescription' => $c->getAwsErrorMessage()
                ], 404
            );
        }

        return response()->json(
            [
                'status' => 'success',
                'data'=> [
                    'kibaroAccountUser'=> $userEntity->toArray()
                ]
            ]
        );
    }
}
