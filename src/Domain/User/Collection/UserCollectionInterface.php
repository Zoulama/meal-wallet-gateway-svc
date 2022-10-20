<?php


namespace MealWallet\Domain\User\Collection;



interface UserCollectionInterface
{
    /**
     * @param array $users
     * @return UserCollectionInterface
     */
    public static function fromArray(array $users):UserCollectionInterface;

    /**
     * @return array
     */
    public function toArray(): array ;
}
