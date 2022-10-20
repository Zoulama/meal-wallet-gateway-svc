<?php

namespace App\Http\Controllers\Offer;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MealWallet\Domain\Offer\Service\Exception\OfferServiceException;
use MealWallet\Domain\Offer\Service\OfferServiceInterface;
use MealWallet\Domain\Report\Service\Exception\ReportServiceException;

class FetchDataOfferController extends Controller
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
     * @param string $offerId
     * @return JsonResponse
     */
    public function fetch(string $offerId)
    {
        try {
            return response()->json(
                [
                    'status' => 'success',
                    'data' => [
                        'offer' => $this
                            ->offerService
                            ->fetch(
                                $offerId
                            )
                            ->toArray()
                    ]
                ]
            );
        } catch (OfferServiceException $exception) {

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
