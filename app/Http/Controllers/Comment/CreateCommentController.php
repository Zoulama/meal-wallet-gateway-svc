<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Comment\Mapper\CommentMapperInterface;
use Illuminate\Support\Facades\Validator;
use MealWallet\Domain\Comment\Service\CommentServiceInterface;
use App\Http\Controllers\Comment\Mapper\CommentMapper;

class CreateCommentController extends Controller
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

    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->json()->all(),
            [
                'userId' => ['required', 'string'],
                'reportId' => ['required', 'string'],
                'comment' => ['required', 'string'],
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
                    'Comment' => $this
                        ->commentService
                        ->create(
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
