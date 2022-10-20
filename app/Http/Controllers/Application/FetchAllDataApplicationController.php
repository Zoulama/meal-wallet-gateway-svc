<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Application\Mapper\ApplicationMapperInterface;
use MealWallet\Domain\Application\Service\ApplicationServiceInterface;

class FetchAllDataApplicationController extends Controller
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


    public function fetchAll(Request $request)
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'applications' => $this
                        ->applicationService
                        ->fetchAll(
                            []
                        )
                        ->toArray()
                ]
            ]
        );
    }
}
