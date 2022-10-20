<?php


namespace App\Http\Controllers\Organization\Account;


use App\Http\Controllers\Account\Mapper\AccountMapper;
use App\Http\Controllers\Account\Mapper\AccountMapperInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MealWallet\Domain\Account\Service\AccountService;
use MealWallet\Domain\Account\Service\AccountServiceInterface;

class CreateAccountController extends Controller
{

    /**
     * @var AccountServiceInterface
     */
    private $accountService;

    /**
     * @var AccountMapperInterface
     */
    private $accountMapper;


    public function __construct(
        AccountService $accountService,
        AccountMapper $accountMapper)
    {
        $this->accountService = $accountService;
        $this->accountMapper = $accountMapper;
    }

    public function create(
        Request $request
    ){
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'kibaroAccount' => $this->accountService->createOrganizationAccount(
                        $this->accountMapper::createAccountFromHttpRequest(
                            $request
                        ),
                        $request->get('ApiConsumer')->getOrganizations()
                    )->toArray()
                ]
            ]

        );
    }
}
