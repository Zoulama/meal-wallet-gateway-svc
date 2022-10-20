<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Category\Mapper\CategoryMapperInterface;
use MealWallet\Domain\Category\Service\CategoryServiceInterface;
use App\Http\Controllers\Category\Mapper\CategoryMapper;

class UpdateCategoryController extends Controller
{
    /**
     * @var CategoryServiceInterface
     */
    private $categoryService;

    /**
     * @var CategoryMapperInterface
     */
    private $categoryMapper;

    /**
     * CreateCategoryController constructor.
     * @param CategoryServiceInterface $categoryService
     * @param CategoryMapper $categoryMapper
     */
    public function __construct(
        CategoryServiceInterface  $categoryService,
        CategoryMapper $categoryMapper
    )
    {
        $this->categoryService = $categoryService;
        $this->categoryMapper = $categoryMapper;
    }

    public function update(string $categoryId, Request $request)
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'Category' => $this
                        ->categoryService
                        ->update(
                            $categoryId,
                            $this->categoryMapper->createCategoryFromHttpRequest(
                                $request
                            )
                        )
                        ->toArray()
                ]
            ]
        );
    }
}
