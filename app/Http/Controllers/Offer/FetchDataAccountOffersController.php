<?php

namespace App\Http\Controllers\Offer;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MealWallet\Domain\Offer\Service\OfferServiceInterface;

class FetchDataAccountOffersController extends Controller
{
    /**
     * @var OfferServiceInterface
     */
    private $offerService;



    /**
     * CreateOfferController constructor.
     * @param OfferServiceInterface $offerService
     */
    public function __construct(
        OfferServiceInterface  $offerService
    )
    {
        $this->offerService = $offerService;
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
                    'offers' => $this
                        ->offerService
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
