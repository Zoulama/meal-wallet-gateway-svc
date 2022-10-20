<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$router->get('/', function () use ($router) {
    //return $router->app->version();
    return redirect('/documentation/api/rest/swagger/redoc/index.html');
});

/**-------------------------------------- USERS ----------------------------------------------------------------------*/

$router->get('/v1/meal-wallet/users', [
    'uses' => 'User\FetchAllUsersController@fetchAll',
    'middleware'=>'auth',
    'as'=>'wallet-gateway/UserRead',
    'groups'=> [
        'root',
        'admin'
    ]
]);

$router->post('/v1/meal-wallet/users', [
    'uses' => 'User\CreateUserController@create',
    'middleware'=>'auth',
    'as'=>'meal-wallet-gateway/UserWrite',
    'groups'=> [
        'root',
        'admin'
    ]
]);

$router->get('/v1/meal-wallet/users/{userId}', [
    'uses' => 'User\FetchUserDataController@fetch',
    'middleware'=>'auth',
    'as'=>'meal-wallet-gateway/UserRead',
    'groups'=> [
        'root',
        'admin',
        'user'
    ]
]);

$router->get('/v1/meal-wallet/users/accounts/{accountId}', [
    'uses' => 'User\FetchAllUsersByAccountController@fetchAllAccountUsers',
    'middleware'=>'auth',
    'as'=>'meal-wallet-gateway/UserRead',
    'groups'=> [
        'root',
        'admin',
        'user'
    ]
]);

$router->put('v1/meal-wallet/users/{userId}', [
    'uses' => 'User\UpdateUserDataController@update',
    'middleware'=>'auth',
    'as'=>"meal-wallet-gateway/UserUpdate",
    'groups'=> [
        'root',
        'admin',
        'user'
    ]
]);


/**-------------------------------------- ACCOUNTS ----------------------------------------------------------------------*/


$router->post('v1/meal-wallet/accounts', [
    'uses' => 'Account\CreateAccountController@create',
    'middleware'=>'auth',
    'as'=>'meal-wallet-gateway/AccountWrite',
    'groups'=> [
        'root',
        'admin',
        'user'

    ]
]);

$router->get('v1/meal-wallet/accounts', [
    'uses' => 'Account\FetchUserAccountsController@fetch',
    'middleware'=>'auth',
    'as'=>"meal-wallet-gateway/AccountRead",
    'groups'=> [
        'root',
        'admin',
        'user'
    ]
]);

$router->put('v1/meal-wallet/accounts/{accountId}', [
    'uses' => 'Account\UpdateAccountController@update',
    'middleware'=>'auth',
    'as'=>"meal-wallet-gateway/AccountWrite",
    'groups'=> [
        'root',
        'admin',
        'user'
    ]
]);

$router->get('v1/meal-wallet/accounts/{accountId}', [
    'uses' => 'Account\FetchAccountDataController@fetch',
    'middleware'=>'auth',
    'as'=>"meal-wallet-gateway/AccountRead",
    'groups'=> [
        'root',
        'admin',
        'user'
    ]
]);


$router->get('/v1/meal-wallet/accounts/organizations/{accountId}', [
    'uses' => 'Organization\Account\GetAccountDataController@fetch',
    'middleware'=>'auth',
    'as'=>"meal-wallet-gateway/GetOrganizationAccount",
    'groups'=> [
        'root',
        'admin'
    ]
]);


/**-------------------------------------- ORGANIZATIONS --------------------------------------------------------------*/

$router->get('/v1/meal-wallet/organizations', [
    'uses' => 'Organization\FetchOrganizationDataController@fetchData',
    'middleware'=>'auth',
    'as'=>"meal-wallet-gateway/FetchOrganizationData",
    'groups'=> [
        'root',
        'admin',
        'user'
    ]
]);

$router->post('/v1/meal-wallet/organizations/accounts', [
    'uses' => 'Organization\Account\CreateAccountController@create',
    'middleware'=>'auth',
    'as'=>"meal-wallet-gateway/CreateOrganizationAccount",
    'groups'=> [
        'root',
        'admin'
    ]
]);


$router->get('/v1/meal-wallet/organizations/accounts/{organizationId}', [
    'uses' => 'Organization\Account\GetAccountDataController@fetch',
    'middleware'=>'auth',
    'as'=>"meal-wallet-gateway/GetOrganizationAccount",
    'groups'=> [
        'root',
        'admin',
        'user'
    ]
]);


/**-------------------------------------- AWS-------------------------------------------------------------------------*/
$router->get('/v1/authentication/oauth2/token/{clientId}/{clientSecret}', [
    'uses' => 'Authentication\FetchAccessTokenController@fetch',
]);


$router->get('/v1/authentication/users/{userName}/{userPassword}', [
    'uses' => 'Authentication\AuthenticateUserController@authenticate',
    'middleware'=>'auth',
    'as'=>'meal-wallet-gateway/AuthenticateUsers',
    'groups'=> [
        'root',
        'admin',
        'user'
    ]
]);


$router->post('/v1/authentication/users', [
    'uses' => 'Authentication\AuthenticateUserController@login',
    'middleware'=>'auth',
    'as'=>'meal-wallet-gateway/AuthenticateUsers',
    'groups'=> [
        'root',
        'admin',
        'user'
    ]
]);


$router->get('/v1/authentication/forgot/password/users/{userName}', [
    'uses' => 'Authentication\AuthenticateUserController@forgotPassword',
    'middleware'=>'auth',
    'as'=>'meal-wallet-gateway/AuthenticateUsers',
    'groups'=> [
        'root',
        'admin',
        'User'
    ]
]);


$router->get('/v1/authentication/confirm/forgotPassword/users/{userName}/{userPassword}/{confirmationCode}', [
    'uses' => 'Authentication\AuthenticateUserController@confirmForgotPassword',
    'middleware'=>'auth',
    'as'=>'meal-wallet-gateway/AuthenticateUsers',
    'groups'=> [
        'root',
        'admin',
        'User'
    ]
]);



$router->get('/v1/authentication/changePassword/users/{userName}/{userPassword}', [
    'uses' => 'Authentication\AuthenticateUserController@changePassword',
    'middleware'=>'auth',
    'as'=>'meal-wallet-gateway/AuthenticateUsers',
    'groups'=> [
        'root',
        'admin',
        'User'
    ]
]);

$router->post('/v1/registration/users', [
    'uses' => 'Registration\RegisterNewUserController@register',
    'middleware'=>'auth',
    'as'=>'meal-wallet-gateway/RegisterNewUsers',
    'groups'=> [
        'root',
        'admin',
        'User'
    ]
]);

$router->get('/v1/registration/users/confirmation/{userName}/{code}', [
    'uses' => 'Registration\ConfirmUserRegistrationController@confirm',
    'middleware'=>'auth',
    'as'=>'meal-wallet-gateway/ConfirmUserRegistration',
    'groups'=> [
        'root',
        'admin',
        'User'
    ]
]);

$router->get('/v1/registration/users/resend/{userName}/confirmationcode', [
    'uses' => 'Registration\ConfirmUserRegistrationController@resendConfirmationCode',
    'middleware'=>'auth',
    'as'=>'meal-wallet-gateway/ConfirmUserRegistration',
    'groups'=> [
        'root',
        'admin',
        'User'
    ]
]);
/** END */
