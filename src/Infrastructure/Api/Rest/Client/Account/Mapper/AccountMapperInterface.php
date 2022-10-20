<?php


namespace MealWallet\Infrastructure\Api\Rest\Client\Account\Mapper;


use Psr\Http\Message\ResponseInterface;
use MealWallet\Domain\Account\Entity\AccountEntityInterface;
use MealWallet\Domain\Account\Collection\AccountCollectionInterface;

interface AccountMapperInterface
{

    /**
     * @param ResponseInterface $response
     * @return AccountEntityInterface
     */
    public function createAccountFromApiResponse(
        ResponseInterface $response
    ):AccountEntityInterface;

    /**
     * @param ResponseInterface $response
     * @return AccountCollectionInterface
     */
    public function createAccountCollectionFromApiResponse(
        ResponseInterface $response
    ):AccountCollectionInterface;
}
