# Elastic Client

[![Latest Stable Version](https://poser.pugx.org/babenkoivan/elastic-client/v/stable)](https://packagist.org/packages/babenkoivan/elastic-client)
[![Total Downloads](https://poser.pugx.org/babenkoivan/elastic-client/downloads)](https://packagist.org/packages/babenkoivan/elastic-client)
[![License](https://poser.pugx.org/babenkoivan/elastic-client/license)](https://packagist.org/packages/babenkoivan/elastic-client)
[![Build Status](https://travis-ci.com/babenkoivan/elastic-client.svg?branch=master)](https://travis-ci.com/babenkoivan/elastic-client)
[![Donate PayPal](https://img.shields.io/badge/donate-paypal-blue)](https://paypal.me/babenkoi)
[![Donate Amazon](https://img.shields.io/badge/donate-amazon-black)](https://www.amazon.de/Amazon-de-e-Gift-Voucher-Various-Designs/dp/B07Q1JNC7R)

---

The official PHP Elasticsearch client integrated with Laravel.

## Contents

* [Compatibility](#compatibility)
* [Installation](#installation) 
* [Configuration](#configuration)
* [Usage](#usage)

## Compatibility

The current version of Elastic Client has been tested with the following configuration:

* PHP 7.2-7.4
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
