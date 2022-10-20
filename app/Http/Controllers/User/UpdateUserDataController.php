<?php


namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Http\Controllers\User\Mapper\UserMapperInterface;
use Illuminate\Http\Request;
use MealWallet\Domain\User\Service\UserService;
use MealWallet\Domain\User\Service\UserServiceInterface;

class UpdateUserDataController extends Controller
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
     * FetchUserDataController constructor.
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function update(string $userId, Request $request)
    {
        return response()->json(
            [

            ]
        );
    }

}
