<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Report\Mapper\ReportMapperInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use MealWallet\Domain\Category\Service\CategoryServiceInterface;
use MealWallet\Domain\Category\Service\Exception\CategoryServiceException;
use MealWallet\Domain\Report\Service\Exception\ReportServiceException;
use MealWallet\Domain\Report\Service\ReportServiceInterface;
use App\Http\Controllers\Report\Mapper\ReportMapper;
use MealWallet\Domain\User\Service\Exception\UserServiceException;
use MealWallet\Domain\User\Service\UserServiceInterface;

class CreateReportController extends Controller
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
     * @var CategoryServiceInterface
     */
    private $categoryService;

    /**
     * CreateReportController constructor.
     * @param ReportServiceInterface $reportService
     * @param ReportMapper $reportMapper
     * @param UserServiceInterface $userService
     * @param CategoryServiceInterface $categoryService
     */
    public function __construct(
        ReportServiceInterface  $reportService,
        ReportMapper $reportMapper,
        UserServiceInterface $userService,
        CategoryServiceInterface $categoryService
    )
    {
        $this->reportService = $reportService;
        $this->reportMapper = $reportMapper;
        $this->userService = $userService;
        $this->categoryService = $categoryService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->json()->all(),
            [
                'userId' => ['required', 'string'],
                'subCategoryId' => ['required', 'string'],
                'alertLevel'  => ['required', 'string'],
                'description' => ['required', 'string'],
               // 'accountId' => ['required', 'string'],
                'address' => ['required', 'array'],
                'location' => ['required', 'array', 'min:1'],
                //'createdAt' => ['required', 'string']
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

      /*  try {
            $user = $this->userService->fetch( $request->json()->get('userId'));
        } catch (UserNotFoundException $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => 404,
                    'StatusDescription' => $e->getMessage()
                ], 404
            );
        }*/

        try {
            $user = $this->userService->fetch($request->json()->get('userId'));
            return response()->json(
                [
                    'status' => 'success',
                    'data' => [
                        'Report' => $this
                            ->reportService
                            ->create(
                                $this->reportMapper->createReportFromHttpRequest(
                                    $request,
                                    $user->getAccountId(),
                                    $this->categoryService->fetchCategoryReportCreation(
                                        $request->json()->get('subCategoryId')
                                    )
                                )
                            )->toArray()
                    ]
                ]
            );
        } catch (UserServiceException $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => 404,
                    'StatusDescription' => $e->getMessage()
                ], 404
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
