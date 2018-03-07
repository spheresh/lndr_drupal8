<?php

namespace Drupal\lndr\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {
  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    // Alter the node route to use our own controller logic
    if ($route = $collection->get('entity.node.canonical')) {
      $route->setDefault('_controller', '\Drupal\lndr\Controller\NodeCustomViewController::view');
    }
  }
}
