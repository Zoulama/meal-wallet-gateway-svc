<?php


namespace MealWallet\Infrastructure\Api\Rest\Client\User;


use MealWallet\Infrastructure\Api\Rest\Client\User\Exception\UserApiClientException;
use MealWallet\Domain\User\Entity\UserEntityInterface;
use MealWallet\Domain\User\Collection\UserCollectionInterface;

interface UserApiClientInterface
{
    /**
     * @param array $userPayload
     * @return UserEntityInterface
     */
    public function create(
        array $userPayload
    ) : UserEntityInterface;

    /**
     * @param string $userId
     * @return UserEntityInterface
     * @throws UserApiClientException
     */
    public function get(string $userId): UserEntityInterface;

    /**
     * @param string $email
     * @return UserEntityInterface
     */
    public function fetchByEmail(string $email): UserEntityInterface;

    /**
     * @param $filter
     * @return UserCollectionInterface
     */
    public function fetchAll(
        $filter
    ): UserCollectionInterface;


    /**
     * @param string $accountId
     * @return UserCollectionInterface
     */
    public function fetchAllAccountUsers(
        string $accountId
    ): UserCollectionInterface;
}
