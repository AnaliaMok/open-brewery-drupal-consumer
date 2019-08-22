<?php

namespace Drupal\open_brew\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Provides controller methods for the OpenBrew API Integration.
 */
class OpenBrewOverviewController extends ControllerBase
{
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
        $build['#markup'] = 'Hello from the overview page';

        return $build;
    }
}
