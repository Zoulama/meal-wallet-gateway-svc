<?php

namespace App\Http\Controllers\Quotes;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MealWallet\Domain\Quotes\Service\Exception\QuoteServiceException;
use MealWallet\Domain\Quotes\Service\QuoteServiceInterface;
use MealWallet\Domain\Report\Service\Exception\ReportServiceException;

class FetchDataQuoteController extends Controller
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
     * @param string $quoteId
     * @return JsonResponse
     */
    public function fetch(string $quoteId)
    {
        try {
            return response()->json(
                [
                    'status' => 'success',
                    'data' => [
                        'quote' => $this
                            ->quoteService
                            ->fetch(
                                $quoteId
                            )
                            ->toArray()
                    ]
                ]
            );
        }  catch (QuoteServiceException $exception) {

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
