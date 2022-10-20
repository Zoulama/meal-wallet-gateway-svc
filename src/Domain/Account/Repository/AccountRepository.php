<?php


namespace MealWallet\Domain\Account\Repository;


use MealWallet\Domain\Account\Repository\Exception\AccountRepositoryException;
use MealWallet\Domain\User\Collection\UserCollectionInterface;
use MealWallet\Infrastructure\Api\Rest\Client\Account\AccountApiClientInterface;
use MealWallet\Domain\Account\Entity\AccountEntityInterface;
use MealWallet\Domain\Account\Collection\AccountCollectionInterface;
use MealWallet\Infrastructure\Api\Rest\Client\Account\Exception\AccountApiClientException;

class AccountRepository implements AccountRepositoryInterface
{

    /**
     * @var AccountApiClientInterface
     */
    private $accountApiClient;

    public function __construct(AccountApiClientInterface $accountApiClient)
    {
        $this->accountApiClient = $accountApiClient;
    }

    public function create(
        AccountEntityInterface $accountEntity
    ): AccountEntityInterface
    {
        try {
            return $this->accountApiClient->create(
                $accountEntity->toRequest()
            );
        } catch (AccountApiClientException $e){
            throw new AccountRepositoryException(
                $e->getMessage()
            );
        }
    }


    /**
     * @inheritDoc
     */
    public function fetchAllAccountOrganizations(
        string $organizationId
    ): AccountCollectionInterface
    {
        return $this
            ->accountApiClient
            ->fetchAll([
                'organizationId' =>  $organizationId
            ]);
    }

    /**
     * @inheritDoc
     */
    public function updateWithUserAndAccountAndOrganizations(
        string $accountId,
        array $data
    ): AccountEntityInterface
    {
        try {
            return $this
                ->accountApiClient
                ->update(
                    $accountId,
                    $data);
        } catch (AccountApiClientException $e){
            throw new AccountRepositoryException(
                $e->getMessage()
            );
        }

    }

    /**
     * @inheritDoc
     */
    public function fetchWithAccountId(string $accountId): AccountEntityInterface
    {
        try {
            return $this
                ->accountApiClient
                ->fetch(
                    $accountId
                );
        } catch (AccountApiClientException $e){
            throw new AccountRepositoryException(
                $e->getMessage()
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function fetchAll(
        array $filter
    ): AccountCollectionInterface{
        return $this->accountApiClient->fetchAll(
            $filter
        );
    }


}
