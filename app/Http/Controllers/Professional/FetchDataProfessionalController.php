<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MealWallet\Domain\Professional\Service\Exception\ProfessionalServiceException;
use MealWallet\Domain\Professional\Service\ProfessionalServiceInterface;

class FetchDataProfessionalController extends Controller
{
    /**
     * @var ProfessionalServiceInterface
     */
    private $professionalService;



    /**
     * CreateProfessionalController constructor.
     * @param ProfessionalServiceInterface $professionalService
     */
    public function __construct(
        ProfessionalServiceInterface  $professionalService
    )
    {
        $this->professionalService = $professionalService;
    }

    /**
     * @param string $professionalId
     * @return JsonResponse
     */
    public function fetch(string $professionalId)
    {
        try {
            return response()->json(
                [
                    'status' => 'success',
                    'data' => [
                        'professional' => $this
                            ->professionalService
                            ->fetch(
                                $professionalId
                            )
                            ->toArray()
                    ]
                ]
            );
        } catch (ProfessionalServiceException $exception) {
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
