<?php declare(strict_types=1);

namespace Elastic\Client;

use Elastic\Elasticsearch\Client;

interface ClientBuilderInterface
{
    public function default(): Client;

    public function connection(string $name): Client;
}
