<?php


namespace App\Http\Controllers\Report\Mapper;

use Illuminate\Http\Request;

use MealWallet\Domain\Report\Entity\ReportEntityInterface;

interface ReportMapperInterface
{
    /**
     * @param Request $request
     * @param string $accountId
     * @param array $categoryElements
     * @return ReportEntityInterface
     */
    public static function createReportFromHttpRequest(
        Request $request,
        string $accountId,
        array $categoryElements
    ): ReportEntityInterface;

}
