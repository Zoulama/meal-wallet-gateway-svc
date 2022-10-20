<?php


namespace MealWallet\Domain\Organization\Repository;


use MealWallet\Domain\Organization\Entity\OrganizationEntityInterface;

interface OrganizationRepositoryInterface
{

    /**
     * @param string $clientId
     * @return OrganizationEntityInterface
     */
    public function fromClientIdentifier(string $clientId): OrganizationEntityInterface;
}
