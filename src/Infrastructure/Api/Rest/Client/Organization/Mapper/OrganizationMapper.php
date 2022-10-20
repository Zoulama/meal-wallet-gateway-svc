<?php


namespace MealWallet\Infrastructure\Api\Rest\Client\Organization\Mapper;


use MealWallet\Domain\Organization\Entity\OrganizationEntityInterface;
use Psr\Http\Message\ResponseInterface;
use MealWallet\Domain\Organization\Collection\OrganizationCollection;
use MealWallet\Domain\Organization\Collection\OrganizationCollectionInterface;
use MealWallet\Domain\Organization\Entity\OrganizationEntity;

class OrganizationMapper implements OrganizationMapperInterface
{

    /**
     * @param ResponseInterface $response
     * @return OrganizationEntityInterface
     */
    public function createUserFromApiResponse(
        ResponseInterface $response
    ):OrganizationEntityInterface
    {
        $data = json_decode(
            $response->getBody()->getContents(),
            true
        );

        return OrganizationEntity::fromArray(
            $data['data']['kibaroOrganizations']
        );
    }

    /**
     * @inheritDoc
     */
    public function createOrganizationCollectionFromApiResponse(
        ResponseInterface $response
    ): OrganizationCollectionInterface{
        $data = json_decode(
            $response->getBody()->getContents(),
            true
        );

        return OrganizationCollection::fromArray(
            $data['data']['kibaroOrganizations']
        );
    }
}
