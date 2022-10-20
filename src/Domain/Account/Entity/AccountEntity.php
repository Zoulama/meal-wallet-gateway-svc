<?php


namespace MealWallet\Domain\Account\Entity;


class AccountEntity implements AccountEntityInterface
{
    /**
     * @var ?string
     */
    private $accountId;

    /**
     * @var ?string
     */
    private $organizationId;

    /**
     * @var ?string
     */
    private $name;

    /**
     * @var ?array
     */
    private $address;

    /**
     * @var ?string
     */
    private $email;

    /**
     * @var ?string
     */
    private $phoneNumber;

    /**
     * @var ?string
     */
    private $mobileNumber;

    /**
     * @var ?string
     */
    private $userPassword;

    /**
     * @var ?string
     */
    private $createdAt;

    /**
     * OrganizationEntity constructor.
     * @param string|null $accountId
     * @param string|null $name
     * @param array|null $address
     * @param string|null $email
     * @param string|null $phoneNumber
     * @param string $mobileNumber
     * @param string|null $userPassword
     * @param string $organizationId
     * @param string|null $createdAt
     */
    public function __construct(
        ?string $accountId,
        ?string $name,
        ?array $address,
        ?string $email,
        ?string $phoneNumber,
        ?string $mobileNumber,
        ?string $userPassword,
        ?string $organizationId,
        ?string $createdAt
    ){
        $this->accountId = $accountId;
        $this->name = $name;
        $this->address = $address;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->mobileNumber = $mobileNumber;
        $this->userPassword = $userPassword;
        $this->organizationId = $organizationId;
        $this->createdAt = $createdAt;
    }

    /**
     * @inheritDoc
     */
    public static function fromArray(array $data): AccountEntityInterface
    {
        return new static(
            $data['accountId'] ?? null,
            $data['name'] ?? null,
            $data['address'] ?? [],
            $data['email'] ?? null,
            $data['phoneNumber'] ?? null,
            $data['mobileNumber'] ?? null,
            $data['userPassword'] ?? null,
            $data['organizationId'] ?? null,
            $data['createdAt'] ?? null
        );
    }


    /**
     * @inheritDoc
     */
    public function toRequest(): array
    {
        return [
            'accountId' => $this->accountId,
            'name' => $this->name,
            'address'=> $this->address,
            'email'=>$this->email,
            'mobileNumber'=>$this->mobileNumber,
            'phoneNumber'=>$this->mobileNumber,
            'userPassword'=>$this->mobileNumber,
            'organizationId'=>$this->organizationId,
            'createdAt' =>$this->createdAt,
        ];
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'accountId' => $this->accountId,
            'name' => $this->name,
            'address'=> $this->address,
            'email'=>$this->email,
            'mobileNumber'=>$this->mobileNumber,
            'phoneNumber'=>$this->mobileNumber,
            'createdAt' =>$this->createdAt,
        ];
    }

    /**
     * @return string
     */
    public function getAccountId(): string
    {
        return $this->accountId;
    }

    /**
     * @return string
     */
    public function getOrganizationId(): string
    {
        return $this->organizationId;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getAddress(): array
    {
        return $this->address;
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
    public function getMobileNumber(): ?string
    {
        return $this->mobileNumber;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }


    /**
     * @return string
     */
    public function getUserPassword(): ?string
    {
        return $this->userPassword;
    }

}
