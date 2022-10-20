<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Professional\Mapper\ProfessionalMapperInterface;
use MealWallet\Domain\Professional\Service\ProfessionalServiceInterface;
use App\Http\Controllers\Professional\Mapper\ProfessionalMapper;
use Ramsey\Uuid\Uuid;

class CreateProfessionalController extends Controller
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

    public function create(Request $request)
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'professional' => $this
                        ->professionalService
                        ->create(
                            $this->professionalMapper::createProfessionalFromHttpRequest(
                                $request,
                                Uuid::uuid4()->toString()
                            )
                        )
                        ->toArray()
                ]
            ]
        );
    }
}
