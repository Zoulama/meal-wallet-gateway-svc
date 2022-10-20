<?php


namespace App\Http\Controllers\Account\Mapper;


use Illuminate\Http\Request;
use MealWallet\Domain\Account\Entity\AccountEntityInterface;

interface AccountMapperInterface
{

    public static function createAccountFromHttpRequest(Request $request): AccountEntityInterface;
}
