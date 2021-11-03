# Elastic Client

[![Latest Stable Version](https://poser.pugx.org/babenkoivan/elastic-client/v/stable)](https://packagist.org/packages/babenkoivan/elastic-client)
[![Total Downloads](https://poser.pugx.org/babenkoivan/elastic-client/downloads)](https://packagist.org/packages/babenkoivan/elastic-client)
[![License](https://poser.pugx.org/babenkoivan/elastic-client/license)](https://packagist.org/packages/babenkoivan/elastic-client)
[![Tests](https://github.com/babenkoivan/elastic-client/workflows/Tests/badge.svg)](https://github.com/babenkoivan/elastic-client/actions?query=workflow%3ATests)
[![Code style](https://github.com/babenkoivan/elastic-client/workflows/Code%20style/badge.svg)](https://github.com/babenkoivan/elastic-client/actions?query=workflow%3A%22Code+style%22)
[![Static analysis](https://github.com/babenkoivan/elastic-client/workflows/Static%20analysis/badge.svg)](https://github.com/babenkoivan/elastic-client/actions?query=workflow%3A%22Static+analysis%22)
[![Donate PayPal](https://img.shields.io/badge/donate-paypal-blue)](https://paypal.me/babenkoi)

---

<p align="center">
    🎅🏻 Ho ho ho! Christmas is coming! Please consider supporting and starring the project! ⭐️
</p>

<p align="center">
    <a href="https://ko-fi.com/ivanbabenko" target="_blank"><img src="support.png" alt="Support the project!" height="80"></a>
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

Then you can adjust the configuration hash in `config/elastic.client.php` file. Note, that you can provide any 
settings supported by [\Elasticsearch\ClientBuilder::fromConfig()](https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/endpoint-closure.html#config-hash):

```php
return [
    'hosts' => [
        env('ELASTIC_HOST', 'localhost:9200'),
    ]
];
``` 

If you want to connect to AWS Elasticsearch, you can configure a handler, which would sign requests with AWS credentials. 
For example, you can install [renoki-co/aws-elastic-client](https://github.com/renoki-co/aws-elastic-client) package and 
reconfigure Elastic Client in `AppServiceProvider::register()` as follows:

```php
class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(\Elasticsearch\Client::class, static function () {
            $config = config('elastic.client');

            $config['handler'] = new \RenokiCo\AwsElasticHandler\AwsHandler([
                'enabled' => env('AWS_ELASTICSEARCH_ENABLED', false),
                'aws_access_key_id' => env('AWS_ACCESS_KEY_ID'),
                'aws_secret_access_key' => env('AWS_SECRET_ACCESS_KEY'),
                'aws_region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
                'aws_session_token' => env('AWS_SESSION_TOKEN'), // optional
            ]);

            return \Elasticsearch\ClientBuilder::fromConfig($config);
        });
    }
}
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
