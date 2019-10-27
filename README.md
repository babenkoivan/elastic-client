# Elastic Client

[![Build Status](https://travis-ci.com/babenkoivan/elastic-client.svg?token=tL2AyZUSS9biRsKPg7fp&branch=master)](https://travis-ci.com/babenkoivan/elastic-client)

---

This is an integration of official PHP Elasticsearch client with Laravel.

## Contents

* [Installation](#installation) 
* [Configuration](#configuration)
* [Usage](#usage)

## Installation

You can install the library using composer:

```bash
composer require babenkoivan/elastic-client
```

## Configuration

You can create configuration file using artisan publish command:

```bash
php artisan vendor:publish --provider="ElasticClient\ServiceProvider"
```

You can use any settings supported by [\Elasticsearch\ClientBuilder::fromConfig](https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/configuration.html#_building_the_client_from_a_configuration_hash)
in the `config/elastic.client.php` file as this factory is used under the hood:

```php
return [
    'hosts' => [
        env('ELASTIC_HOST', 'localhost:9200'),
    ]
];
``` 

## Usage

You can type hint `\Elasticsearch\Client` or use `resolve` function to retrieve the client instance:

```php
namespace App\Console\Commands;

use Elasticsearch\Client;
use Illuminate\Console\Command;

class CreateIndex extends Command
{
    private $client;

    protected $signature = 'create:index {name}';

    protected $description = 'Creates an index';

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        $this->client->indices->exists([
            'index' => $this->argument('name')
        ]);
    }
}
```
