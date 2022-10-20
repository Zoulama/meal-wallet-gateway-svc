<?php


namespace App\Http\Controllers\Account;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MealWallet\Domain\Account\Service\AccountService;
use MealWallet\Domain\Account\Service\AccountServiceInterface;
use MealWallet\Domain\Account\Service\Exception\AccountServiceException;

class FetchAccountDataController extends Controller
{
    /**
     * @var AccountServiceInterface
     */
    private $accountService;

    /**
     * FetchUserAccountsController constructor.
     * @param AccountService $accountService
     */
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function fetch($accountId, Request $request)
    {
        try {
            return response()->json(
                [
                    'status' => 'success',
                    'data' => [
                        'kibarotAccount' => $this->accountService->fetchWithAccountId(
                            $accountId
                        )->toArray()
                    ]
                ]
            );
        } catch (AccountServiceException $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode'=> 0,
                    'StatusDescription'=> $e->getMessage()
                ]
            );
        }
    }
}
