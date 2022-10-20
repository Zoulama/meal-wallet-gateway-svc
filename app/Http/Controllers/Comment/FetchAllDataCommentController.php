<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Comment\Mapper\CommentMapperInterface;
use MealWallet\Domain\Comment\Service\CommentServiceInterface;
use MealWallet\Domain\Comment\Service\Exception\CommentServiceException;

class FetchAllDataCommentController extends Controller
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


    public function fetchAll(Request $request)
    {
        return response()->json(
            [
                'status' => 'success',
                'data' => [
                    'Comments' => $this
                        ->commentService
                        ->fetchAll(
                            []
                        )
                        ->toArray()
                ]
            ]
        );
    }

    public function fetchAllByReport(string $reportId)
    {

        try {

            $commentEntity = $this
                ->commentService
                ->fetchAllByReport(
                    $reportId
                );

            return response()->json(
                [
                    'status' => 'success',
                    'data' => [
                        'Comments' => $commentEntity->toArray(),
                        'NumberOfComments' => count($commentEntity->toArray())
                    ]
                ]
            );

        } catch (CommentServiceException $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode'=> 0,
                    'StatusDescription'=> $e->getMessage()
                ]
            );
        }

    }
}
