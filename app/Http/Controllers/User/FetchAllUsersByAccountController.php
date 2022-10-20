<?php


namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MealWallet\Domain\User\Service\UserService;
use MealWallet\Domain\User\Service\UserServiceInterface;

class FetchAllUsersByAccountController extends Controller
{

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * FetchUserDataController constructor.
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @param string $accountId
     * @return JsonResponse
     */
    public function fetchAllAccountUsers(
        Request $request,
        string $accountId
    )
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'kibaroAccountUsers' => $this
                        ->userService
                        ->fetchAllAccountUsers(
                            $accountId
                        )->toArray()
                ]
            ]
        );
    }
}
