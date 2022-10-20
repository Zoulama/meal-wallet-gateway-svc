<?php

namespace MealWallet\Domain\User\Entity;
use MealWallet\Domain\User\Entity\AddressEntityInterface;
use MealWallet\Infrastructure\User\Model\User;
use Ramsey\Uuid;

class UserEntity implements UserEntityInterface
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private  $mobileNumber;

    /**
     * @var string
     */
    private $organizationId;

    /**
     * @var string
     */
    private $accountId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $status;

    /**
     * UserEntity constructor.
     * @param string|null $userId
     * @param string $email
     * @param string $mobileNumber
     * @param string $organizationId
     * @param string|null $accountId
     * @param string|null $status
     */
    public function __construct(
        ?string $userId,
        ?string $email,
        ?string $mobileNumber,
        ?string $organizationId,
        ?string $accountId,
        ?string $status= null
    ){
        $this->userId = $userId;
        $this->email = $email;
        $this->mobileNumber = $mobileNumber;
        $this->organizationId = $organizationId;
        $this->accountId = $accountId;
        $this->status = $status;
    }

    /**
     * @inheritDoc
     */
    public static function fromArray(
        array $data
    ): UserEntityInterface{
        return new static(
            $data['userId'] ?? null,
            $data['email'] ?? null,
            $data['mobileNumber'] ?? null,
            $data['organizationId'] ?? null,
            $data['accountId'] ?? null,
            $data['status'] ?? null
        );
    }

    /**
     * @param User $user
     * @return UserEntityInterface
     */
   /* public static function fromModel(
        User $user
    ): UserEntityInterface
    {
        return $user->toArray();
        return new static(
            $user->getUserId(),
            $user->getLastName(),
            $user->getFirstName(),
            $user->getEmail(),
            $user->getMobileNumber(),
            $user->getUserName(),
            $user->getOrganizationId(),

        );
    }*/

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $userData =  [
            'userId'=> $this->userId,
            'email' => $this->email,
            'mobileNumber' => $this->mobileNumber,
            'organizationId' => $this->organizationId,
            'accountId' => $this->accountId,
            'status'=> $this->status
        ];

        return array_filter(
            $userData,
            function ($propertyValue, $propertyName){
                return $propertyValue !== null;
            },
            ARRAY_FILTER_USE_BOTH
        );
    }

    /**
     * @return string
     */
    public function getUserId() : string
    {
        return $this->userId;
    }


    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getMobileNumber(): string
    {
        return $this->mobileNumber;
    }


    /**
     * @return string
     */
    public function getOrganizationId(): string
    {
        return $this->organizationId;
    }

    /**
     * @inheritDoc
     */
    public function setOrganizationId(
        string $organizationId
    ): UserEntityInterface
    {
        $this->organizationId = $organizationId;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccountId(): string
    {
        return $this->accountId;
    }

    /**
     * @param string $accountId
     * @return UserEntityInterface
     */
    public function setAccountId(
        string $accountId
    ): UserEntityInterface
    {
        $this->accountId = $accountId;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

}
