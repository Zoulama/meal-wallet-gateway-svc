<?php


namespace App\Http\Controllers\Application\Mapper;


use Illuminate\Http\Request;
use MealWallet\Domain\Application\Entity\ApplicationEntityInterface;
use MealWallet\Domain\Application\Entity\ApplicationEntity;

class ApplicationMapper implements ApplicationMapperInterface
{
    /**
     * @param Request $request
     * @return ApplicationEntityInterface
     */
    public static function createApplicationFromHttpRequest(
        Request $request
    ): ApplicationEntityInterface
    {
        $payload = $request->json()->all();
        return ApplicationEntity::fromArray([
                "offerId" => $payload['offerId'],
                "professionalId" => $payload['professionalId'],
                "organizationId" => $request->get('ApiConsumer')->getOrganizations()[0],
                "quoteId" => $payload['quoteId'],

            ]
        );
    }
}
