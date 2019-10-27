<?php
declare(strict_types=1);

namespace ElasticClient;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider as AbstractServiceProvider;

final class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->app->singleton(Client::class, function () {
            $config = config('elastic.client');

            return ClientBuilder::fromConfig($config);
        });
    }

    /**
     * @inheritDoc
     */
    public function boot()
    {
        $this->publishes([
            realpath(__DIR__ . '/../config/elastic.client.php') => config_path('elastic.client.php')
        ]);
    }
}
