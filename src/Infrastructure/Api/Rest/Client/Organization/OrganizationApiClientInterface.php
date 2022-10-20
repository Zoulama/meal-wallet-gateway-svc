<?php


namespace MealWallet\Infrastructure\Api\Rest\Client\Organization;


use MealWallet\Domain\Organization\Collection\OrganizationCollectionInterface;
use MealWallet\Domain\Organization\Entity\OrganizationEntityInterface;
use MealWallet\Domain\User\Entity\UserEntityInterface;
use MealWallet\Infrastructure\Api\Rest\Client\Organization\Exception\OrganizationApiClientException;
use MealWallet\Infrastructure\Api\Rest\Client\User\Exception\UserApiClientException;

interface OrganizationApiClientInterface
{

    /**
     * @param array $userPayload
     * @return mixed
     */
    public function create(
        array $userPayload
    ): OrganizationEntityInterface;

    /**
     * @param array $filters
     * @return OrganizationCollectionInterface
     */
    public function fetchAll(array $filters): OrganizationCollectionInterface;

    /**
     * @param string $userId
     * @return OrganizationEntityInterface
     * @throws OrganizationApiClientException
     */
    public function fetch(string $userId): OrganizationEntityInterface;

}
