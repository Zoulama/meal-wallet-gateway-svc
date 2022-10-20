<?php


namespace App\Http\Controllers\Report;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MealWallet\Domain\Report\Service\Exception\ReportServiceException;
use MealWallet\Domain\Report\Service\ReportServiceInterface;

class FetchAllDataByUserReportController extends Controller
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
     * @param Request $request
     * @param string $userId
     * @return JsonResponse
     */
    public function fetchAll(Request $request, string $userId)
    {
        try{

            $filters = [];

            if ($request->has('pageNumber'))
                $filters['number'] = $request->get('pageNumber');

            if ($request->has('limit'))
                $filters['limit'] = $request->get('limit');

            $reportCollection = $this
                ->reportService
                ->fetchAllByUser(
                    $userId,
                    $filters
                );

            return response()->json(
                [
                    'status' => 'success',
                    'data' => [
                        'Reports' => $this
                            ->reportService
                            ->fetchReportWithComments(
                                $reportCollection
                            )
                    ]
                ]
            );

        } catch (ReportServiceException $exception) {

            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => 404,
                    'StatusDescription' => $exception->getMessage()
                ], 404
            );
        }



    }
}
