<?php

namespace App\Http\Controllers\Offer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Offer\Mapper\OfferMapperInterface;
use MealWallet\Domain\Offer\Service\OfferServiceInterface;

class FetchAllDataOfferController extends Controller
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


    public function fetchAll(Request $request)
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'offers' => $this
                        ->offerService
                        ->fetchAll(
                            []
                        )
                        ->toArray()
                ]
            ]
        );
    }
}
