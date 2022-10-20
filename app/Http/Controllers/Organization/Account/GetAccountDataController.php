<?php


namespace App\Http\Controllers\Organization\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MealWallet\Domain\Account\Service\AccountServiceInterface;

class GetAccountDataController extends Controller
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

    /**
     * @param string $organizationId
     * @return JsonResponse
     */
    public function fetch(
        string $organizationId
    ){
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'OrganizationAccount' => $this->accountService->fetchAllAccountOrganizations(
                        $organizationId
                    )->toArray()
                ]
            ]

        );
    }
}
