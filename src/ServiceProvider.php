<?php declare(strict_types=1);

namespace Elastic\Client;

use Illuminate\Support\ServiceProvider as AbstractServiceProvider;

final class ServiceProvider extends AbstractServiceProvider
{
    private string $configPath;

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

        $this->app->singletonIf(ClientBuilderInterface::class, ClientBuilder::class);
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
