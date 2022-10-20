<?php


namespace MealWallet\Domain\Organization\Entity;


class OrganizationEntity implements OrganizationEntityInterface
{

    /**
     * @var string
     */
    private $organizationId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $address;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $mobileNumber;

    /**
     * OrganizationEntity constructor.
     * @param string $organizationId
     * @param string $name
     * @param array $address
     * @param string $email
     * @param string $mobileNumber
     */
    public function __construct(
        ?string $organizationId = null,
        ?string $name = null,
        ?array $address = null,
        ?string $email = null,
        string $mobileNumber = null)
    {
        $this->organizationId = $organizationId;
        $this->name = $name;
        $this->address = $address;
        $this->email = $email;
        $this->mobileNumber = $mobileNumber;
    }

    /**
     * @inheritDoc
     */
    public static function fromArray(array $data): OrganizationEntityInterface
    {
        return new static(
            $data['organizationId'] ?? null,
            $data['name'] ?? null,
            $data['address'] ?? null,
            $data['email'] ?? null,
            $data['mobileNumber'] ?? null
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'organizationId' => $this->organizationId,
            'name' => $this->name,
            'address'=> $this->address,
            'email'=>$this->email,
            'mobileNumber'=>$this->mobileNumber
        ];
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
    public function getName(): string
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
    public function getMobileNumber(): string
    {
        return $this->mobileNumber;
    }

}
