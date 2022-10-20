<?php


namespace App\Http\Controllers\Report;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Report\Mapper\ReportMapper;
use App\Http\Controllers\Report\Mapper\ReportMapperInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use MealWallet\Domain\Report\Service\Exception\ReportServiceException;
use MealWallet\Domain\Report\Service\ReportServiceInterface;
use MealWallet\Domain\User\Service\UserServiceInterface;

class SearchReportController extends Controller
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
     * @var UserServiceInterface
     */
    private $userService;


    /**
     * CreateReportController constructor.
     * @param ReportServiceInterface $reportService
     * @param ReportMapper $reportMapper
     * @param UserServiceInterface $userService
     */
    public function __construct(
        ReportServiceInterface  $reportService,
        ReportMapper $reportMapper,
        UserServiceInterface $userService
    )
    {
        $this->reportService = $reportService;
        $this->reportMapper = $reportMapper;
        $this->userService = $userService;

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request)
    {

        $validator = Validator::make(
            $request->json()->all(),
            [
                'lng' => ['required', 'string'],
                'lat' => ['required', 'string'],
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
            return response()->json(
                [
                    'status' => 'success',
                    'data' => [
                        'Reports' => $this
                            ->reportService
                            ->search(
                                [
                                    'lng' => $request->json()->get('lng'),
                                    'lat' => $request->json()->get('lat')
                                ]
                            )->toArray()
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
