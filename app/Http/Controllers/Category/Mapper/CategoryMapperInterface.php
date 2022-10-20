<?php


namespace App\Http\Controllers\Category\Mapper;

use Illuminate\Http\Request;

use MealWallet\Domain\Category\Entity\CategoryEntityInterface;

interface CategoryMapperInterface
{
    /**
     * @param Request $request
     * @return CategoryEntityInterface
     */
    public static function createCategoryFromHttpRequest(
        Request $request
    ): CategoryEntityInterface;
}
