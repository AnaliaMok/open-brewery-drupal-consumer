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
            'per_page' => 10,
        ]);

        $build['response'] = [];

        if ($response->getStatusCode() === 200) {
            $build['response']['#markup'] = '<p><strong>Status:</strong> 200</p>';
            $build['results'] = [
                '#type' => 'table',
                '#header' => [t('ID'), t('Name'), t('Brewery Type'), t('City'), t('State'), t('Website')],
                '#title' => t('First 10 Breweries'),
            ];

            $results = json_decode($response->getBody(), TRUE);
            foreach ($results as $brewery) {
                $build['results']['#rows'][$brewery['id']] = [
                    $brewery['id'],
                    $brewery['name'],
                    $brewery['brewery_type'],
                    $brewery['city'],
                    $brewery['state'],
                    $brewery['website_url'],
                ];
            }
        } else {
            $build['response']['#items'][] = t('Status: ' . $response->getStatusCode());
            $build['response']['#items'][] = 'No Results Found';
        }

        return $build;
    }
}
