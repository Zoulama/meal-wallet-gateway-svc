<?php


namespace MealWallet\Infrastructure\Api\Rest\Client\User\Mapper;


use Psr\Http\Message\ResponseInterface;
use MealWallet\Domain\User\Entity\UserEntity;
use MealWallet\Domain\User\Entity\UserEntityInterface;
use MealWallet\Domain\User\Collection\UserCollection;
use MealWallet\Domain\User\Collection\UserCollectionInterface;

class UserMapper implements UserMapperInterface
{

    /**
     * @inheritDoc
     */
    public function createUserFromApiResponse(ResponseInterface $response): UserEntityInterface
    {
        $userData = json_decode(
            $response->getBody()->getContents(),
            true
        );

        return  UserEntity::fromArray(
            $userData['data']['user']
        );
    }

    /**
     * @inheritDoc
     */
    public function createUserCollectionFromApiResponse(ResponseInterface $response): UserCollectionInterface
    {
        $data = json_decode(
            $response->getBody()->getContents(),
            true
        );

        return UserCollection::fromArray(
            $data['data']['users']
        );
    }


}
