<?php


namespace App\Http\Controllers\Professional\Mapper;

use Illuminate\Http\Request;

use MealWallet\Domain\Professional\Entity\ProfessionalEntityInterface;

interface ProfessionalMapperInterface
{
    /**
     * @param Request $request
     * @param string $accountId
     * @return ProfessionalEntityInterface
     */
    public static function createProfessionalFromHttpRequest(
        Request $request,
        string $accountId
    ): ProfessionalEntityInterface;

    /**
     * @param Request $request
     * @return ProfessionalEntityInterface
     */
    public static function updateProfessionalFromHttpRequest(
        Request $request
    ): ProfessionalEntityInterface;
}
