<?php


namespace App\Http\Controllers\Report;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use MealWallet\Domain\Report\Service\ReportServiceInterface;

class FetchAllDataByAccountReportController extends Controller
{
    /**
     * @var ReportServiceInterface
     */
    private $reportService;


    /**
     * CreateReportController constructor.
     * @param ReportServiceInterface $reportService
     */
    public function __construct(
        ReportServiceInterface  $reportService
    )
    {
        $this->reportService = $reportService;
    }

    /**
     * @param string $accountId
     * @return JsonResponse
     */
    public function fetchAll(string $accountId)
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'Reports' => $this
                        ->reportService
                        ->fetchAllByAccount(
                            $accountId
                        )
                        ->toArray()
                ]
            ]
        );
    }

}
