<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Application\Mapper\ApplicationMapperInterface;
use MealWallet\Domain\Application\Service\ApplicationServiceInterface;
use App\Http\Controllers\Application\Mapper\ApplicationMapper;

class UpdateApplicationController extends Controller
{
    /**
     * @var ApplicationServiceInterface
     */
    private $applicationService;

    /**
     * @var ApplicationMapperInterface
     */
    private $applicationMapper;

    /**
     * CreateApplicationController constructor.
     * @param ApplicationServiceInterface $applicationService
     * @param ApplicationMapper $applicationMapper
     */
    public function __construct(
        ApplicationServiceInterface  $applicationService,
        ApplicationMapper $applicationMapper
    )
    {
        $this->applicationService = $applicationService;
        $this->applicationMapper = $applicationMapper;
    }

    public function update(string $applicationId, Request $request)
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'application' => $this
                        ->applicationService
                        ->update(
                            $applicationId,
                            $this->applicationMapper->createApplicationFromHttpRequest(
                                $request
                            )
                        )
                        ->toArray()
                ]
            ]
        );
    }
}
