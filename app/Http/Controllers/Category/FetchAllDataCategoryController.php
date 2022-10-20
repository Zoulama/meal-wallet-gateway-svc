<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Category\Mapper\CategoryMapperInterface;
use MealWallet\Domain\Category\Service\CategoryServiceInterface;

class FetchAllDataCategoryController extends Controller
{
    /**
     * @var CategoryServiceInterface
     */
    private $categoryService;



    /**
     * CreateCategoryController constructor.
     * @param CategoryServiceInterface $categoryService
     */
    public function __construct(
        CategoryServiceInterface  $categoryService
    )
    {
        $this->categoryService = $categoryService;
    }


    public function fetchAll(Request $request)
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'Categories' => $this
                        ->categoryService
                        ->fetchAll(
                            []
                        )
                        ->toArray()
                ]
            ]
        );
    }

    /**
     * @param string $categoryId
     * @return JsonResponse
     */
    public function fetchAllByCategory(string $categoryId)
    {//var_dump($categoryId);die();
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'SubCategories' => $this
                        ->categoryService
                        ->fetchAllSubCategoryByCategory(
                            $categoryId
                        )
                        ->toArray()
                ]
            ]
        );
    }
}
