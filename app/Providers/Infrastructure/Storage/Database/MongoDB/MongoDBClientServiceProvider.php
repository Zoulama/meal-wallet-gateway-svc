<?php


namespace App\Providers\Infrastructure\Storage\Database\MongoDB;


use Illuminate\Support\ServiceProvider;
use MealWallet\Infrastructure\Storage\Database\MongoDB\MongoClientInterface;
use MealWallet\Infrastructure\Secrets\SecretManagerInterface;
use MongoDB\Client;

class MongoDBClientServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(MongoClientInterface::class, function ($app) {

            return $mongoClient = new Client(
                app(SecretManagerInterface::class)->get("DB_MONGODB_URI")
            );
        });
    }
}
