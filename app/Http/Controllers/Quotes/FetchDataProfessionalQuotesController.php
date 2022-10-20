<?php

namespace App\Http\Controllers\Quotes;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MealWallet\Domain\Quotes\Service\QuoteServiceInterface;

class FetchDataProfessionalQuotesController extends Controller
{
    /**
     * @var QuoteServiceInterface
     */
    private $quoteService;



    /**
     * CreateQuoteController constructor.
     * @param QuoteServiceInterface $quoteService
     */
    public function __construct(
        QuoteServiceInterface  $quoteService
    )
    {
        $this->quoteService = $quoteService;
    }

    /**
     * @param string $professionalId
     * @return JsonResponse
     */
    public function fetchAll(string $professionalId)
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'quotes' => $this
                        ->quoteService
                        ->fetchAll(
                            [
                                'professionalId' => $professionalId
                            ]
                        )
                        ->toArray()
                ]
            ]
        );
    }
}
