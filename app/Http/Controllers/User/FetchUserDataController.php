<?php


namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use MealWallet\Domain\User\Service\Exception\UserServiceException;
use MealWallet\Domain\User\Service\UserService;
use MealWallet\Domain\User\Service\UserServiceInterface;
use Illuminate\Http\Request;

class FetchUserDataController extends Controller
{

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * FetchUserDataController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function fetch($userId, Request $request)
    {

        try {
            return response()->json(
                [
                    'status' => 'success',
                    'data' => [
                        'kibaroAccountUser' => $this->userService->fetch($userId)->toArray()
                    ]
                ]

            );
        } catch (UserServiceException $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => 0,
                    'StatusDescription' => $e->getMessage()
                ], 404
            );
        }
    }
}
