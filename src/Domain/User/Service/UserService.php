<?php


namespace MealWallet\Domain\User\Service;

use MealWallet\Domain\User\Entity\UserEntityInterface;
use MealWallet\Domain\User\Collection\UserCollectionInterface;
use MealWallet\Domain\User\Repository\UserRepositoryInterface;
use MealWallet\Domain\User\Repository\Exception\UserRepositoryException;
use MealWallet\Domain\User\Service\Exception\UserServiceException;

class UserService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @inheritDoc
     */
    public function create(
        UserEntityInterface $userEntity
    ): UserEntityInterface
    {
        try {
            return $this
                ->userRepository
                ->create(
                    $userEntity
                );
        } catch (UserRepositoryException $e) {
            throw new UserServiceException(
                $e->getMessage()
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function fetch(string $userId): UserEntityInterface
    {
        try {
            return $this
                ->userRepository
                ->fetch(
                $userId
            );
        } catch (UserRepositoryException $e) {
            throw new UserServiceException(
                $e->getMessage()
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function fetchByEmail(string $email): UserEntityInterface
    {
        try {
            return $this
                ->userRepository
                ->fetchByEmail(
                $email
            );
        } catch (UserRepositoryException $e) {
            throw new UserServiceException(
                $e->getMessage()
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function fetchAll(array $filter): UserCollectionInterface
    {
        return $this
            ->userRepository
            ->fetchAll(
            $filter
        );
    }

    /**
     * @inheritDoc
     */
    public function fetchAllAccountUsers(
        string $accountId
    ): UserCollectionInterface
    {
        return $this->userRepository
            ->fetchAllAccountUsers(
                $accountId
            );
    }
}
