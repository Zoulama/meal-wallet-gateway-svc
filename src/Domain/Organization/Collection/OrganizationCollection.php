<?php


namespace MealWallet\Domain\Organization\Collection;


use MealWallet\Domain\Organization\Entity\OrganizationEntity;
use MealWallet\Domain\Organization\Entity\OrganizationEntityInterface;

class OrganizationCollection implements OrganizationCollectionInterface
{

    /**
     * @var array
     */
    private $collection;

    /**
     * OrganizationCollection constructor.
     * @param array $collection
     */
    public function __construct(array $collection)
    {
        $this->collection = $collection;
    }


    /**
     * @inheritDoc
     */
    public static function fromArray(array $data): OrganizationCollectionInterface
    {
        return new static(
            array_map(function (array $organization){
                return OrganizationEntity::fromArray($organization);
            },$data)
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_map(function (OrganizationEntityInterface $organizationEntity){
            return $organizationEntity->toArray();
        },$this->collection);
    }

    /**
     * @return array
     */
    public function getCollection(): array
    {
        return $this->collection;
    }
}
