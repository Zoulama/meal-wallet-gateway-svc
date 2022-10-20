<?php

namespace App\Http\Controllers\Quotes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Quotes\Mapper\QuoteMapperInterface;
use MealWallet\Domain\Quotes\Service\QuoteServiceInterface;

class FetchAllDataQuoteController extends Controller
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


    public function fetchAll(Request $request)
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'quotes' => $this
                        ->quoteService
                        ->fetchAll(
                            []
                        )
                        ->toArray()
                ]
            ]
        );
    }
}
