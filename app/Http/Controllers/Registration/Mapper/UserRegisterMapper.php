<?php


namespace App\Http\Controllers\Registration\Mapper;


use Illuminate\Http\Request;
use MealWallet\Domain\User\Entity\UserEntityInterface;
use MealWallet\Domain\User\Entity\UserEntity;
use Ramsey\Uuid\Uuid;

class UserRegisterMapper implements UserRegisterMapperInterface
{
    /**
     * @param Request $request
     * @param string $accountId
     * @return UserEntityInterface
     */
    public static function createRegisterFromHttpRequest(
        Request $request,
        string $accountId
    ): UserEntityInterface
    {
        $payload =  $request->json()->all();
        return UserEntity::fromArray(
            [
                'email' => strtolower($payload['email']),
                'organizationId' => $request->get('ApiConsumer')->getOrganizations()[0],
                'accountId' => $accountId,
            ]
        );
    }
}
