<?php declare(strict_types=1);

namespace ElasticClient;

use Elasticsearch\Client;
use Orchestra\Testbench\TestCase;

/**
 * @covers \ElasticClient\ServiceProvider
 */
class ServiceProviderTest extends TestCase
{
    public function test_client_is_registered(): void
    {
        (new ServiceProvider($this->app))->register();

        $client = $this->app->make(Client::class);
        $connection = $client->transport->getConnection();

        $this->assertInstanceOf(Client::class, $client);
        $this->assertSame('localhost', $connection->getHost());
        $this->assertSame(9200, $connection->getPort());
    }

    public function test_configuration_can_be_published(): void
    {
        (new ServiceProvider($this->app))->boot();

        $publishes = ServiceProvider::$publishes[ServiceProvider::class];

        $publishFrom = dirname(__DIR__, 2) . '/config/elastic.client.php';
        $publishTo = config_path('elastic.client.php');

        $this->assertArrayHasKey($publishFrom, $publishes);
        $this->assertSame($publishTo, $publishes[$publishFrom]);
    }
}
