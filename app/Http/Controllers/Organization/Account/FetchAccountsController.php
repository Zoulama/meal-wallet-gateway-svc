<?php


namespace App\Http\Controllers\Organization\Account;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MealWallet\Domain\Account\Service\AccountServiceInterface;

class FetchAccountsController extends Controller
{
    /**
     * @var AccountServiceInterface
     */
    private $accountService;

    /**
     * FetchAccountsController constructor.
     * @param AccountServiceInterface $accountService
     */
    public function __construct(AccountServiceInterface $accountService)
    {
        $this->accountService = $accountService;
    }


    public function fetchAll(
        Request $request
    ){
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'OrganizationAccounts' => $this->accountService->fetchAll(
                        [
                            'organization'=>true
                        ]
                    )->toArray()
                ]
            ]

        );
    }
}
