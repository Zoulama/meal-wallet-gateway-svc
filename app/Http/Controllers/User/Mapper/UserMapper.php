<?php


namespace App\Http\Controllers\User\Mapper;


use Illuminate\Http\Request;
use MealWallet\Domain\User\Entity\UserEntityInterface;
use MealWallet\Domain\User\Entity\UserEntity;

class UserMapper implements UserMapperInterface
{
    const STATUS_ENABLED = 'enabled';
    const STATUS_DISABLED = 'disabled';

    /**
     * @inheritDoc
     */
    public static function createUserFromHttpRequest(Request $request): UserEntityInterface
    {
        $payload =  $request->json()->all();

        return UserEntity::fromArray(
            [
                "email" => $payload['email'],
                "mobileNumber" => $payload['mobileNumber'],
                "organizationId" => $request->get('ApiConsumer')->getOrganizations(),
                "status" => self::STATUS_ENABLED,
                //"companyId" => $payload[''],
            ]
        );
    }
}
