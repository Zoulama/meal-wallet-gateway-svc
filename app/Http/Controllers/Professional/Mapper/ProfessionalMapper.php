<?php


namespace App\Http\Controllers\Professional\Mapper;


use Illuminate\Http\Request;
use MealWallet\Domain\Professional\Entity\ProfessionalEntityInterface;
use MealWallet\Domain\Professional\Entity\ProfessionalEntity;

class ProfessionalMapper implements ProfessionalMapperInterface
{
    /**
     * @inheritDoc
     */
    public static function createProfessionalFromHttpRequest(
        Request $request,
        string $accountId
    ): ProfessionalEntityInterface
    {
        $payload = $request->json()->all();
        return ProfessionalEntity::fromArray([
                "companyName" => $payload['companyName'],
                "email" => $payload['email'],
                "mobileNumber" => $payload['mobileNumber'],
                "activity" => $payload['activity'],
                "accountId" => $accountId,
                "address" => $payload['address'],
                "organizationId" => $request->get('ApiConsumer')->getOrganizations()[0],
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public static function updateProfessionalFromHttpRequest(
        Request $request
    ): ProfessionalEntityInterface {

        $payload = $request->json()->all();

        return ProfessionalEntity::fromArray([
                "companyName" => $payload['companyName'],
                "email" => $payload['email'],
                "mobileNumber" => $payload['mobileNumber'],
                "activity" => $payload['activity'],
                "address" => $payload['address'],
                "organizationId" => $request->get('ApiConsumer')->getOrganizations()[0],
            ]
        );
    }
}
