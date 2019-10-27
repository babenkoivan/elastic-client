<?php
declare(strict_types=1);

namespace ElasticClient;


use Elasticsearch\Client;
use Orchestra\Testbench\TestCase;

/**
 * @covers \ElasticClient\ServiceProvider
 */
class ServiceProviderTest extends TestCase
{
    /**
     * @inheritDoc
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('elastic.client.hosts', ['foo:9200']);
    }

    public function test_client_is_registered(): void
    {
        (new ServiceProvider($this->app))->register();

        $client = $this->app->make(Client::class);
        $connection = $client->transport->getConnection();

        $this->assertInstanceOf(Client::class, $client);
        $this->assertSame('foo', $connection->getHost());
        $this->assertSame(9200, $connection->getPort());
    }

    public function test_configuration_is_published(): void
    {
        (new ServiceProvider($this->app))->boot();

        $publishes = ServiceProvider::$publishes[ServiceProvider::class];

        $publishFrom = realpath(__DIR__ . '/../../config/elastic.client.php');
        $publishTo = config_path('elastic.client.php');

        $this->assertArrayHasKey($publishFrom, $publishes);
        $this->assertSame($publishTo, $publishes[$publishFrom]);
    }
}
