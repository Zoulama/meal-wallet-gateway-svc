<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Comment\Mapper\CommentMapperInterface;
use MealWallet\Domain\Comment\Service\CommentServiceInterface;
use App\Http\Controllers\Comment\Mapper\CommentMapper;

class UpdateCommentController extends Controller
{
    /**
     * @var CommentServiceInterface
     */
    private $commentService;

    /**
     * @var CommentMapperInterface
     */
    private $commentMapper;

    /**
     * CreateCommentController constructor.
     * @param CommentServiceInterface $commentService
     * @param CommentMapper $commentMapper
     */
    public function __construct(
        CommentServiceInterface  $commentService,
        CommentMapper $commentMapper
    )
    {
        $this->commentService = $commentService;
        $this->commentMapper = $commentMapper;
    }

    public function update(string $commentId, Request $request)
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'Comment' => $this
                        ->commentService
                        ->update(
                            $commentId,
                            $this->commentMapper->createCommentFromHttpRequest(
                                $request
                            )
                        )
                        ->toArray()
                ]
            ]
        );
    }
}
