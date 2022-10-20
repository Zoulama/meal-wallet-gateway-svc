<?php


namespace MealWallet\Domain\Account\Service;


use MealWallet\Domain\Account\Entity\AccountEntityInterface;
use MealWallet\Domain\Account\Collection\AccountCollectionInterface;
use MealWallet\Domain\User\Collection\UserCollectionInterface;

interface AccountServiceInterface
{
    /**
     * @param AccountEntityInterface $accountEntity
     * @return AccountEntityInterface
     */
    public function create(
        AccountEntityInterface $accountEntity
    ): AccountEntityInterface;


    /**
     * @param string $accountId
     * @return AccountCollectionInterface
     */
    public function fetchAllAccountOrganizations(
        string $accountId
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
     * @param AccountEntityInterface $accountEntity
     * @param array $organizations
     * @return AccountEntityInterface
     */
/*    public function createOrganizationAccount(
        AccountEntityInterface $accountEntity,
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
