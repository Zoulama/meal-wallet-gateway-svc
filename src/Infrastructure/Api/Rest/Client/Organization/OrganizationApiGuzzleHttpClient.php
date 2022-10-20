<?php


namespace MealWallet\Infrastructure\Api\Rest\Client\Organization;


use DomainException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\RequestOptions;
use MealWallet\Domain\Organization\Entity\OrganizationEntityInterface;
use MealWallet\Infrastructure\Api\Rest\Client\Organization\Exception\OrganizationApiClientException;
use MealWallet\Infrastructure\Api\Rest\Client\Organization\Mapper\OrganizationMapperInterface;
use MealWallet\Domain\Organization\Collection\OrganizationCollectionInterface;
use MealWallet\Infrastructure\Api\Rest\Client\User\Exception\UserApiClientException;

class OrganizationApiGuzzleHttpClient implements OrganizationApiClientInterface
{
    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * @var OrganizationMapperInterface
     */
    private $organizationMapper;

    /**
     * OrganizationApiGuzzleHttpClient constructor.
     * @param Client $guzzleClient
     * @param OrganizationMapperInterface $organizationMapper
     */
    public function __construct(Client $guzzleClient, OrganizationMapperInterface $organizationMapper)
    {
        $this->guzzleClient = $guzzleClient;
        $this->organizationMapper = $organizationMapper;
    }

    /**
     * @param array $userPayload
     * @return mixed
     * @throws GuzzleException
     */
    public function create(
        array $userPayload
    ): OrganizationEntityInterface
    {
        $response = $this->guzzleClient->post('/v1/organizations', [
            RequestOptions::QUERY => $userPayload
        ]);

        return $this
            ->organizationMapper
            ->createUserFromApiResponse(
                $response
            );
    }

    /**
     * @param string $organizationId
     * @return OrganizationEntityInterface
     * @throws OrganizationApiClientException
     * @throws GuzzleException
     */
    public function fetch(string $organizationId): OrganizationEntityInterface
    {
        try {
            $response = $this->guzzleClient->get(
                sprintf('/v1/organizations/%s', $organizationId)
            );
        } catch (ClientException $e) {
            if($e->getResponse()->getStatusCode() == 404){
                throw new UserApiClientException(
                    sprintf('User %s not found', $organizationId)
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

        return $this->organizationMapper->createUserFromApiResponse(
            $response
        );
    }

    /**
     * @inheritDoc
     * @throws GuzzleException
     */
    public function fetchAll(array $filters): OrganizationCollectionInterface
    {
        $response = $this->guzzleClient->get('/v1/organizations', [
            RequestOptions::QUERY => $filters
        ]);

        return $this
            ->organizationMapper
            ->createOrganizationCollectionFromApiResponse(
                $response
            );
    }
}
