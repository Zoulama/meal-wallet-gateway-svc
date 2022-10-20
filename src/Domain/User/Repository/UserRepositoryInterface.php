<?php


namespace MealWallet\Domain\User\Repository;


use MealWallet\Domain\User\Entity\UserEntityInterface;
use MealWallet\Domain\User\Collection\UserCollectionInterface;
use MealWallet\Domain\User\Repository\Exception\UserRepositoryException;

interface UserRepositoryInterface
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
     * @throws UserRepositoryException
     */
    public function fetch(
        string $userId
    ):UserEntityInterface;

    /**
     * @param string $email
     * @return UserEntityInterface
     * @throws UserRepositoryException
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
     * @param string $accountId
     * @return UserCollectionInterface
     */
    public function fetchAllAccountUsers(
        string $accountId
    ): UserCollectionInterface;


}
