<?php


namespace MealWallet\Infrastructure\Api\Rest\Client\Organization\Mapper;


use MealWallet\Domain\Organization\Entity\OrganizationEntityInterface;
use Psr\Http\Message\ResponseInterface;
use MealWallet\Domain\Organization\Collection\OrganizationCollectionInterface;

interface OrganizationMapperInterface
{

    /**
     * @param ResponseInterface $response
     * @return OrganizationEntityInterface
     */
    public function createUserFromApiResponse(
        ResponseInterface $response
    ):OrganizationEntityInterface;

    /**
     * @param ResponseInterface $response
     * @return OrganizationCollectionInterface
     */
    public function createOrganizationCollectionFromApiResponse(
        ResponseInterface $response
    ):OrganizationCollectionInterface;
}
