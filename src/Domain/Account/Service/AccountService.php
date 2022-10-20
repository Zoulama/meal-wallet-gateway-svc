<?php


namespace MealWallet\Domain\Account\Service;

use MealWallet\Domain\Account\Entity\AccountEntityInterface;
use MealWallet\Domain\Account\Collection\AccountCollectionInterface;
use MealWallet\Domain\Account\Repository\AccountRepositoryInterface;
use MealWallet\Domain\Account\Repository\Exception\AccountRepositoryException;
use MealWallet\Domain\Account\Service\Exception\AccountServiceException;
use MealWallet\Domain\User\Collection\UserCollectionInterface;
use MealWallet\Infrastructure\Api\Rest\Client\Account\Exception\AccountApiClientException;

class AccountService implements AccountServiceInterface
{
    /**
     * @var AccountRepositoryInterface
     */
    private $accountRepository;

    /**
     * AccountService constructor.
     * @param AccountRepositoryInterface $accountRepository
     */
    public function __construct(
        AccountRepositoryInterface $accountRepository
    ) {
        $this->accountRepository = $accountRepository;
    }

    /**
     * @inheritDoc
     */
    public function create(
        AccountEntityInterface $accountEntity
    ): AccountEntityInterface
    {
        try {
            return $this->accountRepository->create(
                $accountEntity
            );
        } catch (AccountRepositoryException $e){
            throw new AccountServiceException(
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
        try {
            return $this
                ->accountRepository
                ->fetchAllAccountOrganizations(
                    $organizationId
                );
        } catch (AccountRepositoryException $e){
            throw new AccountServiceException(
                $e->getMessage()
            );
        }
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
                ->accountRepository
                ->updateWithUserAndAccountAndOrganizations(
                    $accountId,
                    $data
                );
        } catch (AccountRepositoryException $e){
            throw new AccountServiceException(
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
                ->accountRepository
                ->fetchWithAccountId($accountId);
        } catch (AccountRepositoryException $e){
            throw new AccountServiceException(
                $e->getMessage()
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function fetchAll(array $filter): AccountCollectionInterface
    {
        return $this->accountRepository
            ->fetchAll(
                $filter
            );
    }
}
