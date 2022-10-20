<?php


namespace MealWallet\Domain\User\Service\Authentification;


use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Aws\CognitoIdentity\Exception\CognitoIdentityException;
use Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException;
use Aws\Exception\AwsException;
use Exception;
use Illuminate\Validation\ValidationException;


class AuthenticationService implements AuthenticationServiceInterface
{
    const NEW_PASSWORD_CHALLENGE = 'NEW_PASSWORD_REQUIRED';
    const FORCE_PASSWORD_STATUS  = 'FORCE_CHANGE_PASSWORD';
    const RESET_REQUIRED         = 'PasswordResetRequiredException';
    const USER_NOT_FOUND         = 'UserNotFoundException';
    const USERNAME_EXISTS        = 'UsernameExistsException';
    const INVALID_PASSWORD       = 'InvalidPasswordException';
    const CODE_MISMATCH          = 'CodeMismatchException';
    const EXPIRED_CODE           = 'ExpiredCodeException';

    /**
     * @var CognitoIdentityProviderClient
     */
    private $cognitoIdentityProviderClient;

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $userPoolId;

    /**
     * AuthenticationService constructor.
     * @param CognitoIdentityProviderClient $cognitoIdentityProviderClient
     * @param string $clientId
     * @param string $userPoolId
     */
    public function __construct(
        CognitoIdentityProviderClient $cognitoIdentityProviderClient,
        string $clientId,
        string $userPoolId
    ){
        $this->cognitoIdentityProviderClient = $cognitoIdentityProviderClient;
        $this->clientId = $clientId;
        $this->userPoolId = $userPoolId;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function register(
        string $username,
        string $password,
        string $email,
        string $userId,
        string $accountId
    ){
        try {
        $this
            ->cognitoIdentityProviderClient
            ->signUp(
                [
                    'ClientId' => $this->clientId,
                    'Username' => trim(strtolower($username)),
                    'Password' => $password,
                    "UserAttributes" =>
                    [
                            [
                                'Name' => 'email',
                                'Value' => trim(strtolower($email))
                            ],
                            [
                                'Name' => 'custom:userId',
                                'Value' => $userId
                            ],
                            [
                                'Name' => 'custom:accountId',
                                'Value' => $accountId
                            ],
                    ]
                ]
            );

        return $this;

        } catch (CognitoIdentityProviderException $e) {

            throw $e;
        }
    }


    /**
     * @inheritDoc
     */
    public function addUserToGroup(string $username, string $groupName)
    {
        $this
            ->cognitoIdentityProviderClient
            ->adminAddUserToGroup([
                'GroupName' => $groupName,
                'UserPoolId' => $this->userPoolId,
                'Username' => trim(strtolower($username))
            ]);

        return $this;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function authenticate(string $username, string $password)
    {
       try {
           $result = $this
               ->cognitoIdentityProviderClient
               ->initiateAuth([
                   'AuthFlow' => 'USER_PASSWORD_AUTH',
                   'AuthParameters' => [
                       'USERNAME' => trim(strtolower($username)),
                       'PASSWORD' => trim($password)
                   ],
                   'ClientId' => $this->clientId
               ]);

           /*$userData = array_filter($this->getUser(
               $result->get('AuthenticationResult')['AccessToken']
           ), function($value, $k) {

               var_dump($k);die();
               return
                   $value['Name'] == 'custom:userId' ||
                   $value['Name'] == 'custom:accountId';

           }, ARRAY_FILTER_USE_BOTH);

           return array_merge(
               $result->get('AuthenticationResult'),
               [
                   'userId' =>  isset($userData['Value']) ? $userData['Value'] : ""
               ]
           );*/

           $userData =  $this->getUser(
               $result->get('AuthenticationResult')['AccessToken']
           );

           return array_merge(
               $result->get('AuthenticationResult'),
               [
                   'userId' =>  isset(
                       $userData[4]['Value']
                   ) ? $userData[4]['Value'] : "",

                   'accountId' =>  isset(
                       $userData[2]['Value']
                   ) ? $userData[2]['Value'] : "",

               ]
           );
       } catch (CognitoIdentityProviderException $exception)
       {
           throw $exception;
       }

        //return $result->get('AuthenticationResult');
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function confirmRegistration(string $username, string $code)
    {
        try {
        $result = $this
            ->cognitoIdentityProviderClient
            ->confirmSignUp([
                    'ClientId' => $this->clientId,
                    'Username' => $username,
                    'ConfirmationCode' => $code,
                ]
            );
        } catch (CognitoIdentityProviderException $exception) {
            throw $exception;
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function resendConfirmationCode(string $username)
    {
        try {
            $result = $this
                ->cognitoIdentityProviderClient
                ->resendConfirmationCode([
                        'ClientId' => $this->clientId,
                        'Username' => $username,

                    ]
                );
        } catch (CognitoIdentityProviderException $exception) {
            throw $exception;
        }
    }

    /**
     * @inheritDoc
     */
    public function forgotPassword(string $username)
    {
        try {
            $result = $this
                ->cognitoIdentityProviderClient
                ->forgotPassword([
                        'ClientId' => $this->clientId,
                        'Username' => $username,

                    ]
                );

            return $result->get('CodeDeliveryDetails');

        } catch (CognitoIdentityProviderException $exception) {
            throw $exception;
        }
    }

    /**
     * @inheritDoc
     *
     */
    public function confirmForgotPassword(
        string $username,
        string $password,
        string $confirmationCode
    ){
        try {
            $result = $this
                ->cognitoIdentityProviderClient
                ->confirmForgotPassword([
                        'ClientId' => $this->clientId,
                        'ConfirmationCode' => $confirmationCode,
                        'Password' => $password,
                        'Username' => $username,

                    ]
                );

        } catch (CognitoIdentityProviderException $exception) {
            throw $exception;
        }
    }

    /**
     * @inheritDoc
     */
    public function changePassword(
        string $accessToken,
        string $previousPassword,
        string $proposedPassword
    ){
        try {
            $result = $this
                ->cognitoIdentityProviderClient
                ->changePassword([
                        'AccessToken' => $accessToken,
                        'PreviousPassword' => $previousPassword,
                        'ProposedPassword' => $proposedPassword,

                    ]
                );

        } catch (CognitoIdentityProviderException $exception) {
            throw $exception;
        }
    }

    /**
     * @inheritDoc
     */
    public function getUser(string $accessToken)
    {
        $result = $this
            ->cognitoIdentityProviderClient
            ->getUser([
                'AccessToken' => $accessToken
            ]);

        return $result->get('UserAttributes');
    }

    /**
     * @inheritDoc
     */
    public function updateUserAttributes(string $userId, string $accessToken)
    {
        $result = $this
            ->cognitoIdentityProviderClient
            ->updateUserAttributes([
                    'AccessToken' => $accessToken,
                    'UserAttributes' => [
                        [
                            'Name' => 'userId',
                            'Value' => $userId
                        ]
                    ],
                ]
            );
    }
}
