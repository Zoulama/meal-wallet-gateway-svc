<?php


namespace App\Http\Controllers\Account\Mapper;


use Carbon\Carbon;
use Illuminate\Http\Request;
use MealWallet\Domain\Account\Entity\AccountEntity;
use MealWallet\Domain\Account\Entity\AccountEntityInterface;

class AccountMapper implements AccountMapperInterface
{

    public static function createAccountFromHttpRequest(Request $request): AccountEntityInterface
    {
        $payload =  $request->json()->all();
        return AccountEntity::fromArray(
           [
               'name'   => $payload['name'],
               'address' => $payload['address'],
               'email'  => $payload['email'],
               'phoneNumber'  => $payload['phoneNumber'],
               'mobileNumber' => $payload['mobileNumber'],
               "userPassword" => $payload['userPassword'],
               'organizationId' => $request->get('ApiConsumer')->getOrganizations()[0],
               'createdAt' => Carbon::now()->format('d/m/Y H:i:s')
           ]
        );
    }
}
