<?php


namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MealWallet\Domain\Account\Service\AccountService;
use MealWallet\Domain\Account\Service\AccountServiceInterface;
use MealWallet\Domain\Account\Service\Exception\AccountServiceException;

class FetchUserAccountsController extends Controller
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

    public function fetch(Request $request)
    {
        try{
            return response()->json(
                [
                    'status' => 'success',
                    'data' => [
                        'kibarotAccounts' => $this->accountService->fetchAllAccountOrganizations(
                            $request->get('ApiConsumer')->getOrganizations()[0]
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
