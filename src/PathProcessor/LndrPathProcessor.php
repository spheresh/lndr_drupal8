<?php

namespace Drupal\lndr\PathProcessor;

use Drupal\Core\PathProcessor\OutboundPathProcessorInterface;
use Drupal\Core\Render\BubbleableMetadata;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LndrPathProcessor.
 */
class LndrPathProcessor implements OutboundPathProcessorInterface {

  /**
   * {@inheritdoc}
   */
  public function processOutbound($path, &$options = [], Request $request = NULL, BubbleableMetadata $bubbleable_metadata = NULL) {
    if (strpos($path, '/lndr_edit') === 0) {
      unset( $options['query']['destination'] );
    }
    return $path;
  }
}
