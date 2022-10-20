<?php


namespace App\Http\Controllers\Comment\Mapper;


use Illuminate\Http\Request;
use MealWallet\Domain\Comment\Entity\CommentEntityInterface;
use MealWallet\Domain\Comment\Entity\CommentEntity;

class CommentMapper implements CommentMapperInterface
{
    /**
     * @param Request $request
     * @return CommentEntityInterface
     */
    public static function createCommentFromHttpRequest(
        Request $request
    ): CommentEntityInterface
    {
        $payload = $request->json()->all();
        return CommentEntity::fromArray([
                "userId" => $payload['userId'],
                "reportId" => $payload['reportId'],
                "comment" => $payload['comment'],
            ]
        );
    }
}
