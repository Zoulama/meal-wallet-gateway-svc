<?php


namespace App\Http\Controllers\Offer\Mapper;


use Illuminate\Http\Request;
use MealWallet\Domain\Offer\Entity\OfferEntity;
use MealWallet\Domain\Offer\Entity\OfferEntityInterface;

class OfferMapper implements OfferMapperInterface
{
    /**
     * @param Request $request
     * @return OfferEntityInterface
     */
    public static function createOfferFromHttpRequest(
        Request $request
    ): OfferEntityInterface
    {
        $payload = $request->json()->all();
        return OfferEntity::fromArray([
                "userId" => $payload['userId'],
                "description" => $payload['description'],
                "reportId" => $payload['reportId'],
                "organizationId" => $request->get('ApiConsumer')->getOrganizations()[0],
                "status" => "Pending",

            ]
        );
    }
}
