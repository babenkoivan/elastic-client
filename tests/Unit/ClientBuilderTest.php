<?php declare(strict_types=1);

namespace Elastic\Client\Tests\Unit;

use Elastic\Client\ClientBuilder;
use Elastic\Elasticsearch\Client;
use ErrorException;
use Orchestra\Testbench\TestCase;

/**
 * @covers \Elastic\Client\ClientBuilder
 */
final class ClientBuilderTest extends TestCase
{
    private ClientBuilder $clientBuilder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('elastic.client', [
            'default' => 'read',
            'connections' => [
                'read' => [
                    'hosts' => ['https://read.io'],
                ],
                'write' => [
                    'hosts' => ['https://write.io'],
                ],
            ],
        ]);

        $this->clientBuilder = new ClientBuilder();
    }

    public function test_client_with_default_connection_can_be_built(): void
    {
        $client = $this->clientBuilder->default();
        $this->assertHost($client, 'https://read.io');
    }

    public function test_client_with_existing_connection_can_be_built(): void
    {
        $client = $this->clientBuilder->connection('write');
        $this->assertHost($client, 'https://write.io');
    }

    public function test_exception_is_thrown_when_building_client_with_non_existing_connection(): void
    {
        $this->expectException(ErrorException::class);
        $this->clientBuilder->connection('foo');
    }

    private function assertHost(Client $client, string $host): void
    {
        $transport = $client->getTransport();
        $node = $transport->getNodePool()->nextNode();

        $this->assertSame($host, (string)$node->getUri());
    }
}
