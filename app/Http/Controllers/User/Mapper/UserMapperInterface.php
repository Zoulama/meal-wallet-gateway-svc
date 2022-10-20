<?php


namespace App\Http\Controllers\User\Mapper;

use Illuminate\Http\Request;
use MealWallet\Domain\User\Entity\UserEntityInterface;

interface UserMapperInterface
{

    /**
     * @param Request $request
     * @return UserEntityInterface
     */
    public static function createUserFromHttpRequest(Request $request):UserEntityInterface;
}
