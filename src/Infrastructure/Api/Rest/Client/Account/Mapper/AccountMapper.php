<?php


namespace MealWallet\Infrastructure\Api\Rest\Client\Account\Mapper;


use Psr\Http\Message\ResponseInterface;
use MealWallet\Domain\Account\Entity\AccountEntityInterface;
use MealWallet\Domain\Account\Entity\AccountEntity;
use MealWallet\Domain\Account\Collection\AccountCollection;
use MealWallet\Domain\Account\Collection\AccountCollectionInterface;

class AccountMapper implements AccountMapperInterface
{

    /**
     * @inheritDoc
     */
    public function createAccountFromApiResponse(ResponseInterface $response): AccountEntityInterface
    {

        $accountData = json_decode(
            $response->getBody()->getContents(),
            true
        );

        return new AccountEntity(
            $accountData['data']['kibaroAccount']['accountId'] ?? null,
            $accountData['data']['kibaroAccount']['name'],
            $accountData['data']['kibaroAccount']['address'],
            $accountData['data']['kibaroAccount']['email'],
            $accountData['data']['kibaroAccount']['phoneNumber'],
            $accountData['data']['kibaroAccount']['mobileNumber'],
            null,
            $accountData['data']['kibaroAccount']['organizationId'],
            $accountData['data']['kibaroAccount']['createdAt']

        );
    }

    /**
     * @inheritDoc
     */
    public function createAccountCollectionFromApiResponse(
        ResponseInterface $response
    ): AccountCollectionInterface
    {
        $data = json_decode(
            $response->getBody()->getContents(),
            true
        );

        return AccountCollection::fromArray(
            $data['data']['kibaroAccounts']
        );
    }
}
