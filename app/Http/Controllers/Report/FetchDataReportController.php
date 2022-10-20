<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Report\Mapper\ReportMapperInterface;
use Illuminate\Http\JsonResponse;
use MealWallet\Domain\Comment\Service\CommentServiceInterface;
use MealWallet\Domain\Report\Service\Exception\ReportServiceException;
use MealWallet\Domain\Report\Service\ReportServiceInterface;

class FetchDataReportController extends Controller
{
    /**
     * @var ReportServiceInterface
     */
    private $reportService;

    /**
     * @var CommentServiceInterface
     */
    private $commentService;


    /**
     * CreateReportController constructor.
     * @param ReportServiceInterface $reportService
     * @param CommentServiceInterface $commentService
     */
    public function __construct(
        ReportServiceInterface $reportService,
        CommentServiceInterface $commentService
    )
    {
        $this->reportService = $reportService;
        $this->commentService = $commentService;
    }

    /**
     * @param string $reportId
     * @return JsonResponse
     */
    public function fetch(string $reportId)
    {
        try {

            $reportEntity = $this
                ->reportService
                ->fetch(
                    $reportId
                );

            $commentCollection = $this
                ->commentService
                ->fetchAllByReport($reportId);

            $reportEntity->setCommentList(
                [
                    'comments' => $commentCollection->toArray(),
                    'numberOfComments' => collect($commentCollection->toArray())->count()
                ]
            );

            return response()->json(
                [
                    'status' => 'success',
                    'data' => [
                        'Report' => $reportEntity->toArray()
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
