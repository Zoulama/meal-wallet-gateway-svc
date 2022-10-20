<?php


namespace App\Http\Controllers\Application\Mapper;

use Illuminate\Http\Request;

use MealWallet\Domain\Application\Entity\ApplicationEntityInterface;

interface ApplicationMapperInterface
{
    /**
     * @param Request $request
     * @return ApplicationEntityInterface
     */
    public static function createApplicationFromHttpRequest(
        Request $request
    ): ApplicationEntityInterface;
}
