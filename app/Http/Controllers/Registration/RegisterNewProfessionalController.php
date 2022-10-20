<?php


namespace App\Http\Controllers\Registration;


use App\Http\Controllers\Controller;
use App\Http\Controllers\Professional\Mapper\ProfessionalMapper;
use Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use MealWallet\Domain\Professional\Service\Exception\ProfessionalServiceException;
use MealWallet\Domain\Professional\Service\ProfessionalServiceInterface;
use MealWallet\Domain\User\Service\Authentification\AuthenticationServiceInterface;
use MealWallet\Domain\User\Service\UserServiceInterface;

class RegisterNewProfessionalController extends Controller
{

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @var AuthenticationServiceInterface
     */
    private $userAuthenticationService;

    /**
     * @var ProfessionalServiceInterface
     */
    private $professionalService;

    /**
     * @var ProfessionalMapper
     */
    private $professionalMapper;

    /**
     * RegisterNewUserController constructor.
     * @param UserServiceInterface $userService
     * @param AuthenticationServiceInterface $userAuthenticationService
     * @param ProfessionalServiceInterface $professionalService
     * @param ProfessionalMapper $professionalMapper
     */
    public function __construct(
        UserServiceInterface $userService,
        AuthenticationServiceInterface $userAuthenticationService,
        ProfessionalServiceInterface $professionalService,
        ProfessionalMapper $professionalMapper
    ){
        $this->userService = $userService;
        $this->userAuthenticationService = $userAuthenticationService;
        $this->professionalService = $professionalService;
        $this->professionalMapper = $professionalMapper;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(
        Request $request
    )
    {
        $validator = Validator::make(
            $request->json()->all(),
            [
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
                'mobileNumber' => ['required', 'string','regex:/^([0-9\s\-\+\(\)]*)$/','min:10' ]
                //'group' => ['required', 'string'],
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

        try {

            $professionalEntity = $this
                ->professionalService
                ->create(
                    $this->professionalMapper::createProfessionalFromHttpRequest(
                        $request,
                        trim("60afdacc2aeef4f26d71c990")
                    )
                );

            $this
                ->userAuthenticationService
                ->register(
                    $request->get('email'),
                    $request->get('password'),
                    $request->get('email'),
                    $professionalEntity->getProfessionalId(),
                    $professionalEntity->getAccountId()
                )->addUserToGroup(
                    $request->get('email'),
                    'professional'
                );
        } catch (ProfessionalServiceException $exception) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => $exception->getCode(),
                    'StatusDescription' => $exception->getMessage()
                ], 404
            );
        } catch(CognitoIdentityProviderException $c) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => $c->getStatusCode(),
                    'StatusDescription' => $c->getAwsErrorMessage()
                ], 404
            );
        }

        return response()->json(
            [
                'status' => 'success',
                'data'=> [
                    'kibaroProfessional'=> $professionalEntity->toArray()
                ]
            ]
        );
    }
}
