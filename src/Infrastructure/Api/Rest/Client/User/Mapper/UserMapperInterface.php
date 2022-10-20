<?php


namespace MealWallet\Infrastructure\Api\Rest\Client\User\Mapper;


use Psr\Http\Message\ResponseInterface;
use MealWallet\Domain\User\Entity\UserEntityInterface;
use MealWallet\Domain\User\Collection\UserCollectionInterface;

interface UserMapperInterface
{
    /**
     * @param ResponseInterface $response
     * @return UserEntityInterface
     */
    public function createUserFromApiResponse(ResponseInterface $response): UserEntityInterface;

    /**
     * @param ResponseInterface $response
     * @return UserCollectionInterface
     */
    public function createUserCollectionFromApiResponse(
        ResponseInterface $response
    ):UserCollectionInterface;
}
