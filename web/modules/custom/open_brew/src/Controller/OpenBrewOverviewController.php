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

        if ($response['result'] && $response['result']->getStatusCode() === 200) {
            $build['response']['#markup'] = '<p><strong>Status:</strong> 200</p><h2>' . t('First 10 Breweries') . '</h2>';
            $build['results'] = [
                '#type' => 'table',
                '#header' => [t('ID'), t('Name'), t('Brewery Type'), t('City'), t('State'), t('Website')],
                '#empty' => t('No breweries were found'),
            ];

            $results = json_decode($response['result']->getBody(), TRUE);
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
            $build['error'] = $results['render'];
        }

        return $build;
    }
}
