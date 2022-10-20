<?php


namespace MealWallet\Domain\User\Service\Authentification;


interface AuthenticationServiceInterface
{

    /**
     * @param string $username
     * @param string $password
     * @param string $email
     * @param string $userId
     * @param string $accountId
     * @return AuthenticationServiceInterface
     */
    public function register(
        string $username,
        string $password,
        string $email,
        string $userId,
        string $accountId
    );

    /**
     * @param string $username
     * @param string $groupName
     * @return AuthenticationServiceInterface
     */
    public function addUserToGroup(
        string $username,
        string $groupName
    );

    /**
     * @param string $username
     * @param string $password
     * @return mixed
     */
    public function authenticate(
        string $username,
        string $password
    );

    /**
     * @param string $username
     * @param string $code
     * @return mixed
     */
    public function confirmRegistration(
        string $username,
        string $code
    );

    /**
     * @param string $username
     * @return mixed
     */
    public function resendConfirmationCode(string $username);

    /**
     * @param string $username
     * @return mixed
     */
    public function forgotPassword(string $username);

    /**
     * @param string $username
     * @param string $password
     * @param string $confirmationCode
     * @return mixed
     *
     */
    public function confirmForgotPassword(
        string $username,
        string $password,
        string $confirmationCode
    );

    /**
     * @param string $accessToken
     * @param string $previousPassword
     * @param string $proposedPassword
     * @return mixed
     */
    public function changePassword(
        string $accessToken,
        string $previousPassword,
        string $proposedPassword
    );

    /**
     * @param string $accessToken
     * @return mixed
     */
    public function getUser(
        string $accessToken
    );

    /**
     * @inheritDoc
     */
    public function updateUserAttributes(
        string $userId,
        string $accessToken
    );
}
