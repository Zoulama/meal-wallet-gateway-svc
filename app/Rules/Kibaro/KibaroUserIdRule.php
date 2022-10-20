<?php


namespace App\Rules\MealWallet;

use Illuminate\Contracts\Validation\Rule;
use MealWallet\Domain\User\Service\Exception\UserServiceException;
use MealWallet\Domain\User\Service\UserServiceInterface;
use Exception;

class KibaroUserIdRule implements Rule
{
    /**
     * @var UserServiceInterface
     */
    private $kibaroUserService;

    /**
     * KibaroUserIdRule constructor.
     * @param UserServiceInterface $kibaroUserService
     */
    public function __construct(UserServiceInterface $kibaroUserService)
    {
        $this->kibaroUserService = $kibaroUserService;
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        try {
            $this
                ->kibaroUserService
                ->fetch(
                    $value
                );
        } catch (UserServiceException | Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return ":attribute is not valid";
    }

}
