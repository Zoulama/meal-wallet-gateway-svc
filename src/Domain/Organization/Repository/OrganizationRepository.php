<?php


namespace MealWallet\Domain\Organization\Repository;


use MealWallet\Infrastructure\Api\Rest\Client\Organization\OrganizationApiClientInterface;
use MealWallet\Domain\Organization\Entity\OrganizationEntityInterface;

class OrganizationRepository implements OrganizationRepositoryInterface
{

    /**
     * @var OrganizationApiClientInterface
     */
    private $organizationApiClient;

    /**
     * OrganizationRepository constructor.
     * @param OrganizationApiClientInterface $organizationApiClient
     */
    public function __construct(OrganizationApiClientInterface $organizationApiClient)
    {
        $this->organizationApiClient = $organizationApiClient;
    }

    /**
     * @inheritDoc
     */
    public function fromClientIdentifier(string $clientId): OrganizationEntityInterface
    {
        return current($this->organizationApiClient
            ->fetchAll(
                [
                    'clientId' => $clientId
                ]
            )->getCollection());
    }
}
