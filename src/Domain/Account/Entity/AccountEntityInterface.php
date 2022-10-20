<?php


namespace MealWallet\Domain\Account\Entity;


interface AccountEntityInterface
{

    /**
     * @param array $data
     * @return AccountEntityInterface
     */
    public static function fromArray(array $data): AccountEntityInterface;

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return string
     */
    public function getAccountId(): string;

    /**
     * @return string
     */
    public function getOrganizationId(): string;

    /**
     * @return string
     */
    public function getName(): ?string;

    /**
     * @return array
     */
    public function getAddress(): array;

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @return string
     */
    public function getMobileNumber(): ?string;

    /**
     * @return string
     */
    public function getPhoneNumber(): ?string;

    /**
     * @return string
     */
    public function getCreatedAt(): ?string;

    /**
     * @return string
     */
    public function getUserPassword(): ?string;
}
