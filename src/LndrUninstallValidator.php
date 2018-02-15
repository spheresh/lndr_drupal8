<?php

namespace Drupal\lndr;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Extension\ModuleUninstallValidatorInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslationInterface;

/**
 * Prevents lndr module from being uninstalled whilst any lndr landing page nodes exist.
 */
class LndrUninstallValidator implements ModuleUninstallValidatorInterface {

  use StringTranslationTrait;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a LndrUninstallValidator.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\StringTranslation\TranslationInterface $string_translation
   *   The string translation service.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, TranslationInterface $string_translation) {
    $this->entityTypeManager = $entity_type_manager;
    $this->stringTranslation = $string_translation;
  }

  /**
   * {@inheritdoc}
   */
  public function validate($module) {
    $reasons = [];
    if ($module == 'lndr') {
      // The lndr_landing_page node type is provided by the lndr module. Prevent
      // uninstall if there are any nodes of that type.
      if ($this->hasLndrNodes()) {
        $reasons[] = $this->t('To uninstall Lndr, delete all content that has the Lndr:landing page content type.');
      }
    }
    return $reasons;
  }

  /**
   * Determines if there is any lndr_landing_page nodes or not.
   *
   * @return bool
   *   TRUE if there are lndr_landing_page nodes, FALSE otherwise.
   */
  protected function hasLndrNodes() {
    $nodes = $this->entityTypeManager->getStorage('node')->getQuery()
      ->condition('type', 'lndr_landing_page')
      ->accessCheck(FALSE)
      ->range(0, 1)
      ->execute();
    return !empty($nodes);
  }
}
