<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Professional\Mapper\ProfessionalMapperInterface;
use MealWallet\Domain\Professional\Service\ProfessionalServiceInterface;
use App\Http\Controllers\Professional\Mapper\ProfessionalMapper;

class UpdateProfessionalController extends Controller
{
    /**
     * @var ProfessionalServiceInterface
     */
    private $professionalService;

    /**
     * @var ProfessionalMapperInterface
     */
    private $professionalMapper;

    /**
     * CreateProfessionalController constructor.
     * @param ProfessionalServiceInterface $professionalService
     * @param ProfessionalMapper $professionalMapper
     */
    public function __construct(
        ProfessionalServiceInterface  $professionalService,
        ProfessionalMapper $professionalMapper
    )
    {
        $this->professionalService = $professionalService;
        $this->professionalMapper = $professionalMapper;
    }

    public function update(string $professionalId, Request $request)
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'professional' => $this
                        ->professionalService
                        ->update(
                            $professionalId,
                            $this->professionalMapper->updateProfessionalFromHttpRequest(
                                $request
                            )
                        )
                        ->toArray()
                ]
            ]
        );
    }
}
