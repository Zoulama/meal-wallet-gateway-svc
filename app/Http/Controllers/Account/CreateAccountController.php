<?php


namespace App\Http\Controllers\Account;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Account\Mapper\AccountMapper;
use App\Http\Controllers\Account\Mapper\AccountMapperInterface;
use App\Http\Controllers\User\Mapper\UserMapper;
use App\Http\Controllers\User\Mapper\UserMapperInterface;
use App\Rules\IsValidPassword;
use App\Rules\MealWallet\KibaroUserIdRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use MealWallet\Domain\Account\Repository\Exception\AccountRepositoryException;
use MealWallet\Domain\Account\Service\AccountService;
use MealWallet\Domain\Account\Service\AccountServiceInterface;
use MealWallet\Domain\Account\Service\Exception\AccountServiceException;
use MealWallet\Domain\User\Entity\UserEntity;
use MealWallet\Domain\User\Service\Authentification\AuthenticationServiceInterface;
use MealWallet\Domain\User\Service\UserService;
use MealWallet\Domain\User\Service\UserServiceInterface;

class CreateAccountController extends Controller
{
    /**
     * @var AccountServiceInterface
     */
    private $accountService;

    /**
     * @var AccountMapperInterface
     */
    private $accountMapper;

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


    public function __construct(
        AccountService $accountService,
        AccountMapper $accountMapper,
        UserMapper $userMapper,
        UserService $userService,
        AuthenticationServiceInterface $userAuthenticationService
    ) {
        $this->accountService = $accountService;
        $this->accountMapper = $accountMapper;
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
            $request->all(),
            [
                'name' => ['required', 'string'],
                'address' => ['required', 'array'],
                'email'  => ['required', 'email'],
                'phoneNumber' => ['required', 'string'],
                'mobileNumber' => ['required', 'string'],
                'userPassword' => [
                    'required',
                    'string',
                    new IsValidPassword(),
                ],
            ]
        );

        if($validator->fails()){
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode'=> 0,
                    'StatusDescription'=> $validator->errors()
                ]
            );
        }

        try {

            $accountEntity = $this->accountService->create(
                $this->accountMapper::createAccountFromHttpRequest(
                    $request
                )
            );

            $userEntity = $this->userService->create(
                UserEntity::fromArray(
                    [
                        "email" => $accountEntity->getEmail(),
                        "organizationId" => $request->get('ApiConsumer')->getOrganizations()[0],
                        'accountId' => $accountEntity->getAccountId(),
                    ]
                )
            );

            $this
                ->userAuthenticationService
                ->register(
                    $accountEntity->getEmail(),
                    $request->get('userPassword'),
                    $accountEntity->getEmail(),
                    $userEntity->getUserId(),
                    $userEntity->getAccountId()
                )->addUserToGroup(
                    $request->get('email'),
                    "admin"
                );

            return response()->json(
                [
                    'status' => 'success',
                    'data' => [
                        'kibaroAccount' => $this->accountService->create(
                            $this->accountMapper::createAccountFromHttpRequest(
                                $request
                            )
                        )->toArray()
                    ]
                ]
            );
        } catch (AccountServiceException $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode'=> 0,
                    'StatusDescription'=> $e->getMessage()
                ]
            );
        }
    }
}
