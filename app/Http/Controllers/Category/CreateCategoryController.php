<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Category\Mapper\CategoryMapperInterface;
use Illuminate\Support\Facades\Validator;
use MealWallet\Domain\Category\Service\CategoryServiceInterface;
use App\Http\Controllers\Category\Mapper\CategoryMapper;

class CreateCategoryController extends Controller
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {

        $validator = Validator::make(
            $request->json()->all(),
            [
                'name' => ['required', 'string'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => "0000",
                    'StatusDescription' => $validator->errors()
                ]
            );
        }
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'Category' => $this
                        ->categoryService
                        ->create(
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
