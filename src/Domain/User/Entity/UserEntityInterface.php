<?php


namespace MealWallet\Domain\User\Entity;

use MealWallet\Domain\User\Entity\AddressEntityInterface;
use MealWallet\Infrastructure\User\Model\User;

interface UserEntityInterface
{
    /**
     * @return array
     */
    public function toArray(): array ;

    /**
     * @param array $data
     * @return UserEntityInterface
     */
    public static function fromArray(
        array $data
    ):UserEntityInterface;

    /**
     * @param User $user
     * @return UserEntityInterface
     */
    /*public static function fromModel(
        User $user
    ): UserEntityInterface;*/

    /**
     * @return string
     */
    public function getUserId() : string;

    /**
     * @return string
     */
  //  public function getLastName(): string;

    /**
     * @return string
     */
   // public function getFirstName(): string;


    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @return string
     */
    public function getMobileNumber(): string;


    /**
     * @return string
     */
    public function getOrganizationId(): string ;

    /**
     * @param string $organizationId
     * @return UserEntityInterface
     */
    public function setOrganizationId(
        string $organizationId
    ): UserEntityInterface;

    /**
     * @return string
     */
    public function getAccountId(): string ;

    /**
     * @param string $accountId
     * @return UserEntityInterface
     */
    public function setAccountId(
        string $accountId
    ): UserEntityInterface;

    /**
     * @return string
     */
    public function getStatus(): string;

}
