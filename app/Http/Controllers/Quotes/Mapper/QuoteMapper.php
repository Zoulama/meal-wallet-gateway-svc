<?php


namespace App\Http\Controllers\Quotes\Mapper;


use Illuminate\Http\Request;
use MealWallet\Domain\Quotes\Entity\QuoteEntityInterface;
use MealWallet\Domain\Quotes\Entity\QuoteEntity;

class QuoteMapper implements QuoteMapperInterface
{
    /**
     * @param Request $request
     * @return QuoteEntityInterface
     */
    public static function createQuoteFromHttpRequest(
        Request $request
    ): QuoteEntityInterface
    {
        $payload = $request->json()->all();
        return QuoteEntity::fromArray([
                "professionalId" => $payload['professionalId'],
                "vat" => $payload['vat'],
                "totalAmountWithoutVat" => $payload['totalAmountWithoutVat'],
                "totalAmountWithVat" => $payload['totalAmountWithVat'],
                "items" => $payload['items']
            ]
        );
    }
}
