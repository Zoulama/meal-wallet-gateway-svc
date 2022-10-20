<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use MealWallet\Domain\Comment\Service\CommentServiceInterface;
use MealWallet\Domain\Comment\Service\Exception\CommentServiceException;

class FetchDataCommentController extends Controller
{
    /**
     * @var CommentServiceInterface
     */
    private $commentService;

    /**
     * CreateCommentController constructor.
     * @param CommentServiceInterface $commentService
     */
    public function __construct(
        CommentServiceInterface  $commentService
    )
    {
        $this->commentService = $commentService;
    }

    /**
     * @param string $commentId
     * @return JsonResponse
     */
    public function fetch(string $commentId)
    {
        try {
            return response()->json(
                [
                    'status' => 'success',
                    'data' => [
                        'Comment' => $this
                            ->commentService
                            ->fetch(
                                $commentId
                            )
                            ->toArray()
                    ]
                ]
            );
        } catch (CommentServiceException $exception) {

            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => 404,
                    'StatusDescription' => $exception->getMessage()
                ], 404
            );
        }
    }
}
