<?php


namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Http\Controllers\User\Mapper\UserMapper;
use App\Http\Controllers\User\Mapper\UserMapperInterface;
use Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use MealWallet\Domain\User\Service\Authentification\AuthenticationServiceInterface;
use MealWallet\Domain\User\Service\Exception\UserServiceException;
use MealWallet\Domain\User\Service\UserService;
use MealWallet\Domain\User\Service\UserServiceInterface;

class CreateUserController extends Controller
{

    /**
     * @var UserMapperInterface
     */
    private $userMapper;

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @var AuthenticationServiceInterface
     */
    private $userAuthenticationService;

    /**
     * CreateUserController constructor.
     * @param UserMapper $userMapper
     * @param UserService $userService
     * @param AuthenticationServiceInterface $userAuthenticationService
     */
    public function __construct(
        UserMapper $userMapper,
        UserService $userService,
        AuthenticationServiceInterface $userAuthenticationService
    )
    {
        $this->userMapper = $userMapper;
        $this->userService = $userService;
        $this->userAuthenticationService = $userAuthenticationService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {

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
                    'StatusCode' => 0000,
                    'StatusDescription' => $validator->errors()
                ]
            );
        }

        try {

            $userEntity = $this->userService->create(
                $this->userMapper::createUserFromHttpRequest(
                    $request
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
                    'status' => 'Error',
                    'StatusCode' => $exception->getCode(),
                    'StatusDescription' => json_decode(
                        $exception->getMessage(),
                        true
                    )
                ]
            );
        }  catch(CognitoIdentityProviderException $c) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => $c->getStatusCode(),
                    'StatusDescription' =>json_decode(
                        $c->getAwsErrorMessage(),
                        true
                    )
                ]
            );
        }

        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'kibaroAccountUser' => $userEntity->toArray()
                ]
            ]

        );
    }
}
