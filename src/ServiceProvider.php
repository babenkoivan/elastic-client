<?php declare(strict_types=1);

namespace ElasticClient;

use Aws\Credentials\Credentials;
use Aws\Signature\SignatureV4;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Ring\Future\CompletedFutureArray;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider as AbstractServiceProvider;

final class ServiceProvider extends AbstractServiceProvider
{
    /**
     * Map configuration array keys with ES ClientBuilder setters.
     *
     * @var array
     */
    protected $configMappings = [
        'sslVerification' => 'setSSLVerification',
        'sniffOnStart' => 'setSniffOnStart',
        'retries' => 'setRetries',
        'httpHandler' => 'setHandler',
        'connectionPool' => 'setConnectionPool',
        'connectionSelector' => 'setSelector',
        'serializer' => 'setSerializer',
        'connectionFactory'  => 'setConnectionFactory',
        'endpoint' => 'setEndpoint',
        'namespaces' => 'registerNamespace',
    ];

    /**
     * @var string
     */
    private $configPath;

    /**
     * {@inheritDoc}
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $this->configPath = dirname(__DIR__) . '/config/elastic.client.php';
    }

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->mergeConfigFrom(
            $this->configPath,
            basename($this->configPath, '.php')
        );

        $this->app->singleton(Client::class, static function () {
            $config = config('elastic.client');

            return $this->buildClientFromConfig($config);
        });
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            $this->configPath => config_path(basename($this->configPath)),
        ]);
    }

    protected function buildClientFromConfig(array $config)
    {
        $clientBuilder = ClientBuilder::create();

        $clientBuilder->setHosts($config['hosts']);

        // Set additional client configuration
        foreach ($this->configMappings as $key => $method) {
            $value = Arr::get($config, $key);

            if (is_array($value)) {
                foreach ($value as $vItem) {
                    $clientBuilder->$method($vItem);
                }
            } elseif ($value !== null) {
                $clientBuilder->$method($value);
            }
        }

        // For each host, check if it uses AWS configuration and try to set a handler
        // to authenticate through the V4 Signature before hitting the API.
        foreach ($config['hosts'] as $host) {
            if (isset($host['aws_enable']) && $host['aws_enable']) {
                $clientBuilder->setHandler(function (array $request) use ($host) {
                    $psr7Handler = \Aws\default_http_handler();
                    $signer = new SignatureV4('es', $host['aws_region']);

                    // Create a PSR-7 request from the array passed to the handler.
                    $psr7Request = new Request(
                        $request['http_method'],
                        (new Uri($request['uri']))->withScheme($request['scheme'])->withHost($request['headers']['Host'][0]),
                        $request['headers'],
                        $request['body']
                    );

                    // Sign the PSR-7 request with credentials from the environment.
                    $signedRequest = $signer->signRequest(
                        $psr7Request,
                        new Credentials($host['aws_key'], $host['aws_secret'])
                    );

                    // Send the signed request to Amazon ES.
                    /** @var \Psr\Http\Message\ResponseInterface $response */
                    $response = $psr7Handler($signedRequest)->then(function (\Psr\Http\Message\ResponseInterface $response) {
                        return $response;
                    }, function ($error) {
                        return $error['response'];
                    })->wait();

                    // Convert the PSR-7 response to a RingPHP response
                    return new CompletedFutureArray([
                        'status' => $response->getStatusCode(),
                        'headers' => $response->getHeaders(),
                        'body' => $response->getBody()->detach(),
                        'transfer_stats' => ['total_time' => 0],
                        'effective_url' => (string) $psr7Request->getUri(),
                    ]);
                });
            }
        }

        return $clientBuilder->build();
    }
}
