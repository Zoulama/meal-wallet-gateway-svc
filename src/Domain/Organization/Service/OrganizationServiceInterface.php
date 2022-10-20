<?php


namespace MealWallet\Domain\Organization\Service;


use MealWallet\Domain\Organization\Entity\OrganizationEntityInterface;

interface OrganizationServiceInterface
{
    /**
     * @param string $clientId
     * @return OrganizationEntityInterface
     */
    public function fromClientIdentifier(string $clientId): OrganizationEntityInterface;
}
