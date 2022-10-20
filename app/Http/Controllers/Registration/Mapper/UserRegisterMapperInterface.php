<?php


namespace App\Http\Controllers\Registration\Mapper;


use Illuminate\Http\Request;
use MealWallet\Domain\User\Entity\UserEntityInterface;

interface UserRegisterMapperInterface
{
    /**
     * @param Request $request
     * @param string $accountId
     * @return UserEntityInterface
     */
    public static function createRegisterFromHttpRequest(
        Request $request,
        string $accountId
    ): UserEntityInterface;

}
