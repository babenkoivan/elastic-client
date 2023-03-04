# Elastic Client

[![Latest Stable Version](https://poser.pugx.org/babenkoivan/elastic-client/v/stable)](https://packagist.org/packages/babenkoivan/elastic-client)
[![Total Downloads](https://poser.pugx.org/babenkoivan/elastic-client/downloads)](https://packagist.org/packages/babenkoivan/elastic-client)
[![License](https://poser.pugx.org/babenkoivan/elastic-client/license)](https://packagist.org/packages/babenkoivan/elastic-client)
[![Tests](https://github.com/babenkoivan/elastic-client/workflows/Tests/badge.svg)](https://github.com/babenkoivan/elastic-client/actions?query=workflow%3ATests)
[![Code style](https://github.com/babenkoivan/elastic-client/workflows/Code%20style/badge.svg)](https://github.com/babenkoivan/elastic-client/actions?query=workflow%3A%22Code+style%22)
[![Static analysis](https://github.com/babenkoivan/elastic-client/workflows/Static%20analysis/badge.svg)](https://github.com/babenkoivan/elastic-client/actions?query=workflow%3A%22Static+analysis%22)
[![Donate PayPal](https://img.shields.io/badge/donate-paypal-blue)](https://paypal.me/babenkoi)

<p align="center">
    <a href="https://ko-fi.com/ivanbabenko" target="_blank"><img src="https://ko-fi.com/img/githubbutton_sm.svg" alt="Support the project!"></a>
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

* PHP 7.4-8.x
* Elasticsearch 8.x 
* Laravel 6.x-10.x

## Installation

The library can be installed via Composer:

```bash
composer require babenkoivan/elastic-client
```

## Configuration

To change the client settings you need to publish the configuration file first:

```bash
php artisan vendor:publish --provider="Elastic\Client\ServiceProvider"
```

In the newly created `config/elastic.client.php` file you can define the default connection name and describe multiple 
connections using configuration hashes. You can read more about building the client from a configuration hash [here](https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/node_pool.html#config-hash).

```php
return [
    'default' => env('ELASTIC_CONNECTION', 'default'),
    'connections' => [
        'default' => [
            'hosts' => [
                env('ELASTIC_HOST', 'localhost:9200'),
            ],
            // you can also set HTTP client options (which is Guzzle by default) as follows
            'httpClientOptions' => [
                'timeout' => 2,
            ],
        ],
    ],
];
```

If you need more control over the client creation, you can create your own client builder:

```php
// see Elastic\Client\ClientBuilder for the reference
class MyClientBuilder implements Elastic\Client\ClientBuilderInterface
{
    public function default(): Client
    {
        // should return a client instance for the default connection 
    }
    
    public function connection(string $name): Client
    {
        // should return a client instance for the connection with the given name 
    }
}
```

Do not forget to register the builder in your application service provider:

```php
class MyAppServiceProvider extends Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ClientBuilderInterface::class, MyClientBuilder::class);
    }
}
```

## Usage

Use `Elastic\Client\ClientBuilderInterface` to get access to the client instance:

```php
namespace App\Console\Commands;

use Elastic\Elasticsearch\Client;
use Elastic\Client\ClientBuilderInterface;
use Illuminate\Console\Command;

class CreateIndex extends Command
{
    protected $signature = 'create:index {name}';

    protected $description = 'Creates an index';

    public function handle(ClientBuilderInterface $clientBuilder)
    {
        // get a client for the default connection
        $client = $clientBuilder->default();
        // get a client for the connection with name "write"
        $client = $clientBuilder->connection('write');
    
        $client->indices()->create([
            'index' => $this->argument('name')
        ]);
    }
}
```
