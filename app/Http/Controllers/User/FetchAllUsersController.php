<?php


namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use MealWallet\Domain\User\Service\UserService;
use MealWallet\Domain\User\Service\UserServiceInterface;
use Illuminate\Http\Request;

class FetchAllUsersController extends Controller
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
     * @return JsonResponse
     */
    public function fetchAll(
        Request $request
    ){
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'kibaroAccountUsers' => $this
                        ->userService
                        ->fetchAll([])
                        ->toArray()
                ]
            ]
        );
    }
}
