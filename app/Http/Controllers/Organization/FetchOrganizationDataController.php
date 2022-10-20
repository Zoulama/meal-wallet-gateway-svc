<?php


namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MealWallet\Domain\Organization\Service\OrganizationService;
use MealWallet\Domain\Organization\Service\OrganizationServiceInterface;

class FetchOrganizationDataController extends Controller
{

    /**
     * @var OrganizationServiceInterface
     */
    private $kibaroOrganizationService;

    /**
     * FetchOrganizationDataController constructor.
     * @param OrganizationService $kibaroOrganizationService
     */
    public function __construct(OrganizationService $kibaroOrganizationService)
    {
        $this->kibaroOrganizationService = $kibaroOrganizationService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function fetchData(
        Request $request
    ){
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'kibaroOrganization' => $this
                        ->kibaroOrganizationService
                        ->fromClientIdentifier(
                            $request->get(
                                'clientIdentifier',
                                $request->get('ApiConsumer')->getClientId()
                                )
                        )->toArray()
                ]
            ]
        );
    }
}
