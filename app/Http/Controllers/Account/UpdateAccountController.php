<?php


namespace App\Http\Controllers\Account;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MealWallet\Domain\Account\Service\AccountService;
use MealWallet\Domain\Account\Service\AccountServiceInterface;

class UpdateAccountController extends Controller
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

    public function update(
        $userId,
        $accountId,
        Request $request){

        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'kibarotAccount' => $this->accountService->updateWithUserAndAccountAndOrganizations(

                        $accountId,
                        $request->get('ApiConsumer')->getOrganizations(),
                        [
                            'balance' => $request->json()->get('balance')
                        ]
                    )->toArray()
                ]
            ]

        );
    }
}
