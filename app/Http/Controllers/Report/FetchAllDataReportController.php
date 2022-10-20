<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Report\Mapper\ReportMapperInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MealWallet\Domain\Report\Service\ReportServiceInterface;

class FetchAllDataReportController extends Controller
{
    /**
     * @var ReportServiceInterface
     */
    private $reportService;

    /**
     * @var ReportMapperInterface
     */
    private $reportMapper;


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
     * @param Request $request
     * @return JsonResponse
     */
    public function fetchAll(Request $request)
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'Reports' => $this
                        ->reportService
                        ->fetchAll(
                            []
                        )->toArray()
                ]
            ]
        );
    }

}
