<?php


namespace App\Http\Controllers\Comment\Mapper;

use Illuminate\Http\Request;

use MealWallet\Domain\Comment\Entity\CommentEntityInterface;

interface CommentMapperInterface
{
    /**
     * @param Request $request
     * @return CommentEntityInterface
     */
    public static function createCommentFromHttpRequest(
        Request $request
    ): CommentEntityInterface;
}
