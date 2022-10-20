<?php


namespace MealWallet\Domain\User\Repository;


use MealWallet\Infrastructure\Api\Rest\Client\User\UserApiClientInterface;
use MealWallet\Domain\User\Entity\UserEntityInterface;
use MealWallet\Infrastructure\Api\Rest\Client\User\Exception\UserApiClientException as ApiClientUserNotFoundException;
use MealWallet\Domain\User\Collection\UserCollectionInterface;
use MealWallet\Domain\User\Repository\Exception\UserRepositoryException;

class UserRepository implements UserRepositoryInterface
{

    /**
     * @var UserApiClientInterface
     */
    private $userApiClient;

    /**
     * UserRepository constructor.
     * @param UserApiClientInterface $userApiClient
     */
    public function __construct(UserApiClientInterface $userApiClient)
    {
        $this->userApiClient = $userApiClient;
    }


    /**
     * @param UserEntityInterface $userEntity
     * @return UserEntityInterface
     */
    public function create(
        UserEntityInterface $userEntity
    ): UserEntityInterface
    {
        try {
            return $this->userApiClient->create(
                $userEntity->toArray()
            );
        } catch (ApiClientUserNotFoundException $e) {
            throw new UserRepositoryException(
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
            return $this->userApiClient->get(
                $userId
            );
        } catch (ApiClientUserNotFoundException $e) {
            throw new UserRepositoryException(
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
            return $this->userApiClient->fetchByEmail(
                $email
            );
        } catch (ApiClientUserNotFoundException $e) {
            throw new UserRepositoryException(
                $e->getMessage()
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function fetchAll(
        array $filter
    ): UserCollectionInterface
    {
       return $this->userApiClient->fetchAll(
           $filter
       );
    }

    /**
     * @param string $accountId
     * @return UserCollectionInterface
     */
    public function fetchAllAccountUsers(
        string $accountId
    ): UserCollectionInterface
    {
        return $this->userApiClient
            ->fetchAllAccountUsers(
                $accountId
            );
    }


}
