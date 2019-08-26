<?php

namespace Drupal\open_brew;

use GuzzleHttp\Client;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class OpenBrewConnection
{
    /**
     * GuzzleHttp\ClientInterface definition.
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $httpClient;

    /**
     * @var \Drupal\Core\Config\Config OpenBrew Integration settings.
     */
    protected $config = NULL;

    /**
     * Creates an instance of the OpenBrewConnection
     *
     * @param GuzzleHttp\Client $http_client
     */
    public function __construct(ConfigFactoryInterface $config_factory, Client $http_client)
    {
        $this->config = $config_factory->get('open_brew.openbrewconfig');
        $this->httpClient = $http_client;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get('config.factory'),
            $container->get('http_client')
        );
    }

    /**
     * Queries OpenBreweryDB api.
     *
     * @param string $endpoint - API endpoint to query.
     * @param array $options - Optional query parameters.
     * @return array
     *   Query results.
     */
    public function query($endpoint, $options = []): array
    {
        // TODO
        $requestUrl = $this->buildRequestUrl($endpoint, $options);

        return [$requestUrl];
    }

    /**
     * Builds the full request url
     *
     * @param string $endpoint - API endpoint to query.
     * @param array $options - Optional query parameters.
     * @return string
     *   Formatted request url.
     */
    private function buildRequestUrl($endpoint, $options = []): string
    {
        $baseUrl = $this->config->get('base_url') ?? 'https://api.openbrewerydb.org/';

        if ($baseUrl[strlen($baseUrl) - 1] !== '/') {
            $baseUrl .= '/';
        }

        $baseUrl .= $endpoint;

        if (count($options) === 0) {
            return $baseUrl;
        }

        // Build query params.
        $baseUrl .= '?';

        foreach ($options as $key => $value) {
            $baseUrl .= urlencode($key) . '=' . urlencode($value);
        }

        return $baseUrl;
    }
}
