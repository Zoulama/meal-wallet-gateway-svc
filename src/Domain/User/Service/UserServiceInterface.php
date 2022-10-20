<?php

namespace MealWallet\Domain\User\Service;


use MealWallet\Domain\User\Entity\UserEntityInterface;
use MealWallet\Domain\User\Collection\UserCollectionInterface;
use MealWallet\Domain\User\Service\Exception\UserServiceException;

interface UserServiceInterface
{

    /**
     * @param UserEntityInterface $userEntity
     * @return UserEntityInterface
     */
    public function create(
        UserEntityInterface $userEntity
    ):UserEntityInterface;

    /**
     * @param string $userId
     * @return UserEntityInterface
     * @throws UserServiceException
     */
    public function fetch(
        string $userId
    ): UserEntityInterface;


    /**
     * @param string $email
     * @return UserEntityInterface
     * @throws UserServiceException
     */
    public function fetchByEmail(string $email): UserEntityInterface;

    /**
     * @param array $filter
     * @return UserCollectionInterface
     */
    public function fetchAll(
        array $filter
    ): UserCollectionInterface;

    /**
     * @param string $email
     * @param string $group
     * @return UserEntityInterface
     */
   /* public function addToGroup(
        string $email,
        string $group
    ): UserEntityInterface;*/

    /**
     * @param string $accountId
     * @return UserCollectionInterface
     */
    public function fetchAllAccountUsers(
        string $accountId
    ): UserCollectionInterface;

}
