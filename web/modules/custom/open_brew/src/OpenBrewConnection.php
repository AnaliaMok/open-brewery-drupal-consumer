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
     * Creates an instance of the OpenBrewConnection
     *
     * @param ClientInterface $http_client
     */
    public function __construct(ClientInterface $http_client)
    {
        $this->httpClient = $http_client;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container)
    {
        // TODO: Move into OpenBrewConnection class.
        return new static(
            $container->get('http_client')
        );
    }
}
