<?php


namespace App\Http\Controllers\Category\Mapper;


use Illuminate\Http\Request;
use MealWallet\Domain\Category\Entity\CategoryEntityInterface;
use MealWallet\Domain\Category\Entity\CategoryEntity;

class CategoryMapper implements CategoryMapperInterface
{
    /**
     * @param Request $request
     * @return CategoryEntityInterface
     */
    public static function createCategoryFromHttpRequest(
        Request $request
    ): CategoryEntityInterface
    {
        $payload = $request->json()->all();
        return CategoryEntity::fromArray([
                "name" => $payload['name'],
                "accountId" => trim("60afdacc2aeef4f26d71c990"),
            ]
        );
    }
}
