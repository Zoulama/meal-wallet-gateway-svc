<?php


namespace MealWallet\Infrastructure\Api\Rest\Client\Account;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use MealWallet\Domain\User\Collection\UserCollectionInterface;
use MealWallet\Infrastructure\Api\Rest\Client\Account\Exception\AccountApiClientException;
use MealWallet\Infrastructure\Api\Rest\Client\Account\Mapper\AccountMapperInterface;
use MealWallet\Domain\Account\Entity\AccountEntityInterface;
use MealWallet\Domain\Account\Collection\AccountCollectionInterface;

class AccountApiGuzzleHttpClient implements AccountApiClientInterface
{
    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * @var AccountMapperInterface
     */
    private $accountMapper;

    /**
     * AccountApiGuzzleHttpClient constructor.
     * @param Client $guzzleClient
     * @param AccountMapperInterface $accountMapper
     */
    public function __construct(Client $guzzleClient, AccountMapperInterface $accountMapper)
    {
        $this->guzzleClient = $guzzleClient;
        $this->accountMapper = $accountMapper;
    }

    /**
     * @param array $accountPayload
     * @return AccountEntityInterface
     */
    public function create(array $accountPayload): AccountEntityInterface
    {

        try {
            $response = $this->guzzleClient->post('/v1/accounts', [
                RequestOptions::JSON => $accountPayload
            ]);

            return $this->accountMapper->createAccountFromApiResponse(
                $response
            );
        } catch (ClientException $e) {
            throw new AccountApiClientException(
                $e->getMessage()
            );
        } catch (GuzzleException $e) {
            throw new AccountApiClientException(
                $e->getMessage()
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function fetchAll(array $filter): AccountCollectionInterface
    {
        $response = $this->guzzleClient->get('/v1/accounts', [
            RequestOptions::QUERY => $filter
        ]);

        return $this
            ->accountMapper
            ->createAccountCollectionFromApiResponse(
                $response
            );
    }

    /**
     * @inheritDoc
     */
    public function update(string $accountId, array $data): AccountEntityInterface
    {
        try {
            $response = $this->guzzleClient->patch(sprintf('/v1/accounts/%s', $accountId), [
                RequestOptions::JSON => $data
            ]);

            return $this->accountMapper->createAccountFromApiResponse(
                $response
            );
        }  catch (ClientException $e) {
            throw new AccountApiClientException(
                $e->getMessage()
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function fetch(string $accountId): AccountEntityInterface
    {
        try {
            $response = $this->guzzleClient->get(
                sprintf('/v1/accounts/%s', $accountId)
            );

            return $this->accountMapper->createAccountFromApiResponse(
                $response
            );
        }  catch (ClientException $e) {
            throw new AccountApiClientException(
                $e->getMessage()
            );
        }

    }


}
