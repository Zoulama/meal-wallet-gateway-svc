<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MealWallet\Domain\Category\Service\CategoryServiceInterface;
use MealWallet\Domain\Category\Service\Exception\CategoryServiceException;

class FetchDataCategoryController extends Controller
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

    /**
     * @param string $categoryId
     * @return JsonResponse
     */
    public function fetch(string $categoryId)
    {
        try {
            return response()->json(
                [
                    'status' => 'success',
                    'data' => [
                        'Category' => $this
                            ->categoryService
                            ->fetch(
                                $categoryId
                            )
                            ->toArray()
                    ]
                ]
            );
        } catch (CategoryServiceException $exception) {

            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => 404,
                    'StatusDescription' => $exception->getMessage()
                ], 404
            );
        }

    }

    /**
     * @param string $subCategoryId
     * @return JsonResponse
     */
    public function fetchSubCategory(string $subCategoryId)
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'Category' => $this
                        ->categoryService
                        ->fetchSubCategory(
                            $subCategoryId
                        )
                        ->toArray()
                ]
            ]
        );
    }
}
