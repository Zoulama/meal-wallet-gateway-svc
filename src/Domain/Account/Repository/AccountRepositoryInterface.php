<?php


namespace MealWallet\Domain\Account\Repository;


use MealWallet\Domain\Account\Entity\AccountEntityInterface;
use MealWallet\Domain\Account\Collection\AccountCollectionInterface;
use MealWallet\Domain\User\Collection\UserCollectionInterface;

interface AccountRepositoryInterface
{
    /**
     * @param AccountEntityInterface $accountEntity
     * @return AccountEntityInterface
     */
    public function create(
        AccountEntityInterface $accountEntity
    ): AccountEntityInterface;

    /**
     * @param string $organizationId
     * @return AccountCollectionInterface
     */
    public function fetchAllAccountOrganizations(
        string $organizationId
    ): AccountCollectionInterface;

    /**
     * @param string $accountId
     * @param array $data
     * @return AccountEntityInterface
     */
    public function updateWithUserAndAccountAndOrganizations(
        string $accountId,
        array $data
    ): AccountEntityInterface;

    /**
     * @param string $accountId
     * @return mixed
     */
    public function fetchWithAccountId(
        string $accountId
    ): AccountEntityInterface;

    /**
     * @param AccountEntityInterface $entity
     * @param array $organizations
     * @return AccountEntityInterface
     */
/*    public function createOrganizationAccount(
        AccountEntityInterface $entity,
        array $organizations
    ): AccountEntityInterface;*/

    /**
     * @param array $filter
     * @return AccountCollectionInterface
     */
    public function fetchAll(
        array $filter
    ): AccountCollectionInterface;
}
