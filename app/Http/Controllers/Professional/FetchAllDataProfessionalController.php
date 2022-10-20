<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Professional\Mapper\ProfessionalMapperInterface;
use MealWallet\Domain\Professional\Service\ProfessionalServiceInterface;

class FetchAllDataProfessionalController extends Controller
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


    public function fetchAll(Request $request)
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'professionals' => $this
                        ->professionalService
                        ->fetchAll(
                            []
                        )
                        ->toArray()
                ]
            ]
        );
    }
}
