# Elastic Client

[![Build Status](https://travis-ci.com/babenkoivan/elastic-client.svg?token=tL2AyZUSS9biRsKPg7fp&branch=master)](https://travis-ci.com/babenkoivan/elastic-client)

---

The official PHP Elasticsearch client integrated with Laravel.

## Contents

* [Installation](#installation) 
* [Configuration](#configuration)
* [Usage](#usage)

## Installation

The library can be installed via Composer:

```bash
composer require babenkoivan/elastic-client
```

## Configuration

To change the client settings you need to publish the configuration file first:

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

Type hint `\Elasticsearch\Client` or use `resolve` function to retrieve the client instance in your code:

```php
namespace App\Console\Commands;

use Elasticsearch\Client;
use Illuminate\Console\Command;

class CreateIndex extends Command
{
    protected $signature = 'create:index {name}';

    protected $description = 'Creates an index';

    public function handle(Client $client)
    {
        $client->indices()->create([
            'index' => $this->argument('name')
        ]);
    }
}
```
