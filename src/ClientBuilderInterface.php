<?php declare(strict_types=1);

namespace Elastic\Client;

use Elastic\Elasticsearch\ClientInterface;

interface ClientBuilderInterface
{
    public function default(): ClientInterface;

    public function connection(string $name): ClientInterface;
}
