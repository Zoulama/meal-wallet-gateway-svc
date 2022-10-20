<?php

require_once __DIR__.'/../vendor/autoload.php';

use App\Providers\Domain\MealWallet\Application\Repository\ApplicationRepositoryServiceProvider;
use App\Providers\Domain\MealWallet\Application\Service\ApplicationServiceProvider;
use App\Providers\Domain\MealWallet\Offer\Repository\OfferRepositoryServiceProvider;
use App\Providers\Domain\MealWallet\Offer\Service\OfferServiceProvider;
use App\Providers\Domain\MealWallet\Professional\Repository\ProfessionalRepositoryServiceProvider;
use App\Providers\Domain\MealWallet\Professional\Service\ProfessionalServiceProvider;
use App\Providers\Domain\MealWallet\Quote\Repository\QuoteRepositoryServiceProvider;
use App\Providers\Domain\MealWallet\Quote\Service\QuoteServiceProvider;
use App\Providers\Infrastructure\Api\Rest\Client\Application\ApplicationApiClientProvider;
use App\Providers\Infrastructure\Api\Rest\Client\Offer\OfferApiClientProvider;
use App\Providers\Infrastructure\Api\Rest\Client\Professional\ProfessionalApiClientProvider;
use App\Providers\Infrastructure\Api\Rest\Client\Quote\QuoteApiClientProvider;
use App\Providers\Infrastructure\Secrets\SecretManagerServiceProvider;
use App\Providers\Infrastructure\CloudRun\Metadata\CloudRunMetadataGuzzleClientProvider;
use Jenssegers\Mongodb\MongodbServiceProvider;



(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

use App\Http\Middleware\OAuth2ClientCredentials;
use Nord\Lumen\Cors\CorsMiddleware;
use App\Providers\Domain\MealWallet\Account\Service\AccountServiceProvider;
use App\Providers\Domain\MealWallet\Account\Repository\AccountRepositoryProvider;
use App\Providers\Infrastructure\Api\Rest\Client\User\UserApiClientProvider;
use App\Providers\Domain\MealWallet\User\Repository\UserRepositoryProvider;
use App\Providers\Domain\MealWallet\User\Service\UserServiceProvider;
use App\Providers\Infrastructure\Api\Rest\Client\Organization\OrganizationApiClientProvider;
use App\Providers\Domain\MealWallet\Organization\Repository\OrganizationRepositoryProvider;
use App\Providers\Domain\MealWallet\Organization\Service\OrganizationServiceProvider;
use App\Providers\Infrastructure\Api\Rest\Client\Account\AccountApiClientProvider;
use App\Providers\Infrastructure\Api\Auth\OAuth2\Oauth2ClientProvider;
use App\Providers\Infrastructure\Aws\Cognito\IdentityProvider;
use App\Providers\Infrastructure\Storage\Database\MongoDB\MongoDBClientServiceProvider;
use App\Providers\Domain\MealWallet\User\Service\Authentification\AuthenticationServiceProvider;
//use App\Providers\Infrastructure\CloudRun\Metadata\CloudRunMetadataServiceProvider;
use App\Providers\Infrastructure\CloudRun\Metadata\OAuth\IDToken\OAuthIDTokenServiceProvider;
use App\Providers\Infrastructure\CloudRun\Metadata\ProjectID\CloudRunProjectIDServiceProvider;
use Nord\Lumen\Cors\CorsServiceProvider;
/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

 $app->withFacades();

$app->register(MongodbServiceProvider::class);
$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton('filesystem', function ($app) {
    return $app->loadComponent(
        'filesystems',
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        'filesystem'
    );
});

/*
|--------------------------------------------------------------------------
| Register Config Files
|--------------------------------------------------------------------------
|
| Now we will register the "app" configuration file. If the file exists in
| your configuration directory it will be loaded; otherwise, we'll load
| the default version. You may register other files below as needed.
|
*/

$app->configure('app');

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

$app->routeMiddleware([
    'auth' => OAuth2ClientCredentials::class,
]);

$app->middleware([
    CorsMiddleware::class
]);

// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

// $app->routeMiddleware([
//     'auth' => App\Http\Middleware\Authenticate::class,
// ]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

// $app->register(App\Providers\AppServiceProvider::class);
// $app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);

$app->register(CorsServiceProvider::class);


$app->register(AccountApiClientProvider::class);
$app->register(AccountServiceProvider::class);
$app->register(AccountRepositoryProvider::class);

$app->register(UserApiClientProvider::class);
$app->register(UserRepositoryProvider::class);
$app->register(UserServiceProvider::class);

$app->register(OrganizationApiClientProvider::class);
$app->register(OrganizationRepositoryProvider::class);
$app->register(OrganizationServiceProvider::class);

$app->register(CloudRunMetadataGuzzleClientProvider::class);
$app->register(OAuthIDTokenServiceProvider::class);
$app->register(CloudRunProjectIDServiceProvider::class);
$app->register(SecretManagerServiceProvider::class);

$app->register(Oauth2ClientProvider::class);
$app->register(IdentityProvider::class);
$app->register(AuthenticationServiceProvider::class);

$app->register(MongoDBClientServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__ . '/../routes/web.php';
});

return $app;
