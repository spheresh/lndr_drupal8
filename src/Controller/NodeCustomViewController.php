<?php

namespace Drupal\lndr\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Entity\EntityInterface;
use Drupal\node\Controller\NodeViewController;

/**
* Custom node view controller
*/
class NodeCustomViewController extends NodeViewController {
  public function view(EntityInterface $node, $view_mode = 'full', $langcode = NULL) {
    // Redirect to the edit path on the discussion type
    if ($node->getType() == 'lndr_landing_page') {
      $lndr_project_id = $node->get('field_lndr_project_id')->getValue();
      if (!empty($lndr_project_id)) {
        $controller = new \Drupal\lndr\Controller\LndrController();
        return $controller->page($lndr_project_id[0]['value']);
      }
      return parent::view($node, $view_mode, $langcode);
    }
    else {
      return parent::view($node, $view_mode, $langcode);
    }
  }
}
