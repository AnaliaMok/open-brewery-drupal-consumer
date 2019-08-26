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
        $response = $this->connection->query('breweries', [
            'page' => 1,
            'per_page' => 5,
        ]);

        $build['response'] = [
            '#theme' => 'item_list',
            '#title' => t('Results'),
        ];

        if ($response->getStatusCode() === 200) {
            $build['response']['#items'][] = t('Status: 200');
            $build['results'] = [
                '#theme' => 'item_list',
                '#title' => t('First 5 Breweries'),
            ];

            $results = json_decode($response->getBody(), TRUE);
            foreach ($results as $brewery) {
                $build['results']['#items'][] = $brewery['name'];
            }
        } else {
            $build['response']['#items'][] = t('Status: ' . $response->getStatusCode());
            $build['response']['#items'][] = 'No Results Found';
        }

        return $build;
    }
}
