<?php

namespace App\Http\Controllers\Offer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Offer\Mapper\OfferMapperInterface;
use MealWallet\Domain\Offer\Service\OfferServiceInterface;
use App\Http\Controllers\Offer\Mapper\OfferMapper;

class UpdateOfferController extends Controller
{
    /**
     * @var OfferServiceInterface
     */
    private $offerService;

    /**
     * @var OfferMapperInterface
     */
    private $offerMapper;

    /**
     * CreateOfferController constructor.
     * @param OfferServiceInterface $offerService
     * @param OfferMapper $offerMapper
     */
    public function __construct(
        OfferServiceInterface  $offerService,
        OfferMapper $offerMapper
    )
    {
        $this->offerService = $offerService;
        $this->offerMapper = $offerMapper;
    }

    public function update(string $offerId, Request $request)
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'offer' => $this
                        ->offerService
                        ->update(
                            $offerId,
                            $this->offerMapper->createOfferFromHttpRequest(
                                $request
                            )
                        )
                        ->toArray()
                ]
            ]
        );
    }
}
