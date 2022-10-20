<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MealWallet\Domain\Application\Service\ApplicationServiceInterface;

class FetchDataAccountApplicationsController extends Controller
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
     * @param string $accountId
     * @return JsonResponse
     */
    public function fetchAll(string $accountId)
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'applications' => $this
                        ->applicationService
                        ->fetchAll(
                            [
                                'accountId' => $accountId
                            ]
                        )
                        ->toArray()
                ]
            ]
        );
    }
}
