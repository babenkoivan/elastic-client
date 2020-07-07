<?php declare(strict_types=1);

namespace ElasticClient;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider as AbstractServiceProvider;

final class ServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string
     */
    private $configPath;

    /**
     * {@inheritDoc}
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $this->configPath = dirname(__DIR__) . '/config/elastic.client.php';
    }

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->mergeConfigFrom(
            $this->configPath,
            basename($this->configPath, '.php')
        );

        $this->app->singleton(Client::class, static function () {
            $config = config('elastic.client');

            return ClientBuilder::fromConfig($config);
        });
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            $this->configPath => config_path(basename($this->configPath)),
        ]);
    }
}
