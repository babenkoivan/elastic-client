<?php declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | ElasticSearch Hosts
    |--------------------------------------------------------------------------
    |
    | Define your hosts here.
    |
    */

    'hosts' => [
        [
            'host' => env('ELASTIC_HOST', '127.0.0.1'),
            'port' => env('ELASTIC_PORT', 9200),
            'scheme' => env('ELASTIC_SCHEME', null),
            'user' => env('ELASTIC_USER', null),
            'pass' => env('ELASTIC_PASSWORD', null),

            'aws_enable' => env('ELASTIC_USE_AWS', false),
            'aws_region' => env('ELASTIC_AWS_REGION', 'us-east-1'),
            'aws_key' => env('AWS_ACCESS_KEY_ID', ''),
            'aws_secret' => env('AWS_SECRET_ACCESS_KEY', ''),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | SSL Verification
    |--------------------------------------------------------------------------
    |
    | If your Elasticsearch instance uses an out-dated or self-signed SSL
    | certificate, you will need to pass in the certificate bundle.  This can
    | either be the path to the certificate file (for self-signed certs), or a
    | package like https://github.com/Kdyby/CurlCaBundle.  See the documentation
    | below for all the details.
    |
    | If you are using SSL instances, and the certificates are up-to-date and
    | signed by a public certificate authority, then you can leave this null and
    | just use "https" in the host path(s) above and you should be fine.
    |
    | @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/2.0/_security.html#_ssl_encryption_2
    |
    */

    'sslVerification' => null,

    /*
    |--------------------------------------------------------------------------
    | Retries
    |--------------------------------------------------------------------------
    |
    | By default, the client will retry n times, where n = number of nodes in
    | your cluster. If you would like to disable retries, or change the number,
    | you can do so here.
    |
    | @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/2.0/_configuration.html#_set_retries
    |
    */

    'retries' => null,

    /*
    |--------------------------------------------------------------------------
    | Sniffing On Start
    |--------------------------------------------------------------------------
    |
    | @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/2.0/_configuration.html
    |
    */

    'sniffOnStart' => false,

    /*
    |--------------------------------------------------------------------------
    | HTTP Handler
    |--------------------------------------------------------------------------
    |
    | @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/2.0/_configuration.html#_configure_the_http_handler
    | @see http://ringphp.readthedocs.org/en/latest/client_handlers.html
    |
    */

    'httpHandler' => null,

    /*
    |--------------------------------------------------------------------------
    | Connection Pooling
    |--------------------------------------------------------------------------
    |
    | @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/2.0/_configuration.html#_setting_the_connection_pool
    | @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/2.0/_connection_pool.html
    |
    */

    'connectionPool' => null,

    /*
    |--------------------------------------------------------------------------
    | Connection Selector
    |--------------------------------------------------------------------------
    |
    | @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/2.0/_configuration.html#_setting_the_connection_selector
    | @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/2.0/_selectors.html
    |
    */

    'connectionSelector' => null,

    /*
    |--------------------------------------------------------------------------
    | Response Serializer
    |--------------------------------------------------------------------------
    |
    | @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/2.0/_configuration.html#_setting_the_serializer
    | @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/2.0/_serializers.html
    |
    */

    'serializer' => null,

    /*
    |--------------------------------------------------------------------------
    | Connection Factory
    |--------------------------------------------------------------------------
    |
    | @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/2.0/_configuration.html#_setting_a_custom_connectionfactory
    |
    */

    'connectionFactory' => null,

    /*
    |--------------------------------------------------------------------------
    | Endpoint Closure
    |--------------------------------------------------------------------------
    |
    | @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/6.0/_configuration.html#_set_the_endpoint_closure
    |
    */

    'endpoint' => null,

    /*
    |--------------------------------------------------------------------------
    | Endpoint Closure
    |--------------------------------------------------------------------------
    |
    | Register additional namespaces. Add an array of additional
    | namespaces to register.
    |
    | @example 'namespaces' => [XPack::Security(), XPack::Watcher()]
    | @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/ElasticsearchPHP_Endpoints.html#Elasticsearch_ClientBuilderregisterNamespace_registerNamespace
    |
    */

    'namespaces' => [],
];
