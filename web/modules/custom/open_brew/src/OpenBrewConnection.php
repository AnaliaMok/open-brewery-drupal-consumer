<?php

namespace Drupal\open_brew;

use Symfony\Component\DependencyInjection\ContainerInterface;
use GuzzleHttp\ClientInterface;

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
     * @param ClientInterface $http_client
     */
    public function __construct(ConfigFactoryInterface $config_factory, ClientInterface $http_client)
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
    public static function query($endpoint, $options = []): array
    {
        // TODO
        return [];
    }

    /**
     * Builds the full request url
     *
     * @param string $endpoint - API endpoint to query.
     * @param array $options - Optional query parameters.
     * @return string
     *   Formatted request url.
     */
    public static function buildRequestUrl($endpoint, $options = []): string
    {
        return '';
    }
}
