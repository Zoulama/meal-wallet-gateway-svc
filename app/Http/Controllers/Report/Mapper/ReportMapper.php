<?php


namespace App\Http\Controllers\Report\Mapper;


use Illuminate\Http\Request;
use MealWallet\Domain\Report\Entity\ReportEntityInterface;
use MealWallet\Domain\Report\Entity\ReportEntity;

class ReportMapper implements ReportMapperInterface
{
    /**
     * @param Request $request
     * @param string $accountId
     * @param $categoryElements
     * @return ReportEntityInterface
     */
    public static function createReportFromHttpRequest(
        Request $request,
        string $accountId,
        array $categoryElements
    ): ReportEntityInterface
    {
        $payload = $request->json()->all();
        $payload['location']['type']= $payload['location']['type'] ??  "Point";
        return ReportEntity::fromArray([
                "userId" => $payload['userId'],
                "subCategoryId" => $payload['subCategoryId'],
                "category"      => $categoryElements,
                "alertLevel"    => $payload['alertLevel'],
                "description"    => $payload['description'],
                "status" => $payload['status'] ?? "Pending",
                "organizationId" => $request->get('ApiConsumer')->getOrganizations()[0],
                "accountId" => $accountId,
                "address" => $payload['address'],
                "location" => $payload['location'],
            ]
        );
    }
}
