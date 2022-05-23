<?php declare(strict_types=1);

namespace Elastic\Client;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder as BaseClientBuilder;
use ErrorException;

class ClientBuilder implements ClientBuilderInterface
{
    protected array $cache;

    public function default(): Client
    {
        $name = config('elastic.client.default');

        if (!is_string($name)) {
            throw new ErrorException('Default connection name is invalid or missing.');
        }

        return $this->connection($name);
    }

    public function connection(string $name): Client
    {
        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        $config = config('elastic.client.connections.' . $name);

        if (!is_array($config)) {
            throw new ErrorException(sprintf(
                'Configuration for connection %s is invalid or missing.',
                $name
            ));
        }

        $client = BaseClientBuilder::fromConfig($config);
        $this->cache[$name] = $client;

        return $client;
    }
}
