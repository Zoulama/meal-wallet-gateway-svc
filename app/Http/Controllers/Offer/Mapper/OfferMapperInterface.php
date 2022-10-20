<?php


namespace App\Http\Controllers\Offer\Mapper;

use Illuminate\Http\Request;

use MealWallet\Domain\Offer\Entity\OfferEntityInterface;

interface OfferMapperInterface
{
    /**
     * @param Request $request
     * @return OfferEntityInterface
     */
    public static function createOfferFromHttpRequest(
        Request $request
    ): OfferEntityInterface;
}
