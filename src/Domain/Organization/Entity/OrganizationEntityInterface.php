<?php


namespace MealWallet\Domain\Organization\Entity;


interface OrganizationEntityInterface
{

    /**
     * @param array $data
     * @return OrganizationEntityInterface
     */
    public static function fromArray(array $data): OrganizationEntityInterface;

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return string
     */
    public function getOrganizationId(): string;

    /**
     * @return string
     */
    public function getName(): string;

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
    public function getMobileNumber(): string;

}
