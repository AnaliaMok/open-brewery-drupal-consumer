<?php

namespace Drupal\open_brew\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\open_brew\OpenBrewConnection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides controller methods for the OpenBrew API Integration.
 */
class OpenBrewOverviewController extends ControllerBase
{
    /**
     * OpenBrewConnection instance
     *
     * @var Drupal\open_brew\OpenBrewConnection
     */
    protected $connection;

    public function __construct(OpenBrewConnection $openBrewConnection)
    {
        $this->connection = $openBrewConnection;
    }

    /**
     * {@inheritDoc}
     */
    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get('open_brew.connection')
        );
    }

    /**
     * Creates a simple overview page
     *
     * @return array
     *   A renderable array.
     */
    public function showOverview()
    {
        $build = [];

        // TODO: Implement.
        $build['#markup'] = $this->connection->query('breweries')[0];

        return $build;
    }
}
