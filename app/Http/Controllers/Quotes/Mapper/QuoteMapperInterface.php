<?php


namespace App\Http\Controllers\Quotes\Mapper;

use Illuminate\Http\Request;

use MealWallet\Domain\Quotes\Entity\QuoteEntityInterface;

interface QuoteMapperInterface
{
    /**
     * @param Request $request
     * @return QuoteEntityInterface
     */
    public static function createQuoteFromHttpRequest(
        Request $request
    ): QuoteEntityInterface;
}
