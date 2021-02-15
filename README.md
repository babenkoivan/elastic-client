# Elastic Client

[![Latest Stable Version](https://poser.pugx.org/babenkoivan/elastic-client/v/stable)](https://packagist.org/packages/babenkoivan/elastic-client)
[![Total Downloads](https://poser.pugx.org/babenkoivan/elastic-client/downloads)](https://packagist.org/packages/babenkoivan/elastic-client)
[![License](https://poser.pugx.org/babenkoivan/elastic-client/license)](https://packagist.org/packages/babenkoivan/elastic-client)
[![Tests](https://github.com/babenkoivan/elastic-client/workflows/Tests/badge.svg)](https://github.com/babenkoivan/elastic-client/actions?query=workflow%3ATests)
[![Code style](https://github.com/babenkoivan/elastic-client/workflows/Code%20style/badge.svg)](https://github.com/babenkoivan/elastic-client/actions?query=workflow%3A%22Code+style%22)
[![Static analysis](https://github.com/babenkoivan/elastic-client/workflows/Static%20analysis/badge.svg)](https://github.com/babenkoivan/elastic-client/actions?query=workflow%3A%22Static+analysis%22)
[![Donate PayPal](https://img.shields.io/badge/donate-paypal-blue)](https://paypal.me/babenkoi)

<p>
    <a href="https://www.buymeacoffee.com/ivanbabenko" target="_blank"><img src="https://cdn.buymeacoffee.com/buttons/v2/default-green.png" alt="Buy Me A Coffee" height="50"></a>
</p>

---

The official PHP Elasticsearch client integrated with Laravel.

## Contents

* [Compatibility](#compatibility)
* [Installation](#installation) 
* [Configuration](#configuration)
* [Usage](#usage)

## Compatibility

The current version of Elastic Client has been tested with the following configuration:

* PHP 7.2-8.0
* Elasticsearch 7.x

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
method in the `config/elastic.client.php` file as this factory is used under the hood:

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
