<?php

namespace App\Http\Controllers\Quotes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Quotes\Mapper\QuoteMapperInterface;
use MealWallet\Domain\Quotes\Service\QuoteServiceInterface;
use App\Http\Controllers\Quotes\Mapper\QuoteMapper;

class CreateQuoteController extends Controller
{
    /**
     * @var QuoteServiceInterface
     */
    private $quoteService;

    /**
     * @var QuoteMapperInterface
     */
    private $quoteMapper;

    /**
     * CreateQuoteController constructor.
     * @param QuoteServiceInterface $quoteService
     * @param QuoteMapper $quoteMapper
     */
    public function __construct(
        QuoteServiceInterface  $quoteService,
        QuoteMapper $quoteMapper
    )
    {
        $this->quoteService = $quoteService;
        $this->quoteMapper = $quoteMapper;
    }

    public function create(Request $request)
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'quote' => $this
                        ->quoteService
                        ->create(
                            $this->quoteMapper->createQuoteFromHttpRequest(
                                $request
                            )
                        )
                        ->toArray()
                ]
            ]
        );
    }
}
