<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MealWallet\Domain\Application\Service\ApplicationServiceInterface;
use MealWallet\Domain\Application\Service\Exception\ApplicationServiceException;

class FetchDataApplicationController extends Controller
{
    /**
     * @var ApplicationServiceInterface
     */
    private $applicationService;

    /**
     * CreateApplicationController constructor.
     * @param ApplicationServiceInterface $applicationService
     */
    public function __construct(
        ApplicationServiceInterface  $applicationService
    )
    {
        $this->applicationService = $applicationService;
    }

    /**
     * @param string $applicationId
     * @return JsonResponse
     */
    public function fetch(string $applicationId)
    {
        try {
            return response()->json(
                [
                    'status' => 'success',
                    'data' => [
                        'application' => $this
                            ->applicationService
                            ->fetch(
                                $applicationId
                            )
                            ->toArray()
                    ]
                ]
            );
        } catch (ApplicationServiceException $exception) {

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
