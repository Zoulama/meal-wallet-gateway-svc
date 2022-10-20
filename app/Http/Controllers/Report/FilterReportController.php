<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Report\Mapper\ReportMapperInterface;
use Illuminate\Http\Request;
use MealWallet\Domain\Report\Service\ReportServiceInterface;

class FilterReportController extends Controller
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


    public function filterReport(Request $request)
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'Reports' => $this
                        ->reportService
                        ->filterReport(
                            $request->query()
                        )->toArray()
                ]
            ]
        );
    }

}
