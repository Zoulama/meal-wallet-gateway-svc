<?php


namespace MealWallet\Domain\Organization\Collection;


interface OrganizationCollectionInterface
{

    /**
     * @param array $data
     * @return OrganizationCollectionInterface
     */
    public static function fromArray(array $data):OrganizationCollectionInterface;

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return array
     */
    public function getCollection(): array;
}
