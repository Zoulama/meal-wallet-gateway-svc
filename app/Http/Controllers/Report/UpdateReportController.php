<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Report\Mapper\ReportMapperInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use MealWallet\Domain\Category\Service\Exception\CategoryServiceException;
use MealWallet\Domain\Report\Service\Exception\ReportServiceException;
use MealWallet\Domain\Report\Service\ReportServiceInterface;
use App\Http\Controllers\Report\Mapper\ReportMapper;
use MealWallet\Domain\User\Service\Exception\UserServiceException;


class UpdateReportController extends Controller
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
     * @param ReportMapper $reportMapper
     */
    public function __construct(
        ReportServiceInterface  $reportService,
        ReportMapper $reportMapper
    )
    {
        $this->reportService = $reportService;
        $this->reportMapper = $reportMapper;
    }

    public function update(string $reportId, Request $request)
    {
        $validator = Validator::make(
            $request->json()->all(),
            [
                'status' => ['required',
                    Rule::in(
                        [
                            "pending",
                            "in progress",
                            "resolved"
                        ]
                    )
                ]
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => 0000,
                    'StatusDescription' => $validator->errors()
                ]
            );
        }


        try {

            $reportEntity = $this
                ->reportService
                ->fetch(
                    $reportId
                );

            if ($reportEntity->getStatus() === $request->json()->get('status')) {
                return response()->json(
                    [
                        'status' => 'error',
                        'StatusCode' => 2000,
                        'StatusDescription' => "same status"
                    ]
                );
            }

            return response()->json(
                [
                    'status' => 'success',
                    'data' => [
                        'Report' => $this
                            ->reportService
                            ->update(
                                $reportId,
                                $reportEntity->setStatus(
                                    $request->json()->get('status')
                                )
                            )
                            ->toArray()
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
        } catch (CategoryServiceException $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => 404,
                    'StatusDescription' => $e->getMessage()
                ], 404
            );
        }

    }

}
