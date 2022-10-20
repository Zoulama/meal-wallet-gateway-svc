<?php


namespace MealWallet\Infrastructure\Api\Rest\Client\User;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\RequestOptions;
use MealWallet\Infrastructure\Api\Rest\Client\User\Exception\UserApiClientException;
use MealWallet\Infrastructure\Api\Rest\Client\User\Mapper\UserMapperInterface;
use MealWallet\Domain\User\Entity\UserEntityInterface;
use DomainException;
use MealWallet\Domain\User\Collection\UserCollectionInterface;

class UserApiGuzzleHttpClient implements UserApiClientInterface
{

    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * @var UserMapperInterface
     */
    private $userMapper;

    /**
     * UserApiGuzzleHttpClient constructor.
     * @param Client $guzzleClient
     * @param UserMapperInterface $userMapper
     */
    public function __construct(Client $guzzleClient, UserMapperInterface $userMapper)
    {
        $this->guzzleClient = $guzzleClient;
        $this->userMapper = $userMapper;
    }

    /**
     * @inheritDoc
     * @throws GuzzleException
     */
    public function create(array $userPayload) : UserEntityInterface
    {
        try {
            $response = $this->guzzleClient->post('/v1/users', [
                RequestOptions::JSON => $userPayload
            ]);

            return $this->userMapper->createUserFromApiResponse(
                $response
            );
        } catch (ClientException $e) {
            throw new UserApiClientException(
                $e->getMessage()
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function get(string $userId): UserEntityInterface
    {
        try {
            $response = $this->guzzleClient->get(
                sprintf('/v1/users/%s', $userId)
            );
        } catch (ClientException $e) {
            if($e->getResponse()->getStatusCode() == 404){
                throw new UserApiClientException(
                    sprintf('User %s not found', $userId)
                );
            }

            throw $e;
        }catch (ServerException $e){
            $decodedPayload = json_decode(
                $e->getResponse()->getBody()->getContents(), true
            );

            throw new DomainException(
                $decodedPayload['StatusDescription']
            );
        } catch (GuzzleException $e) {
        }

        return $this->userMapper->createUserFromApiResponse(
            $response
        );
    }

    /**
     * @param string $email
     * @return UserEntityInterface
     * @throws GuzzleException
     */
    public function fetchByEmail(
        string $email
    ): UserEntityInterface
    {
        try {
            $response = $this->guzzleClient->get(
                sprintf('/v1/users/email/%s', $email)
            );
        } catch (ClientException $e) {
            if($e->getResponse()->getStatusCode() == 404){
                throw new UserApiClientException(
                    sprintf('User %s not found', $email)
                );
            }

            throw $e;
        }catch (ServerException $e){
            $decodedPayload = json_decode(
                $e->getResponse()->getBody()->getContents(), true
            );

            throw new DomainException(
                $decodedPayload['StatusDescription']
            );
        }

        return $this->userMapper->createUserFromApiResponse(
            $response
        );
    }

    /**
     * @inheritDoc
     */
    public function fetchAll($filter): UserCollectionInterface
    {
        try {
            $response = $this->guzzleClient->get(
                sprintf('/v1/users')
            );

            return $this->userMapper->createUserCollectionFromApiResponse(
                $response
            );
        } catch (ClientException $e) {
            throw $e;
        }
    }

    /**
     * @param string $accountId
     * @return UserCollectionInterface
     * @throws GuzzleException
     */
    public function fetchAllAccountUsers(
        string $accountId
    ): UserCollectionInterface
    {
        try {
            $response = $this->guzzleClient->get(
                sprintf('/v1/users/accounts/%s', $accountId)
            );

            return $this->userMapper->createUserCollectionFromApiResponse(
                $response
            );
        } catch (ClientException $e) {
            throw $e;
        }
    }


}
